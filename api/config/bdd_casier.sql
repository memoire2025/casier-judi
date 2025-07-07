-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 07, 2025 at 12:32 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdd_casier`
--

-- --------------------------------------------------------

--
-- Table structure for table `agent`
--

DROP TABLE IF EXISTS `agent`;
CREATE TABLE IF NOT EXISTS `agent` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `poste` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `temps` bigint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `agent`
--

INSERT INTO `agent` (`id`, `nom`, `prenom`, `poste`, `login`, `mdp`, `code`, `temps`) VALUES
(1, 'Phanzu', 'Joseph', 'admin', 'josephphanzu@gmail.com', '$2y$10$Yk6c02GcsozNby9gzm4HCeDxsOszM6Gp5yNlpgeY9yP5.4pQ4l4qO', 'b045a2a813402acee05a320a36640b78', 1742782250),
(2, 'Mukoko', 'Plamedi', 'greffier', 'plamedimukoko@gmail.com', '$2y$10$7XAfUS8mEIaswDj6ztKubuUNRLN8DIjcpqC8.uP1nuCvdKSRtBu3m', 'e1b81caa4a7a892c12181d978666f0c7', 1749639175),
(3, 'Tati', 'Pascal', 'magistrat', 'pascaltati@gmail.com', '$2y$10$Vy2H.ML9BvlUUF0LMY.Nlen/PZgYXr2JuTdY8oqueLDKAXUQj9dyG', '6280153d55fe4fd0af0771b9160dd9ee', 1749639558);

-- --------------------------------------------------------

--
-- Table structure for table `casierjudiciaire`
--

DROP TABLE IF EXISTS `casierjudiciaire`;
CREATE TABLE IF NOT EXISTS `casierjudiciaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code_personne` varchar(255) NOT NULL,
  `statut` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `temps` bigint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `casierjudiciaire`
--

INSERT INTO `casierjudiciaire` (`id`, `code_personne`, `statut`, `code`, `temps`) VALUES
(1, 'cbd71c5614bb5d6d077ec29dd4aa1658', 'chargé', '450dc5283f6480366401ce9a003778c9', 1748819693),
(2, '2af9ac7e84a18745a82f70b3164870b1', 'chargé', 'a07463621dd3b3d01c9e1ecf31798b75', 1749651662);

-- --------------------------------------------------------

--
-- Table structure for table `infraction`
--

DROP TABLE IF EXISTS `infraction`;
CREATE TABLE IF NOT EXISTS `infraction` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code_casier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `type_infraction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_infraction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lieu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `peine` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dure_pein` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `temps` bigint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `infraction`
--

INSERT INTO `infraction` (`id`, `code_casier`, `type_infraction`, `description`, `date_infraction`, `lieu`, `peine`, `dure_pein`, `code`, `temps`) VALUES
(1, '450dc5283f6480366401ce9a003778c9', 'delit', 'Une description en large', '2025-05-26', 'Ville Muanda', 'peine privatives de liberté', '2 ans', '6284e87746f27344e25db0e41e2f5a6e', 1748819819),
(2, '450dc5283f6480366401ce9a003778c9', 'Harcelement', 'Harcelement contre l\'employé', '2025-05-18', 'Boma', 'retrait de droit', '5 ans', 'e26bdbff46de00c657826af5494f6149', 1748819875),
(3, '450dc5283f6480366401ce9a003778c9', 'infraction contre l\'ordre public', 'Trop agréssive contre les agent de la police lors d\'une échange', '2025-05-05', 'Ville Matadi', 'peine pécuniaire', '-', 'd962c1e629c128a91fe1d3dc800fcf9c', 1748823177),
(4, 'a07463621dd3b3d01c9e1ecf31798b75', 'delit', 'Une déscription', '2025-06-13', 'Matadi', 'confiscation', '3 mois', '5ae7389e5afb7e8d7bcce3b2ed716d86', 1749679810);

-- --------------------------------------------------------

--
-- Table structure for table `personne`
--

DROP TABLE IF EXISTS `personne`;
CREATE TABLE IF NOT EXISTS `personne` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `postnom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `date_naissance` varchar(255) NOT NULL,
  `lieu` varchar(255) NOT NULL,
  `sexe` varchar(10) NOT NULL,
  `nationalite` varchar(255) NOT NULL,
  `num_identite` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `temps` bigint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `personne`
--

INSERT INTO `personne` (`id`, `nom`, `postnom`, `prenom`, `date_naissance`, `lieu`, `sexe`, `nationalite`, `num_identite`, `img`, `code`, `temps`) VALUES
(1, 'PHUATI', 'PHONA', 'NADEGE', '2025-05-28', 'Muanda', 'F', 'Congolaise', 'N25455555', 'http://casier-judiciaire.com/ressources/img/personne/GST_1748819693.jpg', 'cbd71c5614bb5d6d077ec29dd4aa1658', 1748819693),
(2, 'Tsasa', 'Tsasa', 'Joas', '2025-06-14', 'Moanda', 'M', 'Congolaise', 'N369P741', 'http://casier-judiciaire.com/ressources/img/personne/GST_1749651662.jpeg', '2af9ac7e84a18745a82f70b3164870b1', 1749651662);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
