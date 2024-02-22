<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
<?php 
include("../php/functions_BD.php");
$users=users();
$user=$users[0];
echo $user->getPseudo();
?>
</body>
</html>