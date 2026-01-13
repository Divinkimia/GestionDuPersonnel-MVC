-- Script de migration SIMPLE pour ajouter les colonnes manquantes
-- À exécuter dans phpMyAdmin sur votre base de données (empsce ou empsceMvc)

-- Ajout des colonnes à la table service
ALTER TABLE `service` 
ADD COLUMN `sce_actif` TINYINT(1) DEFAULT 1 AFTER `sce_designation`;

-- Mise à jour des services existants
UPDATE `service` SET `sce_actif` = 1;

-- Ajout des colonnes à la table employe
ALTER TABLE `employe`
ADD COLUMN `emp_email` VARCHAR(100) NULL DEFAULT NULL AFTER `emp_service`,
ADD COLUMN `emp_telephone` VARCHAR(20) NULL DEFAULT NULL AFTER `emp_email`,
ADD COLUMN `emp_poste` VARCHAR(100) NULL DEFAULT NULL AFTER `emp_telephone`,
ADD COLUMN `emp_date_embauche` DATE NULL DEFAULT NULL AFTER `emp_poste`,
ADD COLUMN `emp_salaire` DECIMAL(10,2) NULL DEFAULT NULL AFTER `emp_date_embauche`,
ADD COLUMN `emp_actif` TINYINT(1) DEFAULT 1 AFTER `emp_salaire`;

-- Mise à jour des employés existants
UPDATE `employe` SET `emp_actif` = 1;
