<?php
require_once "C_menu.php";
require_once "modeles/M_employe.php";

class C_dashboard
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

    public function action_afficher()
    {
        $this->controleurMenu->FillData($this->data);
        $this->data['statistiques'] = $this->modeleEmploye->GetStatistiques();
        require_once "vues/v_dashboard.php";
    }
}
?>
