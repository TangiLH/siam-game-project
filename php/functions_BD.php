<?php
include("User.php");
include("Partie.php");
include_once("../php/functions_plateau.php");

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
        header("Location: ../pages/");
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
    $data=encodePlateau(initPlateau());
    $db = connexpdo("../db/projet-web2");
    $sql = 'INSERT INTO Parties (plateau, idJoueur1,idJoueur2,data) 
    VALUES ("'.$_POST["nomPartieValue"].'", '.$_SESSION['user']['id'].', '.$_POST['adversaireValue'].',\''.$data.'\')';
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
      $tab[]=$partie=new Partie($row['idParties'],$row['plateau'],$row['idJoueur1'],$row['idJoueur2'],$row['idJoueurGagnant'],$row['idJoueurTour'],$row['data']);

  }
  $db=null;
  return $tab;
  }
/*
* Affichier les parties a joindre en tanque des lignes du tableau
* de l'utilisateur courant 
*/ 
function partiesAsRowsJoindre(){
  $parties=parties();
  foreach($parties as $partie){
    if($partie->getIdJoueur1()==$_SESSION["user"]["id"] || $partie->getIdJoueur2()==$_SESSION["user"]["id"]){
      if($partie->getIdJoueurGagnant()=="" && $partie->getIdJoueurTour()==""){
        $j1=getJoueurById($partie->getIdJoueur1());
        $j2=getJoueurById($partie->getIdJoueur2());
        echo '<tr>
        <th scope="row">'.$partie->getId().'</th>
        <td>'.$partie->getPlateau().'</td>
        <td>'.$j1->getPseudo().'</td>
        <td>'.$j2->getPseudo().'</td>
        <td>
        <form method="get">
          <input type="hidden" value="'.$partie->getId().'" name="id">
          <input class="btn btn-info  btn-md" type="submit" name="submit" value="Joindre"></input>
        </form>
        </td>
      </tr>';
      }
    }
  }
}
/*
* Retourner le joueur par son ID
*/ 
function getJoueurById($id){
  $users=users();
  foreach($users as $user){
    if($user->getId()==$id){
      return $user;
    }
  }
  return null;
}

/*
* Retourner le partie par son ID
*/ 
function getPartieById($id){
  $parties=parties();
  foreach($parties as $partie){
    if($partie->getId()==$id){
      return $partie;
    }
  }
  return null;
}
/*
* Pour commencer la partie avec le joueur courant
*/
function partieCommence(){
  try{

    $db = connexpdo("../db/projet-web2");
    $sql = 'UPDATE Parties SET idJoueurTour = '.$_SESSION['user']['id'].' WHERE idParties = '.$_SESSION["partie"]["id"].'';
    $db->exec($sql);
    $db = null;
  }catch(Exception $e){
    echo $e;
  }
}
/*
* mise a jour la partie avec les changement
*/
function updatePartie($idFuture,$data,$bool){
  try{
    $db = connexpdo("../db/projet-web2");
    if($bool){
      $sql = 'UPDATE Parties SET idJoueurGagnant = '.$_SESSION['user']['id'].' WHERE idParties = '.$_SESSION["partie"]["id"].'';
      
    }else{
      if($idFuture==2){
        $idJoueurTour=$_SESSION["partie"]["idJoueur2"];
      }else{
        $idJoueurTour=$_SESSION["partie"]["idJoueur1"];
      }
      $sql = 'UPDATE Parties SET idJoueurTour = '.$idJoueurTour.',data=\''.$data.'\' WHERE idParties = '.$_SESSION["partie"]["id"].'';
    }
    $db->exec($sql);
    $db = null;
  }catch(Exception $e){
    echo $e;
  }
}

/*
* verifie la mise en place de partie by id
*/
function getPartie(){
  if(isset($_GET["submit"])){
    $partie=getPartieById($_GET["id"]);
    if($partie->getIdJoueur1()==$_SESSION["user"]["id"]||$partie->getIdJoueur2()==$_SESSION["user"]["id"]){
      $_SESSION["partie"]["id"]=$_GET["id"];
      $_SESSION["partie"]["plateau"]=$partie->getPlateau();
      $_SESSION["partie"]["idJoueur1"]=$partie->getIdJoueur1();
      $_SESSION["partie"]["idJoueur2"]=$partie->getIdJoueur2();
      $_SESSION["partie"]["idJoueurTour"]=$partie->getIdJoueurTour();
      $_SESSION["partie"]["data"]=$partie->getData();
      partieCommence();
      header("location: jouerPartie.php");
    }else{
      echo '<script>alert("You dont have permission!")</script>';
      header("refresh:0;url=../pages/portail.php");
    }
  }
}
/*
* Rejoundre une partie pour un utilisateur courrant
*/
function rejoindrePartieEnCours(){
  if(isset($_GET["submit"])){
    $partie=getPartieById($_GET["id"]);
    if($partie->getIdJoueur1()==$_SESSION["user"]["id"]||$partie->getIdJoueur2()==$_SESSION["user"]["id"]){
      $_SESSION["partie"]["id"]=$_GET["id"];
      $_SESSION["partie"]["plateau"]=$partie->getPlateau();
      $_SESSION["partie"]["idJoueur1"]=$partie->getIdJoueur1();
      $_SESSION["partie"]["idJoueur2"]=$partie->getIdJoueur2();
      $_SESSION["partie"]["idJoueurTour"]=$partie->getIdJoueurTour();
      $_SESSION["partie"]["data"]=$partie->getData();
      header("location: jouerPartie.php");
    }else{
      echo '<script>alert("You dont have permission!")</script>';
      header("refresh:0;url=../pages/portail.php");
    }
  }
}

/*
* Affichier les parties en cours en tanque des lignes du tableau
* de l'utilisateur courant 
*/ 
function partiesAsRowsCours(){
  $parties=parties();
  foreach($parties as $partie){
    if($partie->getIdJoueur1()==$_SESSION["user"]["id"] || $partie->getIdJoueur2()==$_SESSION["user"]["id"]){
      if($partie->getIdJoueurGagnant()=="" && $partie->getIdJoueurTour()!=""){
        $j1=getJoueurById($partie->getIdJoueur1());
        $j2=getJoueurById($partie->getIdJoueur2());
        echo '<tr>
        <th scope="row">'.$partie->getId().'</th>
        <td>'.$partie->getPlateau().'</td>
        <td>'.$j1->getPseudo().'</td>
        <td>'.$j2->getPseudo().'</td>
        <td>
        <form method="get">
          <input type="hidden" value="'.$partie->getId().'" name="id">
          <input class="btn btn-info  btn-md" type="submit" name="submit" value="Joindre"></input>
        </form>
        </td>
      </tr>';
      }
    }
  }
}
// Verifie l'utilisateur est admin ?
function verifieAdmin(){
  if(!$_SESSION["user"]["estadmin"]){
    echo '<script>alert("You dont have permission!")</script>';
    header("location: ../pages/");
  }
}

/*
* Function pour crée un nouveau utilisateur a la base avec les vérification nécessaires
*/ 
function creeUserParAdmin(){
  if(isset($_POST["testx"])){
    if($_POST["mdp"] != $_POST["mdpC"]){
      echo '<script>alert("La confirmation du mot de passe est incorrecte!");</script>';
      header("refresh:0;url=../pages/admin.php");
    }else if(verifieByPseudo($_POST["pseudo"])){
      echo '<script>alert("Le pseudo existe déjà!");</script>';
      header("refresh:0;url=../pages/admin.php");
    }else{
      $user=new User(0,$_POST["pseudo"],$_POST["mdp"],0);
      ajouterUtilisateur($user);
      echo '<script>alert("User has been created");</script>';
      header("refresh:0;url=../pages/admin.php");
    }
    
  }
  
}

/*
* Affichier toutes les parties en cours en tanque des lignes du tableau
* pour l'admin
*/ 
function partiesPourAdmin(){
  $parties=parties();
  foreach($parties as $partie){
      if($partie->getIdJoueurGagnant()==""){
        $j1=getJoueurById($partie->getIdJoueur1());
        $j2=getJoueurById($partie->getIdJoueur2());
        echo '<tr>
        <th scope="row">'.$partie->getId().'</th>
        <td>'.$partie->getPlateau().'</td>
        <td>'.$j1->getPseudo().'</td>
        <td>'.$j2->getPseudo().'</td>
        <td>
        <form method="get">
          <input type="hidden" value="'.$partie->getId().'" name="id">
          <input class="btn btn-info  btn-md" type="submit" name="submit" value="Joindre"></input>
        </form>
        </td>
      </tr>';
      }
    
  }
}

function partiesAsOptions(){
  $parties=parties();
  $b=false;
  foreach($parties as $partie){
      if($partie->getIdJoueurGagnant()==""&&$partie->getIdJoueurTour()!=""){
        $b=true;
        $j1=getJoueurById($partie->getIdJoueur1());
        $j2=getJoueurById($partie->getIdJoueur2());
        echo '<option value="'.$partie->getId().'" >'
        .$partie->getId().' '.$partie->getPlateau().' '.$partie->getIdJoueur1().' '.$partie->getIdJoueur2().'</option>';
      }
    }
    return $b;
}

/*
* supprimer une Partie
*/ 
function supprimerPartie(){
  if(isset($_POST["supprimer"])){
    try {
    $db = connexpdo("../db/projet-web2");
    $sql = 'DELETE FROM Parties where idParties="'.$_POST["partieId"].'"';
    $db->exec($sql);
    $db = null;
    echo '<script>alert("Partie est bien supprimer!");</script>';
    header("refresh:0;url=admin.php");
    }catch(Exception $e) {
      echo "Error: " . $e->getMessage();
  }

  }
}

/*
* Verfie l'authentification
*/
function verifieAuth(){
  if(isset($_SESSION["user"])){
    return true;
  }
  return false;
}



?>