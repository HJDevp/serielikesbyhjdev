<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>SerieLikesbyhjdevS</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap-grid.css">
    <link rel="stylesheet" href="css/bootstrap/js/bootstrap.bundle.min.js">
    <link rel='stylesheet' type='text/css' media='screen' href='css/main.css'>
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src='main.js'></script>
  </head>
<body>

  <?php
   /* inclusons la page session et de login */
    include '../../session.php';
    $Film = new Film(null, null, null, null, 0, null, null, null, null);
    $tableauFilm = $Film->getTousLesFilms();

    if(isset($_SESSION['Connexion'])){
     /* ?>
       <h4 style="color: #585858">Bienvenue <?= $Utilisateur1->getLogin() ?></h4>
     <?php */

     if($Utilisateur1->isAdmin()){
       echo '<p>'."Vous etes admin".'</p>';

       if(isset($_POST['IdFilm'])){
        $Film->setFilmParId($_POST['IdFilm']);
       }
       
       ?>
         <form class="formSelect" action="" method="post" onchange="this.submit()">
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
            if(isset($_POST['miseajour'])){
             $Film->setFilmParId($_POST['id']);
             $Film->setTitre($_POST['titre']);
             $Film->setResume($_POST['resume']);
             $Film->setLiensImage($_POST['lienImage']);
             $Film->setDatedeSortie($_POST['datedesortie']);
             $Film->setGenre($_POST['genre']);
             $Film->setDuree($_POST['duree']);
             $Film->setResume($_POST['resume']);
             $Film->setActeur($_POST['acteur']);
             $Film->EnregistrerDansLaBdd();
            }
          ?>

            <form action="" method="post">
              <p><input type="text" placeholder="titre" name="titre" value="<?= $Film->getTitre() ?>" required></p>
              <p><input type="text" placeholder="resume" name="resume" value="<?= $Film->getResume() ?>" required></p>
              <p><input type="text" placeholder="lienImage" name="lienImage" value="<?= $Film->getLiensImage() ?>" required></p>
              <p><input type="hidden" name="id" value="<?= $Film->getId() ?>"></p>
              <p><input type="text" placeholder="date de sortie" name="datedesortie" value="<?= $Film->getDatedeSortie() ?>" required></p>
              <p><input type="text" placeholder="Genre" name="genre" value="<?= $Film->getGenre() ?>" required></p> 
              <p><input type="text" placeholder="Duree" name="duree" value="<?= $Film->getDuree() ?>" required></p>
              <p><input type="text" placeholder="Acteur" name="acteur" value="<?= $Film->getActeur() ?>" required></p>
              <p><input type="submit" name="miseajour" value="Modifier le film"></p>  
            </form>   
        <?php

      }else{
        echo "Vous etes un simple visiteur";
      }
    
    }

    //Dans tous les cas on va afficher les Films
      
    ?>
     <div class="row row-cols-1 row-cols-md-3 g-4 m-0 p-0">    
    <?php
    foreach($tableauFilm as $Film){
      ?>
        <div class="col">
      <?php
      $Film->renderHTML();
    }

  ?>

    
</body>
</html>