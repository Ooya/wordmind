<?php


if(!empty($_POST['email']) && !empty($_POST['mdp']) )
{
	
	if( Utilisateur::bon_identifiant($_POST['email'], $_POST['mdp']) && Utilisateur::verifierConfirmation($_POST['email']) && Utilisateur::verifierAdresseMail($_POST['email']) )
	{	$_SESSION['id'] = Utilisateur::return_id($_POST['email']);
		$id=$_SESSION['id'];
		setcookie('id',$_SESSION['id'], time()+30*24*3600,null,null,false,true);
		$utilisateur= Utilisateur::getUserById($id);
		
		include('vues/page_profil.php');
		
	}
	else
	{	
		$messageConnexion = "Mauvaise combinaison ou compte non valide, veuillez réessayer.";
		include('vues/accueil.php');
		
	}
	
}
else
{
	header('Location:index.php');
}

?>