<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/style.css">
   </head>
<body>
  <div class="wrapper">
    <h2>Registration</h2>
    <form method="post" >
      <div class="input-box">
        <input type="text" name="pseudo" placeholder="Enter your name" required>
      </div>
      <div class="input-box">
        <input type="password" name="mdp" placeholder="Create password" required>
      </div>
      <div class="input-box">
        <input type="password" name="mdpC" placeholder="Confirm password" required>
      </div>
      <div class="policy">
        <input name="terms" type="checkbox">
        <h3>I accept all terms & condition</h3>
      </div>
      <div class="input-box button">
        <input type="Submit" name="submit" value="Register Now">
      </div>
      <div class="text">
        <h3>Vous avez déja un compte? <a href="login.php">Login now</a></h3>
      </div>
    </form>
  </div>
<?php
include("../php/functions_BD.php");
register();
?>
</body>
</html>
