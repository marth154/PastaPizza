<?php

require('fonction.php');

// Reception des données par la méthod GET ainsi que POST
$id_pizza=$_GET['id'];
$nom_ingredient=htmlspecialchars($_POST['nom_ingredient']);
$quantite_ingredient=htmlspecialchars($_POST['quantite_ingredient']);

// Préparation de la requête
$id_ingredient = bdd()->prepare('SELECT id_ingredient FROM ingredients WHERE nom_ingredient = :nom_ingredient');
// Execution de la requete en remplacant les variables nommées
$id_ingredient->execute(array(
	'nom_ingredient' => $nom_ingredient
));

// Boucle tant qu'il y a des données dans l'array de ma requête
while($donnees = $id_ingredient->fetch())
	{
		// Préparation de la requête d'ajout pizza_ingredient en fonction de l'ingredient choisi + la quantité sur la pizza voulue
		$add_pizza_ingredient = bdd()->prepare('INSERT INTO pizza_ingredients (id_pizza, id_ingredient, quantite_ingredient) VALUES (:id_pizza, :id_ingredient, :quantite_ingredient)');
		// Execution de la requete en remplacant les variables nommées
		$add_pizza_ingredient->execute(array(
		'id_pizza' => $id_pizza,
		'id_ingredient' => $donnees['id_ingredient'],
		'quantite_ingredient' => $quantite_ingredient
	));
}

// Retour à la page info_pizza de la pizza en question
header('Location:info_pizza.php?id=' . $id_pizza);