<?php
require_once "C_menu.php";
require_once "modeles/M_employe.php";
require_once "modeles/M_service.php";

class C_modifierEmploye
{
    private $data;
    private $controleurMenu;
    private $modeleEmploye;
    private $modeleService;

    public function __construct()
    {
        $this->data = array();
        $this->controleurMenu = new C_menu();
        $this->modeleEmploye = new M_employe();
        $this->modeleService = new M_service();
    }

    public function action_afficherForm($matricule)
    {
        $this->controleurMenu->FillData($this->data);
        $this->data['lEmploye'] = $this->modeleEmploye->GetEmploye($matricule);
        
        if (is_null($this->data['lEmploye'])) {
            $this->data['leMessage'] = "Employé introuvable.";
            require_once "vues/v_message.php";
        } else {
            require_once "vues/v_modifierEmploye.php";
        }
    }

    public function action_modifier($matricule, $nom, $prenom, $service, $email = '', $telephone = '', $poste = '', $dateEmbauche = '', $salaire = '')
    {
        $this->controleurMenu->FillData($this->data);
        
        // Validation
        if (empty($nom) || empty($prenom) || empty($service)) {
            $this->data['leMessage'] = "Les champs nom, prénom et service sont obligatoires.";
            $this->data['lEmploye'] = $this->modeleEmploye->GetEmploye($matricule);
            require_once "vues/v_modifierEmploye.php";
            return;
        }

        // Conversion salaire
        $salaireNum = !empty($salaire) ? floatval($salaire) : null;
        
        $employe = $this->modeleEmploye->Modifier(
            $matricule,
            $nom,
            $prenom,
            $service,
            !empty($email) ? $email : null,
            !empty($telephone) ? $telephone : null,
            !empty($poste) ? $poste : null,
            !empty($dateEmbauche) ? $dateEmbauche : null,
            $salaireNum
        );

        if (!is_null($employe)) {
            $this->data['leMessage'] = "L'employé " . $employe->GetNom() . " " . $employe->GetPrenom() . " a été modifié avec succès.";
        } else {
            $this->data['leMessage'] = "Erreur lors de la modification de l'employé.";
        }
        
        require_once "vues/v_message.php";
    }
}
?>
