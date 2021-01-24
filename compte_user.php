<?php

session_start();

require('fonction.php');

?>

<!DOCTYPE html>
<html>
<head>

	<title>PastaPizz'</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="image/icon.png" />
	<html lang="fr">

</head>
<body>

<div id="menu">

<?php include('header.php'); ?>

</div>

<section>
	<aside>

<p>
	Vos informations personnelles
</p>
<form method="POST" action="traitement_client.php">
<table border="1">
	<tr align="center">
		
		<td>
			Pseudo
		</td>
		<td>
			Nom
		</td>
		<td>
			Prénom
		</td>
		<td>
			Adresse
		</td>
		<td>
			Téléphone
		</td>
	</tr>

	
	<?php

		$req = bdd()->prepare("SELECT utilisateurs.id_utilisateur, id_client, pseudo, nom, prenom, adresse_client, telephone_client FROM utilisateurs INNER JOIN clients WHERE utilisateurs.id_utilisateur = clients.id_utilisateur AND pseudo LIKE :pseudo ORDER BY pseudo ASC");
		$req->execute(array('pseudo' => $_SESSION['pseudo']));
		$user = $req->fetch();

		?>
			<tr align="center">
				<td><input type="text" name="pseudo" value="<?php echo $user['pseudo'];?>"></td>
				<td><input type="text" name="nom" value="<?php echo $user['nom'];?>"></td>
				<td><input type="text" name="prenom" value="<?php echo $user['prenom'];?>"></td>
				<td><input type="text" name="add" value="<?php echo $user['adresse_client'];?>"></td>
				<td><input type="text" name="tel" value="<?php echo $user['telephone_client'];?>"></td>
			</tr>

			<tr>
				<td colspan="5">
					Entrer votre mot de passe pour confirmer les modifications
				</td>
			</tr>
			
			<tr>
				<td colspan="5">
					<input type="password" name="pass" placeholder="Mot de passe" required> 
				</td>
		    </tr>

			<tr>
				<td colspan="5">
					<input type="submit" value="Mettre à jour">
				</td>
			</tr>

</table>
</form>

<br/><br/>


<form action="supp_compte_user.php">

	<input type="submit" value="Supprimer votre compte">

</form>

<br/><br/>


<?php 

    $rep = bdd()->prepare("SELECT nom, prenom FROM utilisateurs WHERE pseudo LIKE :pseudo");
    $rep->execute(array('pseudo' => $_SESSION['pseudo']));

    foreach($rep as $line)
    {
        $prenom = $line['prenom'];
        $nom = $line['nom'];
    }

    // Requète pour récupérer toute les dates
    $req = bdd()->prepare("SELECT date_commande FROM commandes INNER JOIN clients WHERE clients.id_client = commandes.id_client AND nom_client LIKE :nom AND prenom_client LIKE :prenom LIMIT 1");
    $req->execute(array(
        'nom' => $nom,
        'prenom' => $prenom
        ));
    $req = $req->fetch();

    // On  parcours le tableau créé par notre requète
    if ($req['date_commande'] == "")
    {
        echo "Vous n'avez pas de commande";
    }
    else
	{
        $_SESSION['commande'] = true;
     	include('date_facture.php');
  	}
?>
<br/><br/>

<br/><br/>

<?php

if (remise() < 1)
{
	$max = 50;
	$_SESSION['remise'] = 0;
}
else if (remise() < 50)
{

	$max = 50;
	$_SESSION['remise'] = 0;
}
else if (remise() < 200)
{
	$max = 200;
	$_SESSION['remise'] = 5;
}
else
{
	$max = 500;
	$_SESSION['remise'] = 10;
}

?>

<progress id="file" max="<?php echo $max; ?>" value="<?php echo remise(); ?>"></progress> Prochaine remise à <?php echo $max; ?>€

<p>
	Vous avez une remise de <?php echo $_SESSION['remise']; ?>%
</p>

	</aside>

</section>

<br/><br/>

<footer>PastaPizz' - 2019 copyright</footer>
</body>
</html>