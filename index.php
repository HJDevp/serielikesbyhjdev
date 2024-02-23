<!DOCTYPE html>
<html>
  <head>
      <meta charset='utf-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <title>SerieLikesbyhjdevS</title>
      <meta name='viewport' content='width=device-width, initial-scale=1'>
      <link rel="stylesheet" href="bootstrap/css/bootstrap-grid.css">
      <link rel='stylesheet' type='text/css' media='screen' href='css/main.css'>
      <link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
      <script src='js/main.js' async></script>
  </head>
  <body class="body">
    <?php
      /* inclusons la page session et de login */
      include 'session.php';
      if(isset($_SESSION['Connexion'])){
        ?>
          <!-- <h4 style="color: #585858">Bienvenue <?= $Utilisateur1->getLogin() ?></h4> -->
        <?php
          if($Utilisateur1->isAdmin()){
          // echo '<h3>'."Vous etes admin".'</h3>';
        }else{
          // echo '<h3>'."Vous etes un simple visiteur".'</h3>';
        }
      }
      //Dans tous les cas on va afficher les Films
      $Film = new Film(null, null, null, null, 0, null, null, null, null);
      $tableauFilm = $Film->getTousLesFilms();
        
       /*if(isset($_GET['idvote'])){
        echo "L'id du film est : ".$_GET['idvote']; 
       } */ 
        

        if(isset($_POST['star'])){
          echo '<p>'."La note attribue est : ".'<span style="color: orange">'.$_POST['star'].'</span>'.'</p>';
          $noteFilm = new Note($_SESSION['id'], $_GET['idvote'] , $_POST['star']);
          $noteFilm->EnregistrerDansLaBdd();
        }
    
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
    </div> 
    <script type="text/javascript" src="js/script.js"></script>
  </body>
</html>

