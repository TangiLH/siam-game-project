<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Admin</title>
</head>
<body>
    
<?php 
include("../php/functions_BD.php");
verifieLoginSession();
include("includes/header.php");
verifieAdmin();

?>
<?php if(!isset($_POST["cree"])): ?>
<h1 class="text-center" >Admin bar de menu</h1><br>




<div class="d-flex justify-content-center">
    <form method="post">
    <input class="btn btn-info  btn-lg" type="submit" name="cree" value="Crée un Joueur">&nbsp;&nbsp;
    </form>
    <a class="btn btn-info  btn-lg" href="partiesforadmin.php">Jouer dans n'importe partie</a>&nbsp;&nbsp;
    <a class="btn btn-info  btn-lg" href="partiesEnCours.php">Supprimer une partie</a>&nbsp;&nbsp;
</div>
<?php else: ?>

<h3 class="text-center">Créer Un Joueur</h3>
<div class="container d-flex justify-content-center">
    <form  method="post" action="../php/userCreation.php">
    <div class="mb-3" >
            <label for="nomPartie" class="form-label">Nom</label>
            <input type="text" name="pseudo" class="form-control" id="nomPartie" required>
        </div>
        <div class="mb-3">
            <label for="nomPartie" class="form-label">mot de passe</label>
            <input type="password" name="mdp" class="form-control" id="nomPartie" required>
        </div>
        <div class="mb-3">
            <label for="nomPartie" class="form-label">Confirmation mot de passe</label>
            <input type="password" name="mdpC" class="form-control" id="nomPartie" required>
        </div>
        
        <input class="btn btn-primary  btn-lg" type="submit" name="testx" value="Crée">&nbsp;&nbsp;
    </form>
    <?php  creeUserParAdmin(); ?>
    
</div>

<?php endif; ?>


</body>
</html>