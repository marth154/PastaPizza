<?php

session_start();

require('fonction.php');

$sel = bdd()->prepare("SELECT password FROM utilisateurs WHERE pseudo LIKE :pseudo");
$sel->execute(array('pseudo' => htmlspecialchars($_POST['pseudo'])));
$sel = $sel->fetch();

$valid_mdp = password_verify(htmlspecialchars($_POST['pass']), $sel['password']);
if ($valid_mdp)
{
	$up = bdd()->prepare("UPDATE clients SET nom_client = :nom, prenom_client = :prenom, telephone_client = :tel, adresse_client = :add WHERE id_client = :id");
	$up->execute(array(
		'nom' => htmlspecialchars($_POST['nom']),
		'prenom' => htmlspecialchars($_POST['prenom']),
		'tel' => htmlspecialchars($_POST['tel']),
		'add' => htmlspecialchars($_POST['add']),
		'id' => $_SESSION['id_client']
	));

	$up2 = bdd()->prepare("UPDATE utilisateurs SET pseudo = :pseudo, prenom = :prenom, nom = :nom WHERE id_utilisateur = :id");
	$up2->execute(array(
		'nom' => htmlspecialchars($_POST['nom']),
		'prenom' => htmlspecialchars($_POST['prenom']),
		'pseudo' => htmlspecialchars($_POST['pseudo']),
		'id' => $_SESSION['id_utilisateur']
	));
}


header('Location: compte_user.php');

?>