<?php

session_start();

require('fonction.php');

// #####################################################################
// ############################## TABLEAU ##############################
// #####################################################################

// On défini notre en-tête de tableau
$header = array('Libell' . chr(233), 'Taille', 'Prix Unitaire HT (en ' . chr(128) . ')', 'Quantit' . chr(233), 'Montant HT (en '. chr(128) . ')');


// ###################################################################
// ################# Récuperer les infos les pizzas ##################
// ###################################################################


// On récupère l'ID de la commande en fonction du nom et de la date 
$id_co = bdd()->prepare("SELECT id_commande FROM commandes INNER JOIN clients, utilisateurs WHERE utilisateurs.id_utilisateur = clients.id_utilisateur AND clients.id_client = commandes.id_client AND date_commande LIKE :date_co");
// On execute notre requète
$id_co->execute(array(
    'date_co' => $_POST['date']
    ));

// On parcours le tableau créé par la requête 
foreach ($id_co as $line)
{
    $id_co = $line['id_commande'];
}

// On récupère les données de la pizza avec l'ID de la commande fait au paravant
$data = bdd()->prepare("SELECT nom_pizza, taille_pizza, prix_pizza, quantite_commande FROM pizzas INNER JOIN commandes, lignes_commandes WHERE pizzas.id_pizza = lignes_commandes.id_pizza AND lignes_commandes.id_commande = commandes.id_commande AND commandes.id_commande = :id_commande");
// On execute notre requète
$data->execute(array('id_commande' => $id_co));


// ###################################################################
// ################ Récuperer la date de la commande #################
// ###################################################################

// On récupère la date de la commande avec l'ID de la même commande
$date_commande = bdd()->prepare('SELECT date_commande FROM commandes WHERE id_commande LIKE :id_commande');
// On execute notre requète
$date_commande->execute(array('id_commande' => $id_co));

// On parcours le tableau créé par la requête 
foreach ($date_commande as $line) 
{
    date_default_timezone_set('Europe/Paris');
    
    // On affiche la date en format "01 Janvier 2018"
    $date_commande = strftime('%d %B %Y', strtotime($line['date_commande']));

    // On affiche la date en format " 01 01 2018"
    $num_commande = strftime('%d %m %Y', strtotime($line['date_commande']));

    // On supprime tous les espaces pour avoir un format en chiffre complet
    $num_commande = str_replace(' ','',$num_commande);

    // On ajoute au numéro de commande l'ID de la commande pour avoir un numéro unique
    $num_commande += $id_co;
}


// ###################################################################
// ############### Récuperer les coordonnées du client ###############
// ###################################################################


// On fait une requète pour avoir les données sur le client en fonction de l'ID de la commande
$coo_client = bdd()->prepare('SELECT nom_client, prenom_client, telephone_client, adresse_client FROM clients INNER JOIN commandes WHERE clients.id_client = commandes.id_client AND commandes.id_commande LIKE :id_commande');
// On execute notre requète
$coo_client->execute(array('id_commande' => $id_co));


// On parcours le tableau créé par la requête 
foreach ($coo_client as $line)
{
    // On récupère le nom du client
    $nom_client = $line['nom_client'];

    // On récupère le prénom du client
    $prenom_client = $line['prenom_client'];

    // On récupère le téléphone du client et on met en format " 01 23 45 67 89" 
    $telephone_formate = preg_replace("#^([0-9]{1}[0-9]{1})([0-9]{1}[0-9]{1})([0-9]{1}[0-9]{1})([0-9]{1}[0-9]{1})([0-9]{1}[0-9]{1})$#", "$1 $2 $3 $4 $5", $line['telephone_client']);

    // On récupère l'adresse de client
    $adresse_client = $line['adresse_client'];
}

// On demande le plugin 'FPDF'
require('fpdf/fpdf.php');

// On créer notre PDF
class PDF extends FPDF
{
// Pied de page
function Footer()
{
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Positionnement au milieu de la page
    $this->SetX(20);
    // Police Arial italique 8
    $this->SetFont('Arial','I',8);
    // Numéro de page
    $this->Cell(0,10,'Page 1',0,0,'C');
}

// Fonction Tableau
function FancyTable($header, $data)
{
    // Couleurs des cases 
    $this->SetFillColor(199,199,199);
    // Couleur du texte
    $this->SetTextColor(255);
    // Couleur des lignes du tableau
    $this->SetDrawColor(0,0,0);
    // Épaisseur du tableau
    $this->SetLineWidth(.3);
    // Modifier la police du texte en la police basique
    $this->SetFont('','B');

    // On défini la taille de chaque case de notre en-tête
    $w = array(40, 30, 50, 30, 45);

    // On fait une boucle pour afficher chaque partie de notre en-tête
    for($i=0;$i<count($header);$i++)
    {
        $this->Cell($w[$i],10,$header[$i],1,0,'C',true);
    }
    // Saud de ligne
    $this->Ln();
    // Restauration des couleurs
    $this->SetFillColor(233,198,190);
    // Couleur du texte
    $this->SetTextColor(0);
    // Modifié la police en 'Arial'
    $this->SetFont('Arial');

    // On met la couleur à false 
    $fill = false;

    // On déclare et initialise nos de variables a 0
    $montantHT = 0;
    $montantTTC = 0;

    foreach($data as $row)
    {   
        // Montant par pizza
        $montant = $row[2] * $row[3];
    
        // On affiche la colonne 1 de notre tableau créé par notre requète
        $this->Cell($w[0],6,$row[0],'LRB',0,'L', $fill);
        // On affiche la colonne 2 de notre tableau créé par notre requète
        $this->Cell($w[1],6,$row[1],'LRB',0,'R', $fill);
        // On affiche la colonne 3 de notre tableau créé par notre requète
        $this->Cell($w[2],6,number_format($row[2], $decimals = 2),'LRB',0,'R', $fill);
        // On affiche la colonne 4 de notre tableau créé par notre requète
        $this->Cell($w[3],6,$row[3],'LRB',0,'R', $fill);
        // On affiche la colonne 5 de notre tableau créé par notre requète
        $this->Cell($w[4],6,number_format($montant, $decimals = 2),'LRB',0,'R', $fill);
        // Saut de ligne
        $this->Ln();

    // On fait l'inverse de la couleur pour alterné
    $fill = !$fill;
    }
}

}

// On créé un nouvelle objet PDF
$pdf = new PDF();
// Créer une nouvelle page 
$pdf->AddPage();
// On met la police sur 'Times' et la taille à 12
$pdf->SetFont('Times','',12);

// #####################################################################
// ############################## EN-TETE ##############################
// #####################################################################


// COORDONNEE ENTREPRISE

// On affiche l'image de la boite
$pdf->Image('image/logo.png',140,5,70,35); $pdf->Ln();
// On met la police sur 'Arial' et la taille à 12 et en gras
$pdf->SetFont('Arial','B',12);
// On affiche le nom de l'entreprise
$pdf->Cell(40,5, "Pasta Piz'"); $pdf->Ln();
// On affiche le num de l'entreprise
$pdf->Cell(40,5, "02-54-76-18-25"); $pdf->Ln();
// On affiche le mail de l'entreprise
$pdf->Cell(40,5, "pastapizz@gmail.com"); $pdf->Ln();
// On affiche l'adresse de l'entreprise
$pdf->Cell(40,5, "25 avenue Charles de Gaulles Paris 75000"); $pdf->Ln();



// DATE DE COMMANDE

// On met la police sur 'Arial' et la taille à 12
$pdf->SetFont('Arial','', 12);
// On affiche la date de la facture grâce au requète précédente
$pdf->Cell( 60, 15, "Date de la facture : " . $date_commande); 
// Saut de ligne
$pdf->Ln();


// NUMERO DE COMMANDE

// On affiche le numéro de la commande avec notre requète et un calcul
$pdf->Cell(40,5, "Num de commande : " . 'C' . $num_commande); 
// Saut de ligne de 20
$pdf->Ln(20);


// COORDONNEE CLIENT

// On prend nos variables avec le nom et le prénom du client
$pdf->Cell(0,5, $nom_client . ' ' . $prenom_client,'', 0, 'R'); 
// Saut de ligne
$pdf->Ln();
// On prend notre variable pour afficher le numéro du client 
$pdf->Cell(0,5, $telephone_formate,'', 0, 'R'); 
// Saut de ligne
$pdf->Ln();
// On prend notre variable adresse_client pour afficher l'adresse du client
$pdf->Cell(0,5, $adresse_client,'', 0, 'R');
// Saut de ligne de 20
$pdf->Ln(20);


// AFFICHER LE TABELAU

// On appelle notre fonction tableau
$pdf->FancyTable($header,$data);



$data2 = bdd()->prepare("SELECT prix_pizza, quantite_commande FROM pizzas INNER JOIN commandes, lignes_commandes WHERE pizzas.id_pizza = lignes_commandes.id_pizza AND lignes_commandes.id_commande = commandes.id_commande AND commandes.id_commande = :id_commande");
// On execute notre requète
$data2->execute(array('id_commande' => $id_co));

$montantHT = 0;
$montantTTC = 0;

foreach($data2 as $key)
{
        // Montant pour le total HT
        $montantHT += ($key['prix_pizza'] * $key['quantite_commande']) * 1/(1+0.055);

        // Montant pour le totoal TTC
        $montantTTC += $key['prix_pizza'] * $key['quantite_commande'];

        // Total de TVA
        $montantTVA = 0.055 * $montantHT;
}

    $remise = bdd()->prepare('SELECT remise_commande FROM commandes WHERE id_commande = :id');
    $remise->execute(array('id' => $id_co));
    $remise = $remise->fetch();

    // Saut de ligne de 2 cm
    $pdf->Ln(20);
    // Décalage à gauche de 14 cm
    $pdf->SetLeftMargin(140);
    // Décalage à droite de 0,5 cm
    $pdf->SetRightMargin(5);

    if ($remise['remise_commande'] == "")
    {
        $remise['remise_commande'] = 0;
    }

    $pdf->Cell(0,7, "Remise : ", '1', 0, 'L');
    $pdf->Cell(0,7, $remise['remise_commande'] . " " . chr(37), '1', 0, 'R'); 
    // Saut de ligne de 0,7 cm
    $pdf->Ln(7);

    // Tableau pour tous les montants et la TVA 
    $pdf->Cell(0,7, "Taux TVA : ", '1', 0, 'L');
    $pdf->Cell(0,7, "5,5" . " " . chr(37), '1', 0, 'R'); 
    // Saut de ligne de 0.7 cm
    $pdf->Ln(7);

    // Afficher le montant Hors Taxe
    $pdf->Cell(0,7, "Total HT : ", '1', 0, 'L');
    $pdf->Cell(0,7, number_format($montantHT, $decimals = 2) . " " . chr(128), '1', 0, 'R'); 
    // Saut de ligne de 0,7 cm
    $pdf->Ln(7);

    // Afficher le montant de TVA à payer 
    $pdf->Cell(0,7, "Total TVA : ", '1', 0,'L');
    $pdf->Cell(0,7, number_format($montantTVA, $decimals = 2) . " " . chr(128), '1', 0, 'R'); 
    // Saud de ligne de 0,7 cm
    $pdf->Ln(7);

    // Afficher le montant total à payer
    $pdf->Cell(0,7, "Total TTC Sans Remise : ", '1', 0, 'L');
    $pdf->Cell(0,7, number_format($montantTTC, $decimals = 2) . " " . chr(128), '1', 0, 'R'); 
    // Saut de ligne
    $pdf->Ln(7);

    $pdf->Cell(0,7, "Total TTC Avec Remise : ", '1', 0, 'L');
    $pdf->Cell(0,7, number_format($montantTTC - ($montantTTC * $remise['remise_commande']/100) , $decimals = 2)  . " " . chr(128), '1', 0, 'R'); 
    // Saut de ligne
    $pdf->Ln(0);

// On sors de notre PDF
$pdf->Output();
?>