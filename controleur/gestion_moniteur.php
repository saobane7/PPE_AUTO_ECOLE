<?php
require_once("controleur.class.php");

class GestionMoniteur extends Controleur {
    
    public function getProfilComplet($id_moniteur) {
        $moniteur = $this->getMoniteurById($id_moniteur);
        $eleves = $this->getElevesMoniteur($id_moniteur);
        $cours = $this->getCoursPratiquesMoniteur($id_moniteur);
        
        
        $stats_eleves = [];
        foreach ($eleves as $eleve) {
            $cours_eleve = array_filter($cours, fn($c) => $c['id_client'] == $eleve['id_client']);
            $stats_eleves[$eleve['id_client']] = [
                'eleve' => $eleve,
                'nb_cours' => count($cours_eleve),
                'nb_cours_termines' => count(array_filter($cours_eleve, fn($c) => $c['statut'] === 'termine')),
                'dernier_cours' => !empty($cours_eleve) ? array_values($cours_eleve)[0] : null
            ];
        }
        
        return [
            'moniteur' => $moniteur,
            'eleves' => $eleves,
            'stats_eleves' => $stats_eleves,
            'cours' => $cours,
            'stats' => [
                'nb_eleves' => count($eleves),
                'nb_cours' => count($cours),
                'nb_cours_termines' => count(array_filter($cours, fn($c) => $c['statut'] === 'termine')),
                'nb_cours_planifies' => count(array_filter($cours, fn($c) => $c['statut'] === 'planifie')),
                'heures_enseignees' => count(array_filter($cours, fn($c) => $c['statut'] === 'termine'))
            ]
        ];
    }
}
?>