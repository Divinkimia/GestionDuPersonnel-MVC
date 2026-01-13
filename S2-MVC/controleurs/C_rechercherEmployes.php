<?php
require_once "C_menu.php";
require_once "modeles/M_employe.php";

class C_rechercherEmployes
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

    public function action_rechercher($critere = '')
    {
        $this->controleurMenu->FillData($this->data);
        
        if (!empty($critere)) {
            $this->data['lesEmployes'] = $this->modeleEmploye->Rechercher($critere);
            $this->data['critere'] = $critere;
        } else {
            $this->data['lesEmployes'] = [];
            $this->data['critere'] = '';
        }
        
        require_once "vues/v_rechercherEmployes.php";
    }
}
?>
