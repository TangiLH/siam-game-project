<?php
include("User.php");
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
function users(){
    $db=connexpdo("../db/projet-web2");
    $tab=array();
    $sql = 'SELECT idJoueur, pseudo, mdp, estAdmin FROM Utilisateurs';
    $result = $db->query($sql) ;
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $tab[]=new User($row['pseudo'],$row['mdp'],$row['estAdmin']);
    }
    $db=null;
    return $tab;
    }
    function ajouterUtilisateur($user) {
        $db = connexpdo("../db/projet-web2");
        
        $hash = password_hash($user->getMdp(), PASSWORD_DEFAULT);
        $user->getPseudo();
        $user->getEstAdmin();
        $sql = 'INSERT INTO Utilisateurs (pseudo, mdp, estAdmin) VALUES ("'.$user->getPseudo().'", "'.$hash.'", '.$user->getEstAdmin().')';
        $db->exec($sql);
        $db = null;
    }
    
function verifieLogin($pseudo,$mdp){
    $db=connexpdo("../db/projet-web2");
    if(!verifieByPseudo($pseudo)){
        echo '<script>alert("Pseudo inexistant!");</script>';
    }else{
        $user=verifieByPseudo($pseudo);
        if(password_verify($mdp, $user->getMdp())){
            session_start();
            $_SESSION['pseudo']=$user->getPseudo();
            $_SESSION['estadmin']=$user->getEstAdmin()==1?true:false;
            header("Location: testBD.php");
        }else{
            echo '<script>alert("Mauvais mot de passe! ");</script>';
            echo $mdp.' '.$user->getMdp();
        }
    }


}

function verifieByPseudo($pseudo){
    $users=users();
    foreach ($users as $key => $value) {
      if($value->getPseudo()==$pseudo){
        return $value;
      }
    }
    return null;
}

function register(){
    if(isset($_POST["submit"])){
      if($_POST["mdp"] != $_POST["mdpC"]){
        echo '<script>alert("La confirmation du mot de passe est incorrecte!");</script>';
      }else if(!isset($_POST["terms"])){
        echo '<script>alert("Merci d\'accepter nos termes et condtions");</script>';
      }else if(verifieByPseudo($_POST["pseudo"])){
        echo '<script>alert("Le pseudo existe déjà!");</script>';
      }else{
        $user=new User($_POST["pseudo"],$_POST["mdp"],0);
        ajouterUtilisateur($user);
        header("Location: login.php");
      }
      
    }
  }
  function login(){
    if(isset($_POST["submit"])){
      verifieLogin($_POST["pseudo"],$_POST["mdp"]);
      
    }
  }
  function verifieLoginSession(){
    session_start();
    if(!isset($_SESSION["pseudo"])){
        header("Location: login.php");
    }
  }
  function logout(){
    if(isset($_POST["logout"])){
        session_destroy();
        header("Location: ../login.php");
    }
  }
?>