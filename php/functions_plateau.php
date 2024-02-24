<?php 
//contient toutes les fonctions php relatives au plateau
/**
 * initialise le plateau de jeu pour le début de la partie.
 */

use function PHPSTORM_META\type;

 /**
  * enumeration des directions possibles pour les pions
  */
enum Direction implements JsonSerializable{
    case Haut;
    case Bas;
    case Gauche;
    case Droite;
    case Neutre;//neutre est la direction utilisée pour les cases Montagne et Vide

    /**
     * permet d'encoder l'enum en JSON
     */
    public function jsonSerialize(): string{
        return match ($this) {
            self::Haut => 'H',
            self::Bas => 'B',
            self::Gauche => 'G',
            self::Droite => 'D',
            self::Neutre => 'N'
        };
    }

    /**
     * sert a decoder l'enum depuis JSON
     */
    public static function jsonDeSerialize($char): Direction{
        switch ($char) {
            case 'H':
                $retour= self::Haut;
                break;
            case 'B':
                $retour= self::Bas;
                break;
            case 'G':
                $retour= self::Gauche;
                break;
            case 'D':
                $retour= self::Droite;
                break;
            case 'N':
                $retour= self::Neutre;
                break;
            default:
                $retour= self::Neutre;
                break;
            }
        return $retour;
    }
}

/**
 * enumeration des différents types de cases
 */
enum typeCase implements JsonSerializable{
    case Montagne;
    case Elephant;
    case Rhinoceros;
    case Vide;

    /**
     * permet d'encoder l'enum en JSON
     */
    public function jsonSerialize(): string{
        return match ($this) {
            self::Montagne => 'M',
            self::Elephant => 'E',
            self::Rhinoceros => 'R',
            self::Vide => 'V'
        };
    }

    /**
     * sert a decoder l'enum depuis JSON
     */
    public static function jsonDeSerialize($char): typeCase{
        switch ($char) {
            case 'M':
                $retour= self::Montagne;
                break;
            case 'E':
                $retour= self::Elephant;
                break;
            case 'R':
                $retour= self::Rhinoceros;
                break;
            case 'V':
                $retour= self::Vide;
                break;
            default:
                $retour= self::Vide;
                break;
            }
        return $retour;
    }
}

/**
 * initialise le plateau pour le début de partie
 */
 function initPlateau(){
    $plateau=array();
    for($i=0;$i<5;$i++){
        $plateau[]=array(array(typeCase::Vide,Direction::Neutre),
        array(typeCase::Vide,Direction::Neutre),
        array(typeCase::Vide,Direction::Neutre),
        array(typeCase::Vide,Direction::Neutre),
        array(typeCase::Vide,Direction::Neutre));
    }
    $plateau[]=array(array(typeCase::Elephant,Direction::Haut),
    array(typeCase::Elephant,Direction::Haut),
    array(typeCase::Elephant,Direction::Haut),
    array(typeCase::Elephant,Direction::Haut),
    array(typeCase::Elephant,Direction::Haut));
    $plateau[]=array(array(typeCase::Rhinoceros,Direction::Haut),
    array(typeCase::Rhinoceros,Direction::Haut),
    array(typeCase::Rhinoceros,Direction::Haut),
    array(typeCase::Rhinoceros,Direction::Haut),
    array(typeCase::Rhinoceros,Direction::Haut));
    $plateau[]=array(array(typeCase::Vide,Direction::Neutre));
    $plateau[2][1]=array(typeCase::Montagne,Direction::Neutre);
    $plateau[2][2]=array(typeCase::Montagne,Direction::Neutre);
    $plateau[2][3]=array(typeCase::Montagne,Direction::Neutre);

    return $plateau;
}

/**
 * fonction de debug pour afficher le plateau en texte.
 */
function debugAffichePlateau($plateau){
    foreach($plateau as $ligne){
        foreach($ligne as $case){
            echo "|".afficheCase($case)."|";
        }
        echo "<br>";
    }
}

/**
 * affiche une case du plateau (un tableau [typeCase, Direction])
 */
function afficheCase($case){
    $type=$case[0];
    $direction=$case[1];
    switch($type){
        case typeCase::Rhinoceros:
            $strType="R";
            break;
        case typeCase::Elephant:
            $strType= "E";
            break;
        case typeCase::Montagne:
            $strType= "M";
            break;
        case typeCase::Vide:
            $strType= "V";
            break;
        default:
            $strType= "Err";
            break;
        }
    switch($direction){
        case Direction::Haut:
            $strDirection="H";
            break;
        case Direction::Bas:
            $strDirection= "B";
            break;
        case Direction::Gauche:
            $strDirection= "G";
            break;
        case Direction::Droite:
            $strDirection= "D";
            break;
        case Direction::Neutre:
            $strDirection= "N";
            break;
        default:
            $strDirection= "Err";
            break;
        }
        return $strDirection." ".$strType;
}
/**
 * encode le plateau en JSON
 */
function encodePlateau($plateau){
    $retour=array();
    $retourligne=array();
    foreach($plateau as $ligne){
        foreach($ligne as $case){
            $retourligne[]=json_encode($case);
        }
        $retour[]=json_encode($retourligne);
        $retourligne=array();
    }
    return json_encode($retour);
}

/**
 * decode le plateau
 */
function decodePlateau($str_plateau){
    $decode=json_decode($str_plateau,true);
    $plateau=array();
    foreach($decode as $ligne){
        $ligne=json_decode($ligne,true);
        $ligneDecode=array();
        foreach($ligne as $case){
            $case=json_decode($case,true);
            $caseDecode=array();
            $caseDecode[]=typeCase::jsonDeSerialize($case[0]);
            $caseDecode[]=Direction::jsonDeSerialize($case[1]);
            
            $ligneDecode[]=$caseDecode;
        }
        $plateau[]=$ligneDecode;
        
    }
    return $plateau;
}

/**
 * affiche une ligne du plateau passé en paramètre, avec les boutons
 */
function afficheLignePlateau($plateau,$numLigne){
    $ligne=$plateau[$numLigne];
    for($j=0;$j<5;$j++){
        $case=$ligne[$j];
        echo "<button type=\"button\" name=\"caseChoix\" value=\""
        .$numLigne.",".$j."\">".afficheCase($case)."</button>";
        
    }
    echo "<br>";
}

/**
 * affiche les bouton pour contrôler les pions
 */
function afficheBoutonsControle(){
    $deplacement="<button type=\"button\" name=\"Deplacement\" value=\"";
    echo $deplacement.Direction::Haut->name."\">HAUT</button>";
    echo $deplacement.Direction::Bas->name."\">BAS</button>";
    echo $deplacement.Direction::Gauche->name."\">GAUCHE</button>";
    echo $deplacement.Direction::Droite->name."\">DROITE</button>";
    echo"</br>";

    $rotation="<button type=\"button\" name=\"Rotation\" value=\"";
    echo $rotation.Direction::Haut->name."\">r SHAUT</button>";
    echo $rotation.Direction::Bas->name."\">r BAS</button>";
    echo $rotation.Direction::Gauche->name."\">R GAUCHE</button>";
    echo $rotation.Direction::Droite->name."\">R DROITE</button>";
}

/**
 * affiche le plateau et les boutons de contrôle
 */
function affichePlateau($plateau){
    echo "<form method=\"POST\">";
    afficheLignePlateau($plateau,5);
    for($i=0;$i<5;$i++){
        $ligne=$plateau[$i];
        afficheLignePlateau($plateau,$i);
        
    }
    afficheLignePlateau($plateau,6);
    echo "</br>";
    afficheBoutonsControle();
    echo "</form>";
}