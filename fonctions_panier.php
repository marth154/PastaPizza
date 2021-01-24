<?php

	function bdd()
	{
		try{
		//Connexion à la base de données bdd_pizzas_finale
			$bdd = new PDO('mysql:host=localhost;dbname=bddpizzas_finale', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO:: MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		}
	
		//Capture de l'erreur en cas d'erreur
		catch(Exception $e)
		{
			//Message d'erreur en cas de non-connexion à la base de 	données
			die('Erreur : ' . $e->getMessage());  
		}
		return $bdd;
	}

	function nouveauPanier($idPizza,$qttPizza){ 
			
		$_SESSION['panier']['idPizza'] = array();
		$_SESSION['panier']['qttPizza'] = array();
		$_SESSION['panier']['prixUniPizza'] = array();

		$req = bdd()->prepare('SELECT prix_pizza FROM pizzas WHERE id_pizza = :id');
		$req->execute(array('id' => $idPizza));
		$prix = $req->fetch();

		$_SESSION['panier']['idPizza'][0] = $idPizza;
		$_SESSION['panier']['qttPizza'][0] = $qttPizza;
		$_SESSION['panier']['prixUniPizza'][0] = $prix['prix_pizza'];

		$req->closeCursor();
		
	}

	function ajoutArticle($idPizza, $qttPizza){ 

		if(isset($_SESSION['panier'])){

				$newCase = sizeof($_SESSION['panier']['idPizza']);

				$req = bdd()->prepare('SELECT prix_pizza FROM pizzas WHERE id_pizza = :id');
				$req->execute(array('id' => $idPizza));
				$prix = $req->fetch();

				$_SESSION['panier']['idPizza'][$newCase] = $idPizza;
				$_SESSION['panier']['qttPizza'][$newCase] = $qttPizza;

				$req->closeCursor();

		}else{

			nouveauPanier($idPizza, $qttPizza);

		}

	}

	function taillePanier(){

		return sizeof($_SESSION['panier']['idPizza']);
		
	}

	function supprimePanier(){ 

		unset($_SESSION['panier']);

	}

?>