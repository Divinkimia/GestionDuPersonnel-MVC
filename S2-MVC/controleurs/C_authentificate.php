<?php
require_once "modeles/M_authentificate.php";
require_once "controleurs/C_menu.php";

class C_authentificate
{
    private $data = [];
    private $modeleAuth;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modeleAuth = new M_authentificate();
    }

    // Affiche le formulaire de connexion
    public function action_afficherForm()
    {
        $controleurMenu = new C_menu();
        $controleurMenu->FillData($this->data);
        require_once "vues/v_login.php";
    }

    // Traitement du login
    public function action_login($login, $mdp)
    {
        // Validation minimale
        if (empty($login) || empty($mdp)) {
            $message = "Veuillez renseigner le login et le mot de passe.";
            require_once "vues/v_login.php";
            return;
        }

        $user = $this->modeleAuth->GetUserByLogin($login);
        if ($user && password_verify($mdp, $user['user_mdp'])) {
            // Connexion OK
            $_SESSION['loginU'] = $user['user_login'];
            $_SESSION['user_id'] = $user['user_id'];
            // redirige vers accueil
            header("Location: index.php?page=accueil");
            exit;
        } else {
            $message = "Login ou mot de passe incorrect.";
            require_once "vues/v_login.php";
        }
    }

    // Affiche le formulaire d'enregistrement
    public function action_afficherRegisterForm()
    {
        $controleurMenu = new C_menu();
        $controleurMenu->FillData($this->data);
        require_once "vues/v_enregistrer.php";
    }

    // Traitement de l'inscription
    public function action_register($nom, $prenom, $email, $login, $mdp)
    {
        // Validation minimale côté serveur
        if (empty($nom) || empty($prenom) || empty($email) || empty($login) || empty($mdp)) {
            $message = "Tous les champs sont obligatoires.";
            require_once "vues/v_enregistrer.php";
            return;
        }

        // Vérifier que l'email / login n'existent pas déjà
        if ($this->modeleAuth->GetUserByEmail($email)) {
            $message = "Un compte avec cet e-mail existe déjà.";
            require_once "vues/v_enregistrer.php";
            return;
        }
        if ($this->modeleAuth->GetUserByLogin($login)) {
            $message = "Cet identifiant est déjà utilisé.";
            require_once "vues/v_enregistrer.php";
            return;
        }

        $ok = $this->modeleAuth->RegisterUser($nom, $prenom, $email, $login, $mdp);
        if ($ok) {
            // inscription OK -> redirection vers login
            header("Location: index.php?page=login&registered=1");
            exit;
        } else {
            $message = "Erreur lors de l'inscription. Réessayez.";
            require_once "vues/v_enregistrer.php";
        }
    }

    public function logout()
    {
        // détruit la session proprement
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }

    public function isLoggedOn()
    {
        return isset($_SESSION['loginU']);
    }
}
?>