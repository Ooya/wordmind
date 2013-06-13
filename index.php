<?php
include "config/connection.php" ;
include "config/autoload.php";


session_start();

if(isset($_COOKIE['id']) && !isset($_SESSION['id'])  )
{
	$_SESSION['id']=$_COOKIE['id'];
	
}

if(isset($_GET['p']) && file_exists('controleurs/'.$_GET['p'].'.php')){
	include 'controleurs/'.$_GET['p'].'.php';
}
else
{	
	if(isset($_GET['j']))
	{
		$utilisateur= Utilisateur::getUserById($_SESSION['id']);
		include 'vues/page_jeu.php';
	}
	else if(!empty($_SESSION['id']))
	{
		include 'controleurs/systeme_profil.php';
	}
	else
	{
		$tableScore=Utilisateur::all_users();
		include 'vues/accueil.php';
	}

}


?>