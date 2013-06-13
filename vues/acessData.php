<?php
include "../modeles/Utilisateur.class.php";
include "../config/connexionBDD.php";
forceConnecte();


$nombre = (isset($_GET["nombre"])) ? $_GET["nombre"] : NULL; //Récupération du paramètre passé en GET dans l'URL. Instancié à null si 
								//absent.

if ($nombre) {
    // Récuppération dans la base de données de l'objet voulu
	$i= rand(1,20);
	$req="SELECT * FROM mots WHERE id = ". $i;
	$res=mysql_query($req);
	$tab=mysql_fetch_array($res);
	$mot=$tab['libelle'];

	$phrase = "".$mot."@".$tab['categorie']."@".$tab['definition'];
	
	echo $phrase;//Ce qui sera renvoyé
}

$score = (isset($_GET["score"])) ? $_GET["score"] : NULL;
$idUser = (isset($_GET["user"])) ? $_GET["user"] : NULL;

if ($score && $idUser) {

$user = Utilisateur::getUserById($idUser);

$user->save_highScore($idUser,$score);

echo "Vous avez un nouveau record !";

}


?>