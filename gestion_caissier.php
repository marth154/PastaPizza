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
    	<table border ="1">
    		<tr>
    			<td>
    				Nom client
    			</td>
    			<td>
    				Prénom client
    			</td>
    			<td>
    				Adresse client
    			</td>
    			<td>
    				Téléphone client
    			</td>
    			<td>
    				Date commande
    			</td>
    			<td>
    				Note client
    			</td>
    		</tr>


    		<tr>
				<?php

					$sel = bdd()->query("SELECT id_commande, nom_client, prenom_client, adresse_client, telephone_client, note_client, date_commande FROM commandes INNER JOIN clients WHERE commandes.id_client = clients.id_client AND type_envoi LIKE 'A Emporter' AND date_recup IS NULL AND preparer = 1");

					foreach($sel as $key)
					{
						date_default_timezone_set('Europe/Paris');
					 	$date_format = strftime('%d %B %Y %H:%M', strtotime($key['date_commande']));
					?>
						<td><?php echo $key['nom_client']; ?></td>
						<td><?php echo $key['prenom_client']; ?></td>
						<td><?php echo $key['adresse_client']; ?></td>
						<td><?php echo $key['telephone_client']; ?></td>
						<td><?php echo $date_format; ?></td>
						<td>
							<?php
							if ($key['note_client'] == "")
							{
								echo 'Pas de note';
							} 
							else
							{
								echo $key['note_client'];
							}
							?>
						</td>
						<td>
						<?php
							$prix = bdd()->prepare("SELECT prix_pizza, quantite_commande FROM pizzas INNER JOIN lignes_commandes WHERE pizzas.id_pizza = lignes_commandes.id_pizza AND id_commande = :id");
							$prix->execute(array('id' => $key['id_commande']));

							$prixTotal =0;

							foreach($prix as $ligne)
							{
								$prixTotal += $ligne['prix_pizza'] * $ligne['quantite_commande'];
							}
							echo number_format($prixTotal, $decimals = 2) . "€" ;
						?>
						</td>
					
			</tr>
			<?php 

				$sel = bdd()->prepare("SELECT id_utilisateur FROM utilisateurs WHERE pseudo LIKE :pseudo");
				$sel->execute(array('pseudo' => $_SESSION['pseudo']));
				$sel = $sel->fetch();
				$_SESSION['id_staff'] = $sel['id_utilisateur'];
			?>
			<tr>
				<td>
					<a href="<?php echo "recu.php?id=".$key['id_commande']; ?>&amp;caissier=<?php echo $_SESSION['id_staff'];?>"><input type="button" value="Récuperé"></a>
				</td>
			</tr>
			<?php
			}
			?>
		</table>
    </aside>
</section>

<footer>PastaPizz' - 2019 copyright</footer>
</body>
</html>