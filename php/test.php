<?php
//page pour les tests des fonctions
session_start();
include_once "functions_plateau.php";
$plateau=initPlateau();
$plateau[0][0]=array(typeCase::Elephant,Direction::Bas);
traitementPlateau($plateau);


//echo $cookie["caseOrigine"];
affichePlateau($plateau);
