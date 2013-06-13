<?php
include "config/connection.php";
$varEmail=$_GET["email"];
$varKey=$_GET["mdp"];


$result=" SELECT * FROM utilisateurs WHERE (email='$varEmail' AND  mdp='$varKey')";
$final=mysql_query($result);



if(mysql_num_rows($final)==1){
                $ok="UPDATE utilisateurs SET valid = 1 WHERE email = '$varEmail'";
                mysql_query($ok);
                echo 'COMPTE VALIDE !'.'</br>'.'Vous pouvez maintenant vous connecter';
                
        }
        else{
                echo 'Problème validation !';
        }
        header('location:index.php');
?>

