<?php

session_start();

require('fonction.php');

$sel = bdd()->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :id");
$sel->execute(array('id' => $_GET['bannis']));
$user = $sel->fetch();


$ins = bdd()->prepare('INSERT INTO bannis (pseudo_bannis, id_utilisateur, nom_bannis, prenom_bannis) VALUES (:pseudo, :id, :nom, :prenom)');

$ins->execute(array(
	'pseudo' => $user['pseudo'],
	'id' => $user['id_utilisateur'],
	'nom' => $user['nom'],
	'prenom' => $user['prenom']));

$supp = bdd()->prepare('DELETE FROM utilisateurs WHERE pseudo LIKE :pseudo');
$supp->execute(array('pseudo' => $user['pseudo']));

header('Location: gestion_user.php');


?>