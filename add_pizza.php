<?php

require('fonction.php');

// Imporation des données depuis le formulaire d'ajout de pizza
$nom_pizza = htmlspecialchars($_POST['nom_pizza']);
$taille_pizza = htmlspecialchars($_POST['taille_pizza']);
$prix_pizza = htmlspecialchars($_POST['prix_pizza']);

// Préparation de la requête SQL d'ajout de pizza
$add_pizza = bdd()->prepare('INSERT INTO `pizzas`(`nom_pizza`, `taille_pizza`, `prix_pizza`, image) VALUES (:nom_pizza, :taille_pizza, :prix_pizza, :image)');

// Execution de la requête en remplaçant les variables nommées par les données ci-dessus
$add_pizza->execute(array(
	'nom_pizza' => $nom_pizza,
	'taille_pizza' => $taille_pizza,
	'prix_pizza' => $prix_pizza,
	'image' => $_POST['fic']
	));

// Retour sur la page admin.php
header('Location:gestion_pizza.php');