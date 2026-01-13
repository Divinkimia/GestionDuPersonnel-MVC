<?php
require_once "M_generique.php";
require_once "metiers/Service.php";
class M_service extends M_generique
{
    
    public function GetListe($actifSeulement = true)
    {
        $resultat = [];
        $pdo = $this->GetPdo();
        
        // Vérifier si la colonne sce_actif existe
        try {
            $testReq = "SELECT sce_actif FROM service LIMIT 1";
            $pdo->query($testReq);
            $colonnesExistantes = true;
        } catch (PDOException $e) {
            $colonnesExistantes = false;
        }
        
        if ($colonnesExistantes && $actifSeulement) {
            $req = "SELECT * FROM service WHERE sce_actif = 1 ORDER BY sce_designation";
        } else {
            $req = "SELECT * FROM service ORDER BY sce_designation";
        }
        
        $stmt = $pdo->query($req);
        
        while ($ligne = $stmt->fetch()) {
            $sce = new Service($ligne["sce_code"], $ligne["sce_designation"]);
            $resultat[] = $sce;
        }
        
        return $resultat;
    }


    public function GetService($code)
    {
        $pdo = $this->GetPdo();
        $req = "SELECT * FROM service WHERE sce_code = :code";
        $stmt = $pdo->prepare($req);
        $stmt->execute([':code' => $code]);
        $ligne = $stmt->fetch();
        
        if ($ligne) {
            return new Service($ligne["sce_code"], $ligne["sce_designation"]);
        }
        
        return null;
    }

}

require_once "metiers/Employe.php";

?>