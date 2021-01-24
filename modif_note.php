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
		<?php

		$req = bdd()->prepare("SELECT pseudo, note_client FROM utilisateurs INNER JOIN clients WHERE utilisateurs.id_utilisateur = clients.id_utilisateur AND id_client = :id");
		$req->execute(array('id' => $_GET['user']));
		$user =$req->fetch();


		$_SESSION['id_utilisateur']['note'] = $_GET['user'];
		?>
		<p>Vous modifiez la note de <?php echo strtoupper($user['pseudo']); ?></p>

		<form method="POST" action="traitement_note.php">

		<table>
			<tr>
				<td>
					<input type="text" name="id" value="<?php echo $_GET['user'];?>" disabled>
				</td>
				
				<td>
					<textarea id="story" name="note" rows="5" cols="33" placeholder="Modifier la note"></textarea>
				</td>
			</tr>
		</table>
			
		<br/><br>
	
		<input type="submit" name="">


		<a href="traitement_note.php"><input type="button" value="Supprimer"></a>
		
		</form>

	</aside>

</section>

<br/><br/>

<footer>PastaPizz' - 2019 copyright</footer>
</body>
</html>