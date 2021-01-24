<?php

session_start();

require('fonction.php');

$ins = bdd()->prepare("UPDATE `clients` SET `note_client`= :message WHERE `id_client` = :id");
$ins->execute(array(
	'message' => htmlspecialchars($_POST['note']),
	'id' => $_SESSION['id_utilisateur']['note']));

$_SESSION['id_utilisateur']['note'] = array();
header('Location: gestion_user.php');