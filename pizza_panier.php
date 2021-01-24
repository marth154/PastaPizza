<?php

require('fonction.php');

session_start(); // On démarre la session AVANT toute chose

$id_pizza = $_GET['id'];

$quant = htmlspecialchars($_POST['quant']);

ajoutArticle($id_pizza, $quant);

header('Location: index.php');

?>