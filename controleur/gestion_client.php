<?php
require_once("controleur.class.php");

class GestionClient extends Controleur {

    public function getProfilComplet($idClient) {
        $coursPratiques  = $this->obtenirCoursPratiquesClient($idClient);
        $coursTheoriques = $this->obtenirCoursTheoriquesClient($idClient);
        $examens         = $this->obtenirExamensClient($idClient);

        return [
            'client'           => $this->obtenirClientParId($idClient),
            'cours_pratiques'  => $coursPratiques,
            'cours_theoriques' => $coursTheoriques,
            'examens'          => $examens,
            'moniteur'         => $this->obtenirMoniteurPrincipalClient($idClient),
            'stats'            => [
                'cours_termines'  => count(array_filter($coursPratiques, fn($c) => $c['statut'] === 'termine')),
                'examens_reussis' => count(array_filter($examens, fn($e) => $e['resultat'] === 'reussi'))
            ]
        ];
    }
}
?>
