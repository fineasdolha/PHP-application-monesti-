-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 29, 2023 at 02:17 PM
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
  `id_reservation` smallint UNSIGNED NOT NULL,
  `id_user` smallint UNSIGNED NOT NULL,
  `destination` varchar(100) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_comment`),
  UNIQUE KEY `idx_fk_id_user` (`id_user`),
  KEY `idx_fk_id_reservation` (`id_reservation`),
  KEY `idx_fk_id_comment` (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  PRIMARY KEY (`id_intervention`),
  KEY `idx_fk_id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `type_reservation` varchar(50) NOT NULL,
  `id_user` smallint NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reservation`),
  KEY `idx_fk_id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
