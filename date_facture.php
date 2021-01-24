<table border="1">
    <form action="pdf_user.php" method="POST"  target="_blank">

<!-- Création d'un tableau pour la propreté -->
    <tr align="center">
        <td  colspan="2">
            Créer une facture
        </td>
    </tr>

    <tr>
        <td> 
            Choisir une date de votre facture
        </td>

        <td>
            <!-- Formulaire pour la date du client -->
            <select name="date" >
                <?php
                $rep = bdd()->prepare("SELECT nom, prenom FROM utilisateurs WHERE pseudo LIKE :pseudo");
                $rep->execute(array('pseudo' => $_SESSION['pseudo']));

                foreach($rep as $line)
                {
                    $prenom = $line['prenom'];
                    $nom = $line['nom'];
                }

                // Requète pour récupérer toute les dates
                $req = bdd()->prepare("SELECT date_commande FROM commandes INNER JOIN clients WHERE clients.id_client = commandes.id_client AND nom_client LIKE :nom AND prenom_client LIKE :prenom");
                $req->execute(array(
                    'nom' => $nom,
                    'prenom' => $prenom
                    ));
                foreach($req as $line)
                {
                    // On affiche notre résultat dans un select pour notre PDF
                    echo "<option>" . $line['date_commande'] . "</option>";
                }
                ?>
            </select>
        </td>
    </tr>
</table>

<br/>

<input type="submit" value="Création du PDF">
</form>