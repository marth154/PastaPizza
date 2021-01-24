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
		<div class="main">
	
		<?php 

		$req = bdd()->query("SELECT * FROM pizzas");

		foreach($req as $key)
		{
		?>
		<table border="1">
			<tr align="center">
				<td width="1410"></br>
					<?php 

					$image = bdd()->prepare('SELECT image FROM pizzas WHERE nom_pizza LIKE :nom');
					$image->execute(array('nom' => $key['nom_pizza']));
					$image = $image->fetch();

					?>
					<div id="img"><img src="image/pizza/<?php echo $image['image'] ?>" width="350" height="350" alt="imagetest" /><h2>-=<?php echo $key['nom_pizza'] . ' ' . $key['taille_pizza'] . ' ' . $key['prix_pizza'] . '€'; ?>=-</h2></br>
					</div>
						<div id="texte">
							<?php
								$res = bdd()->prepare("SELECT DISTINCT nom_ingredient FROM ingredients INNER JOIN pizza_ingredients, pizzas WHERE ingredients.id_ingredient = pizza_ingredients.id_ingredient AND pizzas.id_pizza = pizza_ingredients.id_pizza AND pizzas.id_pizza LIKE :id_pizza");
								$res->execute(array('id_pizza' => $key['id_pizza']));

								foreach($res as $line)
								{
									$line['nom_ingredient'] = str_replace('_', ' ', $line['nom_ingredient']);
								?>
									<p><li><?php echo $line['nom_ingredient']; ?></li></p>
								<?php
								}

								if ((isset($_SESSION['pseudo'])) AND ($_SESSION['grade'] == 'utilisateur'))
								{
									if ($_SESSION['grade'] != 'Admin')
									{
								?>
									<br><br><form action="pizza_panier.php?id=<?php echo $key['id_pizza']; ?>" method="POST" ><input type="number" name="quant"><br>

									<input type="submit" value="Ajouter au panier"></form>
								<?php
								}
								else 
								{
								?>
									<p><li><a href="index.php#volet">Connectez-vous</a></li></p>
								<?php
									}
								}

							?>
						</div>
				</td>	
			</tr>
		</table>
		<br/>
		<?php
		}
		?>

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