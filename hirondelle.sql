-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 23 Septembre 2016 à 17:42
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `hr_news`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualites`
--

CREATE TABLE `actualites` (
  `id` int(11) NOT NULL,
  `news_date` date NOT NULL,
  `news_titre` varchar(255) DEFAULT NULL,
  `news_texte` text NOT NULL,
  `news_afficher` tinyint(1) NOT NULL DEFAULT '0',
  `news_afficher_archive` tinyint(1) NOT NULL DEFAULT '0',
  `news_lien` varchar(255) DEFAULT NULL,
  `news_lien_externe` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déclencheurs `actualites`
--
DELIMITER $$
CREATE TRIGGER `before_insert_news` BEFORE INSERT ON `actualites` FOR EACH ROW BEGIN
	IF NEW.news_afficher = 1 THEN 
    	SET NEW.news_afficher_archive = 0;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_news` BEFORE UPDATE ON `actualites` FOR EACH ROW BEGIN
	IF NEW.news_afficher = 1 THEN 
    	SET NEW.news_afficher_archive = 0;
    END IF;
END
$$
DELIMITER ;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `actualites`
--
ALTER TABLE `actualites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `i_date` (`news_date`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `actualites`
--
ALTER TABLE `actualites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
