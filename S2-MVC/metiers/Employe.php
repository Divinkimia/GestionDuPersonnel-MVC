<?php 
 class Employe
 {
    private $emp_matricule;
    private $emp_nom;
    private $emp_prenom;
    private $emp_service;
    private $emp_email;
    private $emp_telephone;
    private $emp_poste;
    private $emp_date_embauche;
    private $emp_salaire;
    
    public function __construct($matricule, $nom, $prenom, $service, $email = null, $telephone = null, $poste = null, $dateEmbauche = null, $salaire = null)
    {
        $this->emp_matricule = $matricule;
        $this->emp_nom = $nom;
        $this->emp_prenom = $prenom;
        $this->emp_service = $service;
        $this->emp_email = $email;
        $this->emp_telephone = $telephone;
        $this->emp_poste = $poste;
        $this->emp_date_embauche = $dateEmbauche;
        $this->emp_salaire = $salaire;
    }
    
    public function GetMatricule()
    {
        return $this->emp_matricule;
    }
    
    public function GetNom()
    {
        return $this->emp_nom;
    }
    
    public function GetPrenom()
    {
        return $this->emp_prenom;
    }
    
    public function GetService()
    {
        return $this->emp_service;
    }
    
    public function GetEmail()
    {
        return $this->emp_email;
    }
    
    public function GetTelephone()
    {
        return $this->emp_telephone;
    }
    
    public function GetPoste()
    {
        return $this->emp_poste;
    }
    
    public function GetDateEmbauche()
    {
        return $this->emp_date_embauche;
    }
    
    public function GetSalaire()
    {
        return $this->emp_salaire;
    }
    
    public function GetNomComplet()
    {
        return $this->emp_prenom . ' ' . $this->emp_nom;
    }
 }

?>