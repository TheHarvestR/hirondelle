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
-- Contenu de la table `actualites`
--

INSERT INTO `actualites` (`id`, `news_date`, `news_titre`, `news_texte`, `news_afficher`, `news_afficher_archive`, `news_lien`, `news_lien_externe`) VALUES
(2, '2016-09-10', 'Journées Européennes du Patrimoine 2016', 'Nous vous invitons à découvrir l\'Hirondelle - Le Bien Gagné à l\'occasion des Journées Européennes du Patrimoine les 17 et 18 septembre 2016.', 1, 0, NULL, 0),
(3, '2016-07-15', 'L\'Hirondelle à l\'honneur', 'L\'Hidondelle à l\'honneur sur la page Facebook officielle de l\'Office de Tourisme de Conflans-Ste-Honorine.', 1, 0, 'https://www.facebook.com/permalink.php?story_fbid=10153844126302017&id=304543412016', 1),
(4, '2016-07-14', 'VAC juillet-août 2016', 'Un article sur l\'Hirondelle - Le Bien Gagné dans le magazine VAC (Vivre À Conflans) de juillet-août 2016', 1, 0, 'http://www.ponton-hirondelle.com/presse.html', 0),
(5, '2016-07-13', 'Cinéma', 'Un ponton similaire à l\'Hirondelle - Le Bien Gagné apparaît dans un film de Claude Autant-Lara de 1947.', 0, 1, 'http://www.ponton-hirondelle.com/presse.html#anchor-1947', 0),
(6, '2016-09-10', 'Crue de juin 2016', 'La crue de la Seine vue du ponton Hirondelle - Le Bien Gagné.', 1, 0, 'http://www.ponton-hirondelle.com/galerie2.html#anchor-crue2016', 0),
(7, '2016-07-12', 'Evénement à Conflans', 'Le Pardon de la Batellerie aura lieu à Conflans du 17 au 19 juin 2016.', 0, 1, 'http://www.conflans-sainte-honorine.fr/pardon-national-de-batellerie/', 1),
(8, '2016-07-11', 'De retour du chantier naval', 'Après avoir vu sa coque révisée et repeinte, le ponton est rentré du chantier naval d\'Achères et a retrouvé son emplacement habituel.', 0, 1, 'http://www.ponton-hirondelle.com/galerie3.html', 0),
(9, '2015-07-06', 'Monument historique !', 'L\'Hirondelle - Le Bien Gagné a obtenu le classement national au titre des Monuments Historiques délivré par le Ministère de la Culture en date du 6 juillet 2015', 0, 1, 'http://www.ponton-hirondelle.com/historique2.html#anchor-Classement', 0),
(18, '2016-09-19', 'Brouillon modifié', 'Ceci est un brouillon de test modifié', 0, 0, 'www.gmail.com', 1);

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
