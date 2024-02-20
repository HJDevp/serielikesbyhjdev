<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>APP NOTE FILMS</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap-grid.css">
    <link rel="stylesheet" href="css/bootstrap/js/bootstrap.bundle.min.js">
    <link rel='stylesheet' type='text/css' media='screen' href='css/main.css'>
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
    <script src='main.js'></script>
  </head>
<body>

  <?php
   /* inclusons la page session et de login */
    include '../../session.php';
    $Film = new Film(null, null, null, null, 0, null, null, null, null);
    $tableauFilm = $Film->getTousLesFilms();

    if(isset($_SESSION['Connexion'])){
     /*?>
       <h4 style="color: #585858">Bienvenue <?= $Utilisateur1->getLogin() ?></h4>
     <?php */

        if($Utilisateur1->isAdmin()){
        // echo '<p>'."Vous etes admin".'</p>';
  
         if(isset($_POST['deleteFilm'])){
          echo "Hey";
          $Film->setFilmParId($_POST['id']);
          $Film->Delete();
          header('Location: supprimerFilm.php');
         }
  
          if(isset($_POST["IdFilm"])){
           $Film->setFilmParId($_POST["IdFilm"]);
           $Film->renderHTML();
  
           ?>
            <form action="" method="post">
             <p><input type="hidden" name="id" value="<?= $Film->getId() ?>"></p>
             <p>Voulez vous vraiment supprimez le film <strong style="color:#fff"><?= $Film->getTitre() ?></strong></p>
             <p><input style="background-color: #fff;border:none; color:#585858;" type="submit" name="deleteFilm" value="Supprimer le film"></p>
            </form>
           <?php
          }
        
          ?>
            <form action="" method="post" onchange="this.submit()">
              <select id="IdFilm" name="IdFilm">
                <option value="null">Choisir un film</option>
                <?php foreach($tableauFilm as $Films){

                   if($Film->getId() == $Films->getId()){
                     $selectioner = "selected";
                    }else{ $selectioner = "";
                   }
                   echo '<p>'.'<option '.$selectioner.' value="'.$Films->getId().'">'.
                   $Films->getTitre().'</option>'.'</p>';
                }?>
              </select>
            </form>
          <?php

        }else{
          echo "Vous etes un simple visiteur";
        }
    }
  ?>

    
</body>
</html>