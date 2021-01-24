<?php 

session_start();

require ('fonction.php');

date_default_timezone_set('Europe/Paris');

$date_auj = date("Y-m-d H:i");

if ($_SESSION['remise'] == NULL)
{
    $_SESSION['remise'] = 0;
}

$req = bdd()->prepare("INSERT INTO `commandes`(`date_commande`, `id_client`, note_commande, remise_commande, type_envoi) VALUES (:date_co, :id_client, :note, :remise, :type)");
$req->execute(array(
	'date_co'=> $date_auj,
	'id_client' => $_SESSION['id_client'],
	'note' => htmlspecialchars($_POST['note']),
	'remise' => $_SESSION['remise'],
	'type' => $_POST['type_envoi']
	));

$appel = bdd()->query("SELECT id_commande FROM commandes ORDER BY id_commande");

foreach($appel as $ligne)
{
	$id_commande = $ligne['id_commande'];
}

for($i=0; $i<taillepanier(); $i++)
	{

	$res = bdd()->prepare("INSERT INTO lignes_commandes (id_commande, id_pizza, quantite_commande) VALUES (:id_commande, :id_pizza, :quantite)");
	$res->execute(array(
		'id_commande' => $id_commande,
		'id_pizza' => $_SESSION['panier']['idPizza'][$i],
		'quantite' => $_SESSION['panier']['qttPizza'][$i]));
	}


supprimePanier();

header('Location: index.php');
?>