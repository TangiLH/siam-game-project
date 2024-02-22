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
include("includes/header.php");
verifieLoginSession();

echo $_SESSION["pseudo"].' '.$_SESSION["estadmin"]
// print_r(users());

// if(isset($_POST["back"])){
//     $hashTrue=password_hash($_POST["mdp"],PASSWORD_DEFAULT);
//     if(password_verify('a1', '$2y$10$mfVLDxTeaPhEaqiZpTG4AuHH047o/MxXtv7K05OocWgq22LEltyqi')){
//         echo "true";
//     }else {
//         echo "false";
//     }
// }
?>
</body>
</html>