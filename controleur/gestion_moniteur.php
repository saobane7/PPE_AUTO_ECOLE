<?php
require_once("controleur.class.php");

class GestionMoniteur extends Controleur {

    public function getProfilComplet($idMoniteur) {
        $eleves     = $this->obtenirElevesMoniteur($idMoniteur);
        $tousCours  = $this->obtenirCoursPratiquesMoniteur($idMoniteur);

        $statsParEleve = [];
        foreach ($eleves as $eleve) {
            $coursDeEleve = array_filter($tousCours, fn($c) => $c['id_client'] == $eleve['id_client']);
            $coursDeEleve = array_values($coursDeEleve);
            $statsParEleve[$eleve['id_client']] = [
                'eleve'             => $eleve,
                'nb_cours'          => count($coursDeEleve),
                'nb_cours_termines' => count(array_filter($coursDeEleve, fn($c) => $c['statut'] === 'termine')),
                'dernier_cours'     => !empty($coursDeEleve) ? $coursDeEleve[0] : null
            ];
        }

        return [
            'moniteur'    => $this->obtenirMoniteurParId($idMoniteur),
            'eleves'      => $eleves,
            'stats_eleves'=> $statsParEleve,
            'cours'       => $tousCours,
            'stats'       => [
                'nb_eleves'          => count($eleves),
                'nb_cours'           => count($tousCours),
                'nb_cours_termines'  => count(array_filter($tousCours, fn($c) => $c['statut'] === 'termine')),
                'nb_cours_planifies' => count(array_filter($tousCours, fn($c) => $c['statut'] === 'planifie'))
            ]
        ];
    }
}
?>
