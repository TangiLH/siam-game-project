<?php
//page pour les tests des fonctions

include_once "functions_plateau.php";

$plateau=initPlateau();
debugAffichePlateau(decodePlateau(encodePlateau($plateau)));
