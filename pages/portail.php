<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail</title>
</head>
<body>
    
<?php 
include("../php/functions_BD.php");
verifieLoginSession();
include("includes/header.php");





?><?php echo '<h3> Bienvenue '.$_SESSION['user']['pseudo'].'</h3>'; ?>
<br>
<h1 class="text-center" >Parties</h1><br>
<?php if(isset($_COOKIE["PartieCreer"])) :?>
    <h6 class="text-center text-success">Votre partie est bien créer!</h6>
<?php endif; ?>
<div class="d-flex justify-content-center">
    <a class="btn btn-info  btn-lg" href="cree.php">Créer</a>&nbsp;&nbsp;
    <a class="btn btn-info  btn-lg" href="parties.php">Rejoindre</a>&nbsp;&nbsp;
    <a class="btn btn-info  btn-lg" href="#">Votre en cours</a>&nbsp;&nbsp;
</div>


</body>
</html>