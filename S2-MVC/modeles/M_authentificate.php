<?php
require_once "M_generique.php";

class M_authentificate extends M_generique
{
    private $pdo;

    public function __construct() {
        // ✅ Connexion à la bonne base
        $dsn = "mysql:host=127.0.0.1;dbname=empsceMvc;charset=utf8";
        $this->pdo = new PDO($dsn, "root", "");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Récupère un utilisateur par login
     * @param string $login
     * @return array|null
     */
    public function GetUserByLogin($login)
    {
        $sql = "SELECT * FROM user WHERE user_login = :login LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':login' => $login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un utilisateur par email
     */
    public function GetUserByEmail($email)
    {
        $sql = "SELECT * FROM user WHERE user_email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Enregistre un nouvel utilisateur (inscription)
     */
    public function RegisterUser($nom, $prenom, $email, $login, $mdp)
    {
        $sql = "INSERT INTO user (user_nom, user_prenom, user_email, user_login, user_mdp)
                VALUES (:nom, :prenom, :email, :login, :mdp)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nom'    => $nom,
            ':prenom' => $prenom,
            ':email'  => $email,
            ':login'  => $login,
            ':mdp'    => password_hash($mdp, PASSWORD_BCRYPT)
        ]);
    }
}
?>