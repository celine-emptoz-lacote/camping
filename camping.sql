-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 25 juin 2020 à 14:17
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `camping`
--

-- --------------------------------------------------------

--
-- Structure de la table `emplacements`
--

DROP TABLE IF EXISTS `emplacements`;
CREATE TABLE IF NOT EXISTS `emplacements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `emplacements`
--

INSERT INTO `emplacements` (`id`, `nom`) VALUES
(1, 'La plage'),
(2, 'Les pins'),
(3, 'Le Maquis');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `debut` date NOT NULL,
  `fin` date NOT NULL,
  `type` int(11) NOT NULL,
  `emplacement` varchar(255) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `option_1` varchar(255) DEFAULT '',
  `option_2` varchar(255) DEFAULT '',
  `option_3` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `debut`, `fin`, `type`, `emplacement`, `id_utilisateur`, `option_1`, `option_2`, `option_3`) VALUES
(59, '2020-06-25', '2020-06-26', 1, 'La plage', 3, 'borne', 'disco', 'pack'),
(60, '2020-06-24', '2020-06-24', 1, 'La plage', 3, '', '', 'pack'),
(61, '2020-06-24', '2020-06-24', 1, 'La plage', 3, '', '', 'pack'),
(62, '2020-06-23', '2020-06-24', 1, 'La plage', 0, 'borne', '', ''),
(63, '2020-08-31', '2020-09-06', 2, 'Le Maquis', 3, 'borne', 'disco', 'pack'),
(64, '2020-08-18', '2020-08-23', 1, 'Les pins', 3, 'borne', 'disco', 'pack'),
(66, '2020-06-29', '2020-07-05', 2, 'Le Maquis', 5, 'borne', 'disco', 'pack'),
(67, '2020-06-29', '2020-07-05', 2, 'Le Maquis', 5, 'borne', 'disco', 'pack'),
(58, '2020-06-24', '2020-06-24', 1, 'La plage', 3, '', '', 'pack'),
(57, '2020-06-29', '2020-07-05', 2, 'Les pins', 3, 'borne', 'disco', 'pack'),
(56, '2020-06-29', '2020-07-05', 2, 'La plage', 3, 'borne', 'disco', 'pack'),
(65, '2020-06-29', '2020-07-05', 2, 'Les pins', 3, 'borne', 'disco', 'pack');

-- --------------------------------------------------------

--
-- Structure de la table `tarifs`
--

DROP TABLE IF EXISTS `tarifs`;
CREATE TABLE IF NOT EXISTS `tarifs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prix` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tarifs`
--

INSERT INTO `tarifs` (`id`, `nom`, `prix`) VALUES
(1, 'borne', 2),
(2, 'disco ', 17),
(4, 'emplacement', 10),
(3, 'pack', 30);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `statut` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`, `statut`) VALUES
(2, 'coco', '$2y$12$bvVgWhRbdzwTVMmuPd55VObfyZLawWuJUfxvpDyrWw1bftDnq5Svq', 'utilisateur'),
(3, 'user_admin', '$2y$12$ug8e8CFTwjPkhP6.hEMWBu1JWipsBbsvCnTsx6bZiOKwwoIFpr3mm', 'administrateur'),
(4, 'user_test', '$2y$12$szDNl7mrpMHXegrl6LFbW.JtQ0dqwyz48qMOGGuCTCbr4kSZKZMlS', 'utilisateur'),
(5, 'admin', '$2y$10$O3h5mpwqliKkmGDWPtu1zujdKWVehDLFgmzrFvJbKJhpQscfnFiKi', 'administrateur');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
