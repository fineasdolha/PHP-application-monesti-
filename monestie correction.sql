-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 07 déc. 2023 à 22:25
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `monestie`
--

-- --------------------------------------------------------

--
-- Structure de la table `association`
--

DROP TABLE IF EXISTS `association`;
CREATE TABLE IF NOT EXISTS `association` (
  `id_association` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_association` varchar(50) NOT NULL,
  `city_association` varchar(50) NOT NULL,
  `address_association` varchar(150) NOT NULL,
  PRIMARY KEY (`id_association`),
  KEY `idx_name_association` (`name_association`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `association`
--

INSERT INTO `association` (`id_association`, `name_association`, `city_association`, `address_association`) VALUES
(3, 'Les as de la belotte', 'Nancy', '24 rue carnot'),
(4, 'les doigts de fée', 'Frouard', 'av du petit pré'),
(5, 'Tricotti tricotta', 'Bainville-les-Metz', '36 rue de la pelotte');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id_comment` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment_id` smallint NOT NULL,
  `description` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_reservation` smallint UNSIGNED DEFAULT NULL,
  `id_user` smallint UNSIGNED NOT NULL,
  `destination` varchar(100) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `association_id` smallint NOT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `idx_fk_id_reservation` (`id_reservation`),
  KEY `idx_fk_id_comment` (`comment_id`),
  KEY `idx_fk_id_user` (`id_user`) USING BTREE,
  KEY `idx_fk_association_id` (`association_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id_comment`, `comment_id`, `description`, `id_reservation`, `id_user`, `destination`, `time_stamp`, `association_id`) VALUES
(37, 0, 'Super! j\'ai hâte d\'être aux automnales', NULL, 17, 'association', '2023-12-07 06:51:00', 1),
(38, 37, 'heureux evenement', NULL, 16, 'association', '2023-12-07 06:26:00', 3),
(39, 0, 'Recevez vos messages ici', NULL, 22, 'cleaning', '2023-12-07 19:15:54', 3),
(40, 39, 'Recevez vos messages ici', NULL, 22, 'association', '2023-12-07 19:16:03', 3),
(43, 0, 'comment faire', NULL, 17, 'admin', '2023-12-07 09:11:00', 3),
(44, 43, 'je ne sais pas', NULL, 16, 'association', '2023-12-07 09:33:00', 3),
(45, 0, 'test', NULL, 17, 'association', '2023-12-07 10:37:00', 3),
(46, 0, 'test admin', NULL, 17, 'admin', '2023-12-07 10:24:00', 3),
(47, 46, 'test reply', NULL, 16, 'association', '2023-12-07 10:02:00', 3),
(48, 0, 'test clean', NULL, 17, 'cleaning', '2023-12-07 10:33:00', 3),
(49, 48, 'test reply clean', NULL, 19, 'association', '2023-12-07 10:04:00', 3),
(50, 0, 'test admin', NULL, 17, 'admin', '2023-12-07 10:45:00', 3),
(52, 0, 'test clean to clean', NULL, 19, 'cleaning', '2023-12-07 10:12:00', 0),
(53, 52, 'reply to clean', NULL, 20, 'cleaning', '2023-12-07 10:37:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `docs`
--

DROP TABLE IF EXISTS `docs`;
CREATE TABLE IF NOT EXISTS `docs` (
  `id_doc` smallint NOT NULL AUTO_INCREMENT,
  `id_association` smallint NOT NULL,
  `file` text,
  `id_reservation` smallint NOT NULL,
  PRIMARY KEY (`id_doc`),
  KEY `idx_fk_id_association` (`id_association`),
  KEY `idx_fk_id_reservation` (`id_reservation`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `docs`
--

INSERT INTO `docs` (`id_doc`, `id_association`, `file`, `id_reservation`) VALUES
(1, 3, 'media1/44.jpg', 44),
(2, 3, 'media1/45.jpg', 45),
(3, 5, 'media1/46.jpg', 46);

-- --------------------------------------------------------

--
-- Structure de la table `interventions`
--

DROP TABLE IF EXISTS `interventions`;
CREATE TABLE IF NOT EXISTS `interventions` (
  `id_intervention` smallint NOT NULL AUTO_INCREMENT,
  `id_user` smallint NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time_spend` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_intervention`),
  KEY `idx_fk_id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `interventions`
--

INSERT INTO `interventions` (`id_intervention`, `id_user`, `time_stamp`, `time_spend`) VALUES
(8, 20, '2023-12-07 17:42:46', '2h30'),
(9, 19, '2023-12-07 17:43:05', '4h'),
(10, 19, '2023-12-07 18:59:42', '2h30');

-- --------------------------------------------------------

--
-- Structure de la table `person`
--

DROP TABLE IF EXISTS `person`;
CREATE TABLE IF NOT EXISTS `person` (
  `id_user` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_association` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `idx_last_name` (`last_name`),
  KEY `idx_fk_id_association` (`id_association`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `person`
--

INSERT INTO `person` (`id_user`, `last_name`, `first_name`, `user_type`, `user_email`, `user_password`, `id_association`) VALUES
(16, 'thesis', 'alix', 'admin', 'at@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$a1ZyeVpCZ1VhVkg1S3dLcA$L8Jyc62bZr9yV5NANhdFZU2F7OLzFhiYKMC7y0yP/ig', 0),
(17, 'master', 'virginie', 'association', 'vm@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$N3lCUlcwQUk3bnlGbVpZZw$jp56jEGTtkg4vIHCTa76m/Lc39NRskXorl84SOdsfKo', 3),
(18, 'Thesis', 'Oceane', 'association', 'ot@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$U29lWVdsY1NRQm1ZdlFrdg$H1+3FKQW1wSA3atxpBYwFVcirofyWNUAq5ijN9RIjaM', 3),
(19, 'de menage', 'femme', 'cleaning', 'f2m@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$NmIvM3JxZXZ1UGhpL2ZReQ$rAQGi6ZbajVgh+pFDbWzPLEDcJIJ1jqjpFsn7MsTdxo', 0),
(20, 'Propre', 'Monsieur', 'cleaning', 'mp@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$UksvU0o1dFJEeFRCWHdpMw$Wc23E7AtrNeWTNcl/G+zsKw3kJge/2FJwYVi6dQ2qu8', 0),
(21, 'Ferb', 'Fineas', 'association', 'ff@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$cVRSdnZTbWFuRzYwZ1lRUA$kXKbiiagavKWT6YLSe2cUrrTDt8X3uk8YSZ5oedTpdk', 4),
(22, 'Mr', 'Sample', 'admin', 'ms@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$RU02MWxacjE2STVJaWFMMg$Ghr01MYzEEauzGZTnIxFXIplBLouceCUtNV4rbQpLLs', 5);

-- --------------------------------------------------------

--
-- Structure de la table `places`
--

DROP TABLE IF EXISTS `places`;
CREATE TABLE IF NOT EXISTS `places` (
  `id_place` smallint NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_place`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `places`
--

INSERT INTO `places` (`id_place`, `name`, `description`) VALUES
(1, 'Salle Monestié', 'Une grande salle de réunion, un bar et un\r\nréfectoire'),
(2, 'Le petit château de Seicheprey', 'une grande salle de reception, un jardin, acces a une cuisine pro, toilettes handicapés');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id_reservation` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `end_datetime` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` varchar(150) NOT NULL,
  `id_user` smallint NOT NULL,
  `type_reservation` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `start_datetime` datetime NOT NULL,
  `id_place` smallint NOT NULL,
  PRIMARY KEY (`id_reservation`),
  KEY `idx_fk_id_user` (`id_user`),
  KEY `idx_fk_id_place` (`id_place`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `title`, `end_datetime`, `last_update`, `description`, `id_user`, `type_reservation`, `start_datetime`, `id_place`) VALUES
(41, 'testslot', '2023-12-07 12:30:00', '0000-00-00 00:00:00', 'qdqsd', 5, 'onetime', '2023-12-07 10:30:00', 0),
(44, 'foire d\'automne', '2023-12-09 23:53:00', '0000-00-00 00:00:00', 'hfghfgf', 16, 'onetime', '2023-12-09 21:53:00', 1),
(45, 'les automnales', '2023-12-14 23:07:00', '0000-00-00 00:00:00', 'frzgazg', 17, 'onetime', '2023-12-14 22:07:00', 1),
(46, 'les pinceaux d\'or', '2023-12-28 16:35:00', '0000-00-00 00:00:00', 'venez aux concours artistique pour ado', 17, 'onetime', '2023-12-28 10:39:00', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
