-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 01 juin 2025 à 11:54
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dzesidb`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `mot_de_passe` varchar(200) NOT NULL,
  `prenom` varchar(150) NOT NULL,
  `email` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `nom`, `mot_de_passe`, `prenom`, `email`) VALUES
(2, 'admin', '$2y$10$pjrnv0ShHBbXtKEc3iI2PuXtnNtx3EfPpTkTFEcmK08QtDUA0mg2e', 'adminprenom', 'ephrema248@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `categories_d`
--

DROP TABLE IF EXISTS `categories_d`;
CREATE TABLE IF NOT EXISTS `categories_d` (
  `id_cat` int NOT NULL AUTO_INCREMENT,
  `nom_cat` varchar(100) NOT NULL,
  `desc_cat` text,
  PRIMARY KEY (`id_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `categories_d`
--

INSERT INTO `categories_d` (`id_cat`, `nom_cat`, `desc_cat`) VALUES
(13, 'Vases', NULL),
(11, 'Pagnes', NULL),
(10, 'Sculptures', NULL),
(8, 'Pots', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commandes_d`
--

DROP TABLE IF EXISTS `commandes_d`;
CREATE TABLE IF NOT EXISTS `commandes_d` (
  `id_ligne` int NOT NULL AUTO_INCREMENT,
  `id_com` int NOT NULL,
  `id_uti` int DEFAULT NULL,
  `nom_prod` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `date_com` datetime DEFAULT CURRENT_TIMESTAMP,
  `total` decimal(10,2) NOT NULL,
  `adresse_livraison` text NOT NULL,
  `mode_paiement` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantite` int DEFAULT '1',
  `num_recu` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_ligne`),
  KEY `id_uti` (`id_uti`),
  KEY `id_uti_2` (`id_uti`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `commandes_d`
--

INSERT INTO `commandes_d` (`id_ligne`, `id_com`, `id_uti`, `nom_prod`, `date_com`, `total`, `adresse_livraison`, `mode_paiement`, `image`, `quantite`, `num_recu`) VALUES
(77, 76, 4, 'Pagn_2', '2025-05-30 08:26:20', 15000.00, 'Limousine', 'stripe_test', 'uploads/prod_68396b60301d55.19036852.jpg', 1, 'RC68396BAC9A69C'),
(75, 73, 4, 'Pot_2', '2025-05-29 23:44:30', 24000.00, 'Abidjan', 'stripe_test', 'uploads/prod_6838ee9bb6ec93.96143527.jpg', 2, 'RC6838F15EE1E19'),
(74, 73, 4, 'Vase_1', '2025-05-29 23:44:30', 45000.00, 'Abidjan', 'stripe_test', 'uploads/prod_683742598f6aa8.26411694.jpg', 3, 'RC6838F15EE1E19'),
(72, 70, 4, 'Pagn_1', '2025-05-29 23:41:37', 15000.00, 'Istanbul', 'stripe_test', 'uploads/prod_6838eefdea40b4.58785804.jpg', 3, 'RC6838F0B10F4B3'),
(71, 70, 4, 'Pot_1', '2025-05-29 23:41:37', 14000.00, 'Istanbul', 'stripe_test', 'uploads/prod_6838ee7b6d2163.49830426.jpeg', 1, 'RC6838F0B10F4B3'),
(69, 66, 4, 'Scul_4', '2025-05-29 22:29:41', 60000.00, 'Lomé-Togo', 'stripe_test', 'uploads/prod_68374812381540.12911670.jpeg', 3, 'RC6838DFD5CBB7E'),
(65, 64, 4, 'Vase_1', '2025-05-29 22:25:11', 15000.00, 'Wida', 'stripe_test', 'uploads/prod_683742598f6aa8.26411694.jpg', 1, 'RC6838DEC70B13B'),
(67, 66, 4, 'Vase_1', '2025-05-29 22:29:41', 45000.00, 'Lomé-Togo', 'stripe_test', 'uploads/prod_683742598f6aa8.26411694.jpg', 3, 'RC6838DFD5CBB7E'),
(68, 66, 4, 'Vase_4', '2025-05-29 22:29:41', 70000.00, 'Lomé-Togo', 'stripe_test', 'uploads/prod_6837433485ce09.16310287.jpeg', 2, 'RC6838DFD5CBB7E'),
(40, 39, 4, 'Vase_1', '2025-05-29 20:06:33', 15000.00, 'Suisse', 'stripe_test', 'uploads/prod_683742598f6aa8.26411694.jpg', 1, 'RC6838BE497FD74'),
(42, 41, 4, 'Vase_1', '2025-05-29 20:10:13', 30000.00, 'Kara', 'stripe_test', 'uploads/prod_683742598f6aa8.26411694.jpg', 2, 'RC6838BF251A722'),
(43, 41, 4, 'Scul_2', '2025-05-29 20:10:13', 80000.00, 'Kara', 'stripe_test', 'uploads/prod_683747ed8b4e55.15377429.jpeg', 4, 'RC6838BF251A722'),
(79, 78, 5, 'Vase_2', '2025-05-30 11:43:24', 42000.00, 'Bengladesh', 'stripe_test', 'uploads/prod_683742d069d8f5.03279372.png', 1, 'RC683999DC3B115'),
(81, 80, 5, 'Vase_1', '2025-05-30 11:54:51', 15000.00, 'Fiesta', 'stripe_test', 'uploads/prod_683742598f6aa8.26411694.jpg', 1, 'RC68399C8B15CDB'),
(83, 82, 5, 'Vase_2', '2025-05-30 11:56:45', 42000.00, 'Nigeria', 'stripe_test', 'uploads/prod_683742d069d8f5.03279372.png', 1, 'RC68399CFD8B973'),
(84, 82, 5, 'Pagn_1', '2025-05-30 11:56:45', 5000.00, 'Nigeria', 'stripe_test', 'uploads/prod_6838eefdea40b4.58785804.jpg', 1, 'RC68399CFD8B973'),
(86, 85, 5, 'Vase_4', '2025-05-30 11:59:15', 35000.00, 'DjiDjolé', 'stripe_test', 'uploads/prod_6837433485ce09.16310287.jpeg', 1, 'RC68399D93975B7'),
(88, 87, NULL, 'Pot_2', '2025-05-30 21:51:01', 36000.00, 'Gotham', 'stripe_test', 'uploads/prod_6838ee9bb6ec93.96143527.jpg', 3, 'RC683A28451B86E');

-- --------------------------------------------------------

--
-- Structure de la table `details_commandes_d`
--

DROP TABLE IF EXISTS `details_commandes_d`;
CREATE TABLE IF NOT EXISTS `details_commandes_d` (
  `id_detcom` int NOT NULL AUTO_INCREMENT,
  `id_com` int NOT NULL,
  `id_prod` int NOT NULL,
  `nom` varchar(200) NOT NULL,
  `quantite` int NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id_detcom`),
  KEY `id_com` (`id_com`),
  KEY `id_prod` (`id_prod`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `informations_d`
--

DROP TABLE IF EXISTS `informations_d`;
CREATE TABLE IF NOT EXISTS `informations_d` (
  `id_info` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `adresse` varchar(200) NOT NULL,
  PRIMARY KEY (`id_info`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `informations_d`
--

INSERT INTO `informations_d` (`id_info`, `email`, `numero`, `adresse`) VALUES
(1, 'ephrema248@gmail.com', '90909090', 'Lomé-Togo');

-- --------------------------------------------------------

--
-- Structure de la table `panier_d`
--

DROP TABLE IF EXISTS `panier_d`;
CREATE TABLE IF NOT EXISTS `panier_d` (
  `id_pan` int NOT NULL AUTO_INCREMENT,
  `id_uti` int NOT NULL,
  `id_prod` int NOT NULL,
  `quantite` int NOT NULL,
  `date_ajout` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pan`),
  KEY `id_uti` (`id_uti`),
  KEY `id_prod` (`id_prod`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `produits_d`
--

DROP TABLE IF EXISTS `produits_d`;
CREATE TABLE IF NOT EXISTS `produits_d` (
  `id_prod` int NOT NULL AUTO_INCREMENT,
  `id_cat` int DEFAULT NULL,
  `nom_prod` varchar(255) NOT NULL,
  `desc_prod` text,
  `prix` decimal(10,2) NOT NULL,
  `quantite_stock` int NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_prod`),
  KEY `id_cat` (`id_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `produits_d`
--

INSERT INTO `produits_d` (`id_prod`, `id_cat`, `nom_prod`, `desc_prod`, `prix`, `quantite_stock`, `image`) VALUES
(1, 13, 'Vase_1', 'Ce magnifique vase en céramique allie élégance et simplicité avec ses courbes raffinées et sa finition lisse. Idéal pour sublimer votre intérieur, il accueille aussi bien des fleurs fraîches que séchées. Sa teinte neutre s’intègre parfaitement à tout style de décoration. Un objet déco aussi pratique qu’esthétique à offrir ou à s’offrir.\r\n', 15000.00, 16, 'uploads/prod_683742598f6aa8.26411694.jpg'),
(3, 13, 'Vase_2', 'Ce magnifique vase en céramique allie élégance et simplicité avec ses courbes raffinées et sa finition lisse. Idéal pour sublimer votre intérieur, il accueille aussi bien des fleurs fraîches que séchées. Sa teinte neutre s’intègre parfaitement à tout style de décoration. Un objet déco aussi pratique qu’esthétique à offrir ou à s’offrir.', 42000.00, 13, 'uploads/prod_683742d069d8f5.03279372.png'),
(4, 13, 'Vase_3', 'Ce magnifique vase en céramique allie élégance et simplicité avec ses courbes raffinées et sa finition lisse. Idéal pour sublimer votre intérieur, il accueille aussi bien des fleurs fraîches que séchées. Sa teinte neutre s’intègre parfaitement à tout style de décoration. Un objet déco aussi pratique qu’esthétique à offrir ou à s’offrir.', 10000.00, 12, 'uploads/prod_68374300991536.39144656.jpeg'),
(5, 13, 'Vase_4', 'Ce magnifique vase en céramique allie élégance et simplicité avec ses courbes raffinées et sa finition lisse. Idéal pour sublimer votre intérieur, il accueille aussi bien des fleurs fraîches que séchées. Sa teinte neutre s’intègre parfaitement à tout style de décoration. Un objet déco aussi pratique qu’esthétique à offrir ou à s’offrir.', 35000.00, 4, 'uploads/prod_6837433485ce09.16310287.jpeg'),
(6, 10, 'Scul_1', '', 20000.00, 15, 'uploads/prod_6837473727fe74.81427964.jpeg'),
(7, 10, 'Scul_2', '', 20000.00, 15, 'uploads/prod_683747ed8b4e55.15377429.jpeg'),
(8, 10, 'Scul_3', '', 20000.00, 20, 'uploads/prod_683747fc674468.69660052.jpeg'),
(9, 10, 'Scul_4', '', 20000.00, 20, 'uploads/prod_68374812381540.12911670.jpeg'),
(10, 8, 'Pot_1', '', 14000.00, 19, 'uploads/prod_6838ee7b6d2163.49830426.jpeg'),
(11, 8, 'Pot_2', '', 12000.00, 0, 'uploads/prod_6838ee9bb6ec93.96143527.jpg'),
(12, 8, 'Pot_3', '', 35000.00, 15, 'uploads/prod_6838eec9438795.71284424.jpeg'),
(13, 11, 'Pagn_1', '', 5000.00, 6, 'uploads/prod_6838eefdea40b4.58785804.jpg'),
(15, 11, 'Pagn_2', '', 15000.00, 11, 'uploads/prod_68396b60301d55.19036852.jpg'),
(16, 10, 'Scul_5', '', 14000.00, 10, 'uploads/prod_6839942f962029.76051163.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `recus`
--

DROP TABLE IF EXISTS `recus`;
CREATE TABLE IF NOT EXISTS `recus` (
  `num` int NOT NULL AUTO_INCREMENT,
  `id_com` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `quantite` int NOT NULL,
  PRIMARY KEY (`num`),
  KEY `fk_recus_commande` (`id_com`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs_d`
--

DROP TABLE IF EXISTS `utilisateurs_d`;
CREATE TABLE IF NOT EXISTS `utilisateurs_d` (
  `id_uti` int NOT NULL AUTO_INCREMENT,
  `nom_uti` varchar(100) NOT NULL,
  `prenom_uti` varchar(100) NOT NULL,
  `email_uti` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `image_profil` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_uti`),
  UNIQUE KEY `email_uti` (`email_uti`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `utilisateurs_d`
--

INSERT INTO `utilisateurs_d` (`id_uti`, `nom_uti`, `prenom_uti`, `email_uti`, `mot_de_passe`, `ville`, `telephone`, `image_profil`) VALUES
(1, 'jean ', '', 'jean@gmail.com', '$2y$10$571d3xenrudNmiABkLOiQelKP988Z2iIiK9CLzKGrfS6CFHh1KT9y', NULL, NULL, NULL),
(2, 'Dan', '', 'dan@gmail.com', '$2y$10$Dev6rZRkdIg/.go2Y1CuIuLbFRzwL0WSVS.alwuM4fuaQqbrBMpr6', NULL, NULL, NULL),
(3, 'Nathan', '', 'nethaneel06@gmail.com', '$2y$10$EI3bXMMcF7EITJYwVgtuhumS2UQosIP45BrMdHmkW/yI4PkzBHxle', NULL, NULL, NULL),
(4, 'Doombee', 'Nathan', 'nathandoo@gmail.com', '$2y$10$32pHROoLdFKzDGAbmT30HOQkmXA7f0D/03rGDXSCooa2/o1LmmG0y', NULL, NULL, 'uploads/profils/profil_683993e0c9edf.jpeg'),
(5, 'Nathan', 'Doom', 'thedoombee@gmail.com', '$2y$10$1PlNhKLGIpw3e5RDz1gkU.GfuGSmQxlLdx/NxsQAUW5CIiJPBSgci', 'Lomé', '99624914', 'uploads/profils/profil_68393dd7718c9.jpeg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
