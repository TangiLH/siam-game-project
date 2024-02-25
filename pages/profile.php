<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
<?php 
include("../php/functions_BD.php");
verifieLoginSession();
include("includes/header.php");
$modifie=false;


?><br><br><br>
<h3 class="text-center" >Modifier votre mot de passe</h3>
<?php if(isset($_COOKIE["ModifieTrue"])) :?>
<h6 class="text-center text-success" >Mot de passe est modifié!</h6>
<?php endif; ?>
<div class="container d-flex justify-content-center ">
<form method="post"> 
  <div class="mb-3  ">
    <label for="exampleInputEmail1" class="form-label">Nom</label>
    <input type="email" value="<?php echo $_SESSION['user']['pseudo']; ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" disabled>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="newMdp" class="form-control" id="exampleInputPassword1" required>
  </div>
  <button type="submit" name="updateP" class="btn btn-primary">Submit</button>
</form>
<?php updatePassword();?>
</div>
</body>
</html>