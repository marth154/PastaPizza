<?php

require('fonction.php');

// Importation des données depuis le formulaire de modification
$nom_ingredient = htmlspecialchars($_POST['nom_ingredient']);
$nom_ingredient_modif = htmlspecialchars($_POST['nom_ingredient_modif']);

// Preparation de la requête pour modifier un ingrédient
$modif_pizza = bdd()->prepare('UPDATE `ingredients` SET `nom_ingredient` = :nom_ingredient_modif WHERE `nom_ingredient` LIKE :nom_ingredient');

// Execution de la modification du nom de l'ingrédient
$modif_pizza->execute(array(
	'nom_ingredient' => $nom_ingredient,
	'nom_ingredient_modif' => $nom_ingredient_modif
));

// Retour vers la page admin
header('Location:gestion_pizza.php');