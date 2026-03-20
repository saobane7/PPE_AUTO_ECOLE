<?php
session_start();
require_once("controleur/controleur.class.php");
require_once("controleur/gestion_admin.php");
require_once("controleur/gestion_moniteur.php");
require_once("controleur/gestion_client.php");

$ctrl           = new Controleur();
$gestionAdmin   = new GestionAdmin();
$gestionMoniteur= new GestionMoniteur();
$gestionClient  = new GestionClient();

$page = isset($_GET['page']) ? trim($_GET['page']) : 'accueil';

if ($ctrl->estConnecte() && $page === 'accueil') {
    header("Location: " . $ctrl->redirigerSelonRole());
    exit();
}

switch ($page) {

    case 'accueil':
        $moniteurs = $ctrl->obtenirMoniteursPageAccueil();
        require_once("vue/vue_presentation.php");
        break;

    case 'connexion':
        if (isset($_POST['Connexion'])) {
            $email          = trim($_POST['email']);
            $motDePasse     = $_POST['mdp'];
            $typeUtilisateur= $_POST['type_user'];

            $connexionReussie = $ctrl->connecterUtilisateur($email, $motDePasse, $typeUtilisateur);
            if ($connexionReussie) {
                header("Location: " . $ctrl->redirigerSelonRole());
                exit();
            } else {
                $_SESSION['error'] = "Identifiants incorrects ou type invalide.";
            }
        }
        require_once("vue/vue_connexion.php");
        break;

    
    case 'inscription':
        if (isset($_POST['Inscription'])) {
            $donneesInscription = [
                'nom'            => trim($_POST['nom']),
                'prenom'         => trim($_POST['prenom']),
                'email'          => trim($_POST['email']),
                'mdp'            => $_POST['mdp'],
                'telephone'      => trim($_POST['telephone']),
                'date_naissance' => $_POST['date_naissance'],
                'type'           => $_POST['type']
            ];
            $resultat = $ctrl->inscrireNouveauClient($donneesInscription);
            if ($resultat['succes']) {
                $_SESSION['success'] = $resultat['message'];
                header("Location: index.php?page=connexion");
                exit();
            } else {
                $_SESSION['error'] = $resultat['message'];
            }
        }
        require_once("vue/vue_inscription.php");
        break;

    case 'deconnexion':
        $ctrl->deconnecterUtilisateur();
        header("Location: index.php");
        exit();

    case 'dashboard_admin':
        if (!$ctrl->estAdmin()) { header("Location: index.php?page=connexion"); exit(); }
        $dash          = $ctrl->getDashAdmin();
        $tableauDeBord = $gestionAdmin->getTableauDeBord();
        require_once("vue/vue_dashboard_admin.php");
        break;

    case 'dashboard_client':
        if (!$ctrl->estClient()) { header("Location: index.php?page=connexion"); exit(); }
        $dash = $ctrl->getDashClient($_SESSION['user_id']);
        require_once("vue/vue_dashboard_client.php");
        break;

    case 'dashboard_moniteur':
        if (!$ctrl->estMoniteur()) { header("Location: index.php?page=connexion"); exit(); }
        $dash          = $ctrl->getDashMoniteur($_SESSION['user_id']);
        $profilComplet = $gestionMoniteur->getProfilComplet($_SESSION['user_id']);
        require_once("vue/vue_dashboard_moniteur.php");
        break;




    case 'ajouter_client':
        if (!$ctrl->estAdmin()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_POST['AjouterClient'])) {
            $donneesClient = [
                'nom'            => trim($_POST['nom']),
                'prenom'         => trim($_POST['prenom']),
                'email'          => trim($_POST['email']),
                'mdp'            => $_POST['mdp'],
                'telephone'      => trim($_POST['telephone']),
                'date_naissance' => $_POST['date_naissance'],
                'type'           => $_POST['type']
            ];
            $resultat = $ctrl->inscrireNouveauClient($donneesClient);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_admin#clients");
        exit();

    case 'modifier_client':
        if (!$ctrl->estAdmin()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_POST['ModifierClient'])) {
            $donneesClient = [
                'id_client'      => $_POST['id_client'],
                'nom'            => trim($_POST['nom']),
                'prenom'         => trim($_POST['prenom']),
                'telephone'      => trim($_POST['telephone']),
                'date_naissance' => $_POST['date_naissance'],
                'type'           => $_POST['type']
            ];
            $resultat = $ctrl->mettreAJourClient($donneesClient);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_admin#clients");
        exit();

    case 'supprimer_client':
        if (!$ctrl->estAdmin()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_GET['id'])) {
            $resultat = $ctrl->supprimerClient($_GET['id']);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_admin#clients");
        exit();



    case 'ajouter_moniteur':
        if (!$ctrl->estAdmin()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_POST['AjouterMoniteur'])) {
            $donneesMoniteur = [
                'nom'             => trim($_POST['nom']),
                'prenom'          => trim($_POST['prenom']),
                'email'           => trim($_POST['email']),
                'mdp'             => $_POST['mdp'],
                'telephone'       => trim($_POST['telephone']),
                'date_embauche'   => $_POST['date_embauche'],
                'numero_agrement' => trim($_POST['numero_agrement'])
            ];
            $resultat = $ctrl->ajouterNouveauMoniteur($donneesMoniteur);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_admin#moniteurs");
        exit();

    case 'modifier_moniteur':
        if (!$ctrl->estAdmin()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_POST['ModifierMoniteur'])) {
            $donneesMoniteur = [
                'id_moniteur'     => $_POST['id_moniteur'],
                'nom'             => trim($_POST['nom']),
                'prenom'          => trim($_POST['prenom']),
                'email'           => trim($_POST['email']),
                'telephone'       => trim($_POST['telephone']),
                'date_embauche'   => $_POST['date_embauche'],
                'numero_agrement' => trim($_POST['numero_agrement'])
            ];
            $resultat = $ctrl->mettreAJourMoniteur($donneesMoniteur);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_admin#moniteurs");
        exit();

    case 'supprimer_moniteur':
        if (!$ctrl->estAdmin()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_GET['id'])) {
            $resultat = $ctrl->supprimerMoniteur($_GET['id']);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_admin#moniteurs");
        exit();

 


    case 'ajouter_cours_pratique':
        if (!$ctrl->estAdmin()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_POST['AjouterCoursPratique'])) {
            $donneesCours = [
                'date_seance'   => $_POST['date_seance'],
                'heure_debut'   => $_POST['heure_debut'],
                'heure_fin'     => $_POST['heure_fin'],
                'id_moniteur'   => $_POST['id_moniteur'],
                'id_client'     => $_POST['id_client'],
                'type_vehicule' => $_POST['type_vehicule'] ?? 'voiture',
                'statut'        => 'planifie',
                'notes'         => $_POST['notes'] ?? null
            ];
            $resultat = $ctrl->planifierCoursPratique($donneesCours);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_admin#cours");
        exit();

    case 'supprimer_cours_pratique':
        if (!$ctrl->estAdmin()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_GET['id'])) {
            $resultat = $ctrl->supprimerCoursPratique($_GET['id']);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_admin#cours");
        exit();

    case 'valider_cours':
        if (!$ctrl->estMoniteur()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_GET['id'])) {
            $resultat = $ctrl->terminerCoursPratique($_GET['id']);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_moniteur#cours");
        exit();

    case 'annuler_cours':
        if (!$ctrl->estMoniteur()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_GET['id'])) {
            $resultat = $ctrl->annulerCoursPratique($_GET['id']);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_moniteur#cours");
        exit();




    case 'ajouter_cours_theorique':
        if (!$ctrl->estAdmin()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_POST['AjouterCoursTheorique'])) {
            $donneesCours = [
                'titre'       => trim($_POST['titre']),
                'date_cours'  => $_POST['date_cours'],
                'heure_debut' => $_POST['heure_debut'],
                'heure_fin'   => $_POST['heure_fin'],
                'salle'       => $_POST['salle'] ?? null,
                'places_max'  => $_POST['places_max'] ?? 20,
                'statut'      => 'planifie'
            ];
            $resultat = $ctrl->creerCoursTheorique($donneesCours);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_admin#cours");
        exit();

    case 'supprimer_cours_theorique':
        if (!$ctrl->estAdmin()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_GET['id'])) {
            $resultat = $ctrl->supprimerCoursTheorique($_GET['id']);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_admin#cours");
        exit();

    case 'inscription_cours_theorique':
        if (!$ctrl->estClient()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_GET['id_cours'])) {
            $resultat = $ctrl->inscrireClientAuCoursTheorique($_SESSION['user_id'], $_GET['id_cours']);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_client#theoriques");
        exit();



    case 'ajouter_examen':
        if (!$ctrl->estAdmin()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_POST['AjouterExamen'])) {
            $donneesExamen = [
                'type'        => $_POST['type'],
                'date_examen' => $_POST['date_examen'],
                'heure'       => $_POST['heure'],
                'id_client'   => $_POST['id_client'],
                'lieu'        => $_POST['lieu'] ?? null,
                'resultat'    => null,
                'notes'       => $_POST['notes'] ?? null
            ];
            $resultat = $ctrl->planifierExamen($donneesExamen);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_admin#examens");
        exit();

    case 'supprimer_examen':
        if (!$ctrl->estAdmin()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_GET['id'])) {
            $resultat = $ctrl->supprimerExamen($_GET['id']);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_admin#examens");
        exit();

    case 'resultat_examen':
        if (!$ctrl->estAdmin()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_POST['EnregistrerResultat'])) {
            $resultat = $ctrl->enregistrerResultatExamen(
                $_POST['id_examen'],
                $_POST['resultat'],
                $_POST['notes'] ?? null
            );
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
        }
        header("Location: index.php?page=dashboard_admin#examens");
        exit();



    case 'profil_moniteur':
        if (!$ctrl->estMoniteur()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_POST['Modifier'])) {
            $donneesMoniteur = [
                'id_moniteur' => $_SESSION['user_id'],
                'nom'         => trim($_POST['nom']),
                'prenom'      => trim($_POST['prenom']),
                'telephone'   => trim($_POST['telephone'])
            ];
            $resultat = $ctrl->mettreAJourMoniteur($donneesMoniteur);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
            header("Location: index.php?page=dashboard_moniteur");
            exit();
        }
        break;



    case 'profil_client':
        if (!$ctrl->estClient()) { header("Location: index.php?page=connexion"); exit(); }
        if (isset($_POST['Modifier'])) {
            $donneesClient = [
                'id_client'      => $_SESSION['user_id'],
                'nom'            => trim($_POST['nom']),
                'prenom'         => trim($_POST['prenom']),
                'telephone'      => trim($_POST['telephone']),
                'date_naissance' => $_POST['date_naissance'],
                'type'           => $_POST['type']
            ];
            $resultat = $ctrl->mettreAJourClient($donneesClient);
            $_SESSION[$resultat['succes'] ? 'success' : 'error'] = $resultat['message'];
            header("Location: index.php?page=dashboard_client#profil");
            exit();
        }
        break;

    default:
        $moniteurs = $ctrl->obtenirMoniteursPageAccueil();
        require_once("vue/vue_presentation.php");
        break;
}
?>
