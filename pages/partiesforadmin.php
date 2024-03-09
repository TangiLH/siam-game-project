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
verifieAdmin();




?>
<?php if(!isset($_GET["submit"])) :?>
<br>
<h1 class="text-center" >Parties a joindre pour admin</h1><br>
<center>
<div class="position-relative  m-8 w-75 p-3 ">
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nom</th>
      <th scope="col">Joueur 1</th>
      <th scope="col">Joueur 2</th>
      <th scope="col">Rejoindre</th>
    </tr>
  </thead>
  <tbody>
    <?php partiesPourAdmin(); ?>
  </tbody>
</table>
</div></center>
<?php else  : rejoindrePartieEnCours()?>
<h1 class="text-center"><?php echo $_SESSION["partie"]["plateau"]; ?></h1>
    
<?php endif; ?>

</body>
</html>