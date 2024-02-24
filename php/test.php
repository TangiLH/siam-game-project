<?php
//page pour les tests des fonctions

include_once "functions_plateau.php";

$plateau=initPlateau();
$plateau[5][2]=array(typeCase::Vide,Direction::Neutre);
$plateau[6][3]=array(typeCase::Vide,Direction::Neutre);
affichePlateau($plateau);
$plateau[0][0]=array(typeCase::Elephant,Direction::Bas);
$plateau[1][0]=array(typeCase::Elephant,Direction::Bas);
$plateau[2][0]=array(typeCase::Montagne,Direction::Neutre);
$plateau[3][0]=array(typeCase::Rhinoceros,Direction::Haut);
echo verifPousse($plateau,0,1,Direction::Droite,Direction::Bas)?"True":"False";
affichePlateau($plateau);

$plateau=pousse($plateau,0,0,Direction::Bas);
affichePlateau($plateau);
$plateau=pousse($plateau,0,0,Direction::Bas);
affichePlateau($plateau);
$plateau=pousse($plateau,0,0,Direction::Bas);
affichePlateau($plateau);
