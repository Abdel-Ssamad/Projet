-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 11 avr. 2022 à 17:57
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `asr_tech`
--

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `products` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `products`, `price`, `date`) VALUES
(1, 1, '1', 250, '2021-06-07 11:55:03'),
(2, 1, '2,1,3', 600, '2021-06-07 15:26:12'),
(3, 1, '2', 150, '2022-02-21 16:30:00');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` enum('developer','graphic','editor') COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `description`, `price`, `thumb`) VALUES
(1, 'Eric', 'developer', 'Passionné depuis toujours par les nouvelles technologies et le web, \r\nSérieux et investi dans chacun de mes projets, ouvert à tout langage de programmation,\r\nJe suis à la recherche de tout projet à partir de maintenant.', 250, 'eric-cod'),
(2, 'Samy', 'editor', 'Amoureux de la vidéo, je met à votre service mon savoir faire :\r\nMonteur truquiste,\r\nFormateur sur Final Cut Pro X, Premiere Pro CC, DaVinci Resolve et Media Composer.\r\n', 150, 'samy-mov'),
(3, 'Caroline', 'graphic', 'Autonome et organisée je vous met a disposition mes compétences : \r\n\r\n- création des newsletters hebdomadaire\r\n- retouche et recadrage d’images\r\n- création de visuels pour le site : bannière et push homepage/catégories\r\n- création de contenus pour les réseaux sociaux (animés et statiques)\r\n- création de visuels pour le display dans le respect des différentes contraintes\r\n-  Mise en scène des produits : aide à la création de looks pour les shootings produits)\r\n\r\n', 200, 'caroline-gra');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT '',
  `password` varchar(255) NOT NULL,
  `birthday` varchar(255) NOT NULL,
  `admin` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `mail`, `phone`, `password`, `birthday`, `admin`) VALUES
(1, 'Abdelssamad', 'Bendahou', 'Batou@gmail.com', '', 'abdelSsamad5', '16-06-1999', '0'),
(9, 'BITOUT', 'djenad', 'steph@gmail.com', '0651406538', 'grdggdgrd', '13-03-2000', '0'),
(8, 'BITOUT', 'djenad', 'bichfbh@gmail.com', '0651406538', 'sazdgh', '13-02-2001', '0');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
