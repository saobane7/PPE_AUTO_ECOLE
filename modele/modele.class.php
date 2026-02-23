<?php
class Modele {
    private $unPdo;

    public function __construct() {
        $url = "mysql:host=localhost;dbname=sat_auto;charset=utf8";
        $user = "root";
        $mdp = "";

        try {
            $this->unPdo = new PDO($url, $user, $mdp);
            $this->unPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->unPdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $exp) {
            die("<br> Erreur de connexion à " . $url . "<br>" . $exp->getMessage());
        }
    }

    public function selectWhere_user($email, $mdp) {
        $requete = "SELECT * FROM user WHERE email = :email AND mdp = :mdp";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":email" => $email, ":mdp" => $mdp]);
        return $select->fetch();
    }

    public function selectAll_users() {
        $requete = "SELECT * FROM user ORDER BY nom, prenom";
        return $this->unPdo->query($requete)->fetchAll();
    }

 
    public function insert_client($tab) {
        $requete = "INSERT INTO client (nom, prenom, email, mot_de_passe, telephone, date_naissance, type) 
                    VALUES (:nom, :prenom, :email, :mdp, :telephone, :date_naissance, :type)";
        $insert = $this->unPdo->prepare($requete);
        return $insert->execute([
            ":nom" => $tab['nom'],
            ":prenom" => $tab['prenom'],
            ":email" => $tab['email'],
            ":mdp" => $tab['mdp'],
            ":telephone" => $tab['telephone'],
            ":date_naissance" => $tab['date_naissance'],
            ":type" => $tab['type']
        ]);
    }

    public function selectWhere_client($email, $mdp) {
        $requete = "SELECT * FROM client WHERE email = :email AND mot_de_passe = :mdp";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":email" => $email, ":mdp" => $mdp]);
        return $select->fetch();
    }

    public function selectAll_clients() {
        $requete = "SELECT * FROM client ORDER BY nom, prenom";
        return $this->unPdo->query($requete)->fetchAll();
    }

    public function select_client_by_id($id_client) {
        $requete = "SELECT * FROM client WHERE id_client = :id_client";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_client" => $id_client]);
        return $select->fetch();
    }

    public function update_client($tab) {
        $requete = "UPDATE client SET 
                    nom = :nom, 
                    prenom = :prenom, 
                    telephone = :telephone, 
                    date_naissance = :date_naissance, 
                    type = :type
                    WHERE id_client = :id_client";
        $update = $this->unPdo->prepare($requete);
        return $update->execute([
            ":id_client" => $tab['id_client'],
            ":nom" => $tab['nom'],
            ":prenom" => $tab['prenom'],
            ":telephone" => $tab['telephone'],
            ":date_naissance" => $tab['date_naissance'],
            ":type" => $tab['type']
        ]);
    }

    public function emailExists_client($email) {
        $requete = "SELECT id_client FROM client WHERE email = :email";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":email" => $email]);
        return $select->rowCount() > 0;
    }

    public function delete_client($id_client) {
        $requete = "DELETE FROM client WHERE id_client = :id_client";
        $delete = $this->unPdo->prepare($requete);
        return $delete->execute([":id_client" => $id_client]);
    }

    public function selectLike_clients($filtre) {
        $requete = "SELECT * FROM client 
                    WHERE nom LIKE :filtre OR prenom LIKE :filtre OR email LIKE :filtre OR telephone LIKE :filtre
                    ORDER BY nom, prenom";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":filtre" => "%" . $filtre . "%"]);
        return $select->fetchAll();
    }

    public function insert_moniteur($tab) {
        $requete = "INSERT INTO moniteur (nom, prenom, email, mot_de_passe, telephone, date_embauche, numero_agrement) 
                    VALUES (:nom, :prenom, :email, :mdp, :telephone, :date_embauche, :numero_agrement)";
        $insert = $this->unPdo->prepare($requete);
        return $insert->execute([
            ":nom" => $tab['nom'],
            ":prenom" => $tab['prenom'],
            ":email" => $tab['email'],
            ":mdp" => $tab['mdp'],
            ":telephone" => $tab['telephone'],
            ":date_embauche" => $tab['date_embauche'],
            ":numero_agrement" => $tab['numero_agrement']
        ]);
    }

    public function selectWhere_moniteur($email, $mdp) {
        $requete = "SELECT * FROM moniteur WHERE email = :email AND mot_de_passe = :mdp";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":email" => $email, ":mdp" => $mdp]);
        return $select->fetch();
    }

    public function selectAll_moniteurs() {
        $requete = "SELECT * FROM moniteur ORDER BY nom, prenom";
        return $this->unPdo->query($requete)->fetchAll();
    }

    public function select_moniteur_by_id($id_moniteur) {
        $requete = "SELECT * FROM moniteur WHERE id_moniteur = :id_moniteur";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_moniteur" => $id_moniteur]);
        return $select->fetch();
    }

    public function update_moniteur($tab) {
        $requete = "UPDATE moniteur SET 
                    nom = :nom, 
                    prenom = :prenom, 
                    telephone = :telephone
                    WHERE id_moniteur = :id_moniteur";
        $update = $this->unPdo->prepare($requete);
        return $update->execute([
            ":id_moniteur" => $tab['id_moniteur'],
            ":nom" => $tab['nom'],
            ":prenom" => $tab['prenom'],
            ":telephone" => $tab['telephone']
        ]);
    }

    public function emailExists_moniteur($email) {
        $requete = "SELECT id_moniteur FROM moniteur WHERE email = :email";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":email" => $email]);
        return $select->rowCount() > 0;
    }

    public function delete_moniteur($id_moniteur) {
        $requete = "DELETE FROM moniteur WHERE id_moniteur = :id_moniteur";
        $delete = $this->unPdo->prepare($requete);
        return $delete->execute([":id_moniteur" => $id_moniteur]);
    }

    public function selectAll_moniteurs_home() {
        $requete = "SELECT * FROM moniteur ORDER BY nom, prenom LIMIT 3";
        return $this->unPdo->query($requete)->fetchAll();
    }


    public function insert_cours_theorique($tab) {
        $requete = "INSERT INTO cours_theorique (titre, date_cours, heure_debut, heure_fin, salle, places_max, statut) 
                    VALUES (:titre, :date_cours, :heure_debut, :heure_fin, :salle, :places_max, :statut)";
        $insert = $this->unPdo->prepare($requete);
        return $insert->execute([
            ":titre" => $tab['titre'],
            ":date_cours" => $tab['date_cours'],
            ":heure_debut" => $tab['heure_debut'],
            ":heure_fin" => $tab['heure_fin'],
            ":salle" => $tab['salle'],
            ":places_max" => $tab['places_max'],
            ":statut" => isset($tab['statut']) ? $tab['statut'] : 'planifie'
        ]);
    }

    public function selectAll_cours_theoriques() {
        $requete = "SELECT ct.*, 
                    (SELECT COUNT(*) FROM inscription_theorique it WHERE it.id_cours = ct.id_cours) AS nb_inscrits
                    FROM cours_theorique ct 
                    ORDER BY ct.date_cours DESC, ct.heure_debut";
        return $this->unPdo->query($requete)->fetchAll();
    }

    public function select_cours_theorique_by_id($id_cours) {
        $requete = "SELECT * FROM cours_theorique WHERE id_cours = :id_cours";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_cours" => $id_cours]);
        return $select->fetch();
    }

    public function selectAll_cours_theoriques_client($id_client) {
        $requete = "SELECT ct.* 
                    FROM cours_theorique ct 
                    JOIN inscription_theorique it ON ct.id_cours = it.id_cours 
                    WHERE it.id_client = :id 
                    ORDER BY ct.date_cours DESC, ct.heure_debut";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id" => $id_client]);
        return $select->fetchAll();
    }

    public function select_cours_theoriques_disponibles($id_client) {
        $requete = "SELECT ct.* 
                    FROM cours_theorique ct 
                    WHERE ct.id_cours NOT IN (
                        SELECT id_cours FROM inscription_theorique WHERE id_client = :id_client
                    )
                    AND ct.date_cours >= CURDATE()
                    AND ct.statut = 'planifie'
                    ORDER BY ct.date_cours, ct.heure_debut";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_client" => $id_client]);
        return $select->fetchAll();
    }

    public function inscrire_client_cours_theorique($id_client, $id_cours) {
        $requete = "INSERT INTO inscription_theorique (id_cours, id_client) VALUES (:id_cours, :id_client)";
        $insert = $this->unPdo->prepare($requete);
        return $insert->execute([":id_cours" => $id_cours, ":id_client" => $id_client]);
    }

    public function desinscrire_client_cours_theorique($id_client, $id_cours) {
        $requete = "DELETE FROM inscription_theorique WHERE id_cours = :id_cours AND id_client = :id_client";
        $delete = $this->unPdo->prepare($requete);
        return $delete->execute([":id_cours" => $id_cours, ":id_client" => $id_client]);
    }

    public function update_cours_theorique($tab) {
        $requete = "UPDATE cours_theorique SET 
                    titre = :titre, 
                    date_cours = :date_cours, 
                    heure_debut = :heure_debut, 
                    heure_fin = :heure_fin, 
                    salle = :salle, 
                    places_max = :places_max, 
                    statut = :statut
                    WHERE id_cours = :id_cours";
        $update = $this->unPdo->prepare($requete);
        return $update->execute([
            ":id_cours" => $tab['id_cours'],
            ":titre" => $tab['titre'],
            ":date_cours" => $tab['date_cours'],
            ":heure_debut" => $tab['heure_debut'],
            ":heure_fin" => $tab['heure_fin'],
            ":salle" => $tab['salle'],
            ":places_max" => $tab['places_max'],
            ":statut" => $tab['statut']
        ]);
    }

    public function delete_cours_theorique($id_cours) {
        $requete = "DELETE FROM cours_theorique WHERE id_cours = :id_cours";
        $delete = $this->unPdo->prepare($requete);
        return $delete->execute([":id_cours" => $id_cours]);
    }


    public function insert_cours_pratique($tab) {
        $requete = "INSERT INTO cours_pratique (date_seance, heure_debut, heure_fin, id_moniteur, id_client, type_vehicule, statut, notes) 
                    VALUES (:date_seance, :heure_debut, :heure_fin, :id_moniteur, :id_client, :type_vehicule, :statut, :notes)";
        $insert = $this->unPdo->prepare($requete);
        return $insert->execute([
            ":date_seance" => $tab['date_seance'],
            ":heure_debut" => $tab['heure_debut'],
            ":heure_fin" => $tab['heure_fin'],
            ":id_moniteur" => $tab['id_moniteur'],
            ":id_client" => $tab['id_client'],
            ":type_vehicule" => isset($tab['type_vehicule']) ? $tab['type_vehicule'] : 'voiture',
            ":statut" => isset($tab['statut']) ? $tab['statut'] : 'planifie',
            ":notes" => isset($tab['notes']) ? $tab['notes'] : null
        ]);
    }

    public function selectAll_cours_pratiques() {
        $requete = "SELECT cp.*, 
                    c.nom AS client_nom, c.prenom AS client_prenom, c.email AS client_email, c.telephone AS client_telephone,
                    m.nom AS moniteur_nom, m.prenom AS moniteur_prenom, m.numero_agrement
                    FROM cours_pratique cp
                    JOIN client c ON cp.id_client = c.id_client
                    JOIN moniteur m ON cp.id_moniteur = m.id_moniteur
                    ORDER BY cp.date_seance DESC, cp.heure_debut";
        return $this->unPdo->query($requete)->fetchAll();
    }

    public function selectAll_cours_pratiques_client($id_client) {
        $requete = "SELECT cp.*, m.nom AS moniteur_nom, m.prenom AS moniteur_prenom, m.numero_agrement, m.telephone AS moniteur_telephone
                    FROM cours_pratique cp
                    JOIN moniteur m ON cp.id_moniteur = m.id_moniteur
                    WHERE cp.id_client = :id
                    ORDER BY cp.date_seance DESC, cp.heure_debut";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id" => $id_client]);
        return $select->fetchAll();
    }

    public function selectAll_cours_pratiques_moniteur($id_moniteur) {
        $requete = "SELECT cp.*, c.nom AS client_nom, c.prenom AS client_prenom, c.email AS client_email, c.telephone AS client_telephone, c.type AS client_type
                    FROM cours_pratique cp
                    JOIN client c ON cp.id_client = c.id_client
                    WHERE cp.id_moniteur = :id
                    ORDER BY cp.date_seance DESC, cp.heure_debut";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id" => $id_moniteur]);
        return $select->fetchAll();
    }

    public function select_cours_pratique_by_id($id_seance) {
        $requete = "SELECT cp.*, 
                    c.nom AS client_nom, c.prenom AS client_prenom, c.email AS client_email,
                    m.nom AS moniteur_nom, m.prenom AS moniteur_prenom
                    FROM cours_pratique cp
                    JOIN client c ON cp.id_client = c.id_client
                    JOIN moniteur m ON cp.id_moniteur = m.id_moniteur
                    WHERE cp.id_seance = :id_seance";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_seance" => $id_seance]);
        return $select->fetch();
    }

    public function update_cours_pratique($tab) {
        $requete = "UPDATE cours_pratique SET 
                    date_seance = :date_seance, 
                    heure_debut = :heure_debut, 
                    heure_fin = :heure_fin, 
                    id_moniteur = :id_moniteur, 
                    id_client = :id_client, 
                    type_vehicule = :type_vehicule, 
                    statut = :statut, 
                    notes = :notes
                    WHERE id_seance = :id_seance";
        $update = $this->unPdo->prepare($requete);
        return $update->execute([
            ":id_seance" => $tab['id_seance'],
            ":date_seance" => $tab['date_seance'],
            ":heure_debut" => $tab['heure_debut'],
            ":heure_fin" => $tab['heure_fin'],
            ":id_moniteur" => $tab['id_moniteur'],
            ":id_client" => $tab['id_client'],
            ":type_vehicule" => $tab['type_vehicule'],
            ":statut" => $tab['statut'],
            ":notes" => isset($tab['notes']) ? $tab['notes'] : null
        ]);
    }

    public function delete_cours_pratique($id_seance) {
        $requete = "DELETE FROM cours_pratique WHERE id_seance = :id_seance";
        $delete = $this->unPdo->prepare($requete);
        return $delete->execute([":id_seance" => $id_seance]);
    }

    public function select_cours_pratiques_a_venir_client($id_client) {
        $requete = "SELECT cp.*, m.nom AS moniteur_nom, m.prenom AS moniteur_prenom, m.telephone AS moniteur_telephone
                    FROM cours_pratique cp
                    JOIN moniteur m ON cp.id_moniteur = m.id_moniteur
                    WHERE cp.id_client = :id_client 
                    AND cp.date_seance >= CURDATE() 
                    AND cp.statut = 'planifie'
                    ORDER BY cp.date_seance, cp.heure_debut";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_client" => $id_client]);
        return $select->fetchAll();
    }

    public function select_cours_pratiques_passes_client($id_client) {
        $requete = "SELECT cp.*, m.nom AS moniteur_nom, m.prenom AS moniteur_prenom
                    FROM cours_pratique cp
                    JOIN moniteur m ON cp.id_moniteur = m.id_moniteur
                    WHERE cp.id_client = :id_client 
                    AND (cp.date_seance < CURDATE() OR cp.statut = 'termine')
                    ORDER BY cp.date_seance DESC, cp.heure_debut";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_client" => $id_client]);
        return $select->fetchAll();
    }

    public function select_cours_pratiques_a_venir_moniteur($id_moniteur) {
        $requete = "SELECT cp.*, c.nom AS client_nom, c.prenom AS client_prenom, c.telephone AS client_telephone
                    FROM cours_pratique cp
                    JOIN client c ON cp.id_client = c.id_client
                    WHERE cp.id_moniteur = :id_moniteur 
                    AND cp.date_seance >= CURDATE() 
                    AND cp.statut = 'planifie'
                    ORDER BY cp.date_seance, cp.heure_debut";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_moniteur" => $id_moniteur]);
        return $select->fetchAll();
    }

    public function insert_examen($tab) {
        $requete = "INSERT INTO examen (type, date_examen, heure, id_client, lieu, resultat, notes) 
                    VALUES (:type, :date_examen, :heure, :id_client, :lieu, :resultat, :notes)";
        $insert = $this->unPdo->prepare($requete);
        return $insert->execute([
            ":type" => $tab['type'],
            ":date_examen" => $tab['date_examen'],
            ":heure" => $tab['heure'],
            ":id_client" => $tab['id_client'],
            ":lieu" => isset($tab['lieu']) ? $tab['lieu'] : null,
            ":resultat" => isset($tab['resultat']) ? $tab['resultat'] : null,
            ":notes" => isset($tab['notes']) ? $tab['notes'] : null
        ]);
    }

    public function selectAll_examens() {
        $requete = "SELECT e.*, 
                    c.nom AS client_nom, c.prenom AS client_prenom, c.email AS client_email
                    FROM examen e
                    JOIN client c ON e.id_client = c.id_client
                    ORDER BY e.date_examen DESC, e.heure";
        return $this->unPdo->query($requete)->fetchAll();
    }

    public function selectAll_examens_client($id_client) {
        $requete = "SELECT e.* 
                    FROM examen e
                    WHERE e.id_client = :id
                    ORDER BY e.date_examen DESC, e.heure";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id" => $id_client]);
        return $select->fetchAll();
    }

    public function select_examen_by_id($id_examen) {
        $requete = "SELECT e.*, 
                    c.nom AS client_nom, c.prenom AS client_prenom
                    FROM examen e
                    JOIN client c ON e.id_client = c.id_client
                    WHERE e.id_examen = :id_examen";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_examen" => $id_examen]);
        return $select->fetch();
    }

    public function update_examen($tab) {
        $requete = "UPDATE examen SET 
                    type = :type, 
                    date_examen = :date_examen, 
                    heure = :heure, 
                    id_client = :id_client, 
                    lieu = :lieu, 
                    resultat = :resultat, 
                    notes = :notes
                    WHERE id_examen = :id_examen";
        $update = $this->unPdo->prepare($requete);
        return $update->execute([
            ":id_examen" => $tab['id_examen'],
            ":type" => $tab['type'],
            ":date_examen" => $tab['date_examen'],
            ":heure" => $tab['heure'],
            ":id_client" => $tab['id_client'],
            ":lieu" => isset($tab['lieu']) ? $tab['lieu'] : null,
            ":resultat" => isset($tab['resultat']) ? $tab['resultat'] : null,
            ":notes" => isset($tab['notes']) ? $tab['notes'] : null
        ]);
    }

    public function delete_examen($id_examen) {
        $requete = "DELETE FROM examen WHERE id_examen = :id_examen";
        $delete = $this->unPdo->prepare($requete);
        return $delete->execute([":id_examen" => $id_examen]);
    }


    public function selectAll_eleves_moniteur($id_moniteur) {
        $requete = "SELECT DISTINCT c.*
                    FROM client c
                    JOIN cours_pratique cp ON c.id_client = cp.id_client
                    WHERE cp.id_moniteur = :id
                    ORDER BY c.nom, c.prenom";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id" => $id_moniteur]);
        return $select->fetchAll();
    }

    public function select_moniteur_principal_client($id_client) {
        $requete = "SELECT m.*, COUNT(cp.id_seance) AS nb_cours
                    FROM moniteur m
                    JOIN cours_pratique cp ON m.id_moniteur = cp.id_moniteur
                    WHERE cp.id_client = :id_client
                    GROUP BY m.id_moniteur
                    ORDER BY nb_cours DESC
                    LIMIT 1";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_client" => $id_client]);
        return $select->fetch();
    }

    public function countTable($table) {
        $tables_valides = ['client', 'moniteur', 'cours_theorique', 'cours_pratique', 'examen', 'user', 'inscription_theorique'];
        
        if (!in_array($table, $tables_valides)) {
            return 0;
        }
        
        $requete = "SELECT COUNT(*) AS n FROM `$table`";
        $result = $this->unPdo->query($requete)->fetch();
        return $result["n"];
    }

    public function count_cours_pratiques_client($id_client) {
        $requete = "SELECT COUNT(*) AS n FROM cours_pratique WHERE id_client = :id_client";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_client" => $id_client]);
        return $select->fetch()["n"];
    }

    public function count_cours_theoriques_client($id_client) {
        $requete = "SELECT COUNT(*) AS n FROM inscription_theorique WHERE id_client = :id_client";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_client" => $id_client]);
        return $select->fetch()["n"];
    }

    public function count_examens_client($id_client) {
        $requete = "SELECT COUNT(*) AS n FROM examen WHERE id_client = :id_client";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_client" => $id_client]);
        return $select->fetch()["n"];
    }

    public function count_examens_reussis_client($id_client) {
        $requete = "SELECT COUNT(*) AS n FROM examen WHERE id_client = :id_client AND resultat = 'reussi'";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_client" => $id_client]);
        return $select->fetch()["n"];
    }

    public function count_cours_pratiques_moniteur($id_moniteur) {
        $requete = "SELECT COUNT(*) AS n FROM cours_pratique WHERE id_moniteur = :id_moniteur";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_moniteur" => $id_moniteur]);
        return $select->fetch()["n"];
    }

    public function count_cours_termines_moniteur($id_moniteur) {
        $requete = "SELECT COUNT(*) AS n FROM cours_pratique WHERE id_moniteur = :id_moniteur AND statut = 'termine'";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_moniteur" => $id_moniteur]);
        return $select->fetch()["n"];
    }

    public function count_eleves_moniteur($id_moniteur) {
        $requete = "SELECT COUNT(DISTINCT id_client) AS n FROM cours_pratique WHERE id_moniteur = :id_moniteur";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_moniteur" => $id_moniteur]);
        return $select->fetch()["n"];
    }

    public function get_heures_conduite_client($id_client) {
        $requete = "SELECT COUNT(*) * 1.0 AS total FROM cours_pratique WHERE id_client = :id_client AND statut = 'termine'";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_client" => $id_client]);
        $result = $select->fetch();
        return $result["total"] ? $result["total"] : 0;
    }

    public function get_heures_enseignees_moniteur($id_moniteur) {
        $requete = "SELECT COUNT(*) * 1.0 AS total FROM cours_pratique WHERE id_moniteur = :id_moniteur AND statut = 'termine'";
        $select = $this->unPdo->prepare($requete);
        $select->execute([":id_moniteur" => $id_moniteur]);
        $result = $select->fetch();
        return $result["total"] ? $result["total"] : 0;
    }

    public function get_progression_client($id_client) {
        $heures_effectuees = $this->get_heures_conduite_client($id_client);
        $heures_minimum = 20;
        $progression = min(100, round(($heures_effectuees / $heures_minimum) * 100));
        return [
            'heures_effectuees' => $heures_effectuees,
            'heures_minimum' => $heures_minimum,
            'progression' => $progression
        ];
    }
}
?>