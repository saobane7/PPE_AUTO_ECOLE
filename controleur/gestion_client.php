<?php
require_once("controleur.class.php");

class GestionClient extends Controleur {
    
    public function getProfilComplet($id_client) {
        $client = $this->getClientById($id_client);
        $cours_pratiques = $this->getCoursPratiquesClient($id_client);
        $cours_theoriques = $this->getCoursTheoriquesClient($id_client);
        $examens = $this->getExamensClient($id_client);
        $moniteur = $this->getMoniteurPrincipalClient($id_client);
        $progression = $this->modele->get_progression_client($id_client);
        
        return [
            'client' => $client,
            'cours_pratiques' => $cours_pratiques,
            'cours_theoriques' => $cours_theoriques,
            'examens' => $examens,
            'moniteur' => $moniteur,
            'progression' => $progression,
            'stats' => [
                'total_heures' => $this->modele->get_heures_conduite_client($id_client),
                'cours_termines' => count(array_filter($cours_pratiques, fn($c) => $c['statut'] === 'termine')),
                'cours_planifies' => count(array_filter($cours_pratiques, fn($c) => $c['statut'] === 'planifie')),
                'examens_reussis' => count(array_filter($examens, fn($e) => $e['resultat'] === 'reussi')),
                'examens_echoues' => count(array_filter($examens, fn($e) => $e['resultat'] === 'echoue'))
            ]
        ];
    }
    
    public function getPlanningClient($id_client) {
        $cours_a_venir = $this->getCoursPratiquesAVenirClient($id_client);
        $examens_a_venir = array_filter(
            $this->getExamensClient($id_client), 
            fn($e) => $e['date_examen'] >= date('Y-m-d') && is_null($e['resultat'])
        );
        $cours_theoriques_a_venir = array_filter(
            $this->getCoursTheoriquesClient($id_client),
            fn($c) => $c['date_cours'] >= date('Y-m-d') && $c['statut'] === 'planifie'
        );
        
        $evenements = [];
        
        foreach ($cours_a_venir as $cours) {
            $evenements[] = [
                'type' => 'cours_pratique',
                'date' => $cours['date_seance'],
                'heure' => $cours['heure_debut'],
                'titre' => 'Cours pratique avec ' . $cours['moniteur_prenom'] . ' ' . $cours['moniteur_nom'],
                'details' => $cours
            ];
        }
        
        foreach ($examens_a_venir as $examen) {
            $evenements[] = [
                'type' => 'examen',
                'date' => $examen['date_examen'],
                'heure' => $examen['heure'],
                'titre' => 'Examen ' . $examen['type'],
                'details' => $examen
            ];
        }
        
        foreach ($cours_theoriques_a_venir as $cours) {
            $evenements[] = [
                'type' => 'cours_theorique',
                'date' => $cours['date_cours'],
                'heure' => $cours['heure_debut'],
                'titre' => $cours['titre'],
                'details' => $cours
            ];
        }
        
        
        usort($evenements, function($a, $b) {
            if ($a['date'] == $b['date']) {
                return strcmp($a['heure'], $b['heure']);
            }
            return strcmp($a['date'], $b['date']);
        });
        
        return $evenements;
    }
}
?>