<header>
		
	<h1>PastaPizz'</h1>
		
</header>
<div>
	<nav>
		<ul>
			<li>
				<a href="accueil.php">Accueil</a>
			</li>
			<li>
				<a href="index.php">Carte</a>
			</li>
			<li>
				<a href="contact.php">Contact</a>
			</li>

			<?php
			if (isset($_SESSION['grade']))
			{	
				if($_SESSION['grade'] == 'Livreur')
				{
				?>
					<li>
						<a href="gestion_livraison.php">Gestion Livraison</a>
					</li>
				<?php
				}

				if($_SESSION['grade'] == 'Caissier')
				{
				?>
					<li>
						<a href="gestion_caissier.php">Gestion Caissier</a>
					</li>
				<?php
				}

				if($_SESSION['grade'] == 'Cuisinier')
				{
				?>
					<li>
						<a href="gestion_cuisine.php">Gestion Cuisine</a>
					</li>
				<?php
				}

				if($_SESSION['grade'] == 'Admin')
				{
				?>
					<li>
						<a href="gestion_user.php">Gestion Utilisateurs</a>
					</li>
					<li>
						<a href="gestion_pizza.php">Gestion Pizzas</a>
					</li>
				<?php
				}
	
				if(isset($_SESSION['pseudo']))
				{
					?>
					<li>
						<a href="deconnexion.php">Déconnexion</a>
					</li>
					<?php
				}
			}
			?>

			<div id="navdroite">

			<?php

			if(isset($_SESSION['pseudo']))
			{
				if (isset($_SESSION['grade']))
				{
					if($_SESSION['grade'] == 'utilisateur')
					{
					?>
					<li>
						<a href="compte_user.php"><?php echo $_SESSION['pseudo'];?></a>
					</li>

					<li>
						<a href="message_user.php?id=<?php echo $_SESSION['id_utilisateur'];?>"><img src="image/message.png" width="25"></a>
					</li>

					<?php
					}
					else
					{
					?>
						<li>
							<a><?php echo $_SESSION['pseudo'];?></a>
						</li>
					<?php
						if($_SESSION['grade'] == 'Admin')
						{
						?>
							<li>
								<a href="message_admin.php"><img src="image/message.png" width="25"></a>
							</li>
						<?php
						}
					}
				}

				if ($_SESSION['grade'] == 'utilisateur')
				{
					?>
				
				<li>
					<a href="panier.php">
						<img src="image/bouton.png" alt="caddie" width="25" title="Panier" />
						<?php
							if(isset($_SESSION['panier']))
							{
								echo sizeof($_SESSION['panier']['idPizza']);
							}
						?>
					</a>
				</li>
			<?php
				}
			}
			?>
			<div>

		</ul>
	</nav>
</div>