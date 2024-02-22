<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
   </head>
<body>
  <div class="wrapper">
    <h2>Login</h2>
    <form method="post">
      <div class="input-box">
        <input type="text" name="pseudo" placeholder="Votre Nom" required>
      </div>
      <div class="input-box">
        <input type="password" name="mdp" placeholder="Ecrire votre mot de passe" required>
      </div>
      <div class="input-box button">
        <input type="Submit" name="submit" value="Login">
      </div>
      <div class="text">
        <h3>Vous n'avez pas encore de compte <a href="sign-up.php">Register now!</a></h3>
      </div>
    </form>
  </div>
<?php 
include("../php/functions_BD.php");
login();
?>
</body>
</html>
