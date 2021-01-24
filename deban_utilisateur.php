<?php

session_start();

require('fonction.php');

$sel = bdd()->prepare("SELECT id_bannis FROM bannis WHERE id_bannis = :id");
$sel->execute(array('id' => $_GET['bannis']));
$user = $sel->fetch();

$supp = bdd()->prepare('DELETE FROM bannis WHERE id_bannis = :id');
$supp->execute(array('id' => $user['id_bannis']));

header('Location: gestion_user.php'); 

?>