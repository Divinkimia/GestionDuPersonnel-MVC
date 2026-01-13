-- Base de données améliorée pour un système de gestion du personnel professionnel
-- Version améliorée avec champs supplémentaires

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Base de données : `empsce` ou `empsceMvc`

-- --------------------------------------------------------

-- Structure de la table `service`
CREATE TABLE IF NOT EXISTS `service` (
  `sce_code` char(3) NOT NULL,
  `sce_designation` varchar(50) DEFAULT NULL,
  `sce_description` text DEFAULT NULL,
  `sce_actif` tinyint(1) DEFAULT 1,
  `sce_date_creation` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Déchargement des données de la table `service`
INSERT INTO `service` (`sce_code`, `sce_designation`, `sce_description`, `sce_actif`) VALUES
('s01', 'Fabrication', 'Service de fabrication et production', 1),
('s02', 'Emballage', 'Service d\'emballage et conditionnement', 1),
('s03', 'Commercial', 'Service commercial et vente', 1),
('s04', 'Administration', 'Service administratif et gestion', 1);

-- --------------------------------------------------------

-- Structure de la table `employe` (améliorée)
CREATE TABLE IF NOT EXISTS `employe` (
  `emp_matricule` char(4) NOT NULL,
  `emp_nom` varchar(50) NOT NULL,
  `emp_prenom` varchar(50) NOT NULL,
  `emp_email` varchar(100) DEFAULT NULL,
  `emp_telephone` varchar(20) DEFAULT NULL,
  `emp_service` char(3) DEFAULT NULL,
  `emp_poste` varchar(100) DEFAULT NULL,
  `emp_date_embauche` date DEFAULT NULL,
  `emp_salaire` decimal(10,2) DEFAULT NULL,
  `emp_actif` tinyint(1) DEFAULT 1,
  `emp_date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `emp_date_modification` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Déchargement des données de la table `employe`
INSERT INTO `employe` (`emp_matricule`, `emp_nom`, `emp_prenom`, `emp_email`, `emp_telephone`, `emp_service`, `emp_poste`, `emp_date_embauche`, `emp_salaire`, `emp_actif`) VALUES
('e001', 'Dubois', 'Roland', 'roland.dubois@example.com', '01.23.45.67.89', 's01', 'Chef d\'atelier', '2020-01-15', 3500.00, 1),
('e002', 'Gernau', 'Patricia', 'patricia.gernau@example.com', '01.23.45.67.90', 's01', 'Ouvrier spécialisé', '2020-03-20', 2800.00, 1),
('e003', 'Louvel', 'Marc', 'marc.louvel@example.com', '01.23.45.67.91', 's01', 'Technicien', '2021-05-10', 3000.00, 1),
('e004', 'Maurel', 'Jeanne', 'jeanne.maurel@example.com', '01.23.45.67.92', 's01', 'Contrôleur qualité', '2021-07-12', 3200.00, 1),
('e005', 'Dubosc', 'Alain', 'alain.dubosc@example.com', '01.23.45.67.93', 's02', 'Responsable emballage', '2019-11-05', 3400.00, 1),
('e006', 'Parent', 'Stéphanie', 'stephanie.parent@example.com', '01.23.45.67.94', 's02', 'Opérateur emballage', '2020-02-18', 2600.00, 1),
('e007', 'Potier', 'Jean', 'jean.potier@example.com', '01.23.45.67.95', 's02', 'Magasinier', '2020-09-22', 2700.00, 1),
('e008', 'Fauvel', 'Anne', 'anne.fauvel@example.com', '01.23.45.67.96', 's03', 'Commerciale', '2019-08-14', 3800.00, 1),
('e009', 'Nouvion', 'Patrick', 'patrick.nouvion@example.com', '01.23.45.67.97', 's03', 'Responsable commercial', '2018-12-03', 4500.00, 1),
('e010', 'Arsane', 'Marie', 'marie.arsane@example.com', '01.23.45.67.98', 's04', 'Comptable', '2020-04-08', 3300.00, 1),
('e011', 'Durand', 'Sylvie', 'sylvie.durand@example.com', '01.23.45.67.99', 's04', 'Secrétaire', '2021-01-25', 2900.00, 1);

-- --------------------------------------------------------

-- Structure de la table `user` (pour l'authentification)
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_nom` varchar(50) NOT NULL,
  `user_prenom` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_login` varchar(50) NOT NULL,
  `user_mdp` varchar(255) NOT NULL,
  `user_role` enum('admin','user') DEFAULT 'user',
  `user_actif` tinyint(1) DEFAULT 1,
  `user_date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_derniere_connexion` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_login` (`user_login`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Index pour les tables
ALTER TABLE `employe`
  ADD PRIMARY KEY (`emp_matricule`),
  ADD KEY `emp_service` (`emp_service`),
  ADD KEY `emp_actif` (`emp_actif`);

ALTER TABLE `service`
  ADD PRIMARY KEY (`sce_code`),
  ADD KEY `sce_actif` (`sce_actif`);

-- Contraintes pour les tables
ALTER TABLE `employe`
  ADD CONSTRAINT `employe_ibfk_1` FOREIGN KEY (`emp_service`) REFERENCES `service` (`sce_code`) ON DELETE SET NULL ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
