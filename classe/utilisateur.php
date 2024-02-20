<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
class Utilisateur{

 //Propriete de l'utilisateur

 private $id ;
 private $isAdmin = false;
 private $login;

 //Les Methodes de l'utilisateur

    public function __construct($id, $isAdmin, $login){
     $this-> id = $id;
     $this->isAdmin = $isAdmin;
     $this->login = $login;
    }

    public function seConnecter($login, $password){
      $SQL = "SELECT * FROM `utilisateur`
      WHERE `login` = '".$login."'
      AND `motdepasse` = '".$password."' ";

      $res = $GLOBALS['PDO']->prepare($SQL);
      $res->execute();
      
      if($res->rowCount() > 0){
       $data = $res->fetch();

       $_SESSION['Connexion'] = true; 
       $_SESSION['id'] = $data[0];

       $this->id = $data[0];
       $this->login = $data[1];
       $this->isAdmin = $data[3];

       return true;
      }else{
        ?>
          <style media="screen">
           input{border-color: red;}
          </style>
          <p style="color: red">Mot de passe incorecte</p>
        <?php
       return false;
      }
    }

    public function CreerNewUtilisateur($login, $password){
     // etape 1 : verifier que le login n'existe pas dans la base de donnee
     // etape 2 : Generer un MDP temporaire pour l'utilisateur si le mot de passe est vide
     // etape 3 : Creer une entre dans la BDD pour enregistrer le MDP et le Login
     // etape 4 : Envoyer un email de confirmation avec le login et le MDP
     
     //Etape 1 : Verifions si l'utilisateur existe dans la base de donnee

     $SQL = "SELECT * FROM `utilisateur`
     WHERE `login` = '".$login."' ";

     $res = $GLOBALS['PDO']->prepare($SQL);
     $res->execute();

      if($res->rowCount() > 0){
       // On a touve le bon id
       $data = $res->fetch(PDO::FETCH_ASSOC);
 
       $this->id = $data['id'];
       $this->isAdmin = $data['isAdmin'];
       $this->login = $data['login'];
       $password = $data['motdepasse'];
       echo '<span style="color: red">'."Ce nom d'utilisateur existe deja".'</span>';
      }else{

        //Etape: 2 Generer un mot de passe temporaire pour l'utilisateur si $pass est vide :
        if(empty($password)){
         $MDPTem = password_hash($login, PASSWORD_DEFAULT);
         $password = substr($MDPTem, 15, 3).substr($MDPTem, 30, 3).substr($MDPTem, 45, 3).'!';
        }

        //Etape: 3 Enregistrer l'utilisateur dans la base de donnee :
        $SQL = "INSERT INTO `utilisateur`(`login`, `motdepasse`, `isAdmin`)
        VALUES('".$login."', '".$password."', '0')";
        $res = $GLOBALS['PDO']->prepare($SQL);
        $res->execute();
        $this->id = $GLOBALS['PDO']->lastInsertId();
        $this->isAdmin = 0;
        $this->login = $login;
        echo '<span style="color:orange">'.
        "Un mot de passe temporaire a ete envoye dans votre boite mail".'</span>';
      }
      
      //Etape: 4 Envoie de l'email de comfirmation pour l'utilisateur
      try{
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";

        $mail->SMTPAuth = true;
        $mail->Username = "hjdevsendmail@gmail.com";
        $mail->Password = "umyy jaud ncxy fnuq";

        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;
        $mail->setFrom("hjdevsendmail@gmail.com");

        $mail->addAddress($login);
        $mail->isHTML(true);
        
        $SubjectHTML = "Code de verification";

        $mail->Subject = $SubjectHTML;

        $MessageHTML = '<p>'."Bienvenue ".$login." Sur notre plateforme
        Nous sommes ravie de vous compter parmis nous.
        Votre code de verification est : ".$password.'</p>';

        $mail->Body = $MessageHTML;

        $mail->send();

        /*echo "
          <script>
           alert('Le code a ete envoye avec success');
           document.location.href = 'index.php';
          </script>
        "; */
      
      }catch(Exception $e){
       echo 'Erreur : '.$e->getMessage().' dans l\'envoie de l\'email';
      }

    }

    public function seDeconnecter(){
     session_unset();
     session_destroy();
    }

    public function isAdmin(){
     return $this->isAdmin;
    }

    public function getLogin(){
     return $this->login;
    }

    public function setUtilisateurId($id){
     $SQL = "SELECT * FROM `utilisateur`
     WHERE `id` = $id ";
     $res = $GLOBALS['PDO']->prepare($SQL);
     $res->execute();

      if($res->rowCount() > 0){
       $data = $res->fetch();
 
       $this->id = $data[0];
       $this->login = $data[1];
       $this->isAdmin = $data[3];
       return true;
      }else{
       return false;
      }
     
    }

}

