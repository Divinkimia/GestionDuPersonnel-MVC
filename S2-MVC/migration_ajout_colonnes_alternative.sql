-- Script de migration alternative (pour MySQL/MariaDB qui ne supporte pas IF NOT EXISTS dans ALTER TABLE)
-- Version à utiliser si la version principale ne fonctionne pas

-- Vérifier d'abord si les colonnes existent avant de les ajouter
-- Pour la table service

-- Ajout des colonnes à la table service (ignorer les erreurs si elles existent déjà)
ALTER TABLE `service` 
ADD COLUMN `sce_description` TEXT NULL DEFAULT NULL AFTER `sce_designation`;

ALTER TABLE `service` 
ADD COLUMN `sce_actif` TINYINT(1) DEFAULT 1 AFTER `sce_description`;

ALTER TABLE `service` 
ADD COLUMN `sce_date_creation` DATETIME DEFAULT CURRENT_TIMESTAMP AFTER `sce_actif`;

-- Mise à jour des services existants
UPDATE `service` SET `sce_actif` = 1 WHERE `sce_actif` IS NULL;

-- Ajout des colonnes à la table employe

ALTER TABLE `employe`
ADD COLUMN `emp_email` VARCHAR(100) NULL DEFAULT NULL AFTER `emp_service`;

ALTER TABLE `employe`
ADD COLUMN `emp_telephone` VARCHAR(20) NULL DEFAULT NULL AFTER `emp_email`;

ALTER TABLE `employe`
ADD COLUMN `emp_poste` VARCHAR(100) NULL DEFAULT NULL AFTER `emp_telephone`;

ALTER TABLE `employe`
ADD COLUMN `emp_date_embauche` DATE NULL DEFAULT NULL AFTER `emp_poste`;

ALTER TABLE `employe`
ADD COLUMN `emp_salaire` DECIMAL(10,2) NULL DEFAULT NULL AFTER `emp_date_embauche`;

ALTER TABLE `employe`
ADD COLUMN `emp_actif` TINYINT(1) DEFAULT 1 AFTER `emp_salaire`;

ALTER TABLE `employe`
ADD COLUMN `emp_date_creation` DATETIME DEFAULT CURRENT_TIMESTAMP AFTER `emp_actif`;

ALTER TABLE `employe`
ADD COLUMN `emp_date_modification` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP AFTER `emp_date_creation`;

-- Mise à jour des employés existants
UPDATE `employe` SET `emp_actif` = 1 WHERE `emp_actif` IS NULL;
