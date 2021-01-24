<?php

function echangerCar($text) {
    $utf8 = array(
        // On remplace les caractères spéciaux 'a'
        '/[áàâãä]/u' => 'a',
        // On remplace les caractères spéciaux 'A'
        '/[ÁÀÂÃÄ]/u' => 'A',
        // On remplace les caractères spéciaux 'I'
        '/[ÍÌÎÏ]/u' => 'I',
        // On remplace les caractères spéciaux 'i'
        '/[íìîï]/u' => 'i',
        // On remplace les caractères spéciaux 'e'
        '/[éèêë]/u' => 'e',
        // On remplace les caractères spéciaux 'E'
        '/[ÉÈÊË]/u' => 'E',
        // On remplace les caractères spéciaux 'o'
        '/[óòôõö]/u' => 'o',
        // On remplace les caractères spéciaux 'O'
        '/[ÓÒÔÕÖ]/u' => 'O',
        // On remplace les caractères spéciaux 'u'
        '/[úùûü]/u' => 'u',
        // On remplace les caractères spéciaux 'U'
        '/[ÚÙÛÜ]/u' => 'U',
        // On remplace 'ç'
        '/ç/' => 'c',
        // On remplace 'Ç'
        '/Ç/' => 'C',
        // On remplace 'ñ'
        '/ñ/' => 'n',
        // On remplace 'Ñ'
        '/Ñ/' => 'N',
    );
    // On envoi notre mot qui est sans les caractères spéciaux 
    return preg_replace(array_keys($utf8), array_values($utf8), $text);
}


function remise()
{
    $remise = bdd()->prepare("SELECT prix_pizza, quantite_commande FROM utilisateurs INNER JOIN clients, commandes, lignes_commandes, pizzas WHERE utilisateurs.id_utilisateur = clients.id_utilisateur AND clients.id_client = commandes.id_client AND commandes.id_commande = lignes_commandes.id_commande AND lignes_commandes.id_pizza = pizzas.id_pizza AND pseudo LIKE :pseudo");
    $remise->execute(array('pseudo' => $_SESSION['pseudo']));

    $remiseTotal = 0;

    foreach($remise as $key)
    {
        $remiseTotal += $key['prix_pizza'] * $key['quantite_commande'];
    }

    return $remiseTotal;
}

function bdd()
    {
        try{
        //Connexion à la base de données bdd_pizzas_finale
            $bdd = new PDO('mysql:host=localhost;dbname=bddpizzas_finale', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO:: MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        }
    
        //Capture de l'erreur en cas d'erreur
        catch(Exception $e)
        {
            //Message d'erreur en cas de non-connexion à la base de     données
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