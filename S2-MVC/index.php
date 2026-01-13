<?php
session_start();

$page = !empty($_GET['page']) ? $_GET['page'] : "login";

function checkLogin() {
    return isset($_SESSION['loginU']) && !empty($_SESSION['loginU']);
}

switch ($page) {

    // LOGIN
    case "login":
        require_once "controleurs/C_authentificate.php";
        $controleur = new C_authentificate();
        $controleur->action_afficherForm();
    break;

    case "loginAction":
        require_once "controleurs/C_authentificate.php";
        $controleur = new C_authentificate();
        $controleur->action_login($_POST["login"] ?? '', $_POST["mdp"] ?? '');
    break;

    case "logout":
        require_once "controleurs/C_authentificate.php";
        $controleur = new C_authentificate();
        $controleur->logout();
    break;

    // REGISTER
    case "register":
        require_once "controleurs/C_authentificate.php";
        $controleur = new C_authentificate();
        $controleur->action_afficherRegisterForm();
    break;

    case "registerAction":
        require_once "controleurs/C_authentificate.php";
        $controleur = new C_authentificate();
        $controleur->action_register(
            $_POST["nom"] ?? '',
            $_POST["prenom"] ?? '',
            $_POST["email"] ?? '',
            $_POST["login"] ?? '',
            $_POST["mdp"] ?? ''
        );
    break;

    // LISTE EMPLOYES
    case "listeEmployes":
        if (checkLogin()) {
            require_once "controleurs/C_consulterEmployes.php";
            $controleur = new C_consulterEmployes();
            $codeService = !empty($_GET['service']) ? $_GET['service'] : "all";
            $controleur->action_listeEmployes($codeService);
        } else {
            header("Location: index.php?page=login");
            exit;
        }
    break;

    // SAISIE EMPLOYE
    case "saisieEmploye":
        if (checkLogin()) {
            require_once "controleurs/C_ajouterEmployes.php";
            $controleur = new C_ajouterEmployes();
            $controleur->action_saisie();
        } else {
            header("Location: index.php?page=login");
            exit;
        }
    break;

    case "ajoutEmploye":
        if (checkLogin()) {
            require_once "controleurs/C_ajouterEmployes.php";
            $controleur = new C_ajouterEmployes();
            $controleur->action_ajout(
                $_POST["matricule"] ?? '',
                $_POST["nom"] ?? '',
                $_POST["prenom"] ?? '',
                $_POST["service"] ?? '',
                $_POST["email"] ?? '',
                $_POST["telephone"] ?? '',
                $_POST["poste"] ?? '',
                $_POST["date_embauche"] ?? '',
                $_POST["salaire"] ?? ''
            );
        } else {
            header("Location: index.php?page=login");
            exit;
        }
    break;

    // MODIFIER EMPLOYE
    case "modifierEmploye":
        if (checkLogin()) {
            require_once "controleurs/C_modifierEmploye.php";
            $controleur = new C_modifierEmploye();
            $matricule = $_GET['matricule'] ?? '';
            $controleur->action_afficherForm($matricule);
        } else {
            header("Location: index.php?page=login");
            exit;
        }
    break;

    case "modifierEmployeAction":
        if (checkLogin()) {
            require_once "controleurs/C_modifierEmploye.php";
            $controleur = new C_modifierEmploye();
            $controleur->action_modifier(
                $_POST["matricule"] ?? '',
                $_POST["nom"] ?? '',
                $_POST["prenom"] ?? '',
                $_POST["service"] ?? '',
                $_POST["email"] ?? '',
                $_POST["telephone"] ?? '',
                $_POST["poste"] ?? '',
                $_POST["date_embauche"] ?? '',
                $_POST["salaire"] ?? ''
            );
        } else {
            header("Location: index.php?page=login");
            exit;
        }
    break;

    // SUPPRIMER EMPLOYE
    case "supprimerEmploye":
        if (checkLogin()) {
            require_once "controleurs/C_supprimerEmploye.php";
            $controleur = new C_supprimerEmploye();
            $matricule = $_GET['matricule'] ?? '';
            $controleur->action_supprimer($matricule);
        } else {
            header("Location: index.php?page=login");
            exit;
        }
    break;

    // RECHERCHER EMPLOYES
    case "rechercherEmployes":
        if (checkLogin()) {
            require_once "controleurs/C_rechercherEmployes.php";
            $controleur = new C_rechercherEmployes();
            $critere = $_GET['q'] ?? $_POST['q'] ?? '';
            $controleur->action_rechercher($critere);
        } else {
            header("Location: index.php?page=login");
            exit;
        }
    break;

    // DASHBOARD
    case "dashboard":
        if (checkLogin()) {
            require_once "controleurs/C_dashboard.php";
            $controleur = new C_dashboard();
            $controleur->action_afficher();
        } else {
            header("Location: index.php?page=login");
            exit;
        }
    break;

    // ACCUEIL (par défaut)
    case "accueil":
    default:
        if (checkLogin()) {
            require_once "controleurs/C_accueil.php";
            $controleur = new C_accueil();
            $controleur->action_afficher();
        } else {
            header("Location: index.php?page=login");
            exit;
        }
    break;
}
?>