<?php

session_start();

require('fonction.php');

// Imporation des données concernant les pizzas : taille / noms / prix / id
$tab_pizza = bdd()->query('SELECT * FROM pizzas');

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

<!-- Insérer les données dans un tableau -->
<table border="1">

	<tr align="center">
			<td>
				<p>ID PIZZA</p>
			</td>
			<td>
				<p>NOM PIZZA</p>
			</td>
			<td>
				<p>TAILLE PIZZA</p>
			</td>
			<td>
				<p>PRIX PIZZA</p>
			</td>
		</tr>

<?php

// Afficher dans chaque ligne du tableau les données de chaque pizza grace à la requete précédente
while ($donnees = $tab_pizza->fetch())
{
?>
		<tr align="center">
			<td>
				<?php echo $donnees['id_pizza']; ?>
			</td>
			<td>
				<?php echo $donnees['nom_pizza']; ?>
			</td>
			<td>
				<?php echo $donnees['taille_pizza']; ?>
			</td>
			<td>
				<?php echo $donnees['prix_pizza']; ?> €
			</td>
			<form method="GET" action="info_pizza.php">
			<td>
				<a href="info_pizza.php?id=<?php echo $donnees['id_pizza']; ?>"><input type="button" value="Modifier"></a>
			</td>
			<td>
				<a href="del_pizza.php?id=<?php echo $donnees['id_pizza']; ?>"><input type="button" value="Supprimer"></a>
			</td>
			</form>
		</tr>
<?php
}
?>
</table>

<br>
<!-- ///////////////////////////////////////////////////////////////////
////////////////////////// AJOUT_PIZZA  ///////////////////////////////
/////////////////////////////////////////////////////////////////////-->

<!-- Formulaire pour ajouter une pizza via la méthod POST -->
<form method="POST" action="add_pizza.php">
<table border="1">
		<tr align="center">
			<td>
				Ajouter Pizza
			</td>
			<td>
				<input type="text" name="nom_pizza" placeholder="Nom Pizza" required="" size="15">
			</td>
			<td>
				<select name="taille_pizza" required="">
					<option value="Medium">Medium</option>
					<option value="Large">Large</option>
				</select>
			</td>
			<td><input type="text" name="prix_pizza" placeholder="Prix Pizza (en €)" required="" minlength="1" maxlength="2" size="17"></td>
         	<td>
         		<input type="file" name="fic" size=50 required />
			</td>
			<td>
         		<input type="hidden" name="MAX_FILE_SIZE" value="250000" required />
         	</td>
			<td><input type="submit" name="add_pizza" value="Ajouter"></td>
		</tr>	
</table>
</form>

<br/>
<!-- ///////////////////////////////////////////////////////////////////
///////////////////////// AJOUT_INGREDIENT  ///////////////////////////
/////////////////////////////////////////////////////////////////////-->
<?php

// Requête pour sélectionner tout dans ingrédient afin de mettre dans un tableau
$tab_ingredient = bdd()->query('SELECT * FROM ingredients');

?>
<table border="1">
	<tr align="center">
		<td>
			<p>ID INGREDIENT</p>
		</td>
		<td>
			<p>NOM INGREDIENTS</p>
		</td>
	</tr>
<?php

// Boucle Tant Que il y a des données dans mon array => affichage des ingrédients
while ($data = $tab_ingredient->fetch())
{
?>
	<tr align="center">
		<td>
			<?php echo $data['id_ingredient']; ?>
		</td>
		<td>
			<?php echo $data['nom_ingredient']; ?>
		</td>
	</tr>
<?php
}
?>
</table>

<br>

<!-- Formulaire d'ajout d'ingrédient méthod POST -->
<form method="POST" action="add_ingredient.php">

<table border="1">
	<tr>
		<td>
			Ajouter Ingrédient
		</td>
		<td>
			<input type="text" name="nom_ingredient" required="">	
		</td>
		<td>
			<input type="submit" name="add_ingredient">
		</td>
	</tr>
</table>
</form>

<br/>
<!-- ///////////////////////////////////////////////////////////////////
///////////////////////// MODIF_INGREDIENT  ///////////////////////////
/////////////////////////////////////////////////////////////////////-->

<!-- Tableau pour modifier le nom d'un ingrédient si l'on s'est malencontresement trompé -->
<table border="1">
	<form method="POST" action="modif_ingredient.php">
		<tr align="center">
			<td>Ingrédient à modifier</td>
			<td>
				<select name="nom_ingredient">
<?php

// Requête pour selectionner chaque nom d'ingredient pour mettre dans un select
$ingredients = bdd()->query('SELECT DISTINCT nom_ingredient FROM ingredients');
// Boucle tant qu'il y a des données dans ma requete
while ($data = $ingredients->fetch())
{
?>
					<option><?php echo $data['nom_ingredient'] ?></option>
<?php
}
?>	
				</select>
			</td>
		</tr>
		<tr align="center">
			<td>Modification</td>
			<td>
				<input type="text" name="nom_ingredient_modif" placeholder="Nouveau Nom" required="" size="15">
			</td>
			<td>
				<input type="submit" name="modification" value="Modification">
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