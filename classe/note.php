<?php
class Note{

 // Les proprietes de la classe note   
 private $id;
 private $idFilm;
 private $idUtilisateur;
 private $noteSur5;

 // Les methodes de la classe note

 public function __construct($newIdUtilisateur, $newIdFilm, $newNoteSur5){
 $this->idUtilisateur = $newIdUtilisateur;
 $this->idFilm = $newIdFilm;
 $this->noteSur5 = $newNoteSur5;
 }

 public function EnregistrerDansLaBdd(){
   if(is_null($this->id)){
    // Verifions si le film n'as pas deja note par un utilisateur

     $SQL = "SELECT film.id FROM film, note, utilisateur
     WHERE
     film.id = note.idFilm
     AND 
     note.idUtilisateur = utilisateur.id
     AND film.id = '".$this->idFilm."'
     AND utilisateur.id = '".$this->idUtilisateur."'
     GROUP BY film.id ";

     $res = $GLOBALS['PDO']->prepare($SQL);
     $res->execute();

      if($res->rowCount() > 0){
       // si l'utilisateur a deja note le film dans ce cas on fait une mise a jour  
       $SQL = "UPDATE `note` SET
       noteSur5 = '".$this->noteSur5."'
       WHERE note.idFilm = '".$this->idFilm."'
       AND note.idUtilisateur = '".$this->idUtilisateur."' "; 
       $res = $GLOBALS['PDO']->prepare($SQL);
       $res->execute();  
      }else{
       // Si l'utilisateur n'as pas encore attribue une note au film on fait un insertion  
       $SQL = "INSERT INTO `note`(`idUtilisateur`, `idFilm`, `noteSur5`)
       VALUES('".$this->idUtilisateur."', '".$this->idFilm."', '".$this->noteSur5."')";
       $res = $GLOBALS['PDO']->prepare($SQL);
       $res->execute(); 
       $this->id = $GLOBALS['PDO']->lastInsertId();
      }

   }else{
    // Si l'Id n'est pas null dans ce cas on va le mettre a jour
    $SQL = "UPDATE `note` SET noteSur5 = '".$this->noteSur5."'
    WHERE id = '".$this->id."' ";
    $res = $GLOBALS['PDO']->prepare($SQL);
    $res->execute();
   }

 }





}





?>