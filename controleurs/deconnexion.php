<?php

if(isset($_SESSION['id']))
{
	session_destroy();
	setcookie('id',$_SESSION['id'], time()-1,null,null,false,true);

	header('Location:index.php');
}

?>


