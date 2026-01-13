-- Script de migration pour ajouter les nouvelles colonnes à la base de données existante
-- À exécuter si vous utilisez l'ancienne base de données

-- Ajout des colonnes à la table service
ALTER TABLE `service` 
ADD COLUMN IF NOT EXISTS `sce_description` TEXT NULL DEFAULT NULL AFTER `sce_designation`,
ADD COLUMN IF NOT EXISTS `sce_actif` TINYINT(1) DEFAULT 1 AFTER `sce_description`,
ADD COLUMN IF NOT EXISTS `sce_date_creation` DATETIME DEFAULT CURRENT_TIMESTAMP AFTER `sce_actif`;

-- Mise à jour des services existants pour qu'ils soient actifs
UPDATE `service` SET `sce_actif` = 1 WHERE `sce_actif` IS NULL;

-- Ajout des colonnes à la table employe
ALTER TABLE `employe`
ADD COLUMN IF NOT EXISTS `emp_email` VARCHAR(100) NULL DEFAULT NULL AFTER `emp_service`,
ADD COLUMN IF NOT EXISTS `emp_telephone` VARCHAR(20) NULL DEFAULT NULL AFTER `emp_email`,
ADD COLUMN IF NOT EXISTS `emp_poste` VARCHAR(100) NULL DEFAULT NULL AFTER `emp_telephone`,
ADD COLUMN IF NOT EXISTS `emp_date_embauche` DATE NULL DEFAULT NULL AFTER `emp_poste`,
ADD COLUMN IF NOT EXISTS `emp_salaire` DECIMAL(10,2) NULL DEFAULT NULL AFTER `emp_date_embauche`,
ADD COLUMN IF NOT EXISTS `emp_actif` TINYINT(1) DEFAULT 1 AFTER `emp_salaire`,
ADD COLUMN IF NOT EXISTS `emp_date_creation` DATETIME DEFAULT CURRENT_TIMESTAMP AFTER `emp_actif`,
ADD COLUMN IF NOT EXISTS `emp_date_modification` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP AFTER `emp_date_creation`;

-- Mise à jour des employés existants pour qu'ils soient actifs
UPDATE `employe` SET `emp_actif` = 1 WHERE `emp_actif` IS NULL;

-- Note: Si votre version de MySQL/MariaDB ne supporte pas IF NOT EXISTS dans ALTER TABLE,
-- utilisez la version alternative ci-dessous (décommentez et commentez la version ci-dessus)
