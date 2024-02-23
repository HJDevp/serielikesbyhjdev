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
     ?>
       <h4 style="color: #585858">Bienvenue <?= $Utilisateur1->getLogin() ?></h4>
      <?php
      if($Utilisateur1->isAdmin()){
        echo "Vous etes admin ";
  
        if(isset($_POST['IdFilm'])){
         $Film->setFilmParId($_POST['IdFilm']);
        }
        if(isset($_POST['star'])){
         echo '<p>'."La note attribue est : ".'<span style="color: orange">'.$_POST['star'].'</span>'.'</p>';
         $noteFilm = new Note($_SESSION['id'], $_POST['idNoteFilm'], $_POST['star']);
         $noteFilm->EnregistrerDansLaBdd();
        }
    
       ?>
       <form action="" method="post" onchange="this.submit()">
          <select id="IdFilm" name="IdFilm">
            <option value="null">Choisir un film</option>
            <?php  
              $afficheEtoile = true;
              foreach($tableauFilm as $Films){
                if($Film->getId() == $Films->getId()){
                   $selectioner = "selected";
                  }else{ $selectioner = "";
                }
                echo '<p>'.'<option '.$selectioner.' value="'.$Films->getId().'">'.
                $Films->getTitre().'</option>'.'</p>';
              }
            ?>  
          </select>
       </form><br>
    
       <?php if($afficheEtoile){ 
        ?>
          <p>Attribue une note ce film : </p>
          <form action="" method="post" onclick="this.submit()">   
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
            <p><input type="hidden" name="idNoteFilm" value="<?= $Film->getId() ?>"></p>
          </form>
        
        <?php }
      }else{
        echo "Vous etes un simple visiteur vous ne pouvez pas effectuez de Crud";
      }
    
    }

 ?>    
 </body>
</html>