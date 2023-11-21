-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 21, 2023 at 03:12 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestion_ventes`
--

-- --------------------------------------------------------

--
-- Table structure for table `gv_commandes`
--

DROP TABLE IF EXISTS `gv_commandes`;
CREATE TABLE IF NOT EXISTS `gv_commandes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_vente` date NOT NULL,
  `n_facture` varchar(20) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `mode_p` int DEFAULT NULL,
  `id_creator` int DEFAULT NULL,
  `dt_crt` datetime DEFAULT NULL,
  `id_updator` int DEFAULT NULL,
  `dt_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `gv_commandes`
--

INSERT INTO `gv_commandes` (`id`, `date_vente`, `n_facture`, `total`, `mode_p`, `id_creator`, `dt_crt`, `id_updator`, `dt_update`) VALUES
(7, '2023-11-20', '001/23', '125.70', 1, 72, '2023-11-20 19:16:34', NULL, NULL),
(8, '2023-11-20', '002/23', '22.20', 1, 72, '2023-11-20 19:20:28', NULL, NULL),
(9, '2023-11-20', '003/23', '115.35', 1, 72, '2023-11-20 19:23:29', NULL, NULL),
(10, '2023-11-20', '004/23', '103.50', 1, 72, '2023-11-20 19:25:13', NULL, NULL),
(11, '2023-11-20', '005/23', '22.20', 1, 72, '2023-11-20 19:27:54', NULL, NULL),
(12, '2023-11-20', '006/23', '22.20', 1, 72, '2023-11-20 19:29:14', NULL, NULL),
(13, '2023-11-21', '007/23', '207.00', 1, 72, '2023-11-20 23:20:43', NULL, NULL),
(14, '2023-11-21', '008/23', '22.20', 1, 72, '2023-11-20 23:21:05', NULL, NULL),
(15, '2023-11-21', '009/23', '22.20', 1, 72, '2023-11-20 23:21:17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gv_commande_article`
--

DROP TABLE IF EXISTS `gv_commande_article`;
CREATE TABLE IF NOT EXISTS `gv_commande_article` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pr` int DEFAULT NULL,
  `id_cmd` int DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `q` int NOT NULL DEFAULT '0',
  `rm` int DEFAULT NULL,
  `id_creator` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cmd` (`id_cmd`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `gv_commande_article`
--

INSERT INTO `gv_commande_article` (`id`, `id_pr`, `id_cmd`, `prix`, `q`, `rm`, `id_creator`) VALUES
(9, 3289, 7, '22.20', 1, 0, 72),
(10, 4677, 7, '103.50', 1, 0, 72),
(11, 3289, 8, '22.20', 1, 0, 72),
(12, 3289, 9, '22.20', 1, 0, 72),
(13, 4677, 9, '103.50', 1, 10, 72),
(14, 4677, 10, '103.50', 1, 0, 72),
(15, 3289, 11, '22.20', 1, 0, 72),
(16, 3289, 12, '22.20', 1, 0, 72),
(17, 4677, 13, '103.50', 2, 0, 72),
(18, 8694, 13, '0.00', 1, 0, 72),
(19, 3289, 14, '22.20', 1, 0, 72),
(20, 3289, 15, '22.20', 1, 0, 72);

-- --------------------------------------------------------

--
-- Table structure for table `gv_compte`
--

DROP TABLE IF EXISTS `gv_compte`;
CREATE TABLE IF NOT EXISTS `gv_compte` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `name` varchar(20) NOT NULL,
  `src` varchar(100) DEFAULT NULL,
  `active` int DEFAULT '0',
  `createime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `config` longtext,
  `code` varchar(50) DEFAULT NULL,
  `menus` longtext,
  `admin` int DEFAULT '0',
  `token` text,
  `session_id` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `gv_compte`
--

INSERT INTO `gv_compte` (`id`, `email`, `pass`, `name`, `src`, `active`, `createime`, `config`, `code`, `menus`, `admin`, `token`, `session_id`) VALUES
(0, 'pivo@kompassit.com', 'UnVIVnlGWTJhRHBQSjVna2ZYQkh5UT09', 'Youness', '14.jpg', 1, '2018-12-22 00:00:00', '{\"AutoD\":{\"active\":false,\"time\":\"1\"},\"theme\":{\"bgcolor\":\"#673AB7\",\"primarycolor\":\"#FFFFFF\",\"fontsize\":16,\"fontfamily\":\"Fira\"},\"header\":\"1\"}', NULL, '[\r\n{\"text\":\"Accueil\",\"url\":\"app.home\",\"icon\":\"home\",\"access\":[],\"locked\":true},\r\n{\"text\":\"Profile\",\"url\":\"app.profile\",\"access\":[],\"hideMenu\":true,\"icon\":\"account\"},\r\n{\"text\":\"Gestion des comptes\",\"icon\":\"people\",\"url\":\"app.gestioncomptes\",\"access\":[],\"hideMenu\":true},\r\n{\"text\":\"Notifications\",\"url\":\"app.notifications\",\"access\":[],\"hideMenu\":true,\"icon\":\"notifications\"},\r\n{\"text\":\"Sessions\",\"url\":\"app.sessions\",\"access\":[],\"hideMenu\":true,\"icon\":\"update\"},\r\n{\"text\":\"INSCRIPTIONS\",\"url\":\"app.register\",\"icon\":\"person_add\",\"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"},{\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}]},\r\n{\"text\":\"Gestion Certificats\",\"url\":\"app.certificat\",\"icon\":\"diploma\",\"access\":[],\"childrens\":[]},\r\n{\"text\":\"Gestion Paiements\",\"url\":\"app.credits\",\"icon\":\"credits\",\"access\":[],\"childrens\":[]},\r\n{\"text\":\"Gestion Dépenses \",\"url\":\"app.depenses\",\"icon\":\"coins\", \"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"}, {\"type\":\"update\",\"value\":true,\"icon\":\"edit\"} ,{\"type\": \"delete\", \"value\":true,\"icon\":\"delete\"}]},\r\n{\"text\":\"Documents \",\"url\":\"app.docs\",\"icon\":\"auto_stories\", \"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"}, {\"type\":\"update\",\"value\":true,\"icon\":\"edit\"} ,{\"type\": \"delete\", \"value\":true,\"icon\":\"delete\"}]},\r\n{\"text\":\"Statistiques \",\"url\":\"app.statistiques\",\"icon\":\"chart-column\",\"access\":[]},\r\n{\"text\":\"Paramètres\",\"url\":\"#\",\"icon\":\"settings\",\"access\":[],\"childrens\":[\r\n{\"text\":\"App Config\",\"url\":\"app.settings.about\", \"icon\":\"settings\",\"access\":[]},\r\n{\"text\":\"Personnels\",\"url\":\"app.settings.staff\", \"icon\":\"people\",\"access\":[{\"type\":\"add\", \"value\":true,\"icon\":\"plus\"}, {\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}]},\r\n{\"text\":\"Formations\",\"url\":\"app.formations\", \"icon\":\"school\",\"access\":[{\"type\":\"add\", \"value\":true,\"icon\":\"plus\"}, {\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}]},\r\n{\"text\":\"Exportation des données \",\"url\":\"app.export\",\"icon\":\"download\",\"access\":[]}\r\n]}\r\n]\r\n', 1, 'dqv0bVqmS5c:APA91bH9tyq6veb7nKex8zb6QfqeiRkP-P7s1_DJUhlWsz7ncavXXoGbUvpqEZMIKQNd1wli8tNk4NkZngAweiTMFqBM8k5T6fGfO_RipmjHEpm98ttbcUHRDqUK4Q5SB3r_0o4dbljt', 'b635f9e3c038855c68c2704f08caeee1'),
(71, 'admin@admin.com', 'UnVIVnlGWTJhRHBQSjVna2ZYQkh5UT09', 'admin', '11.jpg', 1, '2023-11-10 23:00:00', '{\"AutoD\":{\"active\":false,\"time\":\"3\"},\"theme\":{\"bgcolor\":\"#9C27B0\",\"primarycolor\":\"#FFFFFF\",\"fontsize\":16,\"fontfamily\":\"Rajdhani\"},\"header\":\"1\",\"t_expire\":42}', NULL, '[{\"text\":\"Accueil\",\"url\":\"app.home\",\"icon\":\"home\",\"access\":[],\"locked\":true},{\"text\":\"Profile\",\"url\":\"app.profile\",\"access\":[],\"hideMenu\":true,\"icon\":\"account\"},{\"text\":\"Gestion des comptes\",\"icon\":\"people\",\"url\":\"app.gestioncomptes\",\"access\":[],\"hideMenu\":true},{\"text\":\"Notifications\",\"url\":\"app.notifications\",\"access\":[],\"hideMenu\":true,\"icon\":\"notifications\"},{\"text\":\"Sessions\",\"url\":\"app.sessions\",\"access\":[],\"hideMenu\":true,\"icon\":\"update\"},{\"text\":\"INSCRIPTIONS\",\"url\":\"app.register\",\"icon\":\"person_add\",\"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"},{\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}]},{\"text\":\"Entrée des produit\",\"url\":\"app.achats\",\"icon\":\"\",\"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"},{\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}]},{\"text\":\"Ventes\",\"url\":\"app.ventes\",\"icon\":\"ventes\",\"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"},{\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}]},{\"text\":\"Liste Notes\",\"url\":\"app.notes\",\"icon\":\"chat\",\"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"},{\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}],\"childrens\":[]},{\"text\":\"Gestion Dépenses \",\"url\":\"app.depenses\",\"icon\":\"coins\",\"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"},{\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}]},{\"text\":\"Statistiques \",\"url\":\"app.statistiques\",\"icon\":\"chart-column\",\"access\":[]},{\"text\":\"Paramètres\",\"url\":\"#\",\"icon\":\"settings\",\"access\":[],\"childrens\":[{\"text\":\"App Config\",\"url\":\"app.settings.about\",\"icon\":\"settings\",\"access\":[]},{\"text\":\"Produits\",\"url\":\"app.produits\",\"icon\":\"add_shopping_cart\",\"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"},{\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}]},{\"text\":\"Fournisseurs\",\"url\":\"app.settings.fournisseurs\",\"icon\":\"work\",\"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"},{\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}]},{\"text\":\"Exportation des données \",\"url\":\"app.export\",\"icon\":\"download\",\"access\":[]}]}]', 1, NULL, '3d600348cf3aca45a777c9bc043054d4'),
(72, 'admin1@admin.com', 'UnVIVnlGWTJhRHBQSjVna2ZYQkh5UT09', 'admin1', '016637aa3c.png', 1, '2023-11-13 13:29:06', '{\"AutoD\":{\"active\":false,\"time\":\"3\"},\"theme\":{\"bgcolor\":\"#00897b\",\"primarycolor\":\"#ffffff\",\"fontsize\":16,\"fontfamily\":\"Roboto\"},\"header\":\"1\"}', NULL, '[{\"text\":\"Accueil\",\"url\":\"app.home\",\"icon\":\"home\",\"access\":[],\"locked\":true},{\"text\":\"Profile\",\"url\":\"app.profile\",\"access\":[],\"hideMenu\":true,\"icon\":\"account\"},{\"text\":\"Gestion des comptes\",\"icon\":\"people\",\"url\":\"app.gestioncomptes\",\"access\":[],\"hideMenu\":true},{\"text\":\"Notifications\",\"url\":\"app.notifications\",\"access\":[],\"hideMenu\":true,\"icon\":\"notifications\"},{\"text\":\"Sessions\",\"url\":\"app.sessions\",\"access\":[],\"hideMenu\":true,\"icon\":\"update\"},{\"text\":\"INSCRIPTIONS\",\"url\":\"app.register\",\"icon\":\"person_add\",\"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"},{\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}]},{\"text\":\"Entrée des produit\",\"url\":\"app.achats\",\"icon\":\"add_shopping_cart\",\"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"},{\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}]},{\"text\":\"Ventes\",\"url\":\"app.ventes\",\"icon\":\"ventes\",\"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"},{\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}]},{\"text\":\"Liste Notes\",\"url\":\"app.notes\",\"icon\":\"chat\",\"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"},{\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}],\"childrens\":[]},{\"text\":\"Gestion Dépenses \",\"url\":\"app.depenses\",\"icon\":\"coins\",\"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"},{\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}]},{\"text\":\"Statistiques \",\"url\":\"app.statistiques\",\"icon\":\"chart-column\",\"access\":[]},{\"text\":\"Paramètres\",\"url\":\"#\",\"icon\":\"settings\",\"access\":[],\"childrens\":[{\"text\":\"App Config\",\"url\":\"app.settings.about\",\"icon\":\"settings\",\"access\":[]},{\"text\":\"Produits\",\"url\":\"app.produits\",\"icon\":\"products\",\"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"},{\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}]},{\"text\":\"Fournisseurs\",\"url\":\"app.settings.fournisseurs\",\"icon\":\"work\",\"access\":[{\"type\":\"add\",\"value\":true,\"icon\":\"plus\"},{\"type\":\"update\",\"value\":true,\"icon\":\"edit\"},{\"type\":\"delete\",\"value\":true,\"icon\":\"delete\"}]},{\"text\":\"Exportation des données \",\"url\":\"app.export\",\"icon\":\"download\",\"access\":[]}]}]', 1, NULL, '2f254e66097fd653a5ca4cfdb33be358');

-- --------------------------------------------------------

--
-- Table structure for table `gv_config_type_depenses`
--

DROP TABLE IF EXISTS `gv_config_type_depenses`;
CREATE TABLE IF NOT EXISTS `gv_config_type_depenses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `dl` int DEFAULT NULL,
  `id_creator` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `gv_config_type_depenses`
--

INSERT INTO `gv_config_type_depenses` (`id`, `name`, `dl`, `id_creator`) VALUES
(1, 'ELECTRICITE', 1, 47),
(2, 'EAUX', 1, 47),
(3, 'INTERNET', 1, 47),
(4, 'FOURNITURES D\'ACTIVITES', 1, 47),
(5, 'SALAIRES', 1, 47),
(19, 'PUB', NULL, 63),
(20, 'Materiels robotiques', NULL, 66),
(21, 'Materiels informatique', NULL, 66),
(22, 'Sanitaire', NULL, 66);

-- --------------------------------------------------------

--
-- Table structure for table `gv_coop`
--

DROP TABLE IF EXISTS `gv_coop`;
CREATE TABLE IF NOT EXISTS `gv_coop` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `addr` text,
  `logo` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `date_inscrit` date DEFAULT NULL,
  `id_creator` int NOT NULL,
  `dt_crt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_updator` int DEFAULT NULL,
  `dt_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `gv_coop`
--

INSERT INTO `gv_coop` (`id`, `name`, `tel`, `email`, `addr`, `logo`, `date_inscrit`, `id_creator`, `dt_crt`, `id_updator`, `dt_update`) VALUES
(13, 'Coop 4', '06 44 90 95 96', NULL, NULL, 'pr.jpg.webp', NULL, 66, '2023-07-31 19:53:13', 72, '2023-11-13 13:37:09'),
(14, 'Coop 3', '06 20 30 94 14', NULL, NULL, '14.jpg.webp', NULL, 66, '2023-07-31 19:54:05', 72, '2023-11-13 13:36:58'),
(15, 'Coop 2', '06 50 42 33 70', NULL, NULL, '11.jpg.webp', NULL, 66, '2023-07-31 19:54:39', 72, '2023-11-13 13:36:47'),
(16, 'Coop 1', '06 59 29 78 62', NULL, NULL, '3.jpg.webp', NULL, 66, '2023-07-31 19:55:54', 72, '2023-11-13 13:36:36');

-- --------------------------------------------------------

--
-- Table structure for table `gv_depenses`
--

DROP TABLE IF EXISTS `gv_depenses`;
CREATE TABLE IF NOT EXISTS `gv_depenses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mtn` decimal(10,2) NOT NULL,
  `motif` text NOT NULL,
  `date_` date NOT NULL,
  `nature` int NOT NULL,
  `img` varchar(250) DEFAULT NULL,
  `id_creator` int NOT NULL,
  `dt_crt` datetime DEFAULT NULL,
  `id_updator` int DEFAULT NULL,
  `dt_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `gv_depenses`
--

INSERT INTO `gv_depenses` (`id`, `mtn`, `motif`, `date_`, `nature`, `img`, `id_creator`, `dt_crt`, `id_updator`, `dt_update`) VALUES
(4, '300.00', 'ghjkl', '2023-11-13', 20, '11.webp', 71, '2023-11-13 18:56:31', 71, '2023-11-13 19:13:28'),
(5, '120.00', '120 dh', '2023-11-13', 2, 'pr.webp', 71, '2023-11-13 19:01:13', 71, '2023-11-13 19:20:18'),
(6, '345.00', 'RE', '2023-11-13', 19, '14.webp', 71, '2023-11-13 19:03:58', 71, '2023-11-13 19:20:06');

-- --------------------------------------------------------

--
-- Table structure for table `gv_fournisseurs`
--

DROP TABLE IF EXISTS `gv_fournisseurs`;
CREATE TABLE IF NOT EXISTS `gv_fournisseurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) NOT NULL,
  `logo` varchar(200) DEFAULT NULL,
  `iff` varchar(50) DEFAULT NULL,
  `ice` varchar(50) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `cin` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `addr` text,
  `date_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_creator` int NOT NULL,
  `dt_crt` datetime DEFAULT NULL,
  `id_updator` int DEFAULT NULL,
  `dt_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`),
  UNIQUE KEY `ice` (`ice`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `gv_fournisseurs`
--

INSERT INTO `gv_fournisseurs` (`id`, `nom`, `logo`, `iff`, `ice`, `tel`, `cin`, `email`, `ville`, `addr`, `date_`, `id_creator`, `dt_crt`, `id_updator`, `dt_update`) VALUES
(1, 'FOURNISS1', 'pr.jpg.webp', '0239232039', '12323233243', '023923020', 'DA1233l', 'jsdsd@kolsdq.com', 'FESxss', 'zedzezde', '2019-01-10 22:58:35', 0, '0000-00-00 00:00:00', 71, '2023-11-13 15:23:31'),
(9, 'SOCIETE SONAMACH', 'f68d96fe45.png.webp', '5300674', '001666444000044', '0522248519', '152373/casa', NULL, 'CASABLANCA', 'SA 605 BD MOHAMED V CASABLANCA', '2019-04-09 13:09:32', 0, '0000-00-00 00:00:00', 71, '2023-11-13 15:23:17'),
(10, 'TOTAL  MAROCX', '14.jpg.webp', '1085284', '001524641000038', '0801 000 023', '39/CASABLANCAaaaaaa', 'eemail@ddf.com', 'CASABLANCA', 'addre casa anfa', '2019-04-22 12:46:48', 0, '0000-00-00 00:00:00', 71, '2023-11-13 15:19:45'),
(11, 'CPRE XX', '11.jpg.webp', '40274814', '0', '05 35 73 55 55', '30737/FES', NULL, 'FES', 'QI SIDI BRAHIM RUE FARABI N 808', '2022-02-15 16:34:52', 1, '2022-02-15 16:34:52', 71, '2023-11-13 15:14:49');

-- --------------------------------------------------------

--
-- Table structure for table `gv_notes`
--

DROP TABLE IF EXISTS `gv_notes`;
CREATE TABLE IF NOT EXISTS `gv_notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `text` text,
  `writer` int DEFAULT NULL,
  `date_` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `img` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `writer` (`writer`)
) ENGINE=InnoDB AUTO_INCREMENT=346 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `gv_notes`
--

INSERT INTO `gv_notes` (`id`, `text`, `writer`, `date_`, `img`) VALUES
(20, 'SVP 8 copies', 0, '2022-12-14 12:14:15', 'أشهر السنة.pdf'),
(76, '7 copies', 0, '2023-01-12 16:09:51', 'raccourcis.pdf'),
(81, 'imp 2', 0, '2023-01-14 09:53:27', 'simpletext.pdf'),
(90, 'cv hajar mastour', 0, '2023-01-25 15:33:38', 'WhatsApp Image 2023-01-25 at 15.31.15.jpeg'),
(164, 'This certificate is delivered to the person concerned to serve administrative purposes', 0, '2023-03-01 14:35:55', NULL),
(172, 'Compte anapec hajar mastour\nLogin: DA80176\nPass :  DA80176', 0, '2023-03-03 22:37:16', NULL),
(253, 'من الافضل تأجيل الشواهد حتى الاتنين.ليتمكن الكل من الحضور', 0, '2023-05-13 14:09:45', NULL),
(269, 'dahani testتسجيل جديد انظر التفاصيل في صفحة التسجيلات ', NULL, '2023-06-02 16:50:09', NULL),
(270, 'هند بنت المهلهل تسجيل جديد انظر التفاصيل في صفحة التسجيلات ', NULL, '2023-06-02 19:52:58', NULL),
(306, 'Grille des évaluation', 0, '2023-07-15 13:38:23', 'Grille des évaluation.docx');

-- --------------------------------------------------------

--
-- Table structure for table `gv_notifications`
--

DROP TABLE IF EXISTS `gv_notifications`;
CREATE TABLE IF NOT EXISTS `gv_notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_` text,
  `text` text,
  `sent` int NOT NULL DEFAULT '0',
  `id_creator` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `gv_products`
--

DROP TABLE IF EXISTS `gv_products`;
CREATE TABLE IF NOT EXISTS `gv_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `name` varchar(400) NOT NULL,
  `prix` decimal(8,2) DEFAULT NULL,
  `tva` int DEFAULT NULL,
  `descr` text,
  `img` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `qn_min` int DEFAULT '0',
  `id_creator` int DEFAULT NULL,
  `id_updator` int DEFAULT NULL,
  `dt_update` datetime DEFAULT NULL,
  `dt_crt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=8697 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `gv_products`
--

INSERT INTO `gv_products` (`id`, `code`, `name`, `prix`, `tva`, `descr`, `img`, `qn_min`, `id_creator`, `id_updator`, `dt_update`, `dt_crt`) VALUES
(8681, '34', 'tesst', '0.00', NULL, NULL, '169991261714.jpg', 0, 1, 1, '2023-11-13 21:56:57', '2021-04-01 23:32:26'),
(8682, '12345678901233', 'xxxxxxxxx', NULL, NULL, NULL, NULL, 0, 71, NULL, NULL, '2023-11-19 15:48:38'),
(8683, NULL, 'yyyyyyy', NULL, NULL, NULL, NULL, 0, 71, NULL, NULL, '2023-11-19 15:50:45'),
(8684, NULL, 'kkkkkkk', NULL, NULL, NULL, NULL, 0, 71, NULL, NULL, '2023-11-19 15:51:25'),
(8685, NULL, 'nnnnnnn', NULL, NULL, NULL, NULL, 0, 71, NULL, NULL, '2023-11-19 15:53:32'),
(8686, NULL, 'ppppppp', NULL, NULL, NULL, NULL, 0, 71, NULL, NULL, '2023-11-19 15:53:54'),
(8687, NULL, '223', NULL, NULL, NULL, NULL, 0, 71, NULL, NULL, '2023-11-19 16:02:16'),
(8688, NULL, '22', NULL, NULL, NULL, NULL, 0, 71, NULL, NULL, '2023-11-19 16:12:07'),
(8689, NULL, 'Ajolm', NULL, NULL, NULL, NULL, 0, 71, NULL, NULL, '2023-11-19 16:14:31'),
(8690, NULL, 'pelwxxxx', NULL, NULL, NULL, NULL, 0, 71, NULL, NULL, '2023-11-19 16:45:03'),
(8691, NULL, 'xxxxxxqz111', NULL, NULL, NULL, NULL, 0, 71, NULL, NULL, '2023-11-19 16:48:08'),
(8692, NULL, '11111', NULL, NULL, NULL, NULL, 0, 71, NULL, NULL, '2023-11-19 16:50:06'),
(8693, NULL, '22222', NULL, NULL, NULL, NULL, 0, 71, NULL, NULL, '2023-11-19 16:50:29'),
(8694, '12345678901239', '3333333', NULL, NULL, NULL, NULL, 0, 71, NULL, NULL, '2023-11-19 16:50:37'),
(8695, NULL, 'sddez', '0.00', NULL, NULL, '170042610514.jpg', 0, 71, 71, '2023-11-19 20:35:05', '2023-11-19 16:51:37'),
(8696, NULL, '3D VIT 10ML GOUTTES BUV 2 323,00 dhs', NULL, NULL, NULL, NULL, 0, 72, NULL, NULL, '2023-11-20 01:04:49');

-- --------------------------------------------------------

--
-- Stand-in structure for view `gv_products_state`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `gv_products_state`;
CREATE TABLE IF NOT EXISTS `gv_products_state` (
`id_pr` int
,`achats` decimal(32,0)
,`ventes` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `gv_sessions`
--

DROP TABLE IF EXISTS `gv_sessions`;
CREATE TABLE IF NOT EXISTS `gv_sessions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_compte` int NOT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_compte` (`id_compte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `gv_stock`
--

DROP TABLE IF EXISTS `gv_stock`;
CREATE TABLE IF NOT EXISTS `gv_stock` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_en` date DEFAULT NULL,
  `date_pre` date DEFAULT NULL,
  `q` int NOT NULL DEFAULT '0',
  `prix_achat` decimal(10,2) DEFAULT NULL,
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `id_pr` int NOT NULL,
  `id_four` int DEFAULT NULL,
  `id_creator` int DEFAULT NULL,
  `dt_crt` datetime DEFAULT NULL,
  `id_updator` int DEFAULT NULL,
  `dt_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produits_stock` (`id_pr`),
  KEY `id_four` (`id_four`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `gv_stock`
--

INSERT INTO `gv_stock` (`id`, `date_en`, `date_pre`, `q`, `prix_achat`, `prix_vente`, `id_pr`, `id_four`, `id_creator`, `dt_crt`, `id_updator`, `dt_update`) VALUES
(4, '2023-11-19', NULL, 1, NULL, NULL, 8692, 1, 71, '2023-11-19 15:50:13', NULL, NULL),
(5, '2023-11-19', NULL, 1, NULL, NULL, 8693, 10, 71, '2023-11-19 15:50:40', NULL, NULL),
(6, '2023-11-19', NULL, 10, '100.00', '0.00', 8694, 10, 71, '2023-11-19 15:50:40', 71, '2023-11-19 15:52:14');

-- --------------------------------------------------------

--
-- Structure for view `gv_products_state`
--
DROP TABLE IF EXISTS `gv_products_state`;

DROP VIEW IF EXISTS `gv_products_state`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `gv_products_state`  AS SELECT `a`.`id_pr` AS `id_pr`, ifnull(sum(`a`.`q`),0) AS `achats`, ifnull(sum(`v`.`q`),0) AS `ventes` FROM (`gv_stock` `a` left join `gv_commande_article` `v` on((`v`.`id_pr` = `a`.`id_pr`))) GROUP BY `a`.`id_pr``id_pr`  ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gv_commande_article`
--
ALTER TABLE `gv_commande_article`
  ADD CONSTRAINT `gv_commande_article_ibfk_1` FOREIGN KEY (`id_cmd`) REFERENCES `gv_commandes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gv_notes`
--
ALTER TABLE `gv_notes`
  ADD CONSTRAINT `gv_notes_ibfk_1` FOREIGN KEY (`writer`) REFERENCES `gv_compte` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gv_stock`
--
ALTER TABLE `gv_stock`
  ADD CONSTRAINT `gv_stock_ibfk_1` FOREIGN KEY (`id_pr`) REFERENCES `gv_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gv_stock_ibfk_2` FOREIGN KEY (`id_four`) REFERENCES `gv_fournisseurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
