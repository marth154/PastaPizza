<?php

session_start();

require('fonction.php');

$up = bdd()->prepare("UPDATE commandes SET preparer = :preparer WHERE id_commande = :id");
$up->execute(array(
	'preparer' => '1',
	'id' => $_GET['id']));

header('Location: gestion_cuisine.php');


?>