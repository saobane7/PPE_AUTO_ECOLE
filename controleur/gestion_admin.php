<?php
require_once("controleur.class.php");

class GestionAdmin extends Controleur {

    public function getTableauDeBord() {
        $tousClients = $this->obtenirTousLesClients();
        $tousCours   = $this->obtenirTousLesCoursPratiques();
        $tousExamens = $this->obtenirTousLesExamens();

        $clientsParType = ['etudiant' => 0, 'particulier' => 0, 'professionnel' => 0];
        foreach ($tousClients as $unClient) {
            if (isset($clientsParType[$unClient['type']])) {
                $clientsParType[$unClient['type']]++;
            }
        }

        $coursParStatut = ['planifie' => 0, 'termine' => 0, 'annule' => 0];
        foreach ($tousCours as $unCours) {
            if (isset($coursParStatut[$unCours['statut']])) {
                $coursParStatut[$unCours['statut']]++;
            }
        }

        $examensParResultat = ['reussi' => 0, 'echoue' => 0, 'en_attente' => 0];
        foreach ($tousExamens as $unExamen) {
            if ($unExamen['resultat'] === 'reussi')     $examensParResultat['reussi']++;
            elseif ($unExamen['resultat'] === 'echoue') $examensParResultat['echoue']++;
            else                                         $examensParResultat['en_attente']++;
        }

        $dernieresActivites = $this->getDernieresActivites($tousClients, $this->obtenirTousLesMoniteurs(), $tousCours, $tousExamens);

        return [
            'stats'               => $this->getDashAdmin()['stats'],
            'clients_par_type'    => $clientsParType,
            'cours_par_statut'    => $coursParStatut,
            'examens_par_resultat'=> $examensParResultat,
            'dernieres_activites' => $dernieresActivites
        ];
    }

    private function getDernieresActivites($clients, $moniteurs, $cours, $examens) {
        $activites = [];

        foreach (array_slice($clients, 0, 3) as $c) {
            $activites[] = ['type' => 'client',   'action' => 'inscription', 'nom' => $c['prenom'].' '.$c['nom'],    'date' => date('Y-m-d H:i:s')];
        }
        foreach (array_slice($moniteurs, 0, 3) as $m) {
            $activites[] = ['type' => 'moniteur', 'action' => 'ajout',       'nom' => $m['prenom'].' '.$m['nom'],    'date' => date('Y-m-d H:i:s')];
        }
        foreach (array_slice($cours, 0, 3) as $cp) {
            $activites[] = ['type' => 'cours',    'action' => 'planification','nom' => 'Cours: '.$cp['client_prenom'].' avec '.$cp['moniteur_prenom'], 'date' => date('Y-m-d H:i:s')];
        }
        foreach (array_slice($examens, 0, 3) as $e) {
            $activites[] = ['type' => 'examen',   'action' => $e['resultat'] ? 'résultat' : 'planification', 'nom' => $e['type'].' - '.$e['client_prenom'], 'date' => date('Y-m-d H:i:s')];
        }

        return array_slice($activites, 0, 10);
    }
}
?>
