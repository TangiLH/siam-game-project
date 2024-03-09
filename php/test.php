<?php
//page pour les tests des fonctions
session_start();
include_once "functions_plateau.php";
$plateau=initPlateau();
$plateau[4][0]=array(typeCase::Elephant,Direction::Gauche);
$plateau[5][2]=array(typeCase::Vide,Direction::Neutre);
$joueur=typeCase::Elephant;
$plateau=traitementPlateau($plateau,$joueur);


//echo $cookie["caseOrigine"];
affichePlateau($plateau);
