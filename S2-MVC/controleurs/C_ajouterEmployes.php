<?php
require_once "C_menu.php";
require_once "modeles/M_employe.php";
class C_ajouterEmployes
{
    private $data;
    private $controleurMenu;
    private $modeleEmploye;
    public function __construct()
    {
        $this->data=array();
        $this->controleurMenu=new C_menu();
        $this->modeleEmploye=new M_employe();
    }
    public function action_saisie()
    {
        $this->controleurMenu->FillData($this->data);
        require_once "vues/v_saisieEmploye.php";
    }
    public function action_ajout($matricule, $nom, $prenom, $service, $email = '', $telephone = '', $poste = '', $dateEmbauche = '', $salaire = '')
    {
        $this->controleurMenu->FillData($this->data);
        
        // Validation
        if (empty($matricule) || empty($nom) || empty($prenom) || empty($service)) {
            $this->data['leMessage'] = "Les champs matricule, nom, prénom et service sont obligatoires.";
            require_once "vues/v_saisieEmploye.php";
            return;
        }
        
        if (!is_null($this->modeleEmploye->GetEmploye($matricule))) {
            $this->data['leMessage'] = "Le matricule " . $matricule . " existe déjà, ajout annulé.";
            require_once "vues/v_saisieEmploye.php";
            return;
        }
        
        // Conversion salaire
        $salaireNum = !empty($salaire) ? floatval($salaire) : null;
        
        $employe = $this->modeleEmploye->Ajouter(
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
        
        if (is_null($employe)) {
            $this->data['leMessage'] = "L'ajout a échoué pour une raison indéterminée.";
        } else {
            $this->data['leMessage'] = $employe->GetNom() . " " . $employe->GetPrenom() . " a été ajouté avec succès.";
        }
        
        require_once "vues/v_message.php";
    }
}

?>