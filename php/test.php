<?php
//page pour les tests des fonctions

include_once "functions_plateau.php";

$plateau=initPlateau();
debugAffichePlateau($plateau);
//echo $plateau[0];
debugAffichePlateau(decodePlateau(encodePlateau($plateau)));

