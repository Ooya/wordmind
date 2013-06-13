<?php
function chargerClasse($classe)
{
  require 'modeles/'.$classe.'.class.php'; // On inclut la classe correspondante au paramètre passé.
}
spl_autoload_register ('chargerClasse');

?>