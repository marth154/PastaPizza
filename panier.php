<?php

session_start();

require ('fonction.php');

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
		<form action="commande_traitement.php" method="POST">
		<?php 
			if(isset($_SESSION['panier'])){
            
			$prixTotal = 0;	
			$qttTotal = 0;

			echo "<table border='1'>";
			?>

				<thead>
					
					<td>
						Nom Pizza(s)
					</td>
					<td>
						Taille
					</td>
					<td>
						Prix unitaire HT
					</td>
					<td>
						Quantité
					</td>
					<td>
						Prix HT
					</td>
					<td>
						Remise
					</td>
				</thead>	

			<?php

			for($i = 0; $i < taillePanier(); $i++){

				$req = bdd()->prepare("SELECT * FROM pizzas WHERE id_pizza = :id");
				$req->execute(array('id' => $_SESSION['panier']['idPizza'][$i]));
				$pizzas = $req->fetch();

				?>

						<tr>
							<td>
								<?php echo $pizzas['nom_pizza']; ?>
							</td>
							<td>
								<?php echo $pizzas['taille_pizza']; ?>
							</td>
							<td>
								<?php echo $pizzas['prix_pizza']."€"; ?>
							</td>
							<td>
								<?php echo $_SESSION['panier']['qttPizza'][$i]; $qttTotal += $_SESSION['panier']['qttPizza'][$i]; ?>
							</td>
							<td>
								<?php echo $_SESSION['panier']['qttPizza'][$i] * number_format($pizzas['prix_pizza'] * 1/(1+0.055), $decimals = 2) ."€"; $prixTotal += $_SESSION['panier']['qttPizza'][$i] * $pizzas['prix_pizza']; ?>
							</td>
							<td>
								<?php 
								if(isset($_SESSION['remise']))
									{
										echo $_SESSION['remise'] . '%';
									}
								else 
								{
									echo 'Pas de remise';
								}
								?>
							</td>
							<td align="right">
									<a href="<?php echo "supprimerArticle.php?pizza=".$i."'"; ?>" class="panier-ligne-supp"><input type="button" value="Supprimer"></a>
							</td>
						</tr>

					<?php

				}

				$req->closeCursor();

				if(isset($_SESSION['remise']))
				{
					$_SESSION['panier']['prixTotal'] = $prixTotal - ($prixTotal * ($_SESSION['remise']/100));
				}
				else 
				{
					$_SESSION['panier']['prixTotal'] = $prixTotal;
				}
                
				

				?>
					<tfoot>
						<td colspan="4">
							Prix total TTC : <?php echo number_format($_SESSION['panier']['prixTotal'], $decimals = 2); ?> €
						</td>

						<td>
							<textarea name="note" placeholder="Note Potentielle"></textarea>
								
						</td>

						<td>
							<select name="type_envoi">
								<option>A Emporter</option>
								<option>A Livrer</option>
							</select>
						</td>

						<td colspan="3">
							<input type="submit" value="Commander" onclick="self.location.href='commande_traitement.php?valid'">
						</td>
					</tfoot>
				</table>
			</form>
				
				<?php
				$req->closeCursor();

				$_SESSION['panier']['qttTotal'] = $qttTotal;
			}else{

				echo "Votre panier est vide !";

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