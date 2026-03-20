<?php
class Modele {
    private $connexionBDD;

    public function __construct() {
        $serveur = "mysql:host=localhost;dbname=sat_auto;charset=utf8";
        $utilisateur = "root";
        $motDePasse  = "";

        try {
            $this->connexionBDD = new PDO($serveur, $utilisateur, $motDePasse);
            $this->connexionBDD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connexionBDD->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $erreur) {
            die("Erreur de connexion : " . $erreur->getMessage());
        }
    }

    /*------------------CONNEXION----------------------------*/

    public function connexionAdmin($email, $motDePasse) {
        $requete = $this->connexionBDD->prepare("SELECT * FROM user WHERE email = :email AND mdp = :mdp");
        $requete->execute([":email" => $email, ":mdp" => $motDePasse]);
        return $requete->fetch();
    }

    public function connexionClient($email, $motDePasse) {
        $requete = $this->connexionBDD->prepare("SELECT * FROM client WHERE email = :email AND mot_de_passe = :mdp");
        $requete->execute([":email" => $email, ":mdp" => $motDePasse]);
        return $requete->fetch();
    }

    public function connexionMoniteur($email, $motDePasse) {
        $requete = $this->connexionBDD->prepare("SELECT * FROM moniteur WHERE email = :email AND mot_de_passe = :mdp");
        $requete->execute([":email" => $email, ":mdp" => $motDePasse]);
        return $requete->fetch();
    }

    /* ---------------- CLIENTS --------------------*/

    public function emailClientExiste($email) {
        $requete = $this->connexionBDD->prepare("SELECT id_client FROM client WHERE email = :email");
        $requete->execute([":email" => $email]);
        return $requete->rowCount() > 0;
    }

    public function ajouterClient($donnees) {
        $requete = $this->connexionBDD->prepare(
            "INSERT INTO client (nom, prenom, email, mot_de_passe, telephone, date_naissance, type)
             VALUES (:nom, :prenom, :email, :mdp, :telephone, :date_naissance, :type)"
        );
        return $requete->execute([
            ":nom"            => $donnees['nom'],
            ":prenom"         => $donnees['prenom'],
            ":email"          => $donnees['email'],
            ":mdp"            => $donnees['mdp'],
            ":telephone"      => $donnees['telephone'],
            ":date_naissance" => $donnees['date_naissance'],
            ":type"           => $donnees['type']
        ]);
    }

    public function listerTousLesClients() {
        return $this->connexionBDD->query("SELECT * FROM client ORDER BY nom, prenom")->fetchAll();
    }

    public function trouverClientParId($idClient) {
        $requete = $this->connexionBDD->prepare("SELECT * FROM client WHERE id_client = :id");
        $requete->execute([":id" => $idClient]);
        return $requete->fetch();
    }

    public function modifierClient($donnees) {
        $requete = $this->connexionBDD->prepare(
            "UPDATE client SET nom=:nom, prenom=:prenom, telephone=:telephone,
             date_naissance=:date_naissance, type=:type WHERE id_client=:id"
        );
        return $requete->execute([
            ":id"             => $donnees['id_client'],
            ":nom"            => $donnees['nom'],
            ":prenom"         => $donnees['prenom'],
            ":telephone"      => $donnees['telephone'],
            ":date_naissance" => $donnees['date_naissance'],
            ":type"           => $donnees['type']
        ]);
    }

    public function supprimerClient($idClient) {
        $requete = $this->connexionBDD->prepare("DELETE FROM client WHERE id_client = :id");
        return $requete->execute([":id" => $idClient]);
    }

    public function compterCoursDuClient($idClient) {
        $requete = $this->connexionBDD->prepare("SELECT COUNT(*) AS total FROM cours_pratique WHERE id_client = :id");
        $requete->execute([":id" => $idClient]);
        return $requete->fetch()["total"];
    }

    public function compterExamensDuClient($idClient) {
        $requete = $this->connexionBDD->prepare("SELECT COUNT(*) AS total FROM examen WHERE id_client = :id");
        $requete->execute([":id" => $idClient]);
        return $requete->fetch()["total"];
    }

    public function compterCoursTheoriquesDuClient($idClient) {
        $requete = $this->connexionBDD->prepare("SELECT COUNT(*) AS total FROM inscription_theorique WHERE id_client = :id");
        $requete->execute([":id" => $idClient]);
        return $requete->fetch()["total"];
    }

    public function compterExamensReussisDuClient($idClient) {
        $requete = $this->connexionBDD->prepare("SELECT COUNT(*) AS total FROM examen WHERE id_client = :id AND resultat = 'reussi'");
        $requete->execute([":id" => $idClient]);
        return $requete->fetch()["total"];
    }

    public function calculerHeuresDeConduite($idClient) {
        $requete = $this->connexionBDD->prepare("SELECT COUNT(*) AS total FROM cours_pratique WHERE id_client = :id AND statut = 'termine'");
        $requete->execute([":id" => $idClient]);
        $resultat = $requete->fetch();
        return $resultat["total"] ?? 0;
    }

    public function calculerProgressionClient($idClient) {
        $heuresFaites  = $this->calculerHeuresDeConduite($idClient);
        $heuresRequises = 20;
        $pourcentage   = min(100, round(($heuresFaites / $heuresRequises) * 100));
        return [
            'heures_effectuees' => $heuresFaites,
            'heures_minimum'    => $heuresRequises,
            'progression'       => $pourcentage
        ];
    }

    /*-------------------MONITEURS ------------------------*/

    public function emailMoniteurExiste($email) {
        $requete = $this->connexionBDD->prepare("SELECT id_moniteur FROM moniteur WHERE email = :email");
        $requete->execute([":email" => $email]);
        return $requete->rowCount() > 0;
    }

    public function ajouterMoniteur($donnees) {
        $requete = $this->connexionBDD->prepare(
            "INSERT INTO moniteur (nom, prenom, email, mot_de_passe, telephone, date_embauche, numero_agrement)
             VALUES (:nom, :prenom, :email, :mdp, :telephone, :date_embauche, :agrement)"
        );
        return $requete->execute([
            ":nom"           => $donnees['nom'],
            ":prenom"        => $donnees['prenom'],
            ":email"         => $donnees['email'],
            ":mdp"           => $donnees['mdp'],
            ":telephone"     => $donnees['telephone'],
            ":date_embauche" => $donnees['date_embauche'],
            ":agrement"      => $donnees['numero_agrement']
        ]);
    }

    public function listerTousLesMoniteurs() {
        return $this->connexionBDD->query("SELECT * FROM moniteur ORDER BY nom, prenom")->fetchAll();
    }

    public function listerMoniteursPageAccueil() {
        return $this->connexionBDD->query("SELECT * FROM moniteur ORDER BY nom LIMIT 3")->fetchAll();
    }

    public function trouverMoniteurParId($idMoniteur) {
        $requete = $this->connexionBDD->prepare("SELECT * FROM moniteur WHERE id_moniteur = :id");
        $requete->execute([":id" => $idMoniteur]);
        return $requete->fetch();
    }

    public function modifierMoniteur($donnees) {
        $requete = $this->connexionBDD->prepare(
            "UPDATE moniteur SET nom=:nom, prenom=:prenom, telephone=:telephone WHERE id_moniteur=:id"
        );
        return $requete->execute([
            ":id"        => $donnees['id_moniteur'],
            ":nom"       => $donnees['nom'],
            ":prenom"    => $donnees['prenom'],
            ":telephone" => $donnees['telephone']
        ]);
    }

    public function supprimerMoniteur($idMoniteur) {
        $requete = $this->connexionBDD->prepare("DELETE FROM moniteur WHERE id_moniteur = :id");
        return $requete->execute([":id" => $idMoniteur]);
    }

    public function compterCoursDuMoniteur($idMoniteur) {
        $requete = $this->connexionBDD->prepare("SELECT COUNT(*) AS total FROM cours_pratique WHERE id_moniteur = :id");
        $requete->execute([":id" => $idMoniteur]);
        return $requete->fetch()["total"];
    }

    public function compterCoursTerminesDuMoniteur($idMoniteur) {
        $requete = $this->connexionBDD->prepare("SELECT COUNT(*) AS total FROM cours_pratique WHERE id_moniteur = :id AND statut = 'termine'");
        $requete->execute([":id" => $idMoniteur]);
        return $requete->fetch()["total"];
    }

    public function compterElevesMoniteur($idMoniteur) {
        $requete = $this->connexionBDD->prepare("SELECT COUNT(DISTINCT id_client) AS total FROM cours_pratique WHERE id_moniteur = :id");
        $requete->execute([":id" => $idMoniteur]);
        return $requete->fetch()["total"];
    }

    public function listerElevesMoniteur($idMoniteur) {
        $requete = $this->connexionBDD->prepare(
            "SELECT DISTINCT c.* FROM client c
             JOIN cours_pratique cp ON c.id_client = cp.id_client
             WHERE cp.id_moniteur = :id ORDER BY c.nom"
        );
        $requete->execute([":id" => $idMoniteur]);
        return $requete->fetchAll();
    }

    /* ---------------COURS THEORIQUES -----------------*/

    public function ajouterCoursTheorique($donnees) {
        $requete = $this->connexionBDD->prepare(
            "INSERT INTO cours_theorique (titre, date_cours, heure_debut, heure_fin, salle, places_max, statut)
             VALUES (:titre, :date, :hdebut, :hfin, :salle, :places, :statut)"
        );
        return $requete->execute([
            ":titre"  => $donnees['titre'],
            ":date"   => $donnees['date_cours'],
            ":hdebut" => $donnees['heure_debut'],
            ":hfin"   => $donnees['heure_fin'],
            ":salle"  => $donnees['salle'],
            ":places" => $donnees['places_max'],
            ":statut" => $donnees['statut'] ?? 'planifie'
        ]);
    }

    public function listerTousLesCoursTheoriques() {
        return $this->connexionBDD->query(
            "SELECT ct.*, COUNT(it.id_inscription) AS nb_inscrits
             FROM cours_theorique ct
             LEFT JOIN inscription_theorique it ON ct.id_cours = it.id_cours
             GROUP BY ct.id_cours
             ORDER BY ct.date_cours DESC, ct.heure_debut"
        )->fetchAll();
    }

    public function listerCoursTheoriquesClient($idClient) {
        $requete = $this->connexionBDD->prepare(
            "SELECT ct.*, it.present FROM cours_theorique ct
             JOIN inscription_theorique it ON ct.id_cours = it.id_cours
             WHERE it.id_client = :id ORDER BY ct.date_cours DESC"
        );
        $requete->execute([":id" => $idClient]);
        return $requete->fetchAll();
    }

    public function listerCoursTheoriquesDisponibles($idClient) {
        $requete = $this->connexionBDD->prepare(
            "SELECT ct.*, COUNT(it.id_inscription) AS nb_inscrits
             FROM cours_theorique ct
             LEFT JOIN inscription_theorique it ON ct.id_cours = it.id_cours
             WHERE ct.statut = 'planifie'
             AND ct.id_cours NOT IN (SELECT id_cours FROM inscription_theorique WHERE id_client = :id)
             GROUP BY ct.id_cours
             HAVING nb_inscrits < ct.places_max
             ORDER BY ct.date_cours"
        );
        $requete->execute([":id" => $idClient]);
        return $requete->fetchAll();
    }

    public function inscrireClientAuCoursTheorique($idClient, $idCours) {
        $requete = $this->connexionBDD->prepare("INSERT INTO inscription_theorique (id_cours, id_client) VALUES (:id_cours, :id_client)");
        return $requete->execute([":id_cours" => $idCours, ":id_client" => $idClient]);
    }

    public function supprimerCoursTheorique($idCours) {
        $requete = $this->connexionBDD->prepare("DELETE FROM cours_theorique WHERE id_cours = :id");
        return $requete->execute([":id" => $idCours]);
    }

    public function compterLignesDansTable($nomTable) {
        $tablesAutorisees = ['client', 'moniteur', 'cours_theorique', 'cours_pratique', 'examen'];
        if (!in_array($nomTable, $tablesAutorisees)) return 0;
        return $this->connexionBDD->query("SELECT COUNT(*) AS total FROM `$nomTable`")->fetch()["total"];
    }

   /*-------------------COURS PRATIQUES----------------- */

    public function ajouterCoursPratique($donnees) {
        $requete = $this->connexionBDD->prepare(
            "INSERT INTO cours_pratique (date_seance, heure_debut, heure_fin, id_moniteur, id_client, type_vehicule, statut, notes)
             VALUES (:date, :hdebut, :hfin, :id_moniteur, :id_client, :vehicule, :statut, :notes)"
        );
        return $requete->execute([
            ":date"        => $donnees['date_seance'],
            ":hdebut"      => $donnees['heure_debut'],
            ":hfin"        => $donnees['heure_fin'],
            ":id_moniteur" => $donnees['id_moniteur'],
            ":id_client"   => $donnees['id_client'],
            ":vehicule"    => $donnees['type_vehicule'] ?? 'voiture',
            ":statut"      => $donnees['statut'] ?? 'planifie',
            ":notes"       => $donnees['notes'] ?? null
        ]);
    }

    public function listerTousLesCoursPratiques() {
        return $this->connexionBDD->query(
            "SELECT cp.*,
                    c.nom AS client_nom, c.prenom AS client_prenom,
                    m.nom AS moniteur_nom, m.prenom AS moniteur_prenom
             FROM cours_pratique cp
             JOIN client c ON cp.id_client = c.id_client
             JOIN moniteur m ON cp.id_moniteur = m.id_moniteur
             ORDER BY cp.date_seance DESC, cp.heure_debut"
        )->fetchAll();
    }

    public function listerCoursPratiquesClient($idClient) {
        $requete = $this->connexionBDD->prepare(
            "SELECT cp.*, m.nom AS moniteur_nom, m.prenom AS moniteur_prenom
             FROM cours_pratique cp
             JOIN moniteur m ON cp.id_moniteur = m.id_moniteur
             WHERE cp.id_client = :id ORDER BY cp.date_seance DESC"
        );
        $requete->execute([":id" => $idClient]);
        return $requete->fetchAll();
    }

    public function listerCoursPratiquesMoniteur($idMoniteur) {
        $requete = $this->connexionBDD->prepare(
            "SELECT cp.*, c.nom AS client_nom, c.prenom AS client_prenom
             FROM cours_pratique cp
             JOIN client c ON cp.id_client = c.id_client
             WHERE cp.id_moniteur = :id ORDER BY cp.date_seance DESC"
        );
        $requete->execute([":id" => $idMoniteur]);
        return $requete->fetchAll();
    }

    public function listerProchainsCoursDuClient($idClient) {
        $requete = $this->connexionBDD->prepare(
            "SELECT cp.*, m.nom AS moniteur_nom, m.prenom AS moniteur_prenom
             FROM cours_pratique cp
             JOIN moniteur m ON cp.id_moniteur = m.id_moniteur
             WHERE cp.id_client = :id AND cp.date_seance >= CURDATE() AND cp.statut = 'planifie'
             ORDER BY cp.date_seance, cp.heure_debut"
        );
        $requete->execute([":id" => $idClient]);
        return $requete->fetchAll();
    }

    public function listerProchainsCoursDuMoniteur($idMoniteur) {
        $requete = $this->connexionBDD->prepare(
            "SELECT cp.*, c.nom AS client_nom, c.prenom AS client_prenom
             FROM cours_pratique cp
             JOIN client c ON cp.id_client = c.id_client
             WHERE cp.id_moniteur = :id AND cp.date_seance >= CURDATE() AND cp.statut = 'planifie'
             ORDER BY cp.date_seance, cp.heure_debut"
        );
        $requete->execute([":id" => $idMoniteur]);
        return $requete->fetchAll();
    }

    public function trouverCoursPratiqueParId($idSeance) {
        $requete = $this->connexionBDD->prepare("SELECT * FROM cours_pratique WHERE id_seance = :id");
        $requete->execute([":id" => $idSeance]);
        return $requete->fetch();
    }

    public function modifierCoursPratique($donnees) {
        $requete = $this->connexionBDD->prepare(
            "UPDATE cours_pratique SET date_seance=:date, heure_debut=:hdebut, heure_fin=:hfin,
             id_moniteur=:id_moniteur, id_client=:id_client, type_vehicule=:vehicule,
             statut=:statut, notes=:notes WHERE id_seance=:id"
        );
        return $requete->execute([
            ":id"          => $donnees['id_seance'],
            ":date"        => $donnees['date_seance'],
            ":hdebut"      => $donnees['heure_debut'],
            ":hfin"        => $donnees['heure_fin'],
            ":id_moniteur" => $donnees['id_moniteur'],
            ":id_client"   => $donnees['id_client'],
            ":vehicule"    => $donnees['type_vehicule'],
            ":statut"      => $donnees['statut'],
            ":notes"       => $donnees['notes']
        ]);
    }

    public function supprimerCoursPratique($idSeance) {
        $requete = $this->connexionBDD->prepare("DELETE FROM cours_pratique WHERE id_seance = :id");
        return $requete->execute([":id" => $idSeance]);
    }



    public function ajouterExamen($donnees) {
        $requete = $this->connexionBDD->prepare(
            "INSERT INTO examen (type, date_examen, heure, id_client, lieu, resultat, notes)
             VALUES (:type, :date, :heure, :id_client, :lieu, :resultat, :notes)"
        );
        return $requete->execute([
            ":type"      => $donnees['type'],
            ":date"      => $donnees['date_examen'],
            ":heure"     => $donnees['heure'],
            ":id_client" => $donnees['id_client'],
            ":lieu"      => $donnees['lieu'] ?? null,
            ":resultat"  => $donnees['resultat'] ?? null,
            ":notes"     => $donnees['notes'] ?? null
        ]);
    }

    public function listerTousLesExamens() {
        return $this->connexionBDD->query(
            "SELECT e.*, c.nom AS client_nom, c.prenom AS client_prenom
             FROM examen e
             JOIN client c ON e.id_client = c.id_client
             ORDER BY e.date_examen DESC, e.heure"
        )->fetchAll();
    }

    public function listerExamensDuClient($idClient) {
        $requete = $this->connexionBDD->prepare("SELECT * FROM examen WHERE id_client = :id ORDER BY date_examen DESC");
        $requete->execute([":id" => $idClient]);
        return $requete->fetchAll();
    }

    public function trouverExamenParId($idExamen) {
        $requete = $this->connexionBDD->prepare(
            "SELECT e.*, c.nom AS client_nom, c.prenom AS client_prenom
             FROM examen e JOIN client c ON e.id_client = c.id_client
             WHERE e.id_examen = :id"
        );
        $requete->execute([":id" => $idExamen]);
        return $requete->fetch();
    }

    public function modifierExamen($donnees) {
        $requete = $this->connexionBDD->prepare(
            "UPDATE examen SET type=:type, date_examen=:date, heure=:heure,
             id_client=:id_client, lieu=:lieu, resultat=:resultat, notes=:notes
             WHERE id_examen=:id"
        );
        return $requete->execute([
            ":id"        => $donnees['id_examen'],
            ":type"      => $donnees['type'],
            ":date"      => $donnees['date_examen'],
            ":heure"     => $donnees['heure'],
            ":id_client" => $donnees['id_client'],
            ":lieu"      => $donnees['lieu'] ?? null,
            ":resultat"  => $donnees['resultat'] ?? null,
            ":notes"     => $donnees['notes'] ?? null
        ]);
    }

    public function supprimerExamen($idExamen) {
        $requete = $this->connexionBDD->prepare("DELETE FROM examen WHERE id_examen = :id");
        return $requete->execute([":id" => $idExamen]);
    }

    public function trouverMoniteurPrincipalDuClient($idClient) {
        $requete = $this->connexionBDD->prepare(
            "SELECT m.*, COUNT(cp.id_seance) AS nb_cours FROM moniteur m
             JOIN cours_pratique cp ON m.id_moniteur = cp.id_moniteur
             WHERE cp.id_client = :id
             GROUP BY m.id_moniteur ORDER BY nb_cours DESC LIMIT 1"
        );
        $requete->execute([":id" => $idClient]);
        return $requete->fetch();
    }
}
?>
