<?php
 /* inclusons la page session et de login */
 include 'session.php';
  if(isset($_SESSION['Connexion'])){
    ?>
    <center><h4 style="text-transform:uppercase; 
    text-decoration:underline; font-weight:bold; color: orange">
    A propos du film</h4></center><br>
 
   <?php
    $id = $_GET['id'];
    $Film->VoirFilm($id);
  }
 
?>  
