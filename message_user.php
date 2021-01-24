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
		<form action="traitement_message.php" method="POST" name="form">
			<table>
				<tr>
					<td colspan="2">
						<input placeholder="Entrer votre message" size="50" name="mess" autofocus="">
					</td>

					<td>
						<input type="submit" name="">
					</td>
				</tr>
			</table>
				<?php 

				$sel_admin = bdd()->query("SELECT id_utilisateur FROM utilisateurs WHERE grade LIKE 'Admin'");
				$sel_admin = $sel_admin->fetch();

				$sel_mess_exp = bdd()->prepare("SELECT nom_destinataire, nom_expediteur, texte, heure FROM messages INNER JOIN utilisateurs WHERE utilisateurs.id_utilisateur = messages.id_expediteur AND id_expediteur LIKE :id AND id_destinataire LIKE :id_admin OR id_expediteur LIKE :id_admin AND id_destinataire = :id ORDER BY heure DESC");

				$sel_mess_exp->execute(array(
					'id' => $_SESSION['id_utilisateur'],
					'id_admin' => $sel_admin['id_utilisateur']));


				foreach ($sel_mess_exp as $key)
				{
					echo "<p><em>" . strftime('%d %B %Y %X', strtotime($key['heure'])) . " " . "</em><strong>" . $key['nom_expediteur'] . "</strong> " . $key['texte'] . "</p>";
				}
				?>
		</form>
	</aside>
</section>

<footer>PastaPizz' - 2019 copyright</footer>

</body>
</html>

<script type="text/javascript">
document.form.nom.focus();
</script>
