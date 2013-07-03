-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 03 Juillet 2013 à 08:18
-- Version du serveur: 5.5.31-0ubuntu0.13.04.1
-- Version de PHP: 5.4.9-4ubuntu2.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `medialibs`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `categoryid` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`categoryid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`categoryid`, `parent_id`, `name`) VALUES
(14, 16, 'Oui oui je sais'),
(15, NULL, 'test cool'),
(16, NULL, 'Coucou moi'),
(17, 16, 'QUoi ?'),
(18, 16, 'Parfait ');

-- --------------------------------------------------------

--
-- Structure de la table `sheets`
--

CREATE TABLE IF NOT EXISTS `sheets` (
  `sheetid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`sheetid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `sheets`
--

INSERT INTO `sheets` (`sheetid`, `title`, `description`) VALUES
(3, 'gros test', 'oui');

-- --------------------------------------------------------

--
-- Structure de la table `sheets_categories`
--

CREATE TABLE IF NOT EXISTS `sheets_categories` (
  `sheetcategorieid` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `sheetid` int(11) NOT NULL,
  PRIMARY KEY (`sheetcategorieid`),
  UNIQUE KEY `unik_assoc` (`categoryid`,`sheetid`),
  KEY `idx_categorieid` (`categoryid`),
  KEY `idx_sheetid` (`sheetid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `sheets_categories`
--

INSERT INTO `sheets_categories` (`sheetcategorieid`, `categoryid`, `sheetid`) VALUES
(2, 15, 3),
(3, 16, 3);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `sheets_categories`
--
ALTER TABLE `sheets_categories`
  ADD CONSTRAINT `sheets_categories_ibfk_1` FOREIGN KEY (`categoryid`) REFERENCES `categories` (`categoryid`) ON DELETE CASCADE,
  ADD CONSTRAINT `sheets_categories_ibfk_2` FOREIGN KEY (`sheetid`) REFERENCES `sheets` (`sheetid`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
