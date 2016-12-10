-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Sam 10 Décembre 2016 à 19:04
-- Version du serveur: 5.5.49
-- Version de PHP: 5.6.23-1~dotdeb+7.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `papercut_reloads`
--

-- --------------------------------------------------------

--
-- Structure de la table `reloads`
--

DROP TABLE IF EXISTS `reloads`;
CREATE TABLE IF NOT EXISTS `reloads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tra_id` int(11) NOT NULL,
  `user_mail` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `tra_date` datetime NOT NULL,
  `fetched_by_papercut` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fetched_by_papercut` (`fetched_by_papercut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
