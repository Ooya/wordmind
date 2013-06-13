<?php

class Utilisateur
{

	private $id;
	private $nom;
	private $prenom;
	private $email;
	private $mdp;
	private $valid;
	private $highScore;
	private $admin;
		
		
		public function __construct ($id, $nom,$prenom,$email,$mdp,$valid,$highScore,$admin) 
		{ //un constructeur
			$this->id = $id;
			$this->nom = $nom;
			$this->prenom = $prenom;
			$this->email = $email;
			$this->mdp = $mdp;
			$this->valid = $valid;
			$this->highScore = $highScore;
			$this->admin = $admin;
		}
		
		//-------------getter-----------------------------
		
		public function getId() 
		{ 
			return $this->id;
		}
		
		public function getNom() 
		{ 
			return $this->nom;
		}
		
		public function getPrenom() 
		{ 
			return $this->prenom;
		}
		
		public function getEmail() 
		{ 
			return $this->email;
		}
		
		public function getMdp() 
		{ 
			return $this->mdp;
		}
		
		public function getValid() 
		{ 
			return $this->valid;
		}
		
		public function getHighScore() 
		{ 
			return $this->highScore;
		}
		
		public function getAdmin() 
		{ 
			return $this->admin;
		}

		//--------------------setter------------------------------
		
		public function setNom($nom) 
		{ 
			 $this->nom=$nom;
		}
		
		public function setPrenom($prenom) 
		{ 
			$this->prenom=$prenom;
		}
				
		public function setEmail($email) 
		{ 
			$this->email=$email;
		}
			
		public function setValid($valid) 
		{ 
			$this->valid=$valid;
		}
		
		public function setAdmin($admin) 
		{ 
			$this->admin=$admin;
		}
		
		
		//--------------------------------------------------------
		
		
		public static function getUserById($id) 
		{ //une fonction statique
			
			$req="SELECT * FROM utilisateurs WHERE id=$id";
			$result=mysql_query($req);
			$tab=mysql_fetch_array($result);
			
			return new Utilisateur($tab['id'],$tab['nom'],$tab['prenom'],$tab['email'],$tab['mdp'],$tab['valid'],$tab['highScore'],$tab['admin']);
			
		}
		
		public function ajoutUser()
		{
		
		$req4= "INSERT INTO utilisateurs VALUES ('','".$this->getNom()."','".$this->getPrenom()."', '".$this->getEmail()."', '".$this->getMdp()."','".$this->getValid()."','".$this->getHighScore()."','".$this->getAdmin()."')";
		$res=mysql_query($req4);
		
		}

			
		public static function deleteUser($id)
		{
		
		$req= " DELETE FROM utilisateur WHERE id=$id ";
		$res=mysql_query($req);
		
		}
		
		public static function getAllUser($id)
		{
			$req="SELECT id,nom,prenom,valid FROM utilisateur WHERE id !=$id AND admin = 0";
			$result=mysql_query($req);
			return $result;
		}
		
		public static function validUser($id,$valid)
		{
		$req=" UPDATE utilisateur SET valid=$valid WHERE id=$id ";
		$result=mysql_query($req);
			
		}
		
		public static function bon_identifiant($email, $password)
	    {
			$mdp=Utilisateur::crypter_mdp($password);
			$req ="SELECT * FROM utilisateurs WHERE email ='$email' AND mdp = '$mdp'";
			$res=mysql_query($req);
			if(mysql_num_rows($res)==1)
			{
				$valeur=true;
			}
			else 
			{
				$valeur= false;
			}
			return $valeur;
		
		}

		public static function verifierConfirmation($email)
		{//verifie que le compte est valider
			$req ="SELECT * FROM utilisateurs WHERE email='$email' AND valid=1";
			$res=mysql_query($req);
			if(mysql_num_rows($res)==1)
			{
				$valeur=true;
			}
			else
			{
				$valeur= false;
			}
		return $valeur;

		}
		
		public static function existe_mail($email)
		{//verifie si un mail existe deja
			$req3 =" SELECT * FROM utilisateurs WHERE email='$email'";
			$res=mysql_query($req3);
			if(mysql_num_rows($res)==1)
			{
				$valeur=true;
			}
			else
			{
				$valeur= false;
			}
			return $valeur;
		}

		public static function verifierAdresseMail($adresse)
		{
		$Syntaxe="#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#";
		if(preg_match($Syntaxe,$adresse))
			{
			return true;
			}
		else
			{
	        return false;
	     
	        }
	    }
	    
	    public static function crypter_mdp($password)
	    {
			return md5( $password);
		}

		public static function return_id($email)
		{
		
			$req="SELECT * FROM utilisateurs WHERE email ='$email'";
			$res=mysql_query($req);
			$tab=mysql_fetch_array($res); 
			return $tab['id'];
		}

		public static function save_highScore($idUser, $score) {
			$req=" UPDATE utilisateurs SET highScore=$score WHERE id=$idUser ";
			mysql_query($req);
		}

		public static function all_users(){
			$req="SELECT * FROM utilisateurs ORDER BY highScore DESC";
			$result=mysql_query($req);
			
			return $result; 
		}

}









?>