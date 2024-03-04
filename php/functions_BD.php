<?php
include("User.php");

/*
* Function pour connexion a la base sql lite 3 avec PDO
*/ 
function connexpdo($base){
    $dsn="sqlite:$base.sqlite3" ;
    try {
    $db = new PDO($dsn);
    return $db;
    }
    catch(PDOException $except){
    echo "Échec de la connexion",$except->getMessage();
    return FALSE;
    }
}
/*
* Function pour récupérer tout les utilisateurs depuis la base
*/ 
function users(){
    $db=connexpdo("../db/projet-web2");
    $tab=array();
    $sql = 'SELECT idJoueur, pseudo, mdp, estAdmin FROM Utilisateurs';
    $result = $db->query($sql) ;
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $tab[]=new User($row['idJoueur'],$row['pseudo'],$row['mdp'],$row['estAdmin']);
    }
    $db=null;
    return $tab;
    }
    function ajouterUtilisateur($user) {
        $db = connexpdo("../db/projet-web2");
        
        $hash = password_hash($user->getMdp(), PASSWORD_DEFAULT);
        $sql = 'INSERT INTO Utilisateurs (pseudo, mdp, estAdmin) VALUES ("'.$user->getPseudo().'", "'.$hash.'", '.$user->getEstAdmin().')';
        $db->exec($sql);
        $db = null;
    }
    
/*
* Function pour verifie l'authentification d'un utilisateur
*/ 
function verifieLogin($pseudo,$mdp){
    $db=connexpdo("../db/projet-web2");
    if(!verifieByPseudo($pseudo)){
        echo '<script>alert("Pseudo inexistant!");</script>';
    }else{
        $user=verifieByPseudo($pseudo);
        if(password_verify($mdp, $user->getMdp())){
            session_start();
            $_SESSION['user']['pseudo']=$user->getPseudo();
            $_SESSION['user']['estadmin']=$user->getEstAdmin()==1?true:false;
            $_SESSION['user']['id']=$user->getId();
            header('Location: portail.php');
        }else{
            echo '<script>alert("Mauvais mot de passe! ");</script>';
        }
    }


}
/*
* Verifie l'existence d'un pseudo dans la base
*/ 
function verifieByPseudo($pseudo){
    $users=users();
    foreach ($users as $key => $value) {
      if($value->getPseudo()==$pseudo){
        return $value;
      }
    }
    return null;
}
/*
* Function pour crée un nouveau utilisateur a la base avec les vérification nécessaires
*/ 
function register(){
    if(isset($_POST["submit"])){
      if($_POST["mdp"] != $_POST["mdpC"]){
        echo '<script>alert("La confirmation du mot de passe est incorrecte!");</script>';
      }else if(!isset($_POST["terms"])){
        echo '<script>alert("Merci d\'accepter nos termes et condtions");</script>';
      }else if(verifieByPseudo($_POST["pseudo"])){
        echo '<script>alert("Le pseudo existe déjà!");</script>';
      }else{
        $user=new User(0,$_POST["pseudo"],$_POST["mdp"],0);
        ajouterUtilisateur($user);
        header("Location: login.php");
      }
      
    }
  }
/*
* Function qui appel la function verifieLogin si la mise en place de la formule est correcte
*/ 
  function login(){
    if(isset($_POST["submit"])){
      verifieLogin($_POST["pseudo"],$_POST["mdp"]);
      
    }
  }
/*
* Une fonction qui vérifie si un passager est authentifié ou pas sinon il lui diriger vers la page login
*/ 
  function verifieLoginSession(){
    session_start();
    if(!isset($_SESSION['user']["pseudo"])){
        header("Location: login.php");
    }
  }
/*
* Function pour détruire la session et déconnecter l'utilisateur
*/ 
  function logout(){
    if(isset($_POST["logout"])){
        unset($_SESSION['user']);
        session_destroy();
        header("Location: ../pages/login.php");
    }
  }
/*
* Pour modifier le mot de passe
*/ 
  function updatePassword(){
    if(isset($_POST["updateP"])){
        try {
            $db = connexpdo("../db/projet-web2");
            
            // Check if connection is successful
            if(!$db) {
                throw new Exception("Failed to connect to the database.");
            }

            $hash = password_hash($_POST["newMdp"], PASSWORD_DEFAULT);
            $sql = 'UPDATE Utilisateurs
                    SET mdp = "'.$hash.'"
                    WHERE pseudo = "'.$_SESSION['user']['pseudo'].'";';
            $affectedRows = $db->exec($sql);

            // Check if the query was successful
            if($affectedRows === false || $affectedRows == 0) {
                throw new Exception("Failed to update password.");
            }

            $db = null;
            setcookie("ModifieTrue", true, time()+1);
            header("Location: profile.php");
        } catch(Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
/*
* pour crée une partie!
*/ 
function creePartie(){
  if(isset($_POST["creePartie"])){
    try {
    $db = connexpdo("../db/projet-web2");
    $sql = 'INSERT INTO Parties (plateau, idJoueur1,idJoueur2) 
    VALUES ("'.$_POST["nomPartieValue"].'", '.$_SESSION['user']['id'].', '.$_POST['adversaireValue'].')';
    $db->exec($sql);
    $db = null;
    setcookie("PartieCreer", true, time()+1);
    header("Location: portail.php");
    }catch(Exception $e) {
      echo "Error: " . $e->getMessage();
  }

  }
}
/*
* Affichier les utilisateur en tanque des options pour la balise select
*/ 
function usersAsOptions(){
  $users=users();
  foreach($users as $user){
    if($user->getId()!=$_SESSION['user']['id']){
      echo '<option value="'.$user->getId().'" >'.$user->getPseudo().'</option>';
    }
  }
}
/*
* Retourne un tableau de toutes les parties
*/ 
function parties(){
  $db=connexpdo("../db/projet-web2");
  $tab=array();
  $sql = 'SELECT * FROM Parties';
  $result = $db->query($sql) ;
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $tab[]=array("idParties"=>$row['idParties'],"idJoueur1"=>$row['idJoueur1'],"idJoueur2"=>$row['idJoueur1'],"plateau"=>$row['plateau'],"idJoueurGagnant"=>$row['idJoueurGagnant'],"idJoueurTour"=>$row['idJoueurTour'],);
  }
  $db=null;
  return $tab;
  }
/*
* Affichier les parties en cours en tanque des lignes du tableau
*/ 
function partiesAsRows(){
  $users=parties();
  foreach($users as $user){
    if($user->getId()!=$_SESSION['user']['id']){
      echo '<option value="'.$user->getId().'" >'.$user->getPseudo().'</option>';
    }
  }
}
?>