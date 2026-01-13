# Système de Gestion du Personnel - Version Améliorée

## 📋 Description

Système de gestion du personnel professionnel développé en PHP avec architecture MVC (Modèle-Vue-Contrôleur).

## ✨ Améliorations apportées

### 1. Base de données améliorée
- Ajout de champs professionnels : email, téléphone, poste, date d'embauche, salaire
- Gestion des dates de création et modification
- Soft delete (désactivation au lieu de suppression)
- Structure de base de données optimisée

### 2. Sécurité renforcée
- **Requêtes préparées** : Protection contre les injections SQL
- **Validation des données** : Validation côté serveur renforcée
- **Gestion des erreurs** : Meilleure gestion des exceptions
- **Échappement HTML** : Protection XSS avec `htmlspecialchars()`

### 3. Interface utilisateur moderne
- **Design responsive** : Compatible mobile, tablette et desktop
- **Bootstrap 5** : Framework CSS moderne
- **Bootstrap Icons** : Icônes professionnelles
- **Cartes et tableaux** : Interface claire et intuitive
- **Navigation améliorée** : Menu avec icônes et meilleure organisation

### 4. Nouvelles fonctionnalités

#### Dashboard
- Statistiques en temps réel
- Répartition des employés par service
- Indicateurs clés (total employés, moyenne par service)
- Actions rapides

#### Gestion complète des employés
- **Ajout** : Formulaire complet avec tous les champs
- **Modification** : Édition de tous les champs d'un employé
- **Suppression** : Soft delete (désactivation)
- **Recherche** : Recherche avancée par nom, prénom, matricule, email, poste
- **Filtrage** : Filtrage par service

#### Liste des employés améliorée
- Affichage de tous les champs
- Actions rapides (modifier, supprimer)
- Filtres par service
- Design de tableau professionnel

## 🚀 Installation

### Prérequis
- PHP 7.4 ou supérieur
- MySQL/MariaDB
- Serveur web (Apache/Nginx) ou XAMPP

### Étapes d'installation

1. **Importer la base de données**
   ```sql
   -- Exécuter le fichier empsce_ameliore.sql dans phpMyAdmin
   -- ou via la ligne de commande :
   mysql -u root -p empsceMvc < empsce_ameliore.sql
   ```

2. **Configurer la connexion**
   - Vérifier les paramètres de connexion dans `modeles/M_generique.php`
   - Modifier si nécessaire : host, username, password, database

3. **Accéder à l'application**
   - Ouvrir dans le navigateur : `http://localhost/S2-MVC-Terminer/S2-MVC/`
   - Créer un compte utilisateur via "S'inscrire"
   - Se connecter avec vos identifiants

## 📁 Structure du projet

```
S2-MVC/
├── controleurs/          # Contrôleurs MVC
│   ├── C_accueil.php
│   ├── C_ajouterEmployes.php
│   ├── C_authentificate.php
│   ├── C_consulterEmployes.php
│   ├── C_dashboard.php          # NOUVEAU
│   ├── C_menu.php
│   ├── C_modifierEmploye.php    # NOUVEAU
│   ├── C_rechercherEmployes.php # NOUVEAU
│   └── C_supprimerEmploye.php   # NOUVEAU
├── metiers/             # Classes métier
│   ├── Employe.php
│   ├── Service.php
│   └── login.php
├── modeles/             # Modèles de données
│   ├── M_authentificate.php
│   ├── M_employe.php
│   ├── M_generique.php
│   └── M_service.php
├── vues/                # Vues (templates)
│   ├── v_accueil.php
│   ├── v_dashboard.php          # NOUVEAU
│   ├── v_enregistrer.php
│   ├── v_entete.php
│   ├── v_listeEmployes.php
│   ├── v_login.php
│   ├── v_message.php
│   ├── v_modifierEmploye.php    # NOUVEAU
│   ├── v_piedPage.php
│   ├── v_rechercherEmployes.php # NOUVEAU
│   └── v_saisieEmploye.php
├── images/              # Images
├── empsce_ameliore.sql  # Script SQL amélioré
├── index.php            # Point d'entrée
└── README.md            # Ce fichier
```

## 🎯 Fonctionnalités principales

### Authentification
- Inscription de nouveaux utilisateurs
- Connexion sécurisée
- Déconnexion
- Gestion de session

### Gestion des employés
- **Ajout** : `index.php?page=saisieEmploye`
- **Liste** : `index.php?page=listeEmployes&service=all`
- **Modification** : `index.php?page=modifierEmploye&matricule=XXX`
- **Suppression** : `index.php?page=supprimerEmploye&matricule=XXX`
- **Recherche** : `index.php?page=rechercherEmployes&q=terme`

### Dashboard
- **Accès** : `index.php?page=dashboard`
- Statistiques globales
- Répartition par service
- Actions rapides

## 🔧 Configuration

### Base de données
Modifier les paramètres dans `modeles/M_generique.php` :

```php
$dsn = "mysql:host=127.0.0.1;dbname=empsceMvc;charset=utf8mb4";
$this->pdo = new PDO($dsn, "root", "");
```

### Nom de la base de données
Par défaut : `empsceMvc`
- Vérifier dans `M_generique.php` et `M_authentificate.php`
- Adapter selon votre configuration

## 📝 Notes importantes

1. **Compatibilité** : Le code utilise à la fois MySQLi (ancien) et PDO (nouveau) pour la compatibilité
2. **Sécurité** : Toutes les requêtes utilisent maintenant des requêtes préparées
3. **Soft Delete** : Les employés sont désactivés (emp_actif = 0) plutôt que supprimés
4. **Validation** : Validation côté serveur pour tous les formulaires

## 🐛 Dépannage

### Erreur de connexion à la base de données
- Vérifier que MySQL/MariaDB est démarré
- Vérifier les identifiants dans `M_generique.php`
- Vérifier que la base `empsceMvc` existe

### Erreur "Table doesn't exist"
- Exécuter le script SQL `empsce_ameliore.sql`
- Vérifier le nom de la base de données

### Problèmes d'affichage
- Vérifier que Bootstrap est chargé (connexion internet requise)
- Vider le cache du navigateur

## 👨‍💻 Développement

### Architecture MVC
- **Modèles** : Accès aux données (M_employe, M_service, etc.)
- **Vues** : Interface utilisateur (v_*.php)
- **Contrôleurs** : Logique métier (C_*.php)

### Bonnes pratiques appliquées
- Séparation des responsabilités
- Requêtes préparées
- Validation des données
- Échappement HTML
- Gestion d'erreurs

## 📄 Licence

Projet éducatif - Tous droits réservés

## 🔄 Version

**Version 2.0** - Version améliorée et professionnelle

---

**Développé avec ❤️ en respectant l'architecture MVC**
