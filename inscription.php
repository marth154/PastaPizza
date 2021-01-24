<?php

require('fonction.php');

// Importation des données sous forme de variable avec la méthode POST + htmlspecialchars pour empêcher les failles XSS
$pseudo = htmlspecialchars($_POST['pseudo']);
$mdp = htmlspecialchars($_POST['mdp']);
$conf_mdp = htmlspecialchars($_POST['conf_mdp']);
$nom = strtoupper(htmlspecialchars($_POST['nom']));
$prenom = htmlspecialchars($_POST['prenom']);
$adresse = htmlspecialchars($_POST['adresse']);
$telephone = htmlspecialchars($_POST['num_tel']);


// On créer notre tableau SESSION
$_SESSION['pseudo'] = htmlspecialchars($_POST['pseudo']);
$_SESSION['mdp'] = htmlspecialchars($_POST['mdp']);
$_SESSION['prenom'] = htmlspecialchars($_POST['prenom']);
$_SESSION['nom'] = htmlspecialchars($_POST['nom']);

//Vérification d'un pseudo en doublon
$reponseA = bdd()->query('SELECT DISTINCT pseudo FROM utilisateurs'); 

foreach ($reponseA as $line) 
{
	if ($line['pseudo'] == $pseudo)
	{
		echo "Désolé mais ce pseudonyme est déjà existant, veuillez en choisir un autre";
		echo '<a href="index.php">S\'inscrire</a>';
	}
}

$ban = bdd()->query("SELECT pseudo_bannis FROM bannis");

foreach($ban as $key)
{
	if($key['pseudo_bannis'] == $pseudo)
	{
		echo 'Se compte a été bannis';
		echo '<a href="index.php">S\'inscrire</a>';
	}
}

// Vérifcation Mot de passe & Confirmation Mot de passe identique
if ($mdp != $conf_mdp)
{
	echo 'Votre confirmation de mot de passe n\'est pas identique à votre mot de passe' . '<br>' . '<br>';
	echo '<a href="index.php">S\'inscrire</a>';
}

//Hachage du mot de passe
$mdp_hache = password_hash($mdp, PASSWORD_DEFAULT);


//Ajout dans la base de donnée + vérification mot de passe et pseudo
if ($mdp == $conf_mdp)
{
	//Prépartion de la requête permettant d'ajouter le nouvel utilisateur (pseudo + mot de passe haché) à la base de données
	$reponseB = bdd()->prepare('INSERT INTO utilisateurs (pseudo, password, nom, prenom, grade) VALUES (:pseudo, :password, :nom, :prenom, :grade)');

	//Éxécution de la requête ci-dessus
	$reponseB->execute(array( 
	'pseudo' => $pseudo,
	'password' => $mdp_hache,
	'nom' => strtoupper($nom),
	'prenom' => $prenom,
	'grade' => 'utilisateur'
	));

	$reponseC = bdd()->query('SELECT id_utilisateur FROM `utilisateurs` ORDER BY id_utilisateur ASC');

	foreach($reponseC as $key)
	{
		$id_user = $key['id_utilisateur'];
	}

	$reponseD = bdd()->prepare('INSERT INTO clients(nom_client, prenom_client, telephone_client, adresse_client, id_utilisateur) VALUES (:nom, :prenom, :tel, :adresse, :id_utilisateur)');
	$reponseD->execute(array(
		"nom" => strtoupper($nom),
		"prenom" => $prenom,
		"tel" => $telephone,
		"adresse" => $adresse,
		"id_utilisateur" => $id_user));

	
	header("Location:index.php");
}
?>