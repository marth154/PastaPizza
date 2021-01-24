<?php

session_start();

require('fonction.php');

if (htmlspecialchars($_POST['pass']) == htmlspecialchars($_POST['conf_pass']))
{
	if($_POST['grade'] != "")
	{
		$add = bdd()->prepare("INSERT INTO utilisateurs (pseudo, password, nom, prenom, grade) VALUES (:pseudo, :pass, :nom, :prenom, :grade)");
		$add->execute(array(
			'pseudo' => htmlspecialchars($_POST['pseudo']),
			'pass' => password_hash($_POST['pass'], PASSWORD_DEFAULT),
			'nom' => strtoupper(htmlspecialchars($_POST['nom'])),
			'prenom' => htmlspecialchars($_POST['prenom']),
			'grade' => $_POST['grade']
		));
	}
}


header('Location: gestion_user.php')
?>