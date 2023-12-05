-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 05, 2023 at 09:50 AM
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
-- Database: `monestie`
--

-- --------------------------------------------------------

--
-- Table structure for table `association`
--

DROP TABLE IF EXISTS `association`;
CREATE TABLE IF NOT EXISTS `association` (
  `id_association` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_association` varchar(50) NOT NULL,
  `city_association` varchar(50) NOT NULL,
  `address_association` varchar(150) NOT NULL,
  PRIMARY KEY (`id_association`),
  KEY `idx_name_association` (`name_association`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `association`
--

INSERT INTO `association` (`id_association`, `name_association`, `city_association`, `address_association`) VALUES
(1, 'Assoc1', 'Nancy', '3 rue Sainte-Anne'),
(2, 'Assoc2', 'Nancy', '25 rue de Strasbourg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
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
  PRIMARY KEY (`id_comment`),
  KEY `idx_fk_id_reservation` (`id_reservation`),
  KEY `idx_fk_id_comment` (`comment_id`),
  KEY `idx_fk_id_user` (`id_user`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id_comment`, `comment_id`, `description`, `id_reservation`, `id_user`, `destination`, `time_stamp`) VALUES
(1, 0, 'qsdqsdqs', NULL, 0, 'admin', '2023-12-04 08:31:00'),
(3, 0, 'new message', NULL, 8, 'cleaning', '2023-12-04 00:52:00'),
(8, 0, 'new message', NULL, 8, 'cleaning', '2023-12-04 00:08:00'),
(9, 0, 'new message', NULL, 8, 'cleaning', '2023-12-04 00:08:00'),
(10, 0, 'test', NULL, 8, 'cleaning', '2023-12-04 00:46:00'),
(11, 0, 'test', NULL, 8, 'cleaning', '2023-12-04 00:46:00'),
(12, 0, 'test assoc', NULL, 8, 'association', '2023-12-04 00:04:00'),
(13, 0, 'test assoc', NULL, 8, 'association', '2023-12-04 00:04:00'),
(14, 0, 'test assoc', NULL, 8, 'association', '2023-12-04 00:45:00'),
(15, 0, 'test assoc', NULL, 8, 'association', '2023-12-04 00:45:00'),
(16, 0, 'test assoc', NULL, 8, 'association', '2023-12-04 00:36:00'),
(17, 0, 'test assoc', NULL, 8, 'association', '2023-12-04 00:36:00'),
(18, 0, '', NULL, 5, '', '2023-12-05 08:49:00'),
(19, 0, '', NULL, 5, '', '2023-12-05 08:58:00'),
(20, 0, 'replynewmessage', NULL, 5, '', '2023-12-05 08:15:00'),
(21, 0, 'comment', NULL, 5, 'association', '2023-12-05 09:31:00'),
(22, 0, 'bobcomment', NULL, 5, 'association', '2023-12-05 09:49:00'),
(23, 0, 'commentbob2', NULL, 5, 'association', '2023-12-05 09:02:00'),
(24, 0, 'commentbob2', NULL, 5, 'association', '2023-12-05 09:46:00'),
(25, 0, 'commentbob2', NULL, 5, 'association', '2023-12-05 09:51:00'),
(26, 0, 'commentbob2', NULL, 5, 'association', '2023-12-05 09:59:00'),
(27, 0, 'commentbob2', NULL, 5, 'association', '2023-12-05 09:42:00'),
(28, 0, 'fre', NULL, 6, '', '2023-12-05 09:44:00'),
(29, 0, 'fre', NULL, 6, '', '2023-12-05 09:23:00'),
(30, 0, 'notreply', NULL, 6, 'association', '2023-12-05 09:08:00'),
(31, 0, 'notreply', NULL, 6, 'association', '2023-12-05 09:34:00'),
(32, 0, 'thereply', NULL, 6, '', '2023-12-05 09:02:00');

-- --------------------------------------------------------

--
-- Table structure for table `docs`
--

DROP TABLE IF EXISTS `docs`;
CREATE TABLE IF NOT EXISTS `docs` (
  `id_doc` smallint NOT NULL AUTO_INCREMENT,
  `id_association` smallint NOT NULL,
  `file` mediumblob,
  PRIMARY KEY (`id_doc`),
  KEY `idx_fk_id_association` (`id_association`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interventions`
--

DROP TABLE IF EXISTS `interventions`;
CREATE TABLE IF NOT EXISTS `interventions` (
  `id_intervention` smallint NOT NULL AUTO_INCREMENT,
  `id_user` smallint NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time_spend` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_intervention`),
  KEY `idx_fk_id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `person`
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id_user`, `last_name`, `first_name`, `user_type`, `user_email`, `user_password`, `id_association`) VALUES
(5, 'user', 'test1', 'admin', 'test1.user@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$TTYxa2JWTTJETVVRcXdnMQ$9WbUWgL4IelGZOsfl74Wcmx4JqpXVVN+bVn0cAKLfD8', 1),
(6, 'user', 'test2', 'association', 'test2.user@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$TWpoN2llUVZrN1NFSmptaA$3VB4nvL+NxGUj6ZglUYr7XcXhTlGLxzraas+lZfHKEY', 2),
(7, 'user', 'test2', 'association', 'test2.user@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$RnhqdVA5eVZ1Z2Q3ZS5aMQ$1LNL72KkzBqkN6lrcjLEnoPzNIS5peYasNgrncLn020', 2),
(8, 'user', 'test3', 'cleaning', 'test3user@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$T0tJMVdaWnRUcjM2RmhQcg$AcOYnuAAAZ6YsCSRYFWq8ganyoAwuhlhXkt8tuVA0wM', 1),
(9, 'clement', 'clement', 'admin', 'clement@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$NGxKZE0vYVRhSUV0clVXcQ$9T1rs3mJsAUOwzTMXQBs8xjvvIfnH6eh0o9JYzCFpsA', 1),
(10, 'DROP DATABASE', 'aze', 'admin', 'qsdqsd@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Z2lsQmc1OFp1Wm12cUlwNQ$li+nrrLRNzwNC0wCM4R7huJpqThS/hHSGSWGkVf/F30', 1),
(11, 'qsdqsd', 'qsqsd', 'admin', 'qsdqsd@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$dlRSczFCcUNlZ040cnIyWA$aIhFmpdPfJp25bScAKgIpeyOy8bZ2XqnMyHjqQCXZVE', 1),
(12, 'register', 'test', 'association', 'testregister@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$SldjS3REbFN3OU94YnhtQg$x82I2YvTFrZB3LLGLvKlqQahmmLj083/M78sexAP6hQ', 1),
(13, 'qsdqsd', 'qsdq', 'admin', 'qsdqsd@gmail.co', '$argon2id$v=19$m=65536,t=4,p=1$c2ZPdEJpLndLNHBCb3Y3bw$88wI4w1k6Tr+5PrjErxHArEMbXiGtGIhTsbCcL5iCkw', 1),
(14, 'qsdqsd', 'qsdqsd', 'admin', 'qsdqsd@go', '$argon2id$v=19$m=65536,t=4,p=1$dDJaOGRBWHZ2U203Ykx6Yw$Qly6oDp6ZDWFmbJnReXf2emjUECxqq77h2ygXA1lcnw', 2);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
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
  PRIMARY KEY (`id_reservation`),
  KEY `idx_fk_id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `title`, `end_datetime`, `last_update`, `description`, `id_user`, `type_reservation`, `start_datetime`) VALUES
(9, 'reservation', '2023-12-06 17:15:00', '0000-00-00 00:00:00', 'qsdqsdqsdqsd', 5, 'onetime', '2023-12-06 16:15:00'),
(10, 'recurrent', '2023-12-14 18:16:00', '0000-00-00 00:00:00', 'qsdqsd', 5, 'recurrent', '2023-12-14 15:16:00'),
(11, 'short', '2023-12-05 16:30:00', '2023-12-04 15:31:00', 'recurrent', 5, '2024-01-02T16:30', '2023-12-05 15:25:00'),
(12, 'test', '2023-12-14 15:33:00', '0000-00-00 00:00:00', 'testing', 5, 'recurrent', '2023-12-13 15:33:00'),
(13, 'testrecurendjan', '2023-12-10 18:36:00', '0000-00-00 00:00:00', 'testrecurendjan', 5, '2024-02-25T15:36', '2023-12-10 15:36:00'),
(14, 'onetimenow', '2023-12-12 19:38:00', '0000-00-00 00:00:00', 'qsdqsdqsd', 5, '', '2023-12-12 18:38:00'),
(15, 'qsdqs', '2023-12-07 15:39:00', '0000-00-00 00:00:00', 'dqsdqsd', 5, '', '2023-12-06 15:39:00'),
(16, 'qsdqs', '2023-12-07 15:39:00', '0000-00-00 00:00:00', 'dqsdqsd', 5, 'onetime', '2023-12-06 15:39:00'),
(17, 'qsdqs', '2023-12-07 15:39:00', '0000-00-00 00:00:00', 'dqsdqsd', 5, 'onetime', '2023-12-06 15:39:00'),
(18, 'new reservation', '2023-12-05 18:35:00', '2023-12-04 15:35:42', '3 hours', 5, 'onetime', '2023-12-05 15:46:00'),
(19, 'dqs', '2023-12-08 18:45:00', '0000-00-00 00:00:00', 'qsdqsd', 5, 'onetime', '2023-12-08 16:45:00'),
(20, 'new reservation alix', '2023-12-07 11:15:00', '0000-00-00 00:00:00', 'qshlqkshlqkshfqsf', 5, '2024-01-12T09:15', '2023-12-07 09:15:00'),
(21, 'testapp', '2023-12-23 09:31:00', '0000-00-00 00:00:00', 'qsdfqs\'\'\"&é#', 5, 'onetime', '2023-12-23 09:31:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
