<?php
    require_once "C_menu.php";
    class C_accueil 
    {
        private $data;
        private$controleurMenu;
        public function __construct()
        {
            $this->data=array();
            $this->controleurMenu=new C_menu();
        }
        function action_afficher()
        {
            $this->controleurMenu->FillData($this->data);
            require_once "vues/v_accueil.php";
        }
    }
?>