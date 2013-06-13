<?php

	if(!empty($_SESSION['id'])){
		
		$utilisateur= Utilisateur::getUserById($_SESSION['id']);
		include 'vues/page_profil.php';
	}
	else
	{
		header('location:index.php');
	}



	
?>