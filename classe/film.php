<?php
 class Film{

  //Proriete des Films

  private $id;
  private $titre;
  private $resume;
  private $lienImage;
  private $moyenneNote;
  private $DateDeSortie;
  private $Genre;
  private $Duree;
  private $Acteur;

  //Les Methodes public des Films

    public function __construct($id, $titre, $resume, $lienImage, $noteSur5,
     $DateDeSortie, $Genre, $Duree, $Acteur){
     $this->id = $id;
     $this->titre = $titre;
     $this->resume = $resume;
     $this->lienImage = $lienImage;
     $this->moyenneNote = $noteSur5;
     $this->DateDeSortie = $DateDeSortie;
     $this->Genre = $Genre;
     $this->Duree = $Duree; 
     $this->Acteur = $Acteur;
    }

    public function setFilmParId($id){

     $SQL = " SELECT film.id, film.titre, film.resume, film.lienImage, 
     film.datedesortie, film.genre, film.duree, film.acteur,
     AVG(note.noteSur5) as note
     FROM film, note, utilisateur
     WHERE
     film.id = note.idFilm
     AND
     note.idUtilisateur = utilisateur.id
     AND film.id = '".$id."' "; 
   
     $res = $GLOBALS['PDO']->prepare($SQL);
     $res->execute();

     if($res->rowCount() > 0){
      $data = $res->fetch();
      $this->id = $data['id'];
      $this->titre = $data['titre'];
      $this->resume = $data['resume'];
      $this->lienImage = $data['lienImage'];
      $this->moyenneNote = $data['note'];
      $this->DateDeSortie = $data['datedesortie'];
      $this->Genre = $data['genre'];
      $this->Duree = $data['duree'];
      $this->Acteur = $data['acteur'];
     }
    
    }

    public function getTousLesFilms(){
     $listeFilms = [];

     $SQL =" SELECT film.id, film.titre, film.resume, film.lienImage,
     film.datedesortie, film.genre, film.duree, film.acteur,
     AVG(note.noteSur5) as note
     FROM film, note, utilisateur WHERE 
     film.id = note.idFilm AND 
     note.idUtilisateur = utilisateur.id
     GROUP BY film.id";

     $res = $GLOBALS['PDO']->prepare($SQL);
     $res->execute();
     
      while($data = $res->fetch(PDO::FETCH_ASSOC)){   

        $Film = new Film($data['id'], $data['titre'], $data['resume'], $data['lienImage'],
         $data['note'], $data['datedesortie'], $data['genre'], $data['duree'], $data['acteur']);
  
        array_push($listeFilms, $Film);
      }

     return $listeFilms;
    }

    public function getId(){
     return $this->id;
    }

    public function getTitre(){
     return $this->titre;
    }

    public function getResume(){
     return $this->resume;
    }

    public function getImage(){
     $imageHTML = "<img src='".$this->lienImage."' width='auto' alt='".$this->titre."' ";    
     return $imageHTML;
    }

    public function getLiensImage(){
     return $this->lienImage;
    }

    public function getDatedeSortie(){
     return $this->DateDeSortie;
    }

    public function getGenre(){
     return $this->Genre;
    }

    public function getDuree(){
     return $this->Duree;
    }

    public function getActeur(){
     return $this->Acteur;
    }

    public function renderHTML(){
      ?>
        <div class="card">
          <?= $this->getImage() ?>
          <div class="card-body">
           <hr>
           <h4 style="padding-bottom: 8px; 
           letter-spacing:1px; font-family: cambria;
           font-weight: 800; color:#585858"><center>Titre : <span style="color:orange; text-transform:capitalize;"><?= $this->titre ?></span></center></h4>
            <center><a href="index.php?idvote=<?= $this->getId()?>">
            <button name="vote" id="button">
             voter</button></a></center><br>
        
            <?php
              if(isset($_GET['idvote'])){
                if(isset($_GET['idvote']) == $this->id){
               ?>
                  <form method="post" onclick="this.submit()"> 
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
                      <p><input type="hidden" name="idNoteFilm" value="<?= $this->getId()?>"></p>
                  </form>
                <?php }
              }
            ?>
           </center>
           <!-- titre -->
            <div class="d-flex justify-content-center  text-warning mb-2">
             <?php
                for($i = 0 ; $i < round($this->moyenneNote); $i++){
                 echo '<div class="bi-star-fill">☆</div>';
                }
             ?>
             &nbsp; <?= round($this->moyenneNote)." /5" ?>
            </div>
           <small style="color:#ffcb61">Resume</small>
           <p class="card-text" style="color: #000;font-family:cambria;"><?= substr($this->resume, 0, 150)."...." ?></p>
           <i class='fas fa-calendar-alt' style='font-size:20px;color:#585858;margin:5px 20px 1rem '><small>Date de Sortie : </small></i>
            <span style='color:#585858;margin:5px 20px 1rem'><?= $this->DateDeSortie ?></span>
            <span  style='font-size:20px;color:#585858;margin:5px 20px 1rem'>Genre : <?= $this->Genre ?></span>
            <span  style='font-size:20px;color:#585858;margin:5px 20px 1rem'>Duree du <?= $this->Duree ?> : <?= $this->Duree ?></span>
           <i class='fas fa-tv' style='font-size:20px;color:#585858;margin:5px 20px 1rem'><small>Les personnages du <?= $this->Genre ?> :</small></i>
           <span style='color:orange;margin:5px 20px 1rem'><?= $this->Acteur ?></span>
           <a href="voirPlus.php?id=<?= $this->getId()?>" style="text-align:center"><button class="btn btn-warning">+ voir plus</button></a><br>
          </div>
        </div>
      <?php
    }
    
   
    public function VoirFilm($id){
      $SQL = " SELECT film.id, film.titre, film.resume, film.lienImage,
      film.datedesortie, film.genre, film.duree, film.acteur,
      AVG(note.noteSur5) as note
      FROM film, note, utilisateur
      WHERE
      film.id = note.idFilm
      AND
      note.idUtilisateur = utilisateur.id
      AND film.id = '".$id."' ";

      $res = $GLOBALS['PDO']->prepare($SQL);
      $res->execute();

      if($res->rowCount() > 0){
        $data = $res->fetch();
        $this->id = $data['id'];
        $this->moyenneNote = $data['note'];
        
        $imageHTML = "<img src='".$data['lienImage']."' width='auto' alt='".$data['titre']."' ";    

        if($this->id == $this->getId()){
          ?>
           <div class="card">
             <?= $imageHTML ?>
             <div class="card-body">
              <hr>
              <h4 style="padding-bottom: 8px; 
               letter-spacing:1px; font-family: cambria;
               font-weight: 800; color:#585858;"><center>Titre : <span style="color:orange;text-transform:capitalize;"><?= $data['titre'] ?></span></center></h4> 
  
              <center><p style="color:green">Moyenne du film</p>
                <p style="color:orange">&nbsp;<?= round($this->moyenneNote)." /5" ?></p>
              </center>
              <div class="d-flex justify-content-center  text-warning mb-2">
                
                <?php
                  for($i = 0 ; $i < round($this->moyenneNote); $i++){
                   echo '&nbsp;'.'<div class="bi-star-fill">☆</div>';
                  }
                ?> 
              </div>
              <small style="color:#ffcb61">Resume</small>
              <p class="card-text" style="color: #000;font-family:cambria;"><?= $data['resume'] ?></p>
              <i class='fas fa-calendar-alt' style='font-size:20px;color:#585858;margin:5px 20px 1rem '><small>Date de Sortie : </small></i>
            <span style='color:#585858;margin:5px 20px 1rem'><?= $data['datedesortie'] ?></span>
            <span  style='font-size:20px;color:#585858;margin:5px 20px 1rem'>Genre : <?= $data['genre'] ?></span>
            <span  style='font-size:20px;color:#585858;margin:5px 20px 1rem'>Duree du <?= $data['genre'] ?>: <?= $data['duree'] ?></span>
            <i class='fas fa-tv' style='font-size:20px;color:#585858;margin:5px 20px 1rem'><small>Les personnages du film :</small></i>
            <span style='color:orange;margin:5px 20px 1rem'><?= $data['acteur'] ?></span>
            <i class='fas fa-film' style='font-size:20px;color:#585858;margin:5px 20px 1rem'><small>Lien pour regader <?= $data['genre'] ?> : </small></i>
             <span style='margin:5px 20px 1rem'><a href="http://www.viisionerlefilm.com" target="_blank" rel="noopener noreferrer">visionner le film</a></span>
            </div>
           </div><br>
         <?php
          
         
        } 
      }
    }
    public function setTitre($titre){
     $this->titre = $titre;
    }

    public function setResume($resume){
     $this->resume = $resume;
    }

    public function setLiensImage($lienImage){
     $this->lienImage = $lienImage;
    }

    public function setDatedeSortie($DateDeSortie){
     $this->DateDeSortie = $DateDeSortie;
    }

    public function setGenre($Genre){
     $this->Genre = $Genre;
    }

    public function setDuree($Duree){
     return $this->Duree = $Duree; 
    }

    public function setActeur($Acteur){
     return $this->Acteur = $Acteur;
    }

    public function EnregistrerDansLaBdd(){

       $titre = addslashes($this->titre); 
       $resume = addslashes($this->resume);
       $lienImage = addslashes($this->lienImage);
       $DatedeSortie = addslashes($this->DateDeSortie);
       $Genre = addslashes($this->Genre);
       $Duree = addslashes($this->Duree);
       $Acteur = addslashes($this->Acteur);


      if(is_null($this->id)){
       
       $SQL = "INSERT INTO `film`(`titre`, `resume`, `lienImage`, `datedesortie`, `genre`,
       `duree`, `acteur`)
       VALUES('".$titre."', '".$resume."', '".$lienImage."',
       '".$DatedeSortie."', '".$Genre ."', '".$Duree ."', '".$Acteur."')";
  
       $res = $GLOBALS['PDO']->prepare($SQL);
       $res->execute();
       $this->id = $GLOBALS['PDO']->lastInsertId();


        $SQL = "INSERT INTO `note`(`idUtilisateur`, `idFilm`, `noteSur5`)
        VALUES('".$_SESSION['id']."', '".$this->id."', '".$this->moyenneNote."')";
        $res = $GLOBALS['PDO']->prepare($SQL);
        $res->execute();
        //header('Location: creerFiml.php');
       
      }else{
       //Faire une mise a jour si l'ID n'est pas null
       echo '<p>'."Vous allez modifier le film N".'<sup>'."o".'</sup>'.$this->id.'</p>';
       $titre = addslashes($this->titre); 
       $resume = addslashes($this->resume);
       $lienImage = addslashes($this->lienImage);
       $DatedeSortie = addslashes($this->DateDeSortie);
       $Genre = addslashes($this->Genre);
       $Duree = addslashes($this->Duree);
       $Acteur = addslashes($this->Acteur);

       $SQL = "UPDATE `film` SET 
       `titre`='".$titre."', 
       `resume`= '".$resume."', 
       `lienImage`= '".$lienImage."',
       `datedesortie` = '".$DatedeSortie."',
       `genre` = '".$Genre."',
       `duree` = '". $Duree."',
       `acteur` = '".$Acteur."'
        WHERE id = '".$this->id."' ";
        $res = $GLOBALS['PDO']->prepare($SQL);
        $res->execute();
      }
    
    } 

    public function Delete(){
      if(!is_null($this->id)){
       $SQL = "DELETE FROM `film`
       WHERE id = '".$this->id."' ";
       $res = $GLOBALS['PDO']->prepare($SQL);
       $res->execute();
       echo '<p>'."Le Film N".'<sup>'."o".'</sup>'.$this->id." a ete supprimer".'</p>';
      } 
    }
 }




?>