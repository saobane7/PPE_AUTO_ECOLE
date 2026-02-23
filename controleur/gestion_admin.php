<?php
require_once("controleur.class.php");

class GestionAdmin extends Controleur {
    
    public function getTableauDeBord() {
        $stats = $this->getStatsGlobales();
        $clients = $this->getAllClients();
        $moniteurs = $this->getAllMoniteurs();
        $cours_pratiques = $this->getAllCoursPratiques();
        $examens = $this->getAllExamens();
        

        $clients_par_type = [
            'etudiant' => 0,
            'particulier' => 0,
            'professionnel' => 0
        ];
        
        foreach ($clients as $client) {
            if (isset($clients_par_type[$client['type']])) {
                $clients_par_type[$client['type']]++;
            }
        }
        

        $cours_par_statut = [
            'planifie' => 0,
            'termine' => 0,
            'annule' => 0
        ];
        
        foreach ($cours_pratiques as $cours) {
            if (isset($cours_par_statut[$cours['statut']])) {
                $cours_par_statut[$cours['statut']]++;
            }
        }
        
       
        $examens_par_resultat = [
            'reussi' => 0,
            'echoue' => 0,
            'en_attente' => 0
        ];
        
        foreach ($examens as $e) {
            if ($e['resultat'] === 'reussi') {
                $examens_par_resultat['reussi']++;
            } elseif ($e['resultat'] === 'echoue') {
                $examens_par_resultat['echoue']++;
            } else {
                $examens_par_resultat['en_attente']++;
            }
        }
        
        
        $dernieres_activites = $this->getDernieresActivites();
        
        return [
            'stats' => $stats,
            'clients_par_type' => $clients_par_type,
            'cours_par_statut' => $cours_par_statut,
            'examens_par_resultat' => $examens_par_resultat,
            'moniteurs_disponibles' => count($moniteurs),
            'dernieres_activites' => $dernieres_activites
        ];
    }
    
    public function getDernieresActivites() {
        $activites = [];
        
       
        $clients = $this->getAllClients();
        foreach (array_slice($clients, 0, 5) as $client) {
            $activites[] = [
                'type' => 'client',
                'action' => 'inscription',
                'nom' => $client['prenom'] . ' ' . $client['nom'],
                'date' => $client['created_at'] ?? date('Y-m-d H:i:s')
            ];
        }
        
        
        $moniteurs = $this->getAllMoniteurs();
        foreach (array_slice($moniteurs, 0, 5) as $moniteur) {
            $activites[] = [
                'type' => 'moniteur',
                'action' => 'ajout',
                'nom' => $moniteur['prenom'] . ' ' . $moniteur['nom'],
                'date' => $moniteur['created_at'] ?? date('Y-m-d H:i:s')
            ];
        }
        
        
        $cours = $this->getAllCoursPratiques();
        foreach (array_slice($cours, 0, 5) as $c) {
            $activites[] = [
                'type' => 'cours',
                'action' => 'planification',
                'nom' => 'Cours: ' . $c['client_prenom'] . ' avec ' . $c['moniteur_prenom'],
                'date' => $c['created_at'] ?? date('Y-m-d H:i:s')
            ];
        }
        
        
        $examens = $this->getAllExamens();
        foreach (array_slice($examens, 0, 5) as $e) {
            $activites[] = [
                'type' => 'examen',
                'action' => $e['resultat'] ? 'résultat' : 'planification',
                'nom' => $e['type'] . ' - ' . $e['client_prenom'],
                'date' => $e['created_at'] ?? date('Y-m-d H:i:s')
            ];
        }
        
        
        usort($activites, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        
        return array_slice($activites, 0, 10);
    }
    
   
    public function prepareClientData($post) {
        return [
            'id_client' => $post['id_client'],
            'nom' => trim($post['nom']),
            'prenom' => trim($post['prenom']),
            'telephone' => trim($post['telephone']),
            'date_naissance' => $post['date_naissance'],
            'type' => $post['type']
        ];
    }
    

    public function prepareMoniteurData($post, $isUpdate = false) {
        $data = [
            'nom' => trim($post['nom']),
            'prenom' => trim($post['prenom']),
            'email' => trim($post['email']),
            'telephone' => trim($post['telephone']),
            'date_embauche' => $post['date_embauche'],
            'numero_agrement' => trim($post['numero_agrement'])
        ];
        
        if ($isUpdate) {
            $data['id_moniteur'] = $post['id_moniteur'];
        } else {
            $data['mdp'] = $post['mdp'];
        }
        
        return $data;
    }
    
    public function prepareCoursPratiqueData($post) {
        return [
            'date_seance' => $post['date_seance'],
            'heure_debut' => $post['heure_debut'],
            'heure_fin' => $post['heure_fin'],
            'id_moniteur' => $post['id_moniteur'],
            'id_client' => $post['id_client'],
            'type_vehicule' => $post['type_vehicule'] ?? 'voiture',
            'statut' => 'planifie',
            'notes' => $post['notes'] ?? null
        ];
    }
    
    public function prepareExamenData($post) {
        return [
            'type' => $post['type'],
            'date_examen' => $post['date_examen'],
            'heure' => $post['heure'],
            'id_client' => $post['id_client'],
            'lieu' => $post['lieu'] ?? null,
            'resultat' => null,
            'notes' => $post['notes'] ?? null
        ];
    }
}
?>