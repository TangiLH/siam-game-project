<?php  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parties</title>
</head>
<body>
    
<?php
include_once "../php/functions_BD.php";
verifieLoginSession();
include_once "includes/header.php";





?>
<?php if(isset($_SESSION["partie"]["id"])) :?>
<br>
<h1 class="text-center" >Parties En cours</h1><br>
<center>
<h1 class="text-center"><?php echo $_SESSION["partie"]["plateau"]; ?></h1>
<?php
refreshData();
if(isset($_SESSION["partie"]["idJoueurGagnant"])){
    if($_SESSION["partie"]["idJoueurGagnant"]==$_SESSION["user"]["id"]){
        echo "<h2>Vous avez gagné !</h2>";
    }
    else{
        echo "<h2> L'adversaire a gagné ! </h2>";
    }
    affichePlateau(decodePlateau($_SESSION["partie"]["data"]),null);
}
elseif($_SESSION["partie"]["idJoueurTour"]==$_SESSION["user"]["id"]) {
    $typeCaseJoueur=$_SESSION["partie"]["idJoueurTour"]==$_SESSION["partie"]["idJoueur1"]
    ?numToTypeCase(1):numToTypeCase(2);
    $tab=jouerJeu($_SESSION["partie"]["data"],
    $_SESSION["partie"]["idJoueurTour"]==$_SESSION["partie"]["idJoueur1"]?1:2);
    updatePartie($tab[0],$tab[1],$tab[2]);
    if($_SESSION["partie"]["idJoueurTour"]!=$_SESSION["user"]["id"]){
        $typeCaseJoueur=null;
        header("refresh: 0;");
    }
    echo "A vous de jouer !";
    affichePlateau(decodePlateau($_SESSION["partie"]["data"]),$typeCaseJoueur);
    
}
else{
    header("refresh: 5;");
    echo "L'adversaire joue...";
    $partie=getPartieById($_SESSION["partie"]["id"]);
    $_SESSION["partie"]["idJoueurTour"]=$partie->getIdJoueurTour();
    $_SESSION["partie"]["data"]=$partie->getData();
    affichePlateau(decodePlateau($_SESSION["partie"]["data"]),null);
    
}


?>
</center>
<?php else  : header("location: portail.php");?>
<?php endif; ?>

</body>
</html>
