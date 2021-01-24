<?php

session_start();

require('fonction.php');


$del = bdd()->prepare("DELETE FROM utilisateurs WHERE pseudo LIKE :pseudo");
$del->execute(array("pseudo" => $_SESSION['pseudo']));

header('Location: deconnexion.php');