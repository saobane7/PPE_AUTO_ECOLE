<?php
require_once("modele/modele.class.php");

class Controleur {
    private $modele;

    public function __construct() {
        $this->modele = new Modele();
    }


    public function connecter($email, $mdp, $type) {
        $user = null;

        switch ($type) {
            case 'admin':
                $user = $this->modele->selectWhere_user($email, $mdp);
                if ($user) {
                    $_SESSION['user_id'] = $user['iduser'];
                    $_SESSION['type_user'] = 'admin';
                    $_SESSION['nom'] = $user['nom'];
                    $_SESSION['prenom'] = $user['prenom'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['droits'] = $user['droits'];
                }
                break;

            case 'client':
                $user = $this->modele->selectWhere_client($email, $mdp);
                if ($user) {
                    $_SESSION['user_id'] = $user['id_client'];
                    $_SESSION['type_user'] = 'client';
                    $_SESSION['nom'] = $user['nom'];
                    $_SESSION['prenom'] = $user['prenom'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['telephone'] = $user['telephone'];
                    $_SESSION['type_client'] = $user['type'];
                }
                break;

            case 'moniteur':
                $user = $this->modele->selectWhere_moniteur($email, $mdp);
                if ($user) {
                    $_SESSION['user_id'] = $user['id_moniteur'];
                    $_SESSION['type_user'] = 'moniteur';
                    $_SESSION['nom'] = $user['nom'];
                    $_SESSION['prenom'] = $user['prenom'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['telephone'] = $user['telephone'];
                    $_SESSION['agrement'] = $user['numero_agrement'];
                }
                break;
        }

        return ($user !== null && $user !== false);
    }

    public function deconnecter() {
        session_unset();
        session_destroy();
    }

    public function estConnecte() {
        return isset($_SESSION['user_id']);
    }

    public function estAdmin() {
        return isset($_SESSION['type_user']) && $_SESSION['type_user'] === 'admin';
    }

    public function estClient() {
        return isset($_SESSION['type_user']) && $_SESSION['type_user'] === 'client';
    }

    public function estMoniteur() {
        return isset($_SESSION['type_user']) && $_SESSION['type_user'] === 'moniteur';
    }

    public function redirectionRole() {
        if ($this->estAdmin()) {
            return "index.php?page=dashboard_admin";
        } elseif ($this->estClient()) {
            return "index.php?page=dashboard_client";
        } elseif ($this->estMoniteur()) {
            return "index.php?page=dashboard_moniteur";
        } else {
            return "index.php?page=connexion";
        }
    }

   
    public function getMoniteursHome() {
        return $this->modele->selectAll_moniteurs_home();
    }

    
   
    public function inscrireClient($tab) {
        if ($this->modele->emailExists_client($tab['email'])) {
            return ['ok' => false, 'msg' => 'Cet email est déjà utilisé.'];
        }
        $ok = $this->modele->insert_client($tab);
        return $ok
            ? ['ok' => true, 'msg' => 'Client ajouté avec succès !']
            : ['ok' => false, 'msg' => 'Erreur lors de l\'ajout du client.'];
    }

    
    public function getAllClients() {
        return $this->modele->selectAll_clients();
    }

    
    public function getClientById($id_client) {
        return $this->modele->select_client_by_id($id_client);
    }

    public function modifierClient($tab) {
        $ok = $this->modele->update_client($tab);
        if ($ok && $this->estClient() && $_SESSION['user_id'] == $tab['id_client']) {
            $_SESSION['nom'] = $tab['nom'];
            $_SESSION['prenom'] = $tab['prenom'];
            $_SESSION['telephone'] = $tab['telephone'];
            $_SESSION['type_client'] = $tab['type'];
        }
        return $ok 
            ? ['ok' => true, 'msg' => 'Client modifié avec succès.'] 
            : ['ok' => false, 'msg' => 'Erreur lors de la modification.'];
    }

    public function supprimerClient($id_client) {

        $nb_cours = $this->modele->count_cours_pratiques_client($id_client);
        $nb_examens = $this->modele->count_examens_client($id_client);
        
        if ($nb_cours > 0 || $nb_examens > 0) {
            return ['ok' => false, 'msg' => 'Impossible de supprimer : ce client a des cours ou examens associés.'];
        }
        
        $ok = $this->modele->delete_client($id_client);
        return $ok 
            ? ['ok' => true, 'msg' => 'Client supprimé avec succès.'] 
            : ['ok' => false, 'msg' => 'Erreur lors de la suppression.'];
    }


    public function rechercherClients($filtre) {
        return $this->modele->selectLike_clients($filtre);
    }


    
    public function ajouterMoniteur($tab) {
        if ($this->modele->emailExists_moniteur($tab['email'])) {
            return ['ok' => false, 'msg' => 'Cet email est déjà utilisé.'];
        }
        $ok = $this->modele->insert_moniteur($tab);
        return $ok 
            ? ['ok' => true, 'msg' => 'Moniteur ajouté avec succès.'] 
            : ['ok' => false, 'msg' => 'Erreur lors de l\'ajout du moniteur.'];
    }


    public function getAllMoniteurs() {
        return $this->modele->selectAll_moniteurs();
    }

    
    public function getMoniteurById($id_moniteur) {
        return $this->modele->select_moniteur_by_id($id_moniteur);
    }


    public function modifierMoniteur($tab) {
        $ok = $this->modele->update_moniteur($tab);
        if ($ok && $this->estMoniteur() && $_SESSION['user_id'] == $tab['id_moniteur']) {
            $_SESSION['nom'] = $tab['nom'];
            $_SESSION['prenom'] = $tab['prenom'];
            $_SESSION['telephone'] = $tab['telephone'];
        }
        return $ok 
            ? ['ok' => true, 'msg' => 'Moniteur modifié avec succès.'] 
            : ['ok' => false, 'msg' => 'Erreur lors de la modification.'];
    }

    
    public function supprimerMoniteur($id_moniteur) {
        
        $nb_cours = $this->modele->count_cours_pratiques_moniteur($id_moniteur);
        
        if ($nb_cours > 0) {
            return ['ok' => false, 'msg' => 'Impossible de supprimer : ce moniteur a des cours associés.'];
        }
        
        $ok = $this->modele->delete_moniteur($id_moniteur);
        return $ok 
            ? ['ok' => true, 'msg' => 'Moniteur supprimé avec succès.'] 
            : ['ok' => false, 'msg' => 'Erreur lors de la suppression.'];
    }

    
    
    public function ajouterCoursTheorique($tab) {
        $ok = $this->modele->insert_cours_theorique($tab);
        return $ok 
            ? ['ok' => true, 'msg' => 'Cours théorique ajouté avec succès.'] 
            : ['ok' => false, 'msg' => 'Erreur lors de l\'ajout du cours.'];
    }

    
    public function getAllCoursTheoriques() {
        return $this->modele->selectAll_cours_theoriques();
    }

    public function getCoursTheoriquesClient($id_client) {
        return $this->modele->selectAll_cours_theoriques_client($id_client);
    }

    
    public function getCoursTheoriquesDisponibles($id_client) {
        return $this->modele->select_cours_theoriques_disponibles($id_client);
    }

    
    public function modifierCoursTheorique($tab) {
        $ok = $this->modele->update_cours_theorique($tab);
        return $ok 
            ? ['ok' => true, 'msg' => 'Cours théorique modifié avec succès.'] 
            : ['ok' => false, 'msg' => 'Erreur lors de la modification.'];
    }

   
    public function supprimerCoursTheorique($id_cours) {
        $ok = $this->modele->delete_cours_theorique($id_cours);
        return $ok 
            ? ['ok' => true, 'msg' => 'Cours théorique supprimé avec succès.'] 
            : ['ok' => false, 'msg' => 'Erreur lors de la suppression.'];
    }

   
    public function inscrireClientCoursTheorique($id_client, $id_cours) {
        $ok = $this->modele->inscrire_client_cours_theorique($id_client, $id_cours);
        return $ok 
            ? ['ok' => true, 'msg' => 'Inscription réussie au cours théorique.'] 
            : ['ok' => false, 'msg' => 'Erreur lors de l\'inscription.'];
    }

    
    public function ajouterCoursPratique($tab) {
        $ok = $this->modele->insert_cours_pratique($tab);
        return $ok 
            ? ['ok' => true, 'msg' => 'Cours pratique planifié avec succès.'] 
            : ['ok' => false, 'msg' => 'Erreur lors de la planification.'];
    }

   
    public function getAllCoursPratiques() {
        return $this->modele->selectAll_cours_pratiques();
    }

   
    public function getCoursPratiquesClient($id_client) {
        return $this->modele->selectAll_cours_pratiques_client($id_client);
    }

    
    public function getCoursPratiquesMoniteur($id_moniteur) {
        return $this->modele->selectAll_cours_pratiques_moniteur($id_moniteur);
    }

  
    public function getCoursPratiquesAVenirClient($id_client) {
        return $this->modele->select_cours_pratiques_a_venir_client($id_client);
    }

    
    public function getCoursPratiquesAVenirMoniteur($id_moniteur) {
        return $this->modele->select_cours_pratiques_a_venir_moniteur($id_moniteur);
    }

    
    public function modifierCoursPratique($tab) {
        $ok = $this->modele->update_cours_pratique($tab);
        return $ok 
            ? ['ok' => true, 'msg' => 'Cours modifié avec succès.'] 
            : ['ok' => false, 'msg' => 'Erreur lors de la modification.'];
    }

   
    public function supprimerCoursPratique($id_seance) {
        $ok = $this->modele->delete_cours_pratique($id_seance);
        return $ok 
            ? ['ok' => true, 'msg' => 'Cours supprimé avec succès.'] 
            : ['ok' => false, 'msg' => 'Erreur lors de la suppression.'];
    }

    public function validerCoursPratique($id_seance, $notes = null) {
        $cours = $this->modele->select_cours_pratique_by_id($id_seance);
        if (!$cours) {
            return ['ok' => false, 'msg' => 'Cours introuvable.'];
        }

        $tab = [
            'id_seance' => $id_seance,
            'date_seance' => $cours['date_seance'],
            'heure_debut' => $cours['heure_debut'],
            'heure_fin' => $cours['heure_fin'],
            'id_moniteur' => $cours['id_moniteur'],
            'id_client' => $cours['id_client'],
            'type_vehicule' => $cours['type_vehicule'],
            'statut' => 'termine',
            'notes' => $notes ? $notes : $cours['notes']
        ];

        return $this->modifierCoursPratique($tab);
    }


    public function annulerCoursPratique($id_seance) {
        $cours = $this->modele->select_cours_pratique_by_id($id_seance);
        if (!$cours) {
            return ['ok' => false, 'msg' => 'Cours introuvable.'];
        }

        $tab = [
            'id_seance' => $id_seance,
            'date_seance' => $cours['date_seance'],
            'heure_debut' => $cours['heure_debut'],
            'heure_fin' => $cours['heure_fin'],
            'id_moniteur' => $cours['id_moniteur'],
            'id_client' => $cours['id_client'],
            'type_vehicule' => $cours['type_vehicule'],
            'statut' => 'annule',
            'notes' => $cours['notes']
        ];

        return $this->modifierCoursPratique($tab);
    }

  
    

    public function ajouterExamen($tab) {
        $ok = $this->modele->insert_examen($tab);
        return $ok 
            ? ['ok' => true, 'msg' => 'Examen planifié avec succès.'] 
            : ['ok' => false, 'msg' => 'Erreur lors de la planification.'];
    }

    public function getAllExamens() {
        return $this->modele->selectAll_examens();
    }


    public function getExamensClient($id_client) {
        return $this->modele->selectAll_examens_client($id_client);
    }


    public function modifierExamen($tab) {
        $ok = $this->modele->update_examen($tab);
        return $ok 
            ? ['ok' => true, 'msg' => 'Examen modifié avec succès.'] 
            : ['ok' => false, 'msg' => 'Erreur lors de la modification.'];
    }

    public function supprimerExamen($id_examen) {
        $ok = $this->modele->delete_examen($id_examen);
        return $ok 
            ? ['ok' => true, 'msg' => 'Examen supprimé avec succès.'] 
            : ['ok' => false, 'msg' => 'Erreur lors de la suppression.'];
    }

  
    public function enregistrerResultatExamen($id_examen, $resultat, $notes = null) {
        $examen = $this->modele->select_examen_by_id($id_examen);
        if (!$examen) {
            return ['ok' => false, 'msg' => 'Examen introuvable.'];
        }

        $tab = [
            'id_examen' => $id_examen,
            'type' => $examen['type'],
            'date_examen' => $examen['date_examen'],
            'heure' => $examen['heure'],
            'id_client' => $examen['id_client'],
            'lieu' => $examen['lieu'],
            'resultat' => $resultat,
            'notes' => $notes ? $notes : $examen['notes']
        ];

        return $this->modifierExamen($tab);
    }

    public function getElevesMoniteur($id_moniteur) {
        return $this->modele->selectAll_eleves_moniteur($id_moniteur);
    }

    public function getMoniteurPrincipalClient($id_client) {
        return $this->modele->select_moniteur_principal_client($id_client);
    }

  
    public function getDashAdmin() {
        return [
            'clients' => $this->modele->selectAll_clients(),
            'moniteurs' => $this->modele->selectAll_moniteurs(),
            'cours_theoriques' => $this->modele->selectAll_cours_theoriques(),
            'cours_pratiques' => $this->modele->selectAll_cours_pratiques(),
            'examens' => $this->modele->selectAll_examens(),
            'stats' => [
                'nb_clients' => $this->modele->countTable('client'),
                'nb_moniteurs' => $this->modele->countTable('moniteur'),
                'nb_cours_theoriques' => $this->modele->countTable('cours_theorique'),
                'nb_cours_pratiques' => $this->modele->countTable('cours_pratique'),
                'nb_examens' => $this->modele->countTable('examen')
            ]
        ];
    }


    public function getDashClient($id_client) {
        $client = $this->getClientById($id_client);
        $moniteur_principal = $this->getMoniteurPrincipalClient($id_client);
        $progression = $this->modele->get_progression_client($id_client);

        return [
            'client' => $client,
            'stats' => [
                'nb_cours_pratiques' => $this->modele->count_cours_pratiques_client($id_client),
                'nb_cours_theoriques' => $this->modele->count_cours_theoriques_client($id_client),
                'nb_examens' => $this->modele->count_examens_client($id_client),
                'nb_examens_reussis' => $this->modele->count_examens_reussis_client($id_client),
                'heures_conduite' => $this->modele->get_heures_conduite_client($id_client),
                'progression' => $progression
            ],
            'cours_pratiques' => $this->getCoursPratiquesClient($id_client),
            'cours_a_venir' => $this->getCoursPratiquesAVenirClient($id_client),
            'cours_theoriques' => $this->getCoursTheoriquesClient($id_client),
            'cours_theoriques_disponibles' => $this->getCoursTheoriquesDisponibles($id_client),
            'examens' => $this->getExamensClient($id_client),
            'moniteur_principal' => $moniteur_principal,
            'prochain_cours' => !empty($this->getCoursPratiquesAVenirClient($id_client)) ? $this->getCoursPratiquesAVenirClient($id_client)[0] : null
        ];
    }


    public function getDashMoniteur($id_moniteur) {
        $moniteur = $this->getMoniteurById($id_moniteur);
        $eleves = $this->getElevesMoniteur($id_moniteur);
        $cours_pratiques = $this->getCoursPratiquesMoniteur($id_moniteur);
        $cours_a_venir = $this->getCoursPratiquesAVenirMoniteur($id_moniteur);

        return [
            'moniteur' => $moniteur,
            'stats' => [
                'nb_eleves' => $this->modele->count_eleves_moniteur($id_moniteur),
                'nb_cours_total' => $this->modele->count_cours_pratiques_moniteur($id_moniteur),
                'nb_cours_termines' => $this->modele->count_cours_termines_moniteur($id_moniteur),
                'nb_cours_a_venir' => count($cours_a_venir),
                'heures_enseignees' => $this->modele->get_heures_enseignees_moniteur($id_moniteur)
            ],
            'eleves' => $eleves,
            'cours_pratiques' => $cours_pratiques,
            'cours_a_venir' => $cours_a_venir,
            'prochain_cours' => !empty($cours_a_venir) ? $cours_a_venir[0] : null
        ];
    }


    public function getStatsGlobales() {
        return [
            'clients' => $this->modele->countTable('client'),
            'moniteurs' => $this->modele->countTable('moniteur'),
            'cours_pratiques' => $this->modele->countTable('cours_pratique'),
            'cours_theoriques' => $this->modele->countTable('cours_theorique'),
            'examens' => $this->modele->countTable('examen')
        ];
    }
}
?>