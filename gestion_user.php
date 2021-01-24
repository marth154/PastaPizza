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
			STAFFS
		</p>

<table border="1">
	<tr align="center">
		<td>
			ID d'utilisateur
		</td>
		<td>
			Pseudo utilisateur
		</td>

		<td>
			Nom utilisateur
		</td>

		<td>
			Prénom utilisateur
		</td>
	</tr>

	
	<?php

		$req = bdd()->query("SELECT id_utilisateur, pseudo, nom, prenom, grade FROM utilisateurs WHERE grade LIKE 'Admin' OR grade LIKE 'Livreur' OR grade LIKE 'Caissier' OR grade LIKE 'Cuisinier' ORDER BY pseudo ASC");

		foreach ($req as $key) 
		{
		?>
			<tr align="center">
				<td><?php echo $key['id_utilisateur'];?></td>
				<td><?php echo $key['pseudo'];?></td>
				<td><?php echo $key['nom'];?></td>
				<td><?php echo $key['prenom'];?></td>
				<?php
					if($key['grade'] != 'Admin')
					{
						?>
							<td>
								<a href="<?php echo "modif_staff.php?staff=".$key['id_utilisateur']; ?>"><input type="button" value="Modifier"></a>
							</td>
							<td>
								<a href="<?php echo "supp_staff.php?staff=".$key['id_utilisateur']; ?>"><input type="button" value="Supprimer"></a>
							</td>
						<?php
					}
				?>
			</tr>
		<?php
		}

	?>

</table>

<br/>

<a href="ajout_staff.php"><input type="button" value="Ajouter"></a>

<br><br><br>

<p>
	UTILISATEURS
</p>
<table border="1">
	<tr align="center">
		<td>
			ID d'utilisateur
		</td>
		<td>
			ID client
		</td>
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
		<td>
			Note
		</td>
	</tr>

	
	<?php

		$req = bdd()->query("SELECT utilisateurs.id_utilisateur, id_client, pseudo, nom, prenom, adresse_client, telephone_client, note_client FROM utilisateurs INNER JOIN clients WHERE utilisateurs.id_utilisateur = clients.id_utilisateur AND grade LIKE 'utilisateur' ORDER BY pseudo ASC");

		foreach ($req as $key) 
		{
		?>
			<tr align="center">
				<td><?php echo $key['id_utilisateur'];?></td>
				<td><?php echo $key['id_client']; ?></td>
				<td><?php echo $key['pseudo'];?></td>
				<td><?php echo echangerCar($key['nom']);?></td>
				<td><?php echo echangerCar($key['prenom']);?></td>
				<td><?php echo echangerCar($key['adresse_client']);?></td>
				<td><?php echo $key['telephone_client'];?></td>
				<td><?php 
				if ($key['note_client'] == "")
				{
				?>
					<form>
						<a href="<?php echo "ajout_note.php?user=".$key['id_client']; ?>"><input type="button" value="Ajouter"></a>
					</form>
				<?php
				}
				else
				{
					echo echangerCar($key['note_client']); 
				?> <td>
					<form>
						<a href="<?php echo "modif_note.php?user=".$key['id_client']; ?>"><input type="button" value="Modifier Note"></a>
					</form>
				</td>
				<?php
				}
				?>
				</td>

				<?php 
				if ($key['note_client'] == "")
				{
				?>
				<td></td>
				<?php
				}
				?>

				<form>
					<td>
						<a href="<?php echo "ban_utilisateur.php?bannis=".$key['id_utilisateur']; ?>"><input type="button" value="Bannir"></a>
					</td>
				</form>
			</tr>
		<?php
		}

	?>

</table>

<br>

<p>
	BANNIS
</p>
<table border="1">
	<tr align="center">
		<td>
			ID de bannis
		</td>
		<td>
			Pseudo utilisateur
		</td>
		<td>
			Nom utilisateur
		</td>
		<td>
			Prénom utilisateur
		</td>
	</tr>

	<?php

		$req = bdd()->query("SELECT id_bannis, pseudo_bannis, nom_bannis, prenom_bannis FROM bannis ORDER BY pseudo_bannis ASC");

		foreach ($req as $key) 
		{
		?>
			<tr align="center">
				<td><?php echo $key['id_bannis'];?></td>
				<td><?php echo $key['pseudo_bannis'];?></td>
				<td><?php echo echangerCar($key['nom_bannis']);?></td>
				<td><?php echo echangerCar($key['prenom_bannis']);?></td>
				<form>
					<td>
						<a href="<?php echo "deban_utilisateur.php?bannis=".$key['id_bannis']; ?>"><input type="button" value="Debannir"></a>
					</td>
				</form>
			</tr>
		<?php
		}

	?>

</table>

<br/><!-- ///////////////////////////////////////////////////////////////////
////////////////////////////// FACTURE  ////////////////////////////////
/////////////////////////////////////////////////////////////////////-->

<table border="1">
<form action="pdf_admin.php" method="POST" target="_blank">

	<tr align="center">
		<td>
			Créer une facture
		</td>
		<td>
			<!-- Formulaire pour le nom du client -->
			<select name="nom">
					<?php

					// Requète pour récupérer tous les noms
						$req = bdd()->query("SELECT DISTINCT nom_client, prenom_client FROM clients ORDER BY nom_client ASC");

					// On parcours le tableau créé par notre requète
					foreach ($req as $ligne) 
					{
						// On affiche notre résultat dans un select pour notre PDF
						echo "<option>" . $ligne['nom_client'] . " " . $ligne['prenom_client'] . "</option>";
					}
					?>
			</select>
		</td>

		<td>
			<!-- Formulaire pour la date du client -->
			<select name="date" >
				<?php

				// Requète pour récupérer toute les dates
				$req = bdd()->query("SELECT DISTINCT id_utilisateur ,nom_client, prenom_client, date_commande FROM commandes INNER JOIN clients WHERE clients.id_client = commandes.id_client ORDER BY nom_client ASC");				
				
				// On  parcours le tableau créé par notre requète
				foreach ($req as $line) 
				{
					// On affiche les nom auquelle correspond la date
					echo "<option style='font-weight: bold;' disabled>" .  $line['nom_client'] . " " . $line['prenom_client'] . " | id : " . $line['id_utilisateur'] . "</option>";

					// On affiche notre résultat dans un select pour notre PDF
					echo "<option>" . $line['date_commande'] . "</option>";
				}
				?>
			</select>
		</td>

		<td>
			<input type="submit">
		</td>
	</tr>
</form>
</table>

</aside>

</section>

<br/><br/>

<footer>PastaPizz' - 2019 copyright</footer>
</body>
</html>