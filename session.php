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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
      <script src='js/main.js'></script>
  </head>
  <body>  
    <?php
     session_start();
     /* inclusons la connexion a la base de donnees et 
     la classe utilisateur */
     include 'classe/utilisateur.php';
     include 'classe/film.php';
     include 'classe/note.php';
     include 'connexiondb/connexion.php';
     
    
      $Utilisateur1 = new Utilisateur(null, null, null);  
      $Film = new Film(null, null, null, null, 0, null, null, null, null);
      if(isset($_POST['valider'])){
        if(isset($_POST['login']) && isset($_POST['password'])){
         $login = $_POST['login'];
         $password = $_POST['password'];
         
         $Utilisateur1->seConnecter($login, $password);
          // echo '<p>'."Votre login est : ".'<strong>'.$_POST['login'].'</strong>'.
          // " et votre mot de passe est : ".'<strong>'.$_POST['password'].'</strong>'.'</p>';
        }
      }
  
      if(isset($_POST['deconnexion'])){
       $Utilisateur1->seDeconnecter();
      }
    
        if(isset($_SESSION['Connexion']) && $_SESSION['Connexion'] == true){
          $Utilisateur1->setUtilisateurId($_SESSION['id']);
        ?>

          <br>
          <div class="container">
            <div class="row">
                <div class="col-md-12">
                  <nav class="navbar navbar-expand-lg bg-body-tertiary">
                    <div class="container-fluid">
                      <small><a  style="text-transform: uppercase; color: orange;" class="navbar-brand" href="../../index.php">SeriesLike By HJDev</a></small>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                         <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                          <ul class="navbar-nav">
                            <li class="nav-item">
                             <a class="nav-link active" aria-current="page" href="">Acceuil</a>
                            </li>
                            <li class="nav-item">
                             <a class="nav-link" href="">compte</a>
                            </li>
                           
                            <?php if($Utilisateur1->isAdmin() == true){ ?>
                              <li class="nav-item dropdown">
                               <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Films
                               </a>
                               <ul class="dropdown-menu">
                                 <li><a class="dropdown-item " name="laptop" href="" disabled style="font-weight:bold">Gerer les films</a></li><br>
                                 <li><a class="dropdown-item" href="classe/crudFilm/creerFilm.php">Ajouter un film</a></li>
                                 <li><a class="dropdown-item" href="classe/crudFilm/modifierFilm.php">Modifier un film</a></li>
                                 <li><a class="dropdown-item" href="classe/crudFilm/supprimerFilm.php">Supprimer un film</a></li>
                               </ul>
                              </li>
                            <?php  }else{echo "";}?>
                             
                            <li class="image-user">
                              <span><img class="image-user" src="css/image/user3.png"></span>
                              <small class="user"><span><?= substr($Utilisateur1->getLogin(), 0, 5) ?></span></small>
                            </li>

                            <div class="user-info">
                              <h2>SeriesLikeByhjdev</h2>
                              <h4>Login: <?= $Utilisateur1->getLogin() ?></h4>
                            </div>

                            <div class="deconnex">
                              <form class="deconnex" action="" method="post">
                               <small><input type="submit" value="deconnexion"
                                style="border-radius: 10px; width: 150px;
                                " name="deconnexion" value="submit"></small>
                              </form>
                            </div>   
                          </ul>
                        </div>
                      </div>
                    </nav>
              </div>
            </div>
    
        <?php 
        }else{
        ?>
          <div class="image-de-font">
            <center>
              <form class="form" action="" method="post">
                <center>
                 <p style="color: orange">App notes Films</p>
                 <p style="color: red">Veuillez vous connecter</p>
                </center>
                <input type="text" placeholder="email" name="login"  required><br>
                <input type="text" placeholder="Mot de passe" name="password"><br>
                <input type="submit"  value="Connexion" name="valider">
       
                <div class="UserProblem">
                 <p id="pe"><small>Vous n'avez pas encore de compte?
                 <input type="submit" id="inscription" name="inscription" value="s'inscrire"></small></p><br>
                 <p id="pm"><a href="" >Mot de passe oublie</a></p>
                </div>
                <?php
                  if(isset($_POST['inscription']) && isset($_POST['login'])){
                   $Utilisateur1->CreerNewUtilisateur($_POST['login'], $_POST['password']);

                  } 
                ?>
              </form>
            </center>
          </div> <br>  
        <?php   
      }
    ?>
   
  
    
    
    
    