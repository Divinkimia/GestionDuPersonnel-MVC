# 📚 Documentation Complète - Système de Gestion du Personnel

Premier projet en MVC (Si c'est votre premier projet en Model Vue controleur MVC voici une documentation plus détailler du projet pour vous aider a comprendre )
 
## 🎯 Introduction

Cette documentation explique **en détail** comment fonctionne le système de gestion du personnel. Elle est conçue pour les **débutants en programmation** qui veulent comprendre chaque partie du code.

-------------------------------------------

## 📖 Table des Matières

1. [Qu'est-ce que l'architecture MVC ?](#quest-ce-que-larchitecture-mvc)
2. [Structure du Projet](#structure-du-projet)
3. [Le Point d'Entrée : index.php](#le-point-dentrée-indexphp)
4. [Les Contrôleurs (C_*.php)](#les-contrôleurs-c_php)
5. [Les Modèles (M_*.php)](#les-modèles-m_php)
6. [Les Vues (v_*.php)](#les-vues-v_php)
7. [Les Classes Métier](#les-classes-métier)
8. [Flux d'Exécution Complet](#flux-dexécution-complet)
9. [Exemples Concrets](#exemples-concrets)
10. [Glossaire](#glossaire)

-------------------------------

## 🏗️ Qu'est-ce que l'Architecture MVC ?

**MVC** signifie **Modèle-Vue-Contrôleur**. C'est une façon d'organiser le code en 3 parties :

### 📦 Le Modèle (M_*.php)
- **Rôle** : Communique avec la base de données
- **Responsabilité** : Récupérer, ajouter, modifier, supprimer des données
- **Exemple** : `M_employe.php` récupère la liste des employés depuis la base de données



### 🎨 La Vue (v_*.php)
- **Rôle** : Afficher les informations à l'utilisateur
- **Responsabilité** : Créer l'interface HTML que l'utilisateur voit
- **Exemple** : `v_listeEmployes.php` affiche la liste des employés dans un tableau




### 🎮 Le Contrôleur (C_*.php)
- **Rôle** : Coordonner le Modèle et la Vue
- **Responsabilité** : Recevoir les demandes de l'utilisateur, demander les données au Modèle, et les envoyer à la Vue
- **Exemple** : `C_consulterEmployes.php` demande la liste au Modèle, puis l'envoie à la Vue



### 🔄 Schéma du Fonctionnement du fonctionnement des demandes et reception des paquets 

```
Utilisateur → index.php → Contrôleur → Modèle → Base de données
                                                      ↓
Utilisateur ← Vue (HTML) ← Contrôleur ← Modèle ← Résultats
```

---------------------------------------------------

## 📁 Structure du Projet

```
S2-MVC/
├── index.php                    # Point d'entrée (routeur)
├── controleurs/                 # Les contrôleurs (logique)
│   ├── C_accueil.php
│   ├── C_ajouterEmployes.php
│   ├── C_authentificate.php
│   ├── C_consulterEmployes.php
│   ├── C_dashboard.php
│   ├── C_menu.php
│   ├── C_modifierEmploye.php
│   ├── C_rechercherEmployes.php
│   └── C_supprimerEmploye.php
├── modeles/                     # Les modèles (base de données)
│   ├── M_authentificate.php
│   ├── M_employe.php
│   ├── M_generique.php
│   └── M_service.php
├── vues/                        # Les vues (interface)
│   ├── v_accueil.php
│   ├── v_dashboard.php
│   ├── v_enregistrer.php
│   ├── v_entete.php
│   ├── v_listeEmployes.php
│   ├── v_login.php
│   ├── v_message.php
│   ├── v_modifierEmploye.php
│   ├── v_piedPage.php
│   ├── v_rechercherEmployes.php
│   └── v_saisieEmploye.php
└── metiers/                     # Les classes métier (objets)
    ├── Employe.php
    └── Service.php
```

-----------------------------------------

## 🚪 Le Point d'Entrée : index.php

`index.php` est le **premier fichier** qui s'exécute quand quelqu'un visite votre site. C'est comme un **réceptionniste** qui dirige les visiteurs vers le bon bureau.

### Comment ça fonctionne ?

```php
<?php
session_start();  // Démarre une session pour garder l'utilisateur connecté

// On Récupère la page demandée (ex: ?page=login)
$page = !empty($_GET['page']) ? $_GET['page'] : "login";

// On Vérifie si l'utilisateur est connecté
function checkLogin() {
    return isset($_SESSION['loginU']) && !empty($_SESSION['loginU']);
}

// Selon la page demandée, on charge le bon contrôleur
switch ($page) {
    case "login":
        require_once "controleurs/C_authentificate.php";
        $controleur = new C_authentificate();
        $controleur->action_afficherForm();
    break;
    
    case "listeEmployes":
        if (checkLogin()) {  // Vérifie si connecté
            require_once "controleurs/C_consulterEmployes.php";
            $controleur = new C_consulterEmployes();
            $controleur->action_listeEmployes("all");
        } else {
            header("Location: index.php?page=login");  // Redirige vers login
        }
    break;
    
    // ... autres cas
}
?>
```

### Explication Ligne par Ligne

1. **`session_start()`** : Démarre une session PHP. Une session permet de garder des informations sur l'utilisateur (comme son nom) pendant qu'il navigue sur le site.

2. **`$page = !empty($_GET['page']) ? $_GET['page'] : "login"`** :
   - `$_GET['page']` : Récupère la valeur de `?page=...` dans l'URL
   - Si l'URL est `index.php?page=login`, alors `$page = "login"`
   - Si rien n'est spécifié, par défaut `$page = "login"`

3. **`function checkLogin()`** : Une fonction qui vérifie si l'utilisateur est connecté en vérifiant si `$_SESSION['loginU']` existe.

4. **`switch ($page)`** : C'est comme un aiguillage de train. Selon la valeur de `$page`, on exécute un code différent.

### Exemple Concret

Quand un utilisateur tape dans son navigateur :
```
http://localhost/S2-MVC/index.php?page=listeEmployes
```

1. `index.php` reçoit `$page = "listeEmployes"`
2. Le `switch` trouve le cas `"listeEmployes"`
3. Il vérifie si l'utilisateur est connecté avec `checkLogin()`
4. Si oui, il charge `C_consulterEmployes.php` et appelle `action_listeEmployes()`
5. Si non, il redirige vers la page de connexion

---

## 🎮 Les Contrôleurs (C_*.php)

### Qu'est-ce qu'un Contrôleur ?

Un contrôleur est comme un **chef d'orchestre**. Il :
- Reçoit les demandes de l'utilisateur
- Demande les données au Modèle
- Envoie les données à la Vue pour affichage

### Exemple : C_consulterEmployes.php

```php
<?php
require_once "C_menu.php";
require_once "modeles/M_service.php";
require_once "modeles/M_employe.php";

class C_consulterEmployes
{
    // Propriétés (variables de la classe)
    private $data;              // Tableau qui contient les données à envoyer à la vue
    private $controleurMenu;    // Contrôleur pour le menu
    private $modeleService;      // Modèle pour les services
    private $modeleEmploye;      // Modèle pour les employés

    // Constructeur : s'exécute quand on crée un objet de cette classe
    public function __construct()
    {
        $this->data = array();                    // Initialise un tableau vide
        $this->controleurMenu = new C_menu();     // Crée un objet C_menu
        $this->modeleService = new M_service();   // Crée un objet M_service
        $this->modeleEmploye = new M_employe();   // Crée un objet M_employe
    }

    // Méthode principale : affiche la liste des employés
    public function action_listeEmployes($codeService)
    {
        // 1. Remplit le menu dans $data
        $this->controleurMenu->FillData($this->data);
        
        // 2. Selon le code service demandé
        if ($codeService == "all") {
            // Tous les services
            $this->data['leService'] = null;
            $this->data['lesEmployes'] = $this->modeleEmploye->GetListe();
        } else {
            // Un service spécifique
            $this->data['leService'] = $this->modeleService->GetService($codeService);
            $this->data['lesEmployes'] = $this->modeleEmploye->GetListeService($codeService);
        }
        
        // 3. Charge la vue qui va afficher les données
        require_once "vues/v_listeEmployes.php";
    }
}
?>
```

### Explication Détaillée

#### 1. Les `require_once`
```php
require_once "C_menu.php";
```
- Charge le fichier `C_menu.php` pour pouvoir l'utiliser
- `require_once` signifie "charge une seule fois" (évite les doublons)

#### 2. La Classe
```php
class C_consulterEmployes
```
- Une classe est comme un **modèle** ou un **plan** pour créer des objets
- On peut créer plusieurs objets à partir d'une classe

#### 3. Les Propriétés (`private $data`, etc.)
```php
private $data;
```
- `private` : Signifie que cette variable n'est accessible QUE dans cette classe
- `$data` : Un tableau qui contiendra toutes les données à envoyer à la vue
- C'est comme une **boîte** où on met les informations

#### 4. Le Constructeur (`__construct`)
```php
public function __construct()
{
    $this->data = array();
    $this->modeleEmploye = new M_employe();
}
```
- S'exécute **automatiquement** quand on crée un objet
- `$this->` : Signifie "cette instance de la classe"
- `new M_employe()` : Crée un nouvel objet de type `M_employe`

#### 5. La Méthode `action_listeEmployes`
```php
public function action_listeEmployes($codeService)
```
- `public` : Accessible de l'extérieur de la classe
- `$codeService` : Paramètre reçu (ex: "all" ou "s01")
- Cette méthode :
  1. Remplit `$this->data` avec les données nécessaires
  2. Charge la vue `v_listeEmployes.php` qui affichera ces données

### Flux d'Exécution

```
1. index.php crée : $controleur = new C_consulterEmployes()
   ↓
2. Le constructeur s'exécute et initialise tout
   ↓
3. index.php appelle : $controleur->action_listeEmployes("all")
   ↓
4. action_listeEmployes() :
   - Demande les données au Modèle
   - Met les données dans $this->data
   - Charge la Vue
```

---

## 💾 Les Modèles (M_*.php)

### Qu'est-ce qu'un Modèle ?

Un modèle est comme un **traducteur** entre votre code PHP et la base de données. Il :
- Se connecte à la base de données
- Exécute des requêtes SQL
- Retourne les résultats sous forme d'objets PHP

### Exemple : M_employe.php

```php
<?php
require_once "metiers/Employe.php";
require_once "M_generique.php";

class M_employe extends M_generique 
{
    // Méthode pour obtenir la liste de tous les employés
    public function GetListe($actifSeulement = true)
    {
        $resultat = array();           // Tableau vide pour stocker les résultats
        $pdo = $this->GetPdo();       // Obtient la connexion à la base de données
        
        // Construit la requête SQL selon si on veut seulement les actifs
        if ($actifSeulement) {
            $req = "SELECT * FROM employe WHERE emp_actif = 1 ORDER BY emp_nom, emp_prenom";
        } else {
            $req = "SELECT * FROM employe ORDER BY emp_nom, emp_prenom";
        }
        
        // Prépare et exécute la requête
        $stmt = $pdo->prepare($req);
        $stmt->execute();
        
        // Parcourt les résultats ligne par ligne
        while ($ligne = $stmt->fetch()) {
            // Crée un objet Employe avec les données de la ligne
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
            // Ajoute l'employé au tableau de résultats
            $resultat[] = $employe;
        }
        
        return $resultat;  // Retourne le tableau d'employés
    }
}
?>
```

### Explication Détaillée

#### 1. `extends M_generique`
```php
class M_employe extends M_generique
```
- `extends` signifie "hérite de"
- `M_employe` hérite de toutes les fonctionnalités de `M_generique`
- `M_generique` contient la méthode `GetPdo()` pour se connecter à la base de données

#### 2. `$pdo = $this->GetPdo()`
```php
$pdo = $this->GetPdo();
```
- `GetPdo()` est définie dans `M_generique`
- Retourne un objet PDO (PHP Data Objects) qui permet de communiquer avec la base de données
- C'est comme un **téléphone** pour parler à MySQL

#### 3. La Requête SQL
```php
$req = "SELECT * FROM employe WHERE emp_actif = 1 ORDER BY emp_nom, emp_prenom";
```
- `SELECT *` : Sélectionne toutes les colonnes
- `FROM employe` : Depuis la table `employe`
- `WHERE emp_actif = 1` : Seulement les employés actifs
- `ORDER BY emp_nom, emp_prenom` : Trie par nom puis prénom

#### 4. `prepare()` et `execute()`
```php
$stmt = $pdo->prepare($req);
$stmt->execute();
```
- `prepare()` : Prépare la requête (plus sécurisé)
- `execute()` : Exécute la requête sur la base de données

#### 5. La Boucle `while`
```php
while ($ligne = $stmt->fetch()) {
    // Crée un objet Employe
}
```
- `$stmt->fetch()` : Récupère une ligne de résultats
- Tant qu'il y a des lignes, on continue
- Pour chaque ligne, on crée un objet `Employe`

#### 6. Création d'un Objet Employe
```php
$employe = new Employe(
    $ligne["emp_matricule"],
    $ligne["emp_nom"],
    // ...
);
```
- `new Employe(...)` : Crée un nouvel objet de type `Employe`
- Les paramètres sont les valeurs de la ligne de la base de données

### M_generique.php - La Classe de Base

```php
<?php
class M_generique
{
    private $pdo;  // Variable pour stocker la connexion

    // Méthode pour obtenir la connexion à la base de données
    public function GetPdo()
    {
        if ($this->pdo === null) {
            // Si pas encore connecté, on se connecte
            $dsn = "mysql:host=127.0.0.1;dbname=empsceMvc;charset=utf8mb4";
            $this->pdo = new PDO($dsn, "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $this->pdo;
    }
}
?>
```

**Explication** :
- `$dsn` : "Data Source Name" - l'adresse de la base de données
- `new PDO(...)` : Crée une connexion PDO
- `setAttribute(...)` : Configure PDO pour lancer des exceptions en cas d'erreur

---

## 🎨 Les Vues (v_*.php)

### Qu'est-ce qu'une Vue ?

Une vue est un fichier qui contient du **HTML** et un peu de **PHP** pour afficher les données. C'est ce que l'utilisateur voit dans son navigateur.

### Exemple : v_listeEmployes.php

```php
<?php include_once 'v_entete.php'; ?>

<div class="container mt-4">
    <h2>Liste des employés</h2>
    
    <table class="table">
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->data['lesEmployes'] as $unEmploye): ?>
                <tr>
                    <td><?php echo htmlspecialchars($unEmploye->GetMatricule()); ?></td>
                    <td><?php echo htmlspecialchars($unEmploye->GetNom()); ?></td>
                    <td><?php echo htmlspecialchars($unEmploye->GetPrenom()); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include_once 'v_piedPage.php'; ?>
```

### Explication Détaillée

#### 1. `include_once 'v_entete.php'`
```php
<?php include_once 'v_entete.php'; ?>
```
- Inclut le fichier `v_entete.php` qui contient le header HTML (navigation, CSS, etc.)
- C'est comme copier-coller le contenu de `v_entete.php` ici

#### 2. `$this->data['lesEmployes']`
```php
$this->data['lesEmployes']
```
- `$this` : Référence à l'objet contrôleur qui a chargé cette vue
- `$this->data` : Le tableau de données rempli par le contrôleur
- `['lesEmployes']` : Accède à la clé 'lesEmployes' du tableau

#### 3. La Boucle `foreach`
```php
<?php foreach ($this->data['lesEmployes'] as $unEmploye): ?>
    <!-- HTML pour chaque employé -->
<?php endforeach; ?>
```
- `foreach` : Parcourt chaque élément du tableau
- `as $unEmploye` : Pour chaque élément, on l'appelle `$unEmploye`
- Répète le code HTML pour chaque employé

#### 4. `htmlspecialchars()`
```php
echo htmlspecialchars($unEmploye->GetNom());
```
- **Sécurité** : Convertit les caractères spéciaux en entités HTML
- Empêche les attaques XSS (injection de code malveillant)
- Exemple : `<script>` devient `&lt;script&gt;`

#### 5. `include_once 'v_piedPage.php'`
```php
<?php include_once 'v_piedPage.php'; ?>
```
- Inclut le footer (pied de page) avec les scripts JavaScript

### v_entete.php - L'En-tête Commun

```php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Gestion du personnel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <!-- Menu de navigation -->
    </nav>
    <div class="container mt-4">
```

**Rôle** : Contient tout le HTML commun à toutes les pages (header, navigation, CSS, etc.)

---

## 🏢 Les Classes Métier

### Qu'est-ce qu'une Classe Métier ?

Une classe métier représente un **objet du monde réel** (un Employé, un Service). Elle contient les données et les méthodes pour manipuler ces données.

### Exemple : Employe.php

```php
<?php 
class Employe
{
    // Propriétés (caractéristiques d'un employé)
    private $emp_matricule;
    private $emp_nom;
    private $emp_prenom;
    private $emp_service;
    private $emp_email;
    // ... autres propriétés
    
    // Constructeur : crée un employé avec des valeurs
    public function __construct($matricule, $nom, $prenom, $service, $email = null, ...)
    {
        $this->emp_matricule = $matricule;
        $this->emp_nom = $nom;
        $this->emp_prenom = $prenom;
        $this->emp_service = $service;
        $this->emp_email = $email;
    }
    
    // Méthodes "getter" : récupèrent les valeurs
    public function GetMatricule()
    {
        return $this->emp_matricule;
    }
    
    public function GetNom()
    {
        return $this->emp_nom;
    }
    
    // ... autres getters
}
?>
```

### Explication

#### 1. Les Propriétés
```php
private $emp_matricule;
```
- Chaque propriété stocke une information sur l'employé
- `private` : Accessible uniquement dans la classe

#### 2. Le Constructeur
```php
public function __construct($matricule, $nom, $prenom, ...)
{
    $this->emp_matricule = $matricule;
}
```
- S'exécute quand on crée un objet : `new Employe("e001", "Dupont", "Jean", ...)`
- Assigne les valeurs reçues aux propriétés

#### 3. Les Getters
```php
public function GetNom()
{
    return $this->emp_nom;
}
```
- Permet de récupérer la valeur d'une propriété privée
- On ne peut pas faire `$employe->emp_nom` (car privé)
- Mais on peut faire `$employe->GetNom()`

### Pourquoi Utiliser des Classes ?

**Avantages** :
- **Encapsulation** : Les données sont protégées
- **Réutilisabilité** : On peut créer plusieurs employés facilement
- **Organisation** : Le code est mieux structuré

**Exemple d'utilisation** :
```php
// Créer un employé
$employe = new Employe("e001", "Dupont", "Jean", "s01", "jean@example.com");

// Récupérer son nom
echo $employe->GetNom();  // Affiche "Dupont"
```

---

## 🔄 Flux d'Exécution Complet

### Scénario : Afficher la Liste des Employés

#### Étape 1 : L'Utilisateur Clique
```
Utilisateur clique sur "Liste des employés"
↓
URL : index.php?page=listeEmployes
```

#### Étape 2 : index.php Reçoit la Demande
```php
// index.php
$page = $_GET['page'];  // $page = "listeEmployes"

switch ($page) {
    case "listeEmployes":
        require_once "controleurs/C_consulterEmployes.php";
        $controleur = new C_consulterEmployes();
        $controleur->action_listeEmployes("all");
    break;
}
```

#### Étape 3 : Le Contrôleur S'Exécute
```php
// C_consulterEmployes.php
public function action_listeEmployes($codeService)
{
    // 1. Remplit le menu
    $this->controleurMenu->FillData($this->data);
    
    // 2. Demande les données au Modèle
    $this->data['lesEmployes'] = $this->modeleEmploye->GetListe();
    
    // 3. Charge la Vue
    require_once "vues/v_listeEmployes.php";
}
```

#### Étape 4 : Le Modèle Interroge la Base de Données
```php
// M_employe.php
public function GetListe()
{
    $pdo = $this->GetPdo();
    $req = "SELECT * FROM employe WHERE emp_actif = 1";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    
    $resultat = array();
    while ($ligne = $stmt->fetch()) {
        $employe = new Employe(...);
        $resultat[] = $employe;
    }
    
    return $resultat;  // Retourne au Contrôleur
}
```

#### Étape 5 : Le Contrôleur Reçoit les Données
```php
// Les données sont maintenant dans $this->data['lesEmployes']
// C'est un tableau d'objets Employe
```

#### Étape 6 : La Vue Affiche
```php
// v_listeEmployes.php
<?php foreach ($this->data['lesEmployes'] as $unEmploye): ?>
    <tr>
        <td><?php echo $unEmploye->GetMatricule(); ?></td>
        <td><?php echo $unEmploye->GetNom(); ?></td>
    </tr>
<?php endforeach; ?>
```

#### Étape 7 : Le Navigateur Affiche le HTML
```
L'utilisateur voit un tableau avec tous les employés
```

### Schéma Visuel

```
┌─────────────┐
│  Utilisateur│
│  (Navigateur)│
└──────┬───────┘
       │ 1. Clique sur "Liste"
       ↓
┌─────────────┐
│  index.php  │ 2. Route vers le bon contrôleur
└──────┬───────┘
       │
       ↓
┌──────────────────────┐
│ C_consulterEmployes  │ 3. Demande les données
└──────┬───────────────┘
       │
       ↓
┌─────────────┐
│ M_employe   │ 4. Interroge la base de données
└──────┬───────┘
       │
       ↓
┌─────────────┐
│ Base de     │ 5. Retourne les résultats
│ Données     │
└──────┬───────┘
       │
       ↓
┌─────────────┐
│ M_employe   │ 6. Crée des objets Employe
└──────┬───────┘
       │
       ↓
┌──────────────────────┐
│ C_consulterEmployes  │ 7. Met les données dans $data
└──────┬───────────────┘
       │
       ↓
┌──────────────────────┐
│ v_listeEmployes.php  │ 8. Génère le HTML
└──────┬───────────────┘
       │
       ↓
┌─────────────┐
│  Utilisateur│ 9. Voit le tableau
│  (Navigateur)│
└─────────────┘
```

---

## 💡 Exemples Concrets

### Exemple 1 : Ajouter un Employé

#### 1. L'utilisateur remplit le formulaire
```html
<!-- v_saisieEmploye.php -->
<form action="index.php?page=ajoutEmploye" method="post">
    <input type="text" name="matricule" value="e012">
    <input type="text" name="nom" value="Martin">
    <input type="text" name="prenom" value="Sophie">
    <button type="submit">Enregistrer</button>
</form>
```

#### 2. index.php route vers le contrôleur
```php
// index.php
case "ajoutEmploye":
    require_once "controleurs/C_ajouterEmployes.php";
    $controleur = new C_ajouterEmployes();
    $controleur->action_ajout(
        $_POST["matricule"],  // "e012"
        $_POST["nom"],        // "Martin"
        $_POST["prenom"],    // "Sophie"
        $_POST["service"]    // "s01"
    );
break;
```

#### 3. Le contrôleur valide et appelle le modèle
```php
// C_ajouterEmployes.php
public function action_ajout($matricule, $nom, $prenom, $service, ...)
{
    // Validation
    if (empty($nom) || empty($prenom)) {
        $this->data['leMessage'] = "Erreur : champs obligatoires";
        require_once "vues/v_message.php";
        return;
    }
    
    // Appelle le modèle pour ajouter
    $employe = $this->modeleEmploye->Ajouter($matricule, $nom, $prenom, $service, ...);
    
    if ($employe) {
        $this->data['leMessage'] = "Employé ajouté avec succès";
    }
    
    require_once "vues/v_message.php";
}
```

#### 4. Le modèle insère dans la base de données
```php
// M_employe.php
public function Ajouter($matricule, $nom, $prenom, $service, ...)
{
    $pdo = $this->GetPdo();
    
    $req = "INSERT INTO employe (emp_matricule, emp_nom, emp_prenom, emp_service) 
            VALUES (:matricule, :nom, :prenom, :service)";
    
    $stmt = $pdo->prepare($req);
    $ok = $stmt->execute([
        ':matricule' => $matricule,
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':service' => $service
    ]);
    
    if ($ok) {
        return new Employe($matricule, $nom, $prenom, $service, ...);
    }
    
    return null;
}
```

### Exemple 2 : Rechercher un Employé

#### 1. L'utilisateur tape dans le champ de recherche
```
URL : index.php?page=rechercherEmployes&q=Dupont
```

#### 2. Le contrôleur reçoit le critère
```php
// index.php
case "rechercherEmployes":
    $critere = $_GET['q'];  // "Dupont"
    $controleur = new C_rechercherEmployes();
    $controleur->action_rechercher($critere);
break;
```

#### 3. Le modèle recherche dans la base
```php
// M_employe.php
public function Rechercher($critere)
{
    $req = "SELECT * FROM employe 
            WHERE emp_nom LIKE :critere 
            OR emp_prenom LIKE :critere";
    
    $stmt = $pdo->prepare($req);
    $critere = '%' . $critere . '%';  // "%Dupont%"
    $stmt->execute([':critere' => $critere]);
    
    // ... retourne les résultats
}
```

---

## 📚 Glossaire

### Termes Techniques

**Classe** : Un modèle ou plan pour créer des objets. Exemple : `class Employe` est un plan pour créer des employés.

**Objet** : Une instance d'une classe. Exemple : `$employe = new Employe(...)` crée un objet employé.

**Méthode** : Une fonction à l'intérieur d'une classe. Exemple : `GetNom()` est une méthode de la classe `Employe`.

**Propriété** : Une variable à l'intérieur d'une classe. Exemple : `private $emp_nom` est une propriété.

**Constructeur** : Une méthode spéciale qui s'exécute automatiquement quand on crée un objet.

**Requête SQL** : Une commande pour interagir avec la base de données. Exemple : `SELECT * FROM employe`.

**PDO** : PHP Data Objects - Une interface pour communiquer avec la base de données de manière sécurisée.

**Session** : Un mécanisme pour garder des informations sur l'utilisateur pendant sa visite.

**$_GET** : Un tableau PHP qui contient les paramètres de l'URL. Exemple : `?page=login` → `$_GET['page'] = "login"`.

**$_POST** : Un tableau PHP qui contient les données envoyées par un formulaire.

**require_once** : Charge un fichier PHP une seule fois.

**htmlspecialchars()** : Fonction de sécurité qui empêche les attaques XSS.

**extends** : Permet à une classe d'hériter des fonctionnalités d'une autre classe.

**private/public** : Visibilité des propriétés et méthodes.
- `private` : Accessible uniquement dans la classe
- `public` : Accessible de partout

---

## 🎓 Conseils pour Comprendre le Code

### 1. Lisez de Haut en Bas
Commencez par `index.php`, puis suivez le flux d'exécution.

### 2. Utilisez un Débogueur
Ajoutez `var_dump()` ou `print_r()` pour voir ce que contiennent les variables :
```php
var_dump($this->data);  // Affiche le contenu de $data
```

### 3. Commentez le Code
Ajoutez vos propres commentaires pour mieux comprendre :
```php
// Cette ligne récupère tous les employés
$employes = $this->modeleEmploye->GetListe();
```

### 4. Testez Petite Partie par Petite Partie
Ne cherchez pas à tout comprendre d'un coup. Testez une fonctionnalité à la fois.

### 5. Utilisez la Documentation PHP
Si vous ne comprenez pas une fonction, cherchez-la sur [php.net](https://www.php.net)

---

## 🔍 Points Clés à Retenir

1. **MVC** : Modèle (données), Vue (affichage), Contrôleur (coordination)

2. **Flux** : Utilisateur → index.php → Contrôleur → Modèle → Base de données → Vue → Utilisateur

3. **Sécurité** : Toujours utiliser `htmlspecialchars()` et des requêtes préparées

4. **Organisation** : Chaque fichier a un rôle précis

5. **Réutilisabilité** : Les classes permettent de créer plusieurs objets facilement

---

## 📞 Questions Fréquentes

**Q : Pourquoi séparer en Modèle, Vue et Contrôleur ?**
R : Pour organiser le code, le rendre plus facile à maintenir et à modifier.

**Q : Que fait `$this->` ?**
R : Référence l'objet actuel. `$this->data` signifie "la propriété data de cet objet".

**Q : Pourquoi utiliser `private` ?**
R : Pour protéger les données et forcer l'utilisation de méthodes (getters/setters).

**Q : Comment savoir quelle méthode appeler ?**
R : Regardez dans le contrôleur. Il appelle les méthodes du modèle et charge les vues.

**Q : Que fait `require_once` ?**
R : Charge un fichier PHP. `_once` signifie qu'il ne le charge qu'une seule fois.

---

## 🎯 Conclusion

Cette documentation explique les concepts de base du système. Pour aller plus loin :

1. **Lisez le code** : Ouvrez les fichiers et lisez-les ligne par ligne
2. **Modifiez le code** : Essayez de changer des choses et voyez ce qui se passe
3. **Ajoutez des fonctionnalités** : Créez de nouvelles pages en suivant le même modèle
4. **Pratiquez** : Plus vous codez, plus vous comprendrez


