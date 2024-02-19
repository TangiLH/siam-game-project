<?php 
//contient toutes les fonctions php relatives au plateau
/**
 * initialise le plateau de jeu pour le début de la partie.
 */
function initPlateau(){
    $plateau=array();
    for($i=0;$i<5;$i++){
        $plateau[]=array("","","","","");
    }
    $plateau[]=array("eh","eh","eh","eh","eh");
    $plateau[]=array("rh","rh","rh","rh","rh");
    $plateau[2][1]="M";
    $plateau[2][2]="M";
    $plateau[2][3]="M";

    return $plateau;
}

/**
 * fonction de debug pour afficher le plateau en texte.
 */
function debugAffichePlateau($plateau){
    foreach($plateau as $i => $ligne){
        foreach($ligne as $j => $case){
            echo "|".$case."|";
        }
        echo "<br>";
    }
}

/**
 * encode le plateau en JSON
 */
function encodePlateau($plateau){
    return json_encode($plateau);
}

/**
 * decode le plateau
 */
function decodePlateau($str_plateau){
    return json_decode($str_plateau,true);
}