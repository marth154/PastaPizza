<?php

require('fonction.php');

// Importation des données par le fomulaire de suppression
$id_pizza=$_GET['id'];

// Préparation de la requête SQL de suppresion de pizza
$del_pizza = bdd()->prepare('DELETE FROM pizzas WHERE id_pizza = :id_pizza');

// Execution de la requête en remplaçant les variables nommées par les données importés au-dessus
$del_pizza->execute(array(
	'id_pizza' => $id_pizza
));

// Puis renvoie sur la page admin
header('Location:gestion_pizza.php');