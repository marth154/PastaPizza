<div id="volet_clos">
		<div id="volet">

			<h2>Connexion</h2>

			<form method="POST" action="connexion.php">


				<input type="text" name="pseudo" placeholder="Identifiant" maxlength="10" required>

				<br><br>

				<input type="password" name="mdp" placeholder="Mot de passe" required>

				<br><br>

				<input type="submit" name="connexion" value="Connexion">

			</form>	

			<h2>Inscription</h2>

			<form method="post" action="inscription.php">

				<input type="text" name="nom" placeholder="Nom" minlength="2" maxlength="10" size="25" autofocus required="">
				<span class="validity"></span>

				<br><br>

				<input type="text" name="prenom" placeholder="Prénom" minlength="2" maxlength="10" size="25" autofocus required="">
				<span class="validity"></span>

				<br><br>

				<input type="text" name="adresse" placeholder="Adresse" minlength="3" maxlength="20" size="25" autofocus required="">
				<span class="validity"></span>

				<br><br>

				<input type="text" name="pseudo" placeholder="Identifiant" minlength="2" maxlength="10" size="25" autofocus required="">
				<span class="validity"></span>

				<br><br>

				<input type="password" name="mdp" placeholder="Mot de passe" minlength="2" maxlength="10" size="25" required="">
				<span class="validity"></span>

				<br><br>

				<input type="password" name="conf_mdp" placeholder="Confirmer mot de passe" minlength="2" maxlength="10" size="25" required="">
				<span class="validity"></span>

				<br><br>

				<input type="email" name="email" placeholder="E-mail" minlength="3" maxlength="40" size="25" required>
				<span class="validity"></span>

				<br><br>

				<input type="tel" name="num_tel" placeholder="Téléphone" minlength="10" maxlength="10" size="25">
				<span class="validity"></span>
			
				<br><br>

				<input type="checkbox" name="cond_utilis" id="cond_utilis" required="">
				<label for="cond_utilis">J'accepte les termes et conditions d'utilisations*</label>
				
				<br><br>

				<div id="button">
					<button class="bouton" type="submit">S'inscrire</button>
				</div>
			</form>

			<a href="#volet" class="ouvrir" aria-hidden="true">Connexion</a>
			<a href="#volet_clos" class="fermer" aria-hidden="true">Connexion</a>
		</div>
	</div>
