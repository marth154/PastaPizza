<?php

require('fonction.php');

// Importation de la donnée nom_ingredient dans une variable
 $nom_ingredient = htmlspecialchars($_POST['nom_ingredient']);

 // Preparation à la requête SQL permettant d'ajout un ingrédient
 $add_ingredient = bdd() -> prepare('INSERT INTO `ingredients`(`nom_ingredient`) VALUES (:nom_ingredient)');

 // Execution de la requête en remplaçant les variables nommées par les données ci-dessus
 $add_ingredient->execute(array(
 	'nom_ingredient' => $nom_ingredient
 ));

 // Puis renvoie sur la page admin
header('Location:gestion_pizza.php');