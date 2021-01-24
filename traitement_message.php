<?php

session_start();

require('fonction.php');

$ins = bdd()->prepare('INSERT INTO messages (id_destinataire, nom_destinataire, texte, id_expediteur, nom_expediteur, heure) VALUES (:id_dest, :nom_dest, :texte, :id_exp, :nom_exp, :heure)');

$sel = bdd()->query("SELECT id_utilisateur, pseudo FROM utilisateurs WHERE grade LIKE 'Admin'");

$sel = $sel->fetch();

$ins->execute(array(
	'id_dest' => $sel['id_utilisateur'],
	'nom_dest' => $sel['pseudo'],
	'texte' => htmlspecialchars($_POST['mess']),
	'id_exp' => $_SESSION['id_utilisateur'],
	'nom_exp' => $_SESSION['pseudo'],
	'heure' => date("Y-m-d H:i")
));

header('Location: message_user.php');
?>