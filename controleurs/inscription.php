<?php


if (!empty($_POST['email']) && !empty($_POST['mdp'])  && !empty($_POST['nom']) && !empty($_POST['prenom']))
{
	
	if(!(Utilisateur::existe_mail($_POST['email'])) && (Utilisateur::verifierAdresseMail($_POST['email'])) )
	{
		$mdp=Utilisateur::crypter_mdp($_POST['mdp']);
		$utilisateur=new Utilisateur('',$_POST['nom'],$_POST['prenom'],$_POST['email'],$mdp,1,'','');
		$utilisateur->ajoutUser();
		//envoi_email($_POST['email'],$mdp);
		$messageInscription = "Vous êtes inscrit !";
	}else
	{	
		if(Utilisateur::existe_mail($_POST['email']))
		{
			$messageInscription = "Cette adresse email est deja utilisée.Veuillez entrer une adresse email valide";
		}
		else
		{
			
			$messageInscription = "Problème d'inscription, veuillez ressayer.";
		}
	}
	include 'vues/accueil.php';
}
else
{

	header('Location:index.php');
}





?>