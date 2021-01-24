-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 02 Avril 2019 à 17:47
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bddpizzas_finale`
--

-- --------------------------------------------------------

--
-- Structure de la table `bannis`
--

CREATE TABLE `bannis` (
  `id_bannis` int(11) NOT NULL,
  `pseudo_bannis` varchar(255) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `nom_bannis` varchar(255) NOT NULL,
  `prenom_bannis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `bannis`
--

INSERT INTO `bannis` (`id_bannis`, `pseudo_bannis`, `id_utilisateur`, `nom_bannis`, `prenom_bannis`) VALUES
(4, 'qsd', 19, 'QSD', 'qsd');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id_client` int(11) NOT NULL,
  `nom_client` varchar(255) NOT NULL,
  `prenom_client` varchar(255) NOT NULL,
  `telephone_client` varchar(255) NOT NULL,
  `adresse_client` varchar(255) NOT NULL,
  `note_client` varchar(255) DEFAULT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`id_client`, `nom_client`, `prenom_client`, `telephone_client`, `adresse_client`, `note_client`, `id_utilisateur`) VALUES
(17, 'JM', 'jm', '0123456789', 'avenue', '', 18),
(26, 'AZE', 'aze', '0123456789', 'aze', NULL, 33);

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id_commande` int(11) NOT NULL,
  `date_commande` datetime NOT NULL,
  `date_livraison` datetime DEFAULT NULL,
  `date_recup` datetime DEFAULT NULL,
  `preparer` tinyint(1) NOT NULL DEFAULT '0',
  `remise_commande` int(11) DEFAULT NULL,
  `note_commande` text,
  `type_envoi` varchar(255) NOT NULL,
  `id_client` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `commandes`
--

INSERT INTO `commandes` (`id_commande`, `date_commande`, `date_livraison`, `date_recup`, `preparer`, `remise_commande`, `note_commande`, `type_envoi`, `id_client`) VALUES
(1, '2019-04-02 19:15:00', NULL, NULL, 0, 0, '', 'A Livrer', 17);

-- --------------------------------------------------------

--
-- Structure de la table `ingredients`
--

CREATE TABLE `ingredients` (
  `id_ingredient` int(11) NOT NULL,
  `nom_ingredient` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ingredients`
--

INSERT INTO `ingredients` (`id_ingredient`, `nom_ingredient`) VALUES
(2, 'mozzarella'),
(3, 'boulette_de_boeuf'),
(4, 'champignon'),
(5, 'oignon'),
(6, 'poivron'),
(7, 'jambon'),
(8, 'merguez'),
(9, 'pomme_de_terre'),
(10, 'poivre'),
(14, 'viande_hache');

-- --------------------------------------------------------

--
-- Structure de la table `lignes_commandes`
--

CREATE TABLE `lignes_commandes` (
  `id_commande` int(11) NOT NULL,
  `id_pizza` int(11) NOT NULL,
  `quantite_commande` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `lignes_commandes`
--

INSERT INTO `lignes_commandes` (`id_commande`, `id_pizza`, `quantite_commande`) VALUES
(1, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `pizzas`
--

CREATE TABLE `pizzas` (
  `id_pizza` int(11) NOT NULL,
  `nom_pizza` varchar(255) NOT NULL,
  `taille_pizza` varchar(255) NOT NULL,
  `prix_pizza` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pizzas`
--

INSERT INTO `pizzas` (`id_pizza`, `nom_pizza`, `taille_pizza`, `prix_pizza`, `image`) VALUES
(1, 'DELUXE', 'Medium', 12, 'pepperoni.png'),
(2, 'DELUXE', 'Large', 16, 'pepperoni.png'),
(3, 'ORIENTALE', 'Medium', 12, 'pizza3.png'),
(4, 'ORIENTALE', 'Large', 16, 'pizza3.png'),
(5, 'REINE', 'Medium', 12, 'pizza2.png'),
(6, 'REINE', 'Large', 16, 'pizza2.png'),
(7, 'PEPPER BEEF', 'Medium', 15, 'pizza4.png'),
(9, 'PEPPER BEEF', 'Large', 16, 'pizza4.png'),
(12, 'BARBECUE', 'Medium', 12, 'pizza.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `pizza_ingredients`
--

CREATE TABLE `pizza_ingredients` (
  `id_pizza` int(11) NOT NULL,
  `id_ingredient` int(11) NOT NULL,
  `quantite_ingredient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pizza_ingredients`
--

INSERT INTO `pizza_ingredients` (`id_pizza`, `id_ingredient`, `quantite_ingredient`) VALUES
(1, 2, 50),
(2, 2, 75),
(3, 2, 50),
(4, 2, 75),
(5, 2, 50),
(6, 2, 75),
(7, 2, 50),
(1, 3, 80),
(2, 3, 100),
(7, 3, 80),
(2, 4, 50),
(5, 4, 30),
(6, 4, 50),
(1, 5, 30),
(2, 5, 50),
(3, 5, 30),
(4, 5, 50),
(7, 5, 30),
(1, 6, 30),
(2, 6, 50),
(3, 6, 30),
(4, 6, 50),
(5, 7, 80),
(6, 7, 100),
(3, 8, 40),
(4, 8, 50),
(7, 9, 60),
(7, 10, 4);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `pseudo`, `password`, `prenom`, `nom`, `grade`) VALUES
(16, 'admin', '$2y$10$9nJeww67213.UzQAwOntd.yD2eXhdnksKlp7KzNryl86rJ5ZfQysu', 'admin', 'ADMIN', 'Admin'),
(18, 'jm', '$2y$10$ARUZWLylBHABldtpeWcNIOfyJgvDy0eCWbbHJpJri/py7R5CFb5yO', 'jm', 'JM', 'utilisateur'),
(21, 'livreur', '$2y$10$OsdUA/w6VxqHwcAYimMntOs/TGG42bafSYCGchiDBNHchdVu60U3m', 'livreur', 'LIVREUR', 'Livreur'),
(22, 'caissier', '$2y$10$R8kzHo8Fa4SIPjIoEtl2OO2OahdG0VOke8fvI1C2KbOIeLRRWvGcS', 'caissier', 'CAISSIER', 'Caissier'),
(29, 'cuisine', '$2y$10$CN14MTjYS2Zf1B8JsoKPiuHvMCkLF7/aAlkevXENVARNRQu.Iookm', 'cuisine', 'cuisine', 'Cuisinier'),
(33, 'aze', '$2y$10$xtFp0dtPBVrGiTMswdweROpZSzUYuRJ0x7QRqDtVfV2gyQ3Rc53EK', 'aze', 'AZE', 'utilisateur');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `bannis`
--
ALTER TABLE `bannis`
  ADD PRIMARY KEY (`id_bannis`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id_ingredient`);

--
-- Index pour la table `lignes_commandes`
--
ALTER TABLE `lignes_commandes`
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_pizza` (`id_pizza`);

--
-- Index pour la table `pizzas`
--
ALTER TABLE `pizzas`
  ADD PRIMARY KEY (`id_pizza`);

--
-- Index pour la table `pizza_ingredients`
--
ALTER TABLE `pizza_ingredients`
  ADD KEY `id_pizza` (`id_pizza`),
  ADD KEY `id_ingredient` (`id_ingredient`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `bannis`
--
ALTER TABLE `bannis`
  MODIFY `id_bannis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id_ingredient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `pizzas`
--
ALTER TABLE `pizzas`
  MODIFY `id_pizza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`) ON DELETE CASCADE;

--
-- Contraintes pour la table `lignes_commandes`
--
ALTER TABLE `lignes_commandes`
  ADD CONSTRAINT `lignes_commandes_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commandes` (`id_commande`) ON DELETE CASCADE,
  ADD CONSTRAINT `lignes_commandes_ibfk_2` FOREIGN KEY (`id_pizza`) REFERENCES `pizzas` (`id_pizza`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pizza_ingredients`
--
ALTER TABLE `pizza_ingredients`
  ADD CONSTRAINT `pizza_ingredients_ibfk_1` FOREIGN KEY (`id_pizza`) REFERENCES `pizzas` (`id_pizza`) ON DELETE CASCADE,
  ADD CONSTRAINT `pizza_ingredients_ibfk_2` FOREIGN KEY (`id_ingredient`) REFERENCES `ingredients` (`id_ingredient`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
