<?php

session_start();

require('fonction.php');

$ins = bdd()->prepare("DELETE FROM utilisateurs WHERE id_utilisateur = :id");
$ins->execute(array(
	'id' => $_GET['staff']));


header('Location: gestion_user.php');

?>