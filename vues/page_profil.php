<?php
require "config/est_autorise.php";
?>

<html>

<head>
	<title>WORDMIND</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="./css/styles.css">
	
</head>
<body>
	<div id="contenu">
		<div style="height:2%;"></div>
		<div id="plateauProfil">
			<div>
				<h2>Bienvenue sur votre espace personnel <?php echo $utilisateur->getNom().' '.$utilisateur->getPrenom(); ?> </h2>
			</div>
			<div style="margin-left:15px;">Votre meilleur score est : <?php echo $utilisateur->getHighScore(); ?> </div>
			<p><a href="index.php?p=systeme_profil" class="boutonRouge">Accueil profil</a></p>
			<p><a href="index.php?p=deconnexion" class="boutonRouge">Se déconnecter</a></p>
		</div>
		<div style="height:2%;"></div>

		<div id="boutonJouer">
			<a href="index.php?j=jouer"><div id="texteBouton">Jouer !</div></a>
		</div>


	</div>

</body>

</html>