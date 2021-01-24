<?php

session_start();

require('fonction.php');

// Reception de l'ID de pizza en question par la méthod GET
$id_pizza=$_GET['id'];

// Importation des données depuis le formulaire de modification
$nom_pizza = htmlspecialchars($_POST['nom_pizza']);
$taille_pizza = htmlspecialchars($_POST['taille_pizza']);
$prix_pizza = htmlspecialchars($_POST['prix_pizza']);


// Préparation de la requette pour mettre à jour le nom de la pizza
$nom_pizza_upd = bdd()->prepare('UPDATE pizzas SET nom_pizza = :nom_pizza WHERE id_pizza = :id_pizza');
// Execution de la requete en remplaçant les variables nommées
$nom_pizza_upd->execute(array(
	'nom_pizza' => $nom_pizza,
	'id_pizza' => $id_pizza
));

// Préparation de la requette pour mettre à jour la taille de la pizza
$taille_pizza_upd = bdd()->prepare('UPDATE pizzas SET taille_pizza = :taille_pizza WHERE id_pizza = :id_pizza');
// Execution de la requete en remplaçant les variables nommées
$taille_pizza_upd->execute(array(
	'taille_pizza' => $taille_pizza,
	'id_pizza' => $id_pizza
));

// Préparation de la requette pour mettre à jour le prix de la pizza
$prix_pizza_upd = bdd()->prepare('UPDATE pizzas SET prix_pizza = :prix_pizza WHERE id_pizza = :id_pizza');
// Execution de la requete en remplaçant les variables nommées
$prix_pizza_upd->execute(array(
	'prix_pizza' => $prix_pizza,
	'id_pizza' => $id_pizza
));

// Préparation de la requête pour selectioner le prix de la pizza
// $pizza_prix = bdd()->prepare('SELECT prix_pizza FROM pizzas WHERE id_pizza = :idpizza');
// $pizza_prix->execute(array(
// 	'idpizza' => $id_pizza
// ));

// Préparation de la requête pour prendre la totalité des données dans la tables pizzas
$res = bdd()->prepare('SELECT * FROM pizza_ingredients AS PI INNER JOIN pizzas AS P ON P.id_pizza = PI.id_pizza INNER JOIN ingredients AS I ON I.id_ingredient = PI.id_ingredient WHERE PI.id_pizza = :id_pizza');
// Execution de la requête en remplacant les variables nommées
$res->execute(array(
	'id_pizza' => $id_pizza
));

// Boucle d'UPDATE tant que l'array $res n'est pas vide
while ($ingredients = $res->fetch())
{
	// UPDATE individuel de chaque ingrédient (Préparation)
	$query = bdd()->prepare('UPDATE pizza_ingredients SET quantite_ingredient = :quantite_ingredient WHERE id_pizza = :id_pizza AND id_ingredient = :id_ingredient');

	// Execution de la requete en remplacant les variables nommées
	$query->execute(array(
		'quantite_ingredient' => $_POST[$ingredients['nom_ingredient']],
		'id_pizza' => $id_pizza,
		'id_ingredient' => $ingredients['id_ingredient']
	));
}

// Retour à la page info.pizza de la pizza en question
header('Location:info_pizza.php?id=' . $id_pizza);
?>