<?php
require_once("modele/modele.class.php");

class Controleur {
    protected $modele;

    public function __construct() {
        $this->modele = new Modele();
    }

    /*---------------- CONNEXION------------------------*/

    public function connecterUtilisateur($email, $motDePasse, $typeUtilisateur) {
        $utilisateurTrouve = null;

        if ($typeUtilisateur === 'admin') {
            $utilisateurTrouve = $this->modele->connexionAdmin($email, $motDePasse);
            if ($utilisateurTrouve) {
                $_SESSION['user_id']   = $utilisateurTrouve['iduser'];
                $_SESSION['type_user'] = 'admin';
                $_SESSION['nom']       = $utilisateurTrouve['nom'];
                $_SESSION['prenom']    = $utilisateurTrouve['prenom'];
            }
        } elseif ($typeUtilisateur === 'client') {
            $utilisateurTrouve = $this->modele->connexionClient($email, $motDePasse);
            if ($utilisateurTrouve) {
                $_SESSION['user_id']     = $utilisateurTrouve['id_client'];
                $_SESSION['type_user']   = 'client';
                $_SESSION['nom']         = $utilisateurTrouve['nom'];
                $_SESSION['prenom']      = $utilisateurTrouve['prenom'];
                $_SESSION['telephone']   = $utilisateurTrouve['telephone'];
                $_SESSION['type_client'] = $utilisateurTrouve['type'];
            }
        } elseif ($typeUtilisateur === 'moniteur') {
            $utilisateurTrouve = $this->modele->connexionMoniteur($email, $motDePasse);
            if ($utilisateurTrouve) {
                $_SESSION['user_id']   = $utilisateurTrouve['id_moniteur'];
                $_SESSION['type_user'] = 'moniteur';
                $_SESSION['nom']       = $utilisateurTrouve['nom'];
                $_SESSION['prenom']    = $utilisateurTrouve['prenom'];
                $_SESSION['telephone'] = $utilisateurTrouve['telephone'];
                $_SESSION['agrement']  = $utilisateurTrouve['numero_agrement'];
            }
        }

        return ($utilisateurTrouve !== null && $utilisateurTrouve !== false);
    }

    public function deconnecterUtilisateur() {
        session_unset();
        session_destroy();
    }

    public function estConnecte()  { return isset($_SESSION['user_id']); }
    public function estAdmin()     { return isset($_SESSION['type_user']) && $_SESSION['type_user'] === 'admin'; }
    public function estClient()    { return isset($_SESSION['type_user']) && $_SESSION['type_user'] === 'client'; }
    public function estMoniteur()  { return isset($_SESSION['type_user']) && $_SESSION['type_user'] === 'moniteur'; }

    public function redirigerSelonRole() {
        if ($this->estAdmin())    return "index.php?page=dashboard_admin";
        if ($this->estClient())   return "index.php?page=dashboard_client";
        if ($this->estMoniteur()) return "index.php?page=dashboard_moniteur";
        return "index.php?page=connexion";
    }

    /*------------------------- CLIENTS ------------------------*/

    public function inscrireNouveauClient($donnees) {
        if ($this->modele->emailClientExiste($donnees['email'])) {
            return ['succes' => false, 'message' => 'Cet email est déjà utilisé.'];
        }
        $insertion = $this->modele->ajouterClient($donnees);
        return $insertion
            ? ['succes' => true,  'message' => 'Client ajouté avec succès !']
            : ['succes' => false, 'message' => "Erreur lors de l'ajout du client."];
    }

    public function obtenirTousLesClients() {
        return $this->modele->listerTousLesClients();
    }

    public function obtenirClientParId($idClient) {
        return $this->modele->trouverClientParId($idClient);
    }

    public function mettreAJourClient($donnees) {
        $modification = $this->modele->modifierClient($donnees);
        if ($modification && $this->estClient() && $_SESSION['user_id'] == $donnees['id_client']) {
            $_SESSION['nom']    = $donnees['nom'];
            $_SESSION['prenom'] = $donnees['prenom'];
        }
        return $modification
            ? ['succes' => true,  'message' => 'Client modifié avec succès.']
            : ['succes' => false, 'message' => 'Erreur lors de la modification.'];
    }

    public function supprimerClient($idClient) {
        $nbCours   = $this->modele->compterCoursDuClient($idClient);
        $nbExamens = $this->modele->compterExamensDuClient($idClient);
        if ($nbCours > 0 || $nbExamens > 0) {
            return ['succes' => false, 'message' => 'Impossible : ce client a des cours ou examens liés.'];
        }
        $suppression = $this->modele->supprimerClient($idClient);
        return $suppression
            ? ['succes' => true,  'message' => 'Client supprimé avec succès.']
            : ['succes' => false, 'message' => 'Erreur lors de la suppression.'];
    }

    /*--------------------------MONITEURS ------------------------------*/

    public function ajouterNouveauMoniteur($donnees) {
        if ($this->modele->emailMoniteurExiste($donnees['email'])) {
            return ['succes' => false, 'message' => 'Cet email est déjà utilisé.'];
        }
        $insertion = $this->modele->ajouterMoniteur($donnees);
        return $insertion
            ? ['succes' => true,  'message' => 'Moniteur ajouté avec succès.']
            : ['succes' => false, 'message' => "Erreur lors de l'ajout du moniteur."];
    }

    public function obtenirTousLesMoniteurs() {
        return $this->modele->listerTousLesMoniteurs();
    }

    public function obtenirMoniteurParId($idMoniteur) {
        return $this->modele->trouverMoniteurParId($idMoniteur);
    }

    public function obtenirMoniteursPageAccueil() {
        return $this->modele->listerMoniteursPageAccueil();
    }

    public function obtenirElevesMoniteur($idMoniteur) {
        return $this->modele->listerElevesMoniteur($idMoniteur);
    }

    public function mettreAJourMoniteur($donnees) {
        $modification = $this->modele->modifierMoniteur($donnees);
        if ($modification && $this->estMoniteur() && $_SESSION['user_id'] == $donnees['id_moniteur']) {
            $_SESSION['nom']    = $donnees['nom'];
            $_SESSION['prenom'] = $donnees['prenom'];
        }
        return $modification
            ? ['succes' => true,  'message' => 'Moniteur modifié avec succès.']
            : ['succes' => false, 'message' => 'Erreur lors de la modification.'];
    }

    public function supprimerMoniteur($idMoniteur) {
        $nbCours = $this->modele->compterCoursDuMoniteur($idMoniteur);
        if ($nbCours > 0) {
            return ['succes' => false, 'message' => 'Impossible : ce moniteur a des cours liés.'];
        }
        $suppression = $this->modele->supprimerMoniteur($idMoniteur);
        return $suppression
            ? ['succes' => true,  'message' => 'Moniteur supprimé avec succès.']
            : ['succes' => false, 'message' => 'Erreur lors de la suppression.'];
    }


    /*------------------ COURS THEORIQUES -----------------------*/

    public function creerCoursTheorique($donnees) {
        $insertion = $this->modele->ajouterCoursTheorique($donnees);
        return $insertion
            ? ['succes' => true,  'message' => 'Cours théorique ajouté avec succès.']
            : ['succes' => false, 'message' => "Erreur lors de l'ajout du cours."];
    }

    public function obtenirTousLesCoursTheoriques() {
        return $this->modele->listerTousLesCoursTheoriques();
    }

    public function obtenirCoursTheoriquesClient($idClient) {
        return $this->modele->listerCoursTheoriquesClient($idClient);
    }

    public function obtenirCoursTheoriquesDisponibles($idClient) {
        return $this->modele->listerCoursTheoriquesDisponibles($idClient);
    }

    public function inscrireClientAuCoursTheorique($idClient, $idCours) {
        try {
            $inscription = $this->modele->inscrireClientAuCoursTheorique($idClient, $idCours);
            return $inscription
                ? ['succes' => true,  'message' => 'Inscription réussie.']
                : ['succes' => false, 'message' => "Erreur lors de l'inscription."];
        } catch (Exception $e) {
            return ['succes' => false, 'message' => 'Vous êtes déjà inscrit à ce cours.'];
        }
    }

    public function supprimerCoursTheorique($idCours) {
        $suppression = $this->modele->supprimerCoursTheorique($idCours);
        return $suppression
            ? ['succes' => true,  'message' => 'Cours théorique supprimé.']
            : ['succes' => false, 'message' => 'Erreur lors de la suppression.'];
    }


    /* --------------------COURS PRATIQUES-----------------------*/


    public function planifierCoursPratique($donnees) {
        $insertion = $this->modele->ajouterCoursPratique($donnees);
        return $insertion
            ? ['succes' => true,  'message' => 'Cours pratique planifié avec succès.']
            : ['succes' => false, 'message' => "Erreur lors de l'ajout du cours."];
    }

    public function obtenirTousLesCoursPratiques() {
        return $this->modele->listerTousLesCoursPratiques();
    }

    public function obtenirCoursPratiquesClient($idClient) {
        return $this->modele->listerCoursPratiquesClient($idClient);
    }

    public function obtenirCoursPratiquesMoniteur($idMoniteur) {
        return $this->modele->listerCoursPratiquesMoniteur($idMoniteur);
    }

    public function obtenirProchainsCoursDuClient($idClient) {
        return $this->modele->listerProchainsCoursDuClient($idClient);
    }

    public function obtenirProchainsCoursDuMoniteur($idMoniteur) {
        return $this->modele->listerProchainsCoursDuMoniteur($idMoniteur);
    }

    public function terminerCoursPratique($idSeance) {
        $cours = $this->modele->trouverCoursPratiqueParId($idSeance);
        if (!$cours) return ['succes' => false, 'message' => 'Cours introuvable.'];
        $cours['statut'] = 'termine';
        $modification = $this->modele->modifierCoursPratique($cours);
        return $modification
            ? ['succes' => true,  'message' => 'Cours marqué comme terminé.']
            : ['succes' => false, 'message' => 'Erreur lors de la validation.'];
    }

    public function annulerCoursPratique($idSeance) {
        $cours = $this->modele->trouverCoursPratiqueParId($idSeance);
        if (!$cours) return ['succes' => false, 'message' => 'Cours introuvable.'];
        $cours['statut'] = 'annule';
        $modification = $this->modele->modifierCoursPratique($cours);
        return $modification
            ? ['succes' => true,  'message' => 'Cours annulé.']
            : ['succes' => false, 'message' => "Erreur lors de l'annulation."];
    }

    public function supprimerCoursPratique($idSeance) {
        $suppression = $this->modele->supprimerCoursPratique($idSeance);
        return $suppression
            ? ['succes' => true,  'message' => 'Cours supprimé.']
            : ['succes' => false, 'message' => 'Erreur lors de la suppression.'];
    }

    /*---------------------EXAMENS -------------------------*/

    public function planifierExamen($donnees) {
        $insertion = $this->modele->ajouterExamen($donnees);
        return $insertion
            ? ['succes' => true,  'message' => 'Examen planifié avec succès.']
            : ['succes' => false, 'message' => "Erreur lors de la planification."];
    }

    public function obtenirTousLesExamens() {
        return $this->modele->listerTousLesExamens();
    }

    public function obtenirExamensClient($idClient) {
        return $this->modele->listerExamensDuClient($idClient);
    }

    public function enregistrerResultatExamen($idExamen, $resultat, $notes = null) {
        $examen = $this->modele->trouverExamenParId($idExamen);
        if (!$examen) return ['succes' => false, 'message' => 'Examen introuvable.'];
        $examen['resultat'] = $resultat;
        $examen['notes']    = $notes ?? $examen['notes'];
        $modification = $this->modele->modifierExamen($examen);
        return $modification
            ? ['succes' => true,  'message' => 'Résultat enregistré avec succès.']
            : ['succes' => false, 'message' => "Erreur lors de l'enregistrement."];
    }

    public function supprimerExamen($idExamen) {
        $suppression = $this->modele->supprimerExamen($idExamen);
        return $suppression
            ? ['succes' => true,  'message' => 'Examen supprimé.']
            : ['succes' => false, 'message' => 'Erreur lors de la suppression.'];
    }

    public function obtenirMoniteurPrincipalClient($idClient) {
        return $this->modele->trouverMoniteurPrincipalDuClient($idClient);
    }

    /* ---------------------------DONNEES DASHBOARDS--------------------------------*/

    public function getDashAdmin() {
        return [
            'clients'          => $this->modele->listerTousLesClients(),
            'moniteurs'        => $this->modele->listerTousLesMoniteurs(),
            'cours_theoriques' => $this->modele->listerTousLesCoursTheoriques(),
            'cours_pratiques'  => $this->modele->listerTousLesCoursPratiques(),
            'examens'          => $this->modele->listerTousLesExamens(),
            'stats' => [
                'nb_clients'          => $this->modele->compterLignesDansTable('client'),
                'nb_moniteurs'        => $this->modele->compterLignesDansTable('moniteur'),
                'nb_cours_theoriques' => $this->modele->compterLignesDansTable('cours_theorique'),
                'nb_cours_pratiques'  => $this->modele->compterLignesDansTable('cours_pratique'),
                'nb_examens'          => $this->modele->compterLignesDansTable('examen')
            ]
        ];
    }

    public function getDashClient($idClient) {
        $progression   = $this->modele->calculerProgressionClient($idClient);
        $coursAVenir   = $this->modele->listerProchainsCoursDuClient($idClient);
        return [
            'client'                       => $this->modele->trouverClientParId($idClient),
            'cours_pratiques'              => $this->modele->listerCoursPratiquesClient($idClient),
            'cours_a_venir'                => $coursAVenir,
            'cours_theoriques'             => $this->modele->listerCoursTheoriquesClient($idClient),
            'cours_theoriques_disponibles' => $this->modele->listerCoursTheoriquesDisponibles($idClient),
            'examens'                      => $this->modele->listerExamensDuClient($idClient),
            'moniteur_principal'           => $this->modele->trouverMoniteurPrincipalDuClient($idClient),
            'prochain_cours'               => $coursAVenir[0] ?? null,
            'stats' => [
                'nb_cours_pratiques'  => $this->modele->compterCoursDuClient($idClient),
                'nb_cours_theoriques' => $this->modele->compterCoursTheoriquesDuClient($idClient),
                'nb_examens'          => $this->modele->compterExamensDuClient($idClient),
                'nb_examens_reussis'  => $this->modele->compterExamensReussisDuClient($idClient),
                'heures_conduite'     => $this->modele->calculerHeuresDeConduite($idClient),
                'progression'         => $progression
            ]
        ];
    }

    public function getDashMoniteur($idMoniteur) {
        $coursAVenir = $this->modele->listerProchainsCoursDuMoniteur($idMoniteur);
        return [
            'moniteur'        => $this->modele->trouverMoniteurParId($idMoniteur),
            'eleves'          => $this->modele->listerElevesMoniteur($idMoniteur),
            'cours_pratiques' => $this->modele->listerCoursPratiquesMoniteur($idMoniteur),
            'cours_a_venir'   => $coursAVenir,
            'prochain_cours'  => $coursAVenir[0] ?? null,
            'stats' => [
                'nb_eleves'          => $this->modele->compterElevesMoniteur($idMoniteur),
                'nb_cours_total'     => $this->modele->compterCoursDuMoniteur($idMoniteur),
                'nb_cours_termines'  => $this->modele->compterCoursTerminesDuMoniteur($idMoniteur),
                'nb_cours_a_venir'   => count($coursAVenir),
                'heures_enseignees'  => $this->modele->compterCoursTerminesDuMoniteur($idMoniteur)
            ]
        ];
    }
}
?>
