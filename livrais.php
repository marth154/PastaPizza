<?php

session_start();

require('fonction.php');

date_default_timezone_set('Europe/Paris');

$date_auj = date("Y-m-d H:i");

$up = bdd()->prepare("UPDATE commandes SET date_livraison = :date_livrais, staff = :id_staff WHERE id_commande = :id");
$up->execute(array(
	'date_livrais' => $date_auj,
	'id' => $_GET['id'],
	'id_staff' => $_GET['livreur']));

header('Location: gestion_livraison.php');


?>