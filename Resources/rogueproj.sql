-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Lun 16 Janvier 2017 à 08:35
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `rogueproj`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `contenu` text,
  `dateCommentaire` timestamp NULL DEFAULT NULL,
  `id_Utilisateur` int(11) DEFAULT NULL,
  `id_News` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `contenu`, `dateCommentaire`, `id_Utilisateur`, `id_News`) VALUES
(45, 'C\'est cool!', '2017-01-13 14:30:00', 5, 2),
(46, 'oiuoiu', '2017-01-14 14:49:26', 7, 2),
(47, 'Hey!', '2017-01-14 14:49:48', 7, 2),
(48, 'First!', '2017-01-14 14:55:04', 7, 1),
(53, 'et là c\'est comment si je mets un ça ou un &lt;em&gt;test&lt;/em&gt;', '2017-01-14 16:32:43', 7, 2),
(54, 'voici un commentaire', '2017-01-14 20:27:07', 7, 2);

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `contenu` text,
  `dateNews` timestamp NULL DEFAULT NULL,
  `id_Utilisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `news`
--

INSERT INTO `news` (`id`, `titre`, `contenu`, `dateNews`, `id_Utilisateur`) VALUES
(1, 'Hello World !', 'The news page is finally working!', '2017-01-12 23:00:00', 6),
(2, 'Premiers artworks du jeu !', '<img src="/resources/characters.png" alt="Image de l\'article"><p>Voici les personnages du jeu! J\'espère qu\'ils pourront bientôt bouger!</p>', '2017-01-13 12:06:55', 6);

-- --------------------------------------------------------

--
-- Structure de la table `niveaux`
--

CREATE TABLE `niveaux` (
  `id` int(11) NOT NULL,
  `jsonNiveau` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `niveaux`
--

INSERT INTO `niveaux` (`id`, `jsonNiveau`) VALUES
(1, NULL),
(2, NULL),
(3, NULL),
(4, NULL),
(5, NULL),
(6, NULL),
(7, NULL),
(8, NULL),
(9, NULL),
(10, NULL),
(11, NULL),
(12, NULL),
(13, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sauvegardes`
--

CREATE TABLE `sauvegardes` (
  `id` int(11) NOT NULL,
  `etatPartie` tinyint(1) NOT NULL,
  `jsonPartie` longtext NOT NULL,
  `datePartie` timestamp NOT NULL,
  `id_Niveau` int(11) DEFAULT NULL,
  `id_Utilisateur` int(11) DEFAULT NULL,
  `perso` text NOT NULL,
  `feu` int(2) NOT NULL,
  `terre` int(2) NOT NULL,
  `eau` int(2) NOT NULL,
  `temps` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `sauvegardes`
--

INSERT INTO `sauvegardes` (`id`, `etatPartie`, `jsonPartie`, `datePartie`, `id_Niveau`, `id_Utilisateur`, `perso`, `feu`, `terre`, `eau`, `temps`) VALUES
(1, 0, '', '2017-01-12 11:04:00', 1, 5, 'mage', 0, 0, 0, 112000),
(2, 1, '', '2017-01-13 11:44:38', 1, 6, 'mage', 0, 0, 0, 102000),
(3, 0, '', '2017-01-12 11:03:31', 1, 7, 'mage', 0, 0, 0, 118000),
(4, 0, '', '2017-01-12 11:03:32', 1, 5, 'mage', 0, 0, 0, 124000),
(5, 0, '', '2017-01-12 11:03:32', 1, 6, 'mage', 0, 0, 0, 94000),
(6, 0, '', '2017-01-12 12:47:33', 2, 5, 'mage', 1, 0, 0, 224000),
(7, 0, '', '2017-01-12 12:47:40', 2, 6, 'mage', 0, 1, 0, 120000),
(8, 0, '', '2017-01-12 12:48:45', 2, 7, 'mage', 1, 0, 0, 170000),
(9, 0, '', '2017-01-12 12:48:52', 2, 5, 'mage', 0, 0, 1, 260000),
(10, 0, '', '2017-01-12 12:49:50', 2, 6, 'mage', 1, 0, 0, 132000),
(11, 0, '', '2017-01-12 12:50:04', 3, 5, 'mage', 1, 0, 0, 360000),
(12, 0, '', '2017-01-12 12:50:19', 4, 6, 'mage', 0, 1, 0, 450000),
(13, 0, '', '2017-01-12 12:50:53', 5, 7, 'mage', 2, 0, 0, 560000),
(14, 0, '', '2017-01-12 12:51:07', 6, 5, 'mage', 0, 0, 2, 675000),
(15, 0, '', '2017-01-12 12:51:17', 7, 7, 'mage', 1, 1, 0, 695000),
(16, 0, '', '2017-01-12 12:51:39', 8, 5, 'mage', 0, 2, 0, 764000),
(18, 0, '', '2017-01-12 12:45:50', 10, 7, 'mage', 3, 0, 0, 995000),
(19, 0, '', '2017-01-12 12:45:37', 11, 5, 'mage', 0, 1, 2, 1242000),
(20, 0, '', '2017-01-12 12:45:22', 12, 6, 'mage', 4, 0, 0, 1223000);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `admin` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `pseudo`, `mail`, `mdp`, `avatar`, `admin`) VALUES
(5, 'Renaud', 'renaud@mail.com', '$2y$10$0K0oY.PgiWmVTP6h65EYy.J8w5uwl0SqdHrDeTuW6p7DgI1l1eKQG', NULL, 0),
(6, 'Fenryl', 'fenryl@mail.com', '$2y$10$DRP5/TPl7g91bZY1QOivaeo4wKK3dyreb0Klc.lSYrR.5Mj97GOP.', NULL, 1),
(7, 'Bastien', 'bastien@mail.com', '$2y$10$lohZBovp9HB77WLrpvvO9.0wcmQi3m13caErJ7WpQ6Dl4awaOsUMu', NULL, 0);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Commentaire_id_Utilisateur` (`id_Utilisateur`),
  ADD KEY `FK_Commentaire_id_News` (`id_News`);

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_News_id_Utilisateur` (`id_Utilisateur`);

--
-- Index pour la table `niveaux`
--
ALTER TABLE `niveaux`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sauvegardes`
--
ALTER TABLE `sauvegardes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Sauvegarde_id_Niveau` (`id_Niveau`),
  ADD KEY `FK_Sauvegarde_id_Utilisateur` (`id_Utilisateur`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `niveaux`
--
ALTER TABLE `niveaux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65466;
--
-- AUTO_INCREMENT pour la table `sauvegardes`
--
ALTER TABLE `sauvegardes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `FK_Commentaire_id_News` FOREIGN KEY (`id_News`) REFERENCES `news` (`id`),
  ADD CONSTRAINT `FK_Commentaire_id_Utilisateur` FOREIGN KEY (`id_Utilisateur`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `FK_News_id_Utilisateur` FOREIGN KEY (`id_Utilisateur`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `sauvegardes`
--
ALTER TABLE `sauvegardes`
  ADD CONSTRAINT `FK_Sauvegarde_id_Niveau` FOREIGN KEY (`id_Niveau`) REFERENCES `niveaux` (`id`),
  ADD CONSTRAINT `FK_Sauvegarde_id_Utilisateur` FOREIGN KEY (`id_Utilisateur`) REFERENCES `utilisateurs` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
