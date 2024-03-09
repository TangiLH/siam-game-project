<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parties</title>
</head>
<body>
    
<?php 
include("../php/functions_BD.php");
verifieLoginSession();
include("includes/header.php");





?>
<?php if(isset($_SESSION["partie"]["id"])) :?>
<br>
<h1 class="text-center" >Parties En cours</h1><br>
<center>
<h1 class="text-center"><?php echo $_SESSION["partie"]["plateau"]; ?></h1>
<?php 
$tab=jouerJeu($_SESSION["partie"]["data"],$_SESSION["partie"]["idJoueurTour"]==$_SESSION["partie"]["idJoueur1"]?1:2); 
updatePartie($tab[0],$tab[1],$tab[2]);
?>
</center>
<?php else  : header("location: portail.php");?>
<?php endif; ?>

</body>
</html>