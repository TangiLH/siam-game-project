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
        return $strType." ".$strDirection;
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
    echo "</br>";
    for($i=0;$i<5;$i++){
        afficheLignePlateau($plateau,$i);
        
    }
    echo "</br>";
    afficheLignePlateau($plateau,6);
    echo "</br>";
    afficheBoutonsControle();
    echo "</form>";
}

/**
 * traite les actions du joueur sur le plateau grâce à la méthode POST
 */
function traitementPlateau(){

}

/**
 * Verifie si une poussée est possible
 * @param $plateau le plateau de jeu
 * @param $ligne numero de la ligne de la case vers laquelle on veut pousser
 * @param $colonne numero de la colonne de l a case vers laquelle on veut pousser
 * @param $directionPion orientation du pion qui pousse
 * @param $directionPoussee sens de la poussee
 * @return bool vrai si la poussee est possible faux sinon
 */
function verifPousse($plateau,$ligne,$colonne,$directionPion,$directionPoussee){
    $cpt=0;
    $nextLigne=function()use(&$ligne){
        return $ligne;
    };
    $nextColonne=function()use(&$colonne){
        return $colonne;
    };
    switch($directionPoussee){//traitement de la direction de poussee
        case Direction::Haut:
            $nextLigne =function()use(&$ligne){//fonction d'incrementation de la boucle
                return --$ligne;
            };
            $inverse=Direction::Bas;//inverse de la direction de poussee
            break;
        case Direction::Bas:
            $nextLigne =function()use(&$ligne){
                return ++$ligne;
            };
            $inverse=Direction::Haut;
            break;
        case Direction::Gauche:
            $nextColonne =function()use(&$colonne){
                return --$colonne;
            };
            $inverse=Direction::Droite;
            break;
        case Direction::Droite:
            $nextColonne =function()use(&$colonne){
                return ++$colonne;
            };
            $inverse=Direction::Gauche;
            break;
        default:
            return false;
    }

    if($directionPoussee!=$directionPion){
        if(!($ligne<5 && $ligne >=0 && $colonne<5 && $colonne >=0)){
            
            return true;
        }
        return $plateau[$ligne][$colonne][0]==typeCase::Vide;
        //deplacement hors sens de poussee possible vers une case vide
    }
    else{
        $cpt++;
        while($ligne<5 && $ligne >=0 && $colonne<5 && $colonne >=0){
            
            if($plateau[$ligne][$colonne][1]==$directionPoussee){
                $cpt++;
            }
            elseif($plateau[$ligne][$colonne][1]==$inverse){
                $cpt--;
            }
            
            $ligne=$nextLigne($ligne);
            $colonne=$nextColonne($colonne);
        }
    }
    return $cpt>0;


}