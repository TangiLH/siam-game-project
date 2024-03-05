<?php 
if(isset($_POST["testx"])){
    include("functions_BD.php");
    creeUserParAdmin();
}else{
    header("location: ../pages/");
}
?>