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

		<?php include ('header.php'); ?>

	</div>

<section>
	<aside>
		<table>
			<tr>
				<td>
					<p>
						<h1>Nous contacter.</h1>
					</p>
				
					<p>
						</br></br>
						Il vous sera facile de trouver une de nos pizzerias PastaPizz' à deux pas de chez vous, pour commander en livraison ou à emporter !</br></br>
				
						Une grande partie de nos magasins se trouve dans les grandes villes françaises comme Paris, Lyon, Marseille, Bordeaux et Lille, mais aussi dans des villes comme Strasbourg, Toulouse, Nantes ou encore Montpellier.</br></br>
					</p>
					<p>
						Num: 02.54.76.18.25
					</p>
				
					<p>
						E-mail: pastapizz@gmail
					</p>
				
					<p>
						Adresse : 25 avenue Charles de Gaulle Paris 75000
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