<?php

session_start();

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

<form method="POST" action="traitement_add_staff.php">
	<table border="1">
		<tr align="center">
			<td>
				Pseudo utilisateur
			</td>
	
			<td>
				Nom utilisateur
			</td>
	
			<td>
				Prénom utilisateur
			</td>
			<td>
				Mot de passe
			</td>
			<td>
				Confirmation Mot de passe
			</td>
			<td>
				Grade
			</td>
		</tr>
	
		<tr>
			<td>
				<input type="text" name="pseudo" placeholder="Pseudo" required>
			</td>
			<td>
				<input type="text" name="nom" placeholder="Nom" required>
			</td>
			<td>
				<input type="text" name="prenom" placeholder="Prénom" required>
			</td>
			<td>
				<input type="password" name="pass" placeholder="Mot de passe" required>
			</td>
			<td>
				<input type="password" name="conf_pass" placeholder="Confirmation de Mot de passe" size="29" required>
			</td>
			<td>
				<select name="grade"  required>
					<option></option>
					<option>Livreur</option>
					<option>Caissier</option>
					<option>Cuisinier</option>
				</select>
			</td>
		</tr>
	
	</table>

<br/><br/>

	<input type="submit">

</form>