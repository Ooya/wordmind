<?php
                                        
$hostname='infolimon';  //infolimon ou localhost
$login='mamenee';
$passwd='1104016001T';
$base='mamenee';
$connect = mysql_connect($hostname,$login,$passwd) or die ("erreur de connexion");
mysql_select_db($base,$connect) or die ("erreur de connexion base");
                        
?>
