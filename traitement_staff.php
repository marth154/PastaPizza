<?php

session_start();

require('fonction.php');

$ins = bdd()->prepare("UPDATE utilisateurs SET pseudo = :pseudo, prenom = :prenom, nom = :nom, grade = :grade WHERE id_utilisateur = :id");
$ins->execute(array(
	'pseudo' => htmlspecialchars($_POST['pseudo']),
	'prenom' => htmlspecialchars($_POST['prenom']),
	'nom' => htmlspecialchars($_POST['nom']),
	'grade' => htmlspecialchars($_POST['grade']),
	'id' => $_GET['staff']));


header('Location: gestion_user.php');

?>