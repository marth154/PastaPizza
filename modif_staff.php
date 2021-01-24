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

		<form method="POST" action="<?php echo "traitement_staff.php?staff=".$_GET['staff']; ?>">
		<table border="1">
			<tr>
				<td>
					ID utilisateur
				</td>
				<td>
					Pseudo
				</td>
				<td>
					Prénom
				</td>
				<td>
					Nom
				</td>
				<td>
					Grade
				</td>
			</tr>

			<?php

				$info = bdd()->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :id");
				$info->execute(array('id' => $_GET['staff']));

				foreach ($info as $key)
				{
				?>
					<tr>
						<td>
							<input type="text" value="<?php echo $key['id_utilisateur'];?>" disabled>
						</td>
						<td>
							<input type="text" value="<?php echo $key['pseudo'];?>" name="pseudo">
						</td>
						<td>
							<input type="text" value="<?php echo $key['prenom'];?>" name="nom">
						</td>
						<td>
							<input type="text" value="<?php echo $key['nom'];?>" name="prenom">
						</td>
						<td>
							<input type="text" value="<?php echo $key['grade'];?>" name="grade">
						</td>
					</tr>

					<tr>
						<td>
							<input type="submit" value="Modifier">
						</td>
					</tr>
				<?php
				}

			?>
		</table>


	</form>
