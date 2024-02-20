<?php
 /* inclusons le fichier de configuration de la base de donnees*/
   include 'connexiondb/config-db.php';

 try
 {   
   $GLOBALS['PDO'] = new PDO($DB_DNS, $DB_USER, $DB_PASS);
   //echo "la connexion a bien ete etablie";
 }
 catch(ErrorException $e){
  echo "Imposible de connecter a la base de donnees".$e->getMessage();
 }


?>