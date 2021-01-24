<?php

session_start();

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
		<table>
			<tr>
				<td>
					<p>
						<h1>Nos services.</h1>
					</p>

					<p>
						</br></br>
						Passez votre commande en ligne, faites vous livrer gratuitement votre pizza encore chaude ou passez directement la chercher dans votre restaurant favoris.</br></br>
				
						Il y a toujours un PastaPizz' proche de chez vous, il suffit d’aller sur notre site pour trouver votre PastaPizz' et commander vos pizzas préférées.
					</p>
				</td>
			</tr>
		</table>
	</aside>
</section>

<?php 
if(!isset($_SESSION['pseudo']))
{
	include('volet.php');
}
?>


		<footer>PastaPizz' - 2019 copyright</footer>


</body>
</html>