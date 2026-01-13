<?php
require_once "C_menu.php";
require_once "modeles/M_employe.php";

class C_supprimerEmploye
{
    private $data;
    private $controleurMenu;
    private $modeleEmploye;

    public function __construct()
    {
        $this->data = array();
        $this->controleurMenu = new C_menu();
        $this->modeleEmploye = new M_employe();
    }

    public function action_supprimer($matricule)
    {
        $this->controleurMenu->FillData($this->data);
        
        $employe = $this->modeleEmploye->GetEmploye($matricule);
        
        if (is_null($employe)) {
            $this->data['leMessage'] = "Employé introuvable.";
        } else {
            $ok = $this->modeleEmploye->Supprimer($matricule);
            if ($ok) {
                $this->data['leMessage'] = "L'employé " . $employe->GetNom() . " " . $employe->GetPrenom() . " a été supprimé avec succès.";
            } else {
                $this->data['leMessage'] = "Erreur lors de la suppression de l'employé.";
            }
        }
        
        require_once "vues/v_message.php";
    }
}
?>
