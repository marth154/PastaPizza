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
    				Numéro de commande
    			</td>
    			<td>
    				Date de commande
    			</td>
                <td>
                    Nom pizza
                </td>
                <td>
                    Nombre de pizza(s)
                </td>
    			<td>
    				Type d'envoi
    			</td>
                <td>
                    Note de commande
                </td>
            </tr>

            <tr>
                <?php

                    $sel = bdd()->query("SELECT commandes.id_commande, note_commande, date_commande, nom_pizza, quantite_commande, type_envoi FROM commandes INNER JOIN lignes_commandes, pizzas WHERE commandes.id_commande = lignes_commandes.id_commande AND pizzas.id_pizza = lignes_commandes.id_pizza AND date_livraison IS NULL AND date_recup IS NULL AND preparer = '0'");

                    foreach($sel as $key)
                    {
                        date_default_timezone_set('Europe/Paris');
                        $date_format = strftime('%d %B %Y %H:%M', strtotime($key['date_commande']));
                    ?>
                        <td><?php echo $key['id_commande']; ?></td>
                        <td><?php echo $date_format; ?></td>
                        <td><?php echo $key['nom_pizza']; ?></td>
                        <td><?php echo $key['quantite_commande']; ?></td>
                        <td><?php echo $key['type_envoi']; ?></td>
                        <td>
                            <?php
                                if ($key['note_commande'] == "")
                                {
                                    echo 'Pas de note';
                                } 
                                else
                                {
                                    echo $key['note_client'];
                                }
                            ?>
                        </td>
                </tr>

                <tr>
                    <td>
                    <a href="<?php echo "preparer.php?id=".$key['id_commande']; ?>"><input type="button" value="Préparé"></a>
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