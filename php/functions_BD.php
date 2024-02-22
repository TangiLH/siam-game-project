<?php
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
    $db=connexpdo("db/projet-web2");
    $tab=array();
    $sql = 'SELECT idJoueur, pseudo, mdp, estAdmin FROM Utilisateurs';
    $result = $db->query($sql) ;
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        if(!in_array($row['pseudo'],$tab)&&$row['pseudo']!=''){
            $tab["idJoueur"]=array($row['pseudo'],$row['mdp'],$row['estAdmin']);
        }
    }
    return $tab;
    }
?>