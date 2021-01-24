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

// Reception de l'ID de la pizza par la method GET
$id_pizza=$_GET['id'];

// Préparation de la requête qui selectionne le nom de la pizza
$nom_pizza = bdd()->prepare('SELECT nom_pizza FROM pizzas WHERE id_pizza = :id_pizza');
// Execution de la requete en remplacent les variables nommées
$nom_pizza->execute(array(
	'id_pizza' => $id_pizza
));

// Préparation de la requête qui selectionne la quantité ingredient ainsi que le nom de l'ingredient pour mettre dans un tableau
$pizza_ingredients = bdd()->prepare('SELECT `nom_ingredient`, `quantite_ingredient` FROM `ingredients` INNER JOIN pizza_ingredients, pizzas WHERE pizza_ingredients.id_pizza=pizzas.id_pizza AND pizza_ingredients.id_ingredient=ingredients.id_ingredient AND pizzas.id_pizza=:idpizza');
// Execution de la requête en remplacant les variables nommées
$pizza_ingredients->execute(array(
	'idpizza' => $id_pizza
));

// Préparation de la requête qui selectionne le prix de la pizza
$pizza_prix = bdd()->prepare('SELECT prix_pizza FROM pizzas WHERE id_pizza = :idpizza');
// Execution de la requête en remplacant les variables nommées
$pizza_prix->execute(array(
	'idpizza' => $id_pizza
));

// Préparation de la requête qui selectionne la taille de la pizza
$pizza_taille = bdd()->prepare('SELECT taille_pizza FROM pizzas WHERE id_pizza = :idpizza');
// Execution de la requête en remplacant les variables nommées
$pizza_taille->execute(array(
	'idpizza' => $id_pizza
));

?>
<!-- Formulaire avec des input value qui ont les valeurs par défaut + un bouton sauvegarder qui l'ont veut changer : Nom / Taille / Prix / Quantité Ingredients -->
<form method="POST" action="modif_pizza.php?id=<?php echo $id_pizza; ?>">
<table border="1">
	<tr align="center">
		<td>Nom Pizza</td>
		<td>Taille Pizza</td>
		<td>Prix Pizza</td>
	</tr>
	<?php
	while ($donnees = $nom_pizza->fetch())
	{
	?>
	<tr align="center">
		<td>
			<input type="text" name="nom_pizza" size="15" required="" value="<?php echo $donnees['nom_pizza']; ?>">
		</td>
	<?php
	}
	// Boucle tant qu'il y a des données dans l'array de ma requête
	while ($taille = $pizza_taille->fetch())
	{
	?>
		<td>
			<input type="text" name="taille_pizza" size="15" required="" value="<?php echo ucwords($taille['taille_pizza']); ?>">
		</td>
	<?php
	}
	// Boucle tant qu'il y a des données dans l'array de ma requête
	while ($prix = $pizza_prix->fetch())
	{
	?>
		<td>
			<input type="number" name="prix_pizza" size="8" required="" value="<?php echo $prix['prix_pizza']; ?>"> €
		</td>
		<?php
		}
		?>
	</tr>
</table>
<br><br>
<!-- Nouveau Tableau -->
<table border="1">

	<tr align="center">
		<td>Nom Ingrédients</td>
		<td>Poids (en gramme)</td>
	</tr>
	<?php 
	// Boucle tant qu'il y a des données dans le tableau de ma requête
	while($data = $pizza_ingredients->fetch())
	{
	?>
	<tr align="center">
		<td>
			<?php echo $data['nom_ingredient']; ?>
		</td>
		<td>
			<input type="number" name="<?php echo $data['nom_ingredient']; ?>" required="" value="<?php echo $data['quantite_ingredient']; ?>"> g
		</td>
		<td>	
			<a href="del_pizza_ingredient.php?id=<?php echo $id_pizza; ?>&amp;nom_ingredient=<?php echo $data['nom_ingredient']; ?>"><input type="button" value="Supprimer"></a>
		</td>
	</tr>
<?php
}
?>
</table>
<br>
<input type="submit" name="modification" value="Sauvegarder">
</form>


<br><br>

<!-- //////////////////////////////////
////////////////ADD INGRE//////////////
/////////////////////////////////////// -->


<!-- Formulaire pour ajouter un ingredient à la pizza en question -->
<form method="POST" action="add_pizza_ingredient.php?id=<?php echo $id_pizza; ?>">
<table border="1">
<tr align="center">
	<td>
		<input type="submit" name="ajouter_pizza_ingredient" value="Ajouter Ingredient">
	</td>
	<td>
		<select name="nom_ingredient">
<?php
// Requete SQL selectionnant le nom de l'ingredient
$ingredients = bdd()->query('SELECT `nom_ingredient` FROM `ingredients`');
// Boucle tant qu'il y a des données dans l'array de ma requête
while ($sql = $ingredients->fetch())
{
?>
			<option><?php echo $sql['nom_ingredient'] ?></option>
<?php
}
?>	
		</select>
	</td>
	<td>
		<input type="number" name="quantite_ingredient" required="*">g
	</td>
</tr>
</table>
</form>
<br><br>

<a href="gestion_pizza.php"><input type="button" value="Revenir aux pizzas"></a>

</aside>

</section>




<footer>PastaPizz' - 2019 copyright</footer>
</body>
</html>