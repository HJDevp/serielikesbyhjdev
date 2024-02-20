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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src='main.js'></script>
    </head>
<body>

  <?php
   /* inclusons la page session et de login */
    include '../../session.php';

    if(isset($_SESSION['Connexion'])){
     /*?>
       <h4 style="color: #585858">Bienvenue <?= $Utilisateur1->getLogin() ?></h4> 
     <?php */

      if(isset($_POST['inserer'])){
       $nouveauFilm = new Film(null, $_POST['titre'], $_POST['resume'], $_POST['lienImage'],
       $_POST['star'], $_POST['datedesortie'], $_POST['genre'], $_POST['duree'], $_POST['acteur']);
       $nouveauFilm->EnregistrerDansLaBdd();
      }

     if($Utilisateur1->isAdmin()){
      //  echo "Vous etes admin ";
        ?>
          <form action="" method="post">
          
            <p><input type="text" placeholder="titre" name="titre" required></p>
          
            <p><input type="text" placeholder="name" name="resume" required></p>
          
            <p><input type="text" placeholder="lienImage" name="lienImage" required></p> 

            <p><input type="text" placeholder="date de sortie" name="datedesortie" required></p>

            <p><input type="text" placeholder="Genre" name="genre" required></p> 

            <p><input type="text" placeholder="Duree" name="duree" required></p>  

            <p><input type="text" placeholder="Acteur" name="acteur" required></p> 
           <!-- formulaire pour valider une note-->
            <div class="txt-center"> 
              <div class="rating">
                  <input id="star5" name="star" type="radio" value="5" class="radio-btn hide" />
                  <label for="star5">☆</label>
                  <input id="star4" name="star" type="radio" value="4" class="radio-btn hide" />
                  <label for="star4">☆</label>
                  <input id="star3" name="star" type="radio" value="3" class="radio-btn hide" />
                  <label for="star3">☆</label>
                  <input id="star2" name="star" type="radio" value="2" class="radio-btn hide" />
                  <label for="star2">☆</label>
                  <input id="star1" name="star" type="radio" value="1" class="radio-btn hide" />
                  <label for="star1">☆</label>
                  <div class="clear"></div>
              </div>
            </div>
            <p><input type="submit" name="inserer" value="Inserer un film"></p>
          </form>
         
        <?php
      }else{
       echo "Vous etes un simple visiteur vous ne pouvez pas effectuez de Crud";
      }
    
    }

    //Dans tous les cas on va afficher les Films

    $Film = new Film(null, null, null, null, 0, null, null, null, null);
    $tableauFilm = $Film->getTousLesFilms();
    

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