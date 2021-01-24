<?php

require('fonction.php');

// Reception des données par méthod POST
$id_pizza=$_GET['id'];
$nom_ingredient=$_GET['nom_ingredient'];

// Préparation de la requete qui selectionne l'ID ingredient pdeuis la table ingrédient par rapport au nom
$id_ingredient = bdd()->prepare('SELECT id_ingredient FROM ingredients WHERE nom_ingredient = :nom_ingredient');
// Execution de la requete en remplacant les variables nommées
$id_ingredient->execute(array(
	'nom_ingredient' => $nom_ingredient
));

// Boucle tant qu'il y a des données dans mon array de requete
while($donnees = $id_ingredient->fetch())
	{
		// Suppresion du pizza_ingredient voulu en fonction de l'ID pizza, l'ID ingredient
		$del_pizza_ingredient = bdd()->prepare('DELETE FROM pizza_ingredients WHERE id_pizza = :id_pizza AND id_ingredient = :id_ingredient');
		$del_pizza_ingredient->execute(array(
			'id_pizza' => $id_pizza,
			'id_ingredient' => $donnees['id_ingredient']
		));
	}

// Retour vers la page info.pizza de la pizza en question
header('Location:info_pizza.php?id=' . $id_pizza);