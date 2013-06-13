<?php
     
     if (!empty($_SESSION['id']) && isset($_SESSION['id'])) {
     //do nothing
     }
     else {
     // pas de login en session : redirection sur la page public
     header("Location:index.php");
     }
?>
