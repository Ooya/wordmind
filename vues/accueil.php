<html>

<head>
	<title>WORDMIND</title>
	<meta name="description" content="website description" />
	<meta name="keywords" content="website keywords, website keywords" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<script type="text/javascript"> 
	function surligne(champ, erreur)
	{
		if(erreur)
			champ.style.backgroundColor = "#fba";
		else
			champ.style.backgroundColor = "";
	}


	function verifMail(champ)
	{
		var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
		if(!regex.test(champ.value))
		{
			surligne(champ, true);
			return false;
		}
		else
		{
			surligne(champ, false);
			return true;
		}
	} 
	</script>
</head>
<body>
	<div id="contenu">	
		<div id="titre">
			<h1>Wordmind</h1>
		</div>
		<div id="regles">
			<h2>Règles du jeu</h2>
			<p>
				Vous connaissez le principe du Mastermind ?
				Nous vous le proposons avec des mots ! <br/>
				Le but du jeu est de trouver le mot masqué, 
				en utilisant le moins de tentatives possibles.
				À chacune de vos tentatives, des indices vous seront
				donnés en fonction des lettres que vous avez rentré. <br>
				Bonne chance !
		</div>
		<div id="connexion">
			<form method="post" action="index.php?p=connexion">
				<div><h2>Connexion</h2></div>
				<p>Connectez-vous pour jouer !</p>
				<input type="text" name="email" placeholder="E-mail" onblur="verifMail(this)"><br/>
				<input type="password" name="mdp" placeholder="Mot de passe"><br/>
				<input type="submit" name="connexion" value="Se connecter" class="boutonRouge"><br/>
			</form>

			<?php
			if(isset($messageConnexion))
			{
				echo $messageConnexion;
			}

			?>

		</div>
		<div id="scores">
			<h2>Meilleurs scores</h2>
			<?php
				while($tab=mysql_fetch_array($tableScore)) {
					?>
						<p><?php echo "".$tab['nom']." ".$tab['prenom']." : ".$tab['highScore'] ?></p>
					<?php
				}
			?>
		</div>
		<div id="inscription">
			<form method="post" action="index.php?p=inscription">
				<div><h2>Inscription</h2></div>
				<p>Pas encore de compte ? Remplissez les champs</p>
				<input type="text" name="nom" placeholder="Votre nom" /><br/>
				<input type="text" name="prenom" placeholder="Votre prenom"/><br/>
				<input type="text" name="email" placeholder="Votre adresse mail" onblur="verifMail(this)" /><br/>
				<input type="password" name="mdp" placeholder="Votre mot de passe" /><br/>
				<input type="submit" name="inscription" value="S'inscrire" class="boutonRouge" /><br/>
			</form>

			<?php

			if(isset($messageInscription))
			{
				echo $messageInscription;
			}

			?>
		</div>
	</div>
</body>


</html>