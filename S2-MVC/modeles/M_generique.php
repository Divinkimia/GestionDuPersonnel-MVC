<?php
// modeles/M_generique.php
class M_generique
{
    private $cnx;
    private $pdo;

    public function GetCnx()
    {
        return $this->cnx;
    }

    public function GetPdo()
    {
        if ($this->pdo === null) {
            try {
                $dsn = "mysql:host=127.0.0.1;dbname=empsceMvc;charset=utf8mb4";
                $this->pdo = new PDO($dsn, "root", "");
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return $this->pdo;
    }

    public function Connexion()
    {
        // ADAPTE la DB si besoin
        $this->cnx = mysqli_connect("127.0.0.1", "root", "", "empsceMvc");
        if (!$this->cnx) {
            die("Erreur MySQL : " . mysqli_connect_error());
        }
        mysqli_set_charset($this->cnx, "utf8mb4");
    }

    public function Deconnexion()
    {
        if ($this->cnx) {
            mysqli_close($this->cnx);
        }
    }
}
?>