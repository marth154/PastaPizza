<?php

session_start(); // On démarre la session AVANT toute chose

require('fonction.php');


// Importation des données sous forme de variable avec la méthode POST + htmlspecialchars pour empêcher les failles XSS
$pseudo = htmlspecialchars($_POST['pseudo']);
$mdp = htmlspecialchars($_POST['mdp']);

// Prépration de la requête vérification de l'existence du pseudo dans la base de données

$reponse = bdd()->prepare('SELECT pseudo, password FROM utilisateurs WHERE pseudo = :pseudo');

//Éxécution de la requête ci-dessus
$reponse->execute(array(
	'pseudo' => $pseudo
	));

//Insérer les données de la requête dans un tableau sous forme de lignes
$donnees = $reponse->fetch();

// Comparaison et Validation du mot de passe rentré et celui dans la base de données
$valid_mdp = password_verify($mdp, $donnees['password']);


// Vérification de la présence du pseudo dans la base de données, sinon, renvoie vers la page connexion
if ($donnees)
{
	header("Location:index.php");

	// Vérification du mot de passe dans la base de données, sinon, renvoie vers la page connexion
	if($valid_mdp)
	{

		// Requête SQL : Dans la table utilisateur mettre tout ceux qui ont le grade 'utilisateur' dans un tableau
		$donnee = bdd()->query("SELECT pseudo FROM utilisateurs WHERE grade LIKE 'Admin'");
		$donnee->setFetchMode(PDO::FETCH_ASSOC);
		
		foreach ($donnee as $line) 
		{
			// Si le pseudo rentré est présent dans le tableau
			if ($pseudo == $line['pseudo'])
			{
				header('Location:accueil.php');
			}
			else
			{
				header('Location:index.php');
			}
		}
	
		$res = bdd()->prepare('SELECT grade FROM utilisateurs WHERE pseudo LIKE :pseudo');
	
		$res->execute(array(
			'pseudo' => $pseudo));
	
		foreach($res as $key)
		{
			$_SESSION['grade'] = $key['grade'];
		}

		$_SESSION['pseudo'] = htmlspecialchars($_POST['pseudo']);
		$_SESSION['mdp'] = htmlspecialchars($_POST['mdp']);

		$req = bdd()->prepare('SELECT id_client, utilisateurs.id_utilisateur FROM clients INNER JOIN utilisateurs WHERE utilisateurs.id_utilisateur = clients.id_utilisateur AND pseudo LIKE :pseudo');
		$req->execute(array('pseudo' => $_SESSION['pseudo']));

		foreach ($req as $line)
		{
			$_SESSION['id_client'] = $line['id_client'];
			$_SESSION['id_utilisateur'] = $line['id_utilisateur'];
 		}
	}
	else 
	{
		header('Location:index.php');
	}
}
else 
{
	header('Location:index.php');
}

?>