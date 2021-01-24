<?php

session_start();

require('fonction.php');

date_default_timezone_set('Europe/Paris');

$date_auj = date("Y-m-d H:i");

$up = bdd()->prepare("UPDATE commandes SET date_recup = :date_recup, staff = :id_staff WHERE id_commande = :id");
$up->execute(array(
	'date_recup' => $date_auj,
	'id' => $_GET['id'],
	'id_staff' => $_GET['caissier']));

header('Location: gestion_caissier.php');


?>