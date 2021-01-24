<?php 

session_start();

require ('fonction.php');

if(isset($_SESSION['panier'])){

			if($_GET['pizza'] <= taillePanier()){

				for($i = $_GET['pizza']; $i < taillePanier() - 1; $i++){

					$_SESSION['panier']['idPizza'][$i] = $_SESSION['panier']['idPizza'][$i+1];
					$_SESSION['panier']['qttPizza'][$i] = $_SESSION['panier']['qttPizza'][$i+1];
					$_SESSION['panier']['prixUniPizza'][$i] = $_SESSION['panier']['prixUniPizza'][$i+1];

	 			}

				unset($_SESSION['panier']['idPizza'][taillePanier()-1]);
				unset($_SESSION['panier']['qttPizza'][sizeof($_SESSION['panier']['qttPizza'])-1]);
				unset($_SESSION['panier']['prixUniPizza'][sizeof($_SESSION['panier']['prixUniPizza'])-1]);

 			}else{

 				echo "Erreur : veuillez contacter un administrateur.";

 			}

		}else{

			echo "Erreur : veuillez contacter un administrateur.";

		}


		if(taillePanier() < 1){

			supprimePanier();

		}

header('Location: panier.php');

?>