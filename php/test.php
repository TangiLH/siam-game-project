<?php
//page pour les tests des fonctions

include_once "functions_plateau.php";

$plateau=initPlateau();
affichePlateau($plateau);
$plateau[0][0]=array(typeCase::Elephant,Direction::Bas);
$plateau[1][0]=array(typeCase::Elephant,Direction::Bas);
$plateau[2][0]=array(typeCase::Montagne,Direction::Neutre);
$plateau[3][0]=array(typeCase::Rhinoceros,Direction::Haut);
echo verifPousse($plateau,0,0,Direction::Bas)?"True":"False";
affichePlateau($plateau);
