<?php
require_once "metiers/Employe.php";
require_once "M_generique.php";

class M_employe extends M_generique 
{
    private function colonneExiste($colonne, $table = 'employe')
    {
        $pdo = $this->GetPdo();
        try {
            $req = "SELECT `{$colonne}` FROM `{$table}` LIMIT 1";
            $pdo->query($req);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function GetListe($actifSeulement = true)
    {
        $resultat = array();
        $pdo = $this->GetPdo();
        
        // Vérifier si la colonne emp_actif existe
        $colonneActifExiste = $this->colonneExiste('emp_actif');
        
        if ($colonneActifExiste && $actifSeulement) {
            $req = "SELECT * FROM employe WHERE emp_actif = 1 ORDER BY emp_nom, emp_prenom";
        } else {
            $req = "SELECT * FROM employe ORDER BY emp_nom, emp_prenom";
        }
        
        $stmt = $pdo->prepare($req);
        $stmt->execute();
        
        while ($ligne = $stmt->fetch()) {
            $employe = new Employe(
                $ligne["emp_matricule"],
                $ligne["emp_nom"],
                $ligne["emp_prenom"],
                $ligne["emp_service"],
                $ligne["emp_email"] ?? null,
                $ligne["emp_telephone"] ?? null,
                $ligne["emp_poste"] ?? null,
                $ligne["emp_date_embauche"] ?? null,
                $ligne["emp_salaire"] ?? null
            );
            $resultat[] = $employe;
        }
        
        return $resultat;
    }

    /*class M_employe
    {
    private $cnx;s
    private function connexion()
    {
        $this->cnx=mysqli_connect("127.0.0.1", "root","","emsce");
        mysqli_set_charset($this->cnx, "utf8");
    }
    private function deconnexion()
    {
        mysqli_close($this->cnx);
    }
    public function GetListe()
    {
        $resultat=array();
        $this->connexion();
        $req="select * from employe";
        $res=mysqli_query($this->cnx,$req);
        $ligne=mysqli_fetch_assoc($res);
        while ($ligne) 
        {
            $employe=new Employe( $ligne["emp_matricule"],$ligne["emp_nom"],
                                    $ligne["emp_prenom"],$ligne["emp_service"]);
            $resultat[]=$employe;
            $ligne=mysqli_fetch_assoc($res);
        }
        $this->deconnexion();
        return $resultat;
    }
}*/
    
    public function GetListeService($code, $actifSeulement = true)
    {
        $resultat = array();
        $pdo = $this->GetPdo();
        
        // Vérifier si la colonne emp_actif existe
        $colonneActifExiste = $this->colonneExiste('emp_actif');
        
        if ($colonneActifExiste && $actifSeulement) {
            $req = "SELECT * FROM employe WHERE emp_service = :code AND emp_actif = 1 ORDER BY emp_nom, emp_prenom";
        } else {
            $req = "SELECT * FROM employe WHERE emp_service = :code ORDER BY emp_nom, emp_prenom";
        }
        
        $stmt = $pdo->prepare($req);
        $stmt->execute([':code' => $code]);
        
        while ($ligne = $stmt->fetch()) {
            $employe = new Employe(
                $ligne["emp_matricule"],
                $ligne["emp_nom"],
                $ligne["emp_prenom"],
                $ligne["emp_service"],
                $ligne["emp_email"] ?? null,
                $ligne["emp_telephone"] ?? null,
                $ligne["emp_poste"] ?? null,
                $ligne["emp_date_embauche"] ?? null,
                $ligne["emp_salaire"] ?? null
            );
            $resultat[] = $employe;
        }
        
        return $resultat;
    }
    
    public function Rechercher($critere)
    {
        $resultat = array();
        $pdo = $this->GetPdo();
        
        // Vérifier si les colonnes existent
        $colonneActifExiste = $this->colonneExiste('emp_actif');
        $colonneEmailExiste = $this->colonneExiste('emp_email');
        $colonnePosteExiste = $this->colonneExiste('emp_poste');
        
        $conditions = [];
        $conditions[] = "emp_matricule LIKE :critere";
        $conditions[] = "emp_nom LIKE :critere";
        $conditions[] = "emp_prenom LIKE :critere";
        if ($colonneEmailExiste) {
            $conditions[] = "emp_email LIKE :critere";
        }
        if ($colonnePosteExiste) {
            $conditions[] = "emp_poste LIKE :critere";
        }
        
        $whereClause = implode(' OR ', $conditions);
        
        if ($colonneActifExiste) {
            $req = "SELECT * FROM employe WHERE emp_actif = 1 AND ($whereClause) ORDER BY emp_nom, emp_prenom";
        } else {
            $req = "SELECT * FROM employe WHERE ($whereClause) ORDER BY emp_nom, emp_prenom";
        }
        
        $stmt = $pdo->prepare($req);
        $critere = '%' . $critere . '%';
        $stmt->execute([':critere' => $critere]);
        
        while ($ligne = $stmt->fetch()) {
            $employe = new Employe(
                $ligne["emp_matricule"],
                $ligne["emp_nom"],
                $ligne["emp_prenom"],
                $ligne["emp_service"],
                $ligne["emp_email"] ?? null,
                $ligne["emp_telephone"] ?? null,
                $ligne["emp_poste"] ?? null,
                $ligne["emp_date_embauche"] ?? null,
                $ligne["emp_salaire"] ?? null
            );
            $resultat[] = $employe;
        }
        
        return $resultat;
    }

    public function GetEmploye($matricule)
    {
        $pdo = $this->GetPdo();
        $req = "SELECT * FROM employe WHERE emp_matricule = :matricule";
        $stmt = $pdo->prepare($req);
        $stmt->execute([':matricule' => $matricule]);
        $ligne = $stmt->fetch();

        if ($ligne) {
            return new Employe(
                $ligne["emp_matricule"],
                $ligne["emp_nom"],
                $ligne["emp_prenom"],
                $ligne["emp_service"],
                $ligne["emp_email"] ?? null,
                $ligne["emp_telephone"] ?? null,
                $ligne["emp_poste"] ?? null,
                $ligne["emp_date_embauche"] ?? null,
                $ligne["emp_salaire"] ?? null
            );
        }
        return null;
    }

    public function Ajouter($matricule, $nom, $prenom, $service, $email = null, $telephone = null, $poste = null, $dateEmbauche = null, $salaire = null)
    {
        $pdo = $this->GetPdo();
        
        // Vérifier quelles colonnes existent
        $colonnesExistent = [
            'email' => $this->colonneExiste('emp_email'),
            'telephone' => $this->colonneExiste('emp_telephone'),
            'poste' => $this->colonneExiste('emp_poste'),
            'date_embauche' => $this->colonneExiste('emp_date_embauche'),
            'salaire' => $this->colonneExiste('emp_salaire'),
            'actif' => $this->colonneExiste('emp_actif')
        ];
        
        // Construire la requête selon les colonnes disponibles
        $colonnes = ['emp_matricule', 'emp_nom', 'emp_prenom', 'emp_service'];
        $valeurs = [':matricule', ':nom', ':prenom', ':service'];
        $params = [
            ':matricule' => $matricule,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':service' => $service
        ];
        
        if ($colonnesExistent['email']) {
            $colonnes[] = 'emp_email';
            $valeurs[] = ':email';
            $params[':email'] = $email;
        }
        if ($colonnesExistent['telephone']) {
            $colonnes[] = 'emp_telephone';
            $valeurs[] = ':telephone';
            $params[':telephone'] = $telephone;
        }
        if ($colonnesExistent['poste']) {
            $colonnes[] = 'emp_poste';
            $valeurs[] = ':poste';
            $params[':poste'] = $poste;
        }
        if ($colonnesExistent['date_embauche']) {
            $colonnes[] = 'emp_date_embauche';
            $valeurs[] = ':date_embauche';
            $params[':date_embauche'] = $dateEmbauche ?: null;
        }
        if ($colonnesExistent['salaire']) {
            $colonnes[] = 'emp_salaire';
            $valeurs[] = ':salaire';
            $params[':salaire'] = $salaire ?: null;
        }
        if ($colonnesExistent['actif']) {
            $colonnes[] = 'emp_actif';
            $valeurs[] = '1';
        }
        
        $req = "INSERT INTO employe (" . implode(', ', $colonnes) . ") VALUES (" . implode(', ', $valeurs) . ")";
        
        try {
            $stmt = $pdo->prepare($req);
            $ok = $stmt->execute($params);
            
            if ($ok) {
                return new Employe($matricule, $nom, $prenom, $service, $email, $telephone, $poste, $dateEmbauche, $salaire);
            }
        } catch (PDOException $e) {
            error_log("Erreur ajout employé : " . $e->getMessage());
        }
        
        return null;
    }
    
    public function Modifier($matricule, $nom, $prenom, $service, $email = null, $telephone = null, $poste = null, $dateEmbauche = null, $salaire = null)
    {
        $pdo = $this->GetPdo();
        
        // Vérifier quelles colonnes existent
        $colonnesExistent = [
            'email' => $this->colonneExiste('emp_email'),
            'telephone' => $this->colonneExiste('emp_telephone'),
            'poste' => $this->colonneExiste('emp_poste'),
            'date_embauche' => $this->colonneExiste('emp_date_embauche'),
            'salaire' => $this->colonneExiste('emp_salaire'),
            'date_modification' => $this->colonneExiste('emp_date_modification')
        ];
        
        // Construire la requête selon les colonnes disponibles
        $setClauses = [
            'emp_nom = :nom',
            'emp_prenom = :prenom',
            'emp_service = :service'
        ];
        $params = [
            ':matricule' => $matricule,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':service' => $service
        ];
        
        if ($colonnesExistent['email']) {
            $setClauses[] = 'emp_email = :email';
            $params[':email'] = $email;
        }
        if ($colonnesExistent['telephone']) {
            $setClauses[] = 'emp_telephone = :telephone';
            $params[':telephone'] = $telephone;
        }
        if ($colonnesExistent['poste']) {
            $setClauses[] = 'emp_poste = :poste';
            $params[':poste'] = $poste;
        }
        if ($colonnesExistent['date_embauche']) {
            $setClauses[] = 'emp_date_embauche = :date_embauche';
            $params[':date_embauche'] = $dateEmbauche ?: null;
        }
        if ($colonnesExistent['salaire']) {
            $setClauses[] = 'emp_salaire = :salaire';
            $params[':salaire'] = $salaire ?: null;
        }
        if ($colonnesExistent['date_modification']) {
            $setClauses[] = 'emp_date_modification = NOW()';
        }
        
        $req = "UPDATE employe SET " . implode(', ', $setClauses) . " WHERE emp_matricule = :matricule";
        
        try {
            $stmt = $pdo->prepare($req);
            $ok = $stmt->execute($params);
            
            if ($ok) {
                return $this->GetEmploye($matricule);
            }
        } catch (PDOException $e) {
            error_log("Erreur modification employé : " . $e->getMessage());
        }
        
        return null;
    }
    
    public function Supprimer($matricule)
    {
        $pdo = $this->GetPdo();
        
        // Vérifier si la colonne emp_actif existe pour soft delete
        if ($this->colonneExiste('emp_actif')) {
            // Soft delete : on désactive plutôt que de supprimer
            $req = "UPDATE employe SET emp_actif = 0 WHERE emp_matricule = :matricule";
            if ($this->colonneExiste('emp_date_modification')) {
                $req = "UPDATE employe SET emp_actif = 0, emp_date_modification = NOW() WHERE emp_matricule = :matricule";
            }
        } else {
            // Si pas de colonne emp_actif, supprimer réellement (pour compatibilité)
            $req = "DELETE FROM employe WHERE emp_matricule = :matricule";
        }
        
        try {
            $stmt = $pdo->prepare($req);
            return $stmt->execute([':matricule' => $matricule]);
        } catch (PDOException $e) {
            error_log("Erreur suppression employé : " . $e->getMessage());
            return false;
        }
    }
    
    public function GetStatistiques()
    {
        $pdo = $this->GetPdo();
        
        $stats = [];
        
        // Vérifier si les colonnes existent
        $colonneActifExiste = $this->colonneExiste('emp_actif');
        $colonneServiceActifExiste = $this->colonneExiste('sce_actif', 'service');
        
        // Total employés
        if ($colonneActifExiste) {
            $req = "SELECT COUNT(*) as total FROM employe WHERE emp_actif = 1";
        } else {
            $req = "SELECT COUNT(*) as total FROM employe";
        }
        $stmt = $pdo->query($req);
        $stats['total'] = $stmt->fetch()['total'];
        
        // Par service
        $whereService = '';
        if ($colonneServiceActifExiste) {
            $whereService = 'WHERE s.sce_actif = 1';
        }
        
        $joinCondition = 's.sce_code = e.emp_service';
        if ($colonneActifExiste) {
            $joinCondition .= ' AND e.emp_actif = 1';
        }
        
        $req = "SELECT s.sce_designation, COUNT(e.emp_matricule) as nb 
                FROM service s 
                LEFT JOIN employe e ON {$joinCondition}
                {$whereService}
                GROUP BY s.sce_code, s.sce_designation";
        $stmt = $pdo->query($req);
        $stats['par_service'] = $stmt->fetchAll();
        
        return $stats;
    }

}

?>