-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 23 oct. 2023 à 18:01
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `loufok`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id_administrateur` int(11) NOT NULL,
  `ad_mail_administrateur` varchar(50) NOT NULL,
  `mot_de_passe_administrateur` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id_administrateur`, `ad_mail_administrateur`, `mot_de_passe_administrateur`) VALUES
(1, 'admin@gmail.com', '1234');

-- --------------------------------------------------------

--
-- Structure de la table `contribution`
--

CREATE TABLE `contribution` (
  `id_contribution` int(11) NOT NULL,
  `id_loufokerie` int(11) NOT NULL,
  `id_joueur` int(11) NOT NULL,
  `id_administrateur` int(11) NOT NULL,
  `texte_contribution` varchar(280) NOT NULL,
  `date_soumission` datetime NOT NULL,
  `ordre_soumission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contribution_aleatoire`
--

CREATE TABLE `contribution_aleatoire` (
  `id_joueur` int(11) NOT NULL,
  `id_loufokerie` int(11) NOT NULL,
  `num_contribution` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE `joueur` (
  `id_joueur` int(11) NOT NULL,
  `nom_plume` varchar(50) NOT NULL,
  `ad_mail_joueur` varchar(50) NOT NULL,
  `sexe` tinyint(1) NOT NULL,
  `ddn` date NOT NULL,
  `mot_de_passe_joueur` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`id_joueur`, `nom_plume`, `ad_mail_joueur`, `sexe`, `ddn`, `mot_de_passe_joueur`) VALUES
(1, 'user', 'user@gmail.com', 1, '2013-10-02', '1234');

-- --------------------------------------------------------

--
-- Structure de la table `loufokerie`
--

CREATE TABLE `loufokerie` (
  `id_loufokerie` int(11) NOT NULL,
  `id_administrateur` int(11) NOT NULL,
  `titre_loufokerie` varchar(50) DEFAULT NULL,
  `date_debut_loufokerie` date NOT NULL,
  `date_fin_loufokerie` date NOT NULL,
  `nb_contributions` int(11) DEFAULT NULL,
  `nb_jaime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id_administrateur`);

--
-- Index pour la table `contribution`
--
ALTER TABLE `contribution`
  ADD PRIMARY KEY (`id_contribution`),
  ADD KEY `id_joueur` (`id_joueur`),
  ADD KEY `id_administrateur` (`id_administrateur`);

--
-- Index pour la table `contribution_aleatoire`
--
ALTER TABLE `contribution_aleatoire`
  ADD KEY `num_contribution` (`num_contribution`),
  ADD KEY `contribution_aleatoire_ibfk_1` (`id_joueur`),
  ADD KEY `contribution_aleatoire_ibfk_2` (`id_loufokerie`);

--
-- Index pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD PRIMARY KEY (`id_joueur`);

--
-- Index pour la table `loufokerie`
--
ALTER TABLE `loufokerie`
  ADD PRIMARY KEY (`id_loufokerie`),
  ADD KEY `id_administrateur` (`id_administrateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id_administrateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `contribution`
--
ALTER TABLE `contribution`
  MODIFY `id_contribution` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `joueur`
--
ALTER TABLE `joueur`
  MODIFY `id_joueur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `loufokerie`
--
ALTER TABLE `loufokerie`
  MODIFY `id_loufokerie` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contribution`
--
ALTER TABLE `contribution`
  ADD CONSTRAINT `contribution_ibfk_1` FOREIGN KEY (`id_contribution`) REFERENCES `loufokerie` (`id_loufokerie`),
  ADD CONSTRAINT `contribution_ibfk_2` FOREIGN KEY (`id_joueur`) REFERENCES `joueur` (`id_joueur`),
  ADD CONSTRAINT `contribution_ibfk_3` FOREIGN KEY (`id_administrateur`) REFERENCES `administrateur` (`id_administrateur`);

--
-- Contraintes pour la table `contribution_aleatoire`
--
ALTER TABLE `contribution_aleatoire`
  ADD CONSTRAINT `contribution_aleatoire_ibfk_1` FOREIGN KEY (`id_joueur`) REFERENCES `joueur` (`id_joueur`) ON DELETE CASCADE,
  ADD CONSTRAINT `contribution_aleatoire_ibfk_2` FOREIGN KEY (`id_loufokerie`) REFERENCES `loufokerie` (`id_loufokerie`) ON DELETE CASCADE;

--
-- Contraintes pour la table `loufokerie`
--
ALTER TABLE `loufokerie`
  ADD CONSTRAINT `loufokerie_ibfk_1` FOREIGN KEY (`id_administrateur`) REFERENCES `administrateur` (`id_administrateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
