<?php

session_start();
require_once("controleur/controleur.class.php");
require_once("controleur/gestion_admin.php");
require_once("controleur/gestion_moniteur.php");
require_once("controleur/gestion_client.php");

$ctrl = new Controleur();
$gestionAdmin = new GestionAdmin();
$gestionMoniteur = new GestionMoniteur();
$gestionClient = new GestionClient();

$page = isset($_GET['page']) ? trim($_GET['page']) : 'accueil';


if ($ctrl->estConnecte() && $page === 'accueil') {
    header("Location: " . $ctrl->redirectionRole());
    exit();
}


switch ($page) {

    case 'accueil':
        $moniteurs = $ctrl->getMoniteursHome();
        require_once("vue/vue_presentation.php");
        break;


    case 'connexion':
        if (isset($_POST['Connexion'])) {
            $email = trim($_POST['email']);
            $mdp   = trim($_POST['mdp']);
            $type  = $_POST['type_user'];

            if ($ctrl->connecter($email, $mdp, $type)) {
                header("Location: " . $ctrl->redirectionRole());
                exit();
            } else {
                $_SESSION['error'] = "Identifiants incorrects ou type invalide.";
            }
        }
        require_once("vue/vue_connexion.php");
        break;

    case 'inscription':
        if (isset($_POST['Inscription'])) {
            $tab = [
                'nom'            => trim($_POST['nom']),
                'prenom'         => trim($_POST['prenom']),
                'email'          => trim($_POST['email']),
                'mdp'            => $_POST['mdp'],
                'telephone'      => trim($_POST['telephone']),
                'date_naissance' => $_POST['date_naissance'],
                'type'           => $_POST['type'],
            ];
            $res = $ctrl->inscrireClient($tab);
            if ($res['ok']) {
                $_SESSION['success'] = $res['msg'];
                header("Location: index.php?page=connexion");
                exit();
            } else {
                $_SESSION['error'] = $res['msg'];
            }
        }
        require_once("vue/vue_inscription.php");
        break;

    case 'dashboard_admin':
        if (!$ctrl->estAdmin()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        $dash = $ctrl->getDashAdmin();
        $tableauDeBord = $gestionAdmin->getTableauDeBord();
        require_once("vue/vue_dashboard_admin.php");
        break;


    case 'dashboard_client':
        if (!$ctrl->estClient()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        $dash = $ctrl->getDashClient($_SESSION['user_id']);
        require_once("vue/vue_dashboard_client.php");
        break;

    case 'dashboard_moniteur':
        if (!$ctrl->estMoniteur()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        $dash = $ctrl->getDashMoniteur($_SESSION['user_id']);
        $profilComplet = $gestionMoniteur->getProfilComplet($_SESSION['user_id']);
        require_once("vue/vue_dashboard_moniteur.php");
        break;


    case 'deconnexion':
        $ctrl->deconnecter();
        header("Location: index.php");
        exit();


    case 'ajouter_client':
        if (!$ctrl->estAdmin()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_POST['AjouterClient'])) {
            $tab = [
                'nom' => trim($_POST['nom']),
                'prenom' => trim($_POST['prenom']),
                'email' => trim($_POST['email']),
                'mdp' => $_POST['mdp'],
                'telephone' => trim($_POST['telephone']),
                'date_naissance' => $_POST['date_naissance'],
                'type' => $_POST['type']
            ];
            $res = $ctrl->inscrireClient($tab);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_admin#clients");
        exit();
        break;

    case 'modifier_client':
        if (!$ctrl->estAdmin()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_POST['ModifierClient'])) {
            $tab = [
                'id_client' => $_POST['id_client'],
                'nom' => trim($_POST['nom']),
                'prenom' => trim($_POST['prenom']),
                'telephone' => trim($_POST['telephone']),
                'date_naissance' => $_POST['date_naissance'],
                'type' => $_POST['type']
            ];
            $res = $ctrl->modifierClient($tab);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_admin#clients");
        exit();
        break;

    case 'supprimer_client':
        if (!$ctrl->estAdmin()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_GET['id'])) {
            $res = $ctrl->supprimerClient($_GET['id']);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_admin#clients");
        exit();
        break;


    case 'ajouter_moniteur':
        if (!$ctrl->estAdmin()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_POST['AjouterMoniteur'])) {
            $tab = [
                'nom' => trim($_POST['nom']),
                'prenom' => trim($_POST['prenom']),
                'email' => trim($_POST['email']),
                'mdp' => $_POST['mdp'],
                'telephone' => trim($_POST['telephone']),
                'date_embauche' => $_POST['date_embauche'],
                'numero_agrement' => trim($_POST['numero_agrement'])
            ];
            $res = $ctrl->ajouterMoniteur($tab);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_admin#moniteurs");
        exit();
        break;

    case 'modifier_moniteur':
        if (!$ctrl->estAdmin()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_POST['ModifierMoniteur'])) {
            $tab = [
                'id_moniteur' => $_POST['id_moniteur'],
                'nom' => trim($_POST['nom']),
                'prenom' => trim($_POST['prenom']),
                'email' => trim($_POST['email']),
                'telephone' => trim($_POST['telephone']),
                'date_embauche' => $_POST['date_embauche'],
                'numero_agrement' => trim($_POST['numero_agrement'])
            ];
            $res = $ctrl->modifierMoniteur($tab);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_admin#moniteurs");
        exit();
        break;

    case 'supprimer_moniteur':
        if (!$ctrl->estAdmin()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_GET['id'])) {
            $res = $ctrl->supprimerMoniteur($_GET['id']);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_admin#moniteurs");
        exit();
        break;


    case 'ajouter_cours_pratique':
        if (!$ctrl->estAdmin()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_POST['AjouterCoursPratique'])) {
            $tab = [
                'date_seance' => $_POST['date_seance'],
                'heure_debut' => $_POST['heure_debut'],
                'heure_fin' => $_POST['heure_fin'],
                'id_moniteur' => $_POST['id_moniteur'],
                'id_client' => $_POST['id_client'],
                'type_vehicule' => $_POST['type_vehicule'] ?? 'voiture',
                'statut' => 'planifie',
                'notes' => $_POST['notes'] ?? null
            ];
            $res = $ctrl->ajouterCoursPratique($tab);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_admin#cours");
        exit();
        break;

    case 'supprimer_cours_pratique':
        if (!$ctrl->estAdmin()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_GET['id'])) {
            $res = $ctrl->supprimerCoursPratique($_GET['id']);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_admin#cours");
        exit();
        break;


    case 'ajouter_cours_theorique':
        if (!$ctrl->estAdmin()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_POST['AjouterCoursTheorique'])) {
            $tab = [
                'titre' => trim($_POST['titre']),
                'date_cours' => $_POST['date_cours'],
                'heure_debut' => $_POST['heure_debut'],
                'heure_fin' => $_POST['heure_fin'],
                'salle' => $_POST['salle'] ?? null,
                'places_max' => $_POST['places_max'] ?? 20,
                'statut' => 'planifie'
            ];
            $res = $ctrl->ajouterCoursTheorique($tab);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_admin#cours");
        exit();
        break;

    case 'supprimer_cours_theorique':
        if (!$ctrl->estAdmin()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_GET['id'])) {
            $res = $ctrl->supprimerCoursTheorique($_GET['id']);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_admin#cours");
        exit();
        break;


    case 'ajouter_examen':
        if (!$ctrl->estAdmin()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_POST['AjouterExamen'])) {
            $tab = [
                'type' => $_POST['type'],
                'date_examen' => $_POST['date_examen'],
                'heure' => $_POST['heure'],
                'id_client' => $_POST['id_client'],
                'lieu' => $_POST['lieu'] ?? null,
                'resultat' => null,
                'notes' => $_POST['notes'] ?? null
            ];
            $res = $ctrl->ajouterExamen($tab);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_admin#examens");
        exit();
        break;

    case 'supprimer_examen':
        if (!$ctrl->estAdmin()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_GET['id'])) {
            $res = $ctrl->supprimerExamen($_GET['id']);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_admin#examens");
        exit();
        break;

    case 'resultat_examen':
        if (!$ctrl->estAdmin()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_POST['EnregistrerResultat'])) {
            $res = $ctrl->enregistrerResultatExamen(
                $_POST['id_examen'], 
                $_POST['resultat'], 
                $_POST['notes'] ?? null
            );
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_admin#examens");
        exit();
        break;

    case 'profil_moniteur':
        if (!$ctrl->estMoniteur()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_POST['Modifier'])) {
            $tab = [
                'id_moniteur' => $_SESSION['user_id'],
                'nom' => trim($_POST['nom']),
                'prenom' => trim($_POST['prenom']),
                'telephone' => trim($_POST['telephone'])
            ];
            $res = $ctrl->modifierMoniteur($tab);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
            header("Location: index.php?page=dashboard_moniteur");
            exit();
        }
        break;

    case 'valider_cours':
        if (!$ctrl->estMoniteur()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_GET['id'])) {
            $res = $ctrl->validerCoursPratique($_GET['id']);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_moniteur#cours");
        exit();
        break;

    case 'annuler_cours':
        if (!$ctrl->estMoniteur()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_GET['id'])) {
            $res = $ctrl->annulerCoursPratique($_GET['id']);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_moniteur#cours");
        exit();
        break;

    case 'inscription_cours_theorique':
        if (!$ctrl->estClient()) {
            header("Location: index.php?page=connexion");
            exit();
        }
        if (isset($_GET['id_cours'])) {
            $res = $ctrl->inscrireClientCoursTheorique($_SESSION['user_id'], $_GET['id_cours']);
            $_SESSION[$res['ok'] ? 'success' : 'error'] = $res['msg'];
        }
        header("Location: index.php?page=dashboard_client#theoriques");
        exit();
        break;

    default:
        $moniteurs = $ctrl->getMoniteursHome();
        require_once("vue/vue_presentation.php");
        break;
}
?>