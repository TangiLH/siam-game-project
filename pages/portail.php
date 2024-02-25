<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change mot de passe</title>
</head>
<body>
<?php 
include("../php/functions_BD.php");
verifieLoginSession();
include("includes/header.php");


echo $_SESSION['user']['pseudo'].' '.$_SESSION['user']['estadmin'];


?>

</body>
</html>