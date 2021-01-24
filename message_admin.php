<?php

session_start(); // On démarre la session AVANT toute chose

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

<?php include('header.php') ?>

<section>
	<aside>
		<table>
		<?php

			$sel_admin = bdd()->query("SELECT pseudo FROM utilisateurs WHERE grade LIKE 'Admin'");
			$sel_admin = $sel_admin->fetch();

			$sel = bdd()->prepare("SELECT DISTINCT nom_destinataire FROM messages WHERE nom_expediteur LIKE :pseudo");
			$sel->execute(array('pseudo' => $sel_admin['pseudo']));

			foreach($sel as $sel)
			{
				echo "<tr><td>" . $sel['nom_destinataire'] . "</td><td>";
				?>

				<td>
					<a href="messages_perso.php?nom=<?php echo $sel['nom_destinataire'];?>"><input type="button" value="Message"></a>
				</td>
				<?php
			}

		?>

		</table>
	</aside>

</section>


<footer>PastaPizz' - 2019 copyright</footer>

</body>
</html>