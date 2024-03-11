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
    $plateau[]=array(array(typeCase::Elephant,Direction::Bas),
    array(typeCase::Elephant,Direction::Bas),
    array(typeCase::Elephant,Direction::Bas),
    array(typeCase::Elephant,Direction::Bas),
    array(typeCase::Elephant,Direction::Bas));
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
        return $strType."".$strDirection;
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
function afficheLignePlateau($plateau,$numLigne,$joueur){
    $ligne=$plateau[$numLigne];
    
    for($j=0;$j<5;$j++){
        $case=$ligne[$j];
        echo "<button type=\"submit\" name=\"caseChoix\" value=\""
        .$numLigne.",".$j."\" style=\"";echo "background-image: url('../img/".afficheCase($case).
        ".gif'),url('../img/".arrierePlan($numLigne,$j,$plateau,$joueur).".png'),url('../img/VN.png');";
        echo"width:80px;height:80px; \" >"."</button>";
        
    }
    echo "<br>";
}
/**
 * retourne la couleur d'arriere plan pour la case
 */
function arrierePlan($ligne,$colonne,$plateau,$joueur){
    $retour="VIDE";
    if(isset($_SESSION["actionJoueur"])){
        $cookie=json_decode($_SESSION["actionJoueur"],true);
    }
    if(isset($cookie["caseOrigine"])){
        $caseChoix=$cookie["caseOrigine"];
        $coups=actionsPossiblesCase($plateau,$caseChoix[0],$caseChoix[1]);
        $case=array($ligne,$colonne);
        if($case==$caseChoix){
            $retour="BLEU";
        }
        elseif(dansTableau(array($ligne,$colonne),$coups)){
            $retour= "VERT";
        }
    }
    elseif(isset($joueur)){
        $case=$plateau[$ligne][$colonne];
        if($case[0]==$joueur){
            $retour="VERT";
        }
    }
    return $retour;
}

/**
 * affiche les bouton pour contrôler les pions
 */
function afficheBoutonsControle(){

    $rotation="<button type=\"submit\" name=\"Rotation\" value=\"";
    echo $rotation.Direction::Haut->jsonSerialize()."\">r HAUT</button>";
    echo $rotation.Direction::Bas->jsonSerialize()."\">r BAS</button>";
    echo $rotation.Direction::Gauche->jsonSerialize()."\">R GAUCHE</button>";
    echo $rotation.Direction::Droite->jsonSerialize()."\">R DROITE</button>";
    echo "<button type=\"submit\" name=\"Eject\">retirer piece</button> ";
}

/**
 * affiche le plateau et les boutons de contrôle
 */
function affichePlateau($plateau,$joueur){
    echo "<form method=\"POST\" >";
    afficheLignePlateau($plateau,5,$joueur);
    echo "</br>";
    for($i=0;$i<5;$i++){
        afficheLignePlateau($plateau,$i,$joueur);
        
    }
    echo "</br>";
    afficheLignePlateau($plateau,6,$joueur);
    echo "</br>";
    afficheBoutonsControle();
    echo "<button type=\"submit\" name=\"supprCaseChoix\">Decocher case</button>";
    echo "</form>";
}

/**
 * cherche si $tableau contient un tableau identique à $tab
 */
function dansTableau($tab,$tableau){
    $retour=false;
    foreach($tableau as $t){
        if($t==$tab){
            $retour=true;
        }
    }
    return $retour;
}
function verifVictoire($plateau){
    return $plateau[7][0][0]==typeCase::Montagne;
}
/**
 * fonction principale. recupere le plateau dans la BDD, traite les actions du joueur, et met à jour la BDD.
 */
function jouerJeu($plateau,$idCurrent){
    $plateau=decodePlateau($plateau);
    $joueurTour=$idCurrent;
    switch($joueurTour){
        case 1:
            $tour=typeCase::Elephant;
            break;
        case 2:
            $tour=typeCase::Rhinoceros;
            break;
        default:
            $tour=typeCase::Elephant;
            break;
        }
    $res=traitementPlateau($plateau,$tour);
    affichePlateau($res[0],$tour);
    if($res[1]){
        $id=$joueurTour==1?2:1;
        unset($_SESSION["actionJoueur"]);
    }else{
        $id=$idCurrent;
    }
    $bool=verifVictoire($res[0]);
    return array($id,encodePlateau($res[0]),$bool);
}

/**
 * traite les actions du joueur sur le plateau grâce à la méthode POST
 * @return array un tableau avec le plateau modifié et un booleen indiquant si le joueur a fini son tour
 */
function traitementPlateau($plateau,$joueur){
        $tourfini=false;
        if(isset($_SESSION["actionJoueur"])){
            $cookie=json_decode($_SESSION["actionJoueur"],true);
        }
        else{
            $cookie=array();
        }
        if(isset($_POST["supprCaseChoix"])){
            unset($cookie["caseOrigine"]);
        }
        if(isset($_POST["caseChoix"])){
            $caseChoix=array($_POST["caseChoix"][0],$_POST["caseChoix"][2]);
            
            if(!isset($cookie["caseOrigine"])){
                if(!verifChoixCase($caseChoix,$joueur,$plateau)){
                    echo "choix impossible";
                    return array($plateau,$tourfini);
                }
                $cookie["caseOrigine"]=$caseChoix;
            }
            else{
                $caseDest=$caseChoix;
                $caseChoix=$cookie["caseOrigine"];
                if(!verifChoixCase($caseChoix,$joueur,$plateau)){
                    echo "tricheur!";
                    return array($plateau,$tourfini);
                }
                $coups=actionsPossiblesCase($plateau,$caseChoix[0],$caseChoix[1]);
                if(dansTableau($caseDest,$coups)){
                    echo "coup possible";
                    $plateau=joueCoup($caseChoix,$caseDest,$plateau);
                    $tourfini=true;
                    $cookie["caseDest"]=$_POST["caseChoix"];
                }
                else{
                    echo "coup impossible";
                }
            }
        }
        if(isset($_POST["Rotation"]) && $cookie["caseOrigine"]!=""){
            $caseChoix=$cookie["caseOrigine"];
            if(!verifChoixCase($caseChoix,$joueur,$plateau)){
                echo "tricheur!";
                return array($plateau,$tourfini);
            }
            $plateau=rotationPiece($caseChoix,$_POST["Rotation"],$plateau);
            if($caseChoix[0]<5){
                $tourfini=true;
            }
        }
        if(isset($_POST["Eject"])&& $cookie["caseOrigine"]!=""){
            $caseChoix=$cookie["caseOrigine"];
            if($caseChoix[0]==0||$caseChoix[0]==4||$caseChoix[1]==0||$caseChoix[1]==4){
                $plateau=ejecteCase($plateau,$caseChoix[0],$caseChoix[1]);
                $tourfini=true;
            }
        }
        $_SESSION["actionJoueur"]=json_encode($cookie);
        
        return array($plateau,$tourfini);
}

function joueCoup($caseChoix,$caseDest,$plateau){
    
   // if($caseChoix[0]>4){
        if($plateau[$caseDest[0]][$caseDest[1]][0]!=typeCase::Vide){
            $plateau=pousse($plateau,$caseDest[0],$caseDest[1],$plateau[$caseChoix[0]][$caseChoix[1]][1]);
            
        }
        $plateau=swap($plateau,$caseChoix[0],$caseChoix[1],$caseDest[0],$caseDest[1]);
   // }
    //else{
    //    $plateau=pousse($plateau,$caseDest[0],$caseDest[1],$plateau[$caseChoix[0]][$caseChoix[1]][1]);
    //}
    return $plateau;
}
/**
 * effectue la rotation de la piece
 * @param $piece la piece à pivoter
 * @param $direction la direction après rotation
 * @param $plateau le plateau de jeu
 * @return array le plateau modifié
 */
function rotationPiece($piece,$direction,$plateau){
    $dir=Direction::jsonDeSerialize($direction);
    $plateau[$piece[0]][$piece[1]][1]=$dir;
    return $plateau;

}

/**
 *verifie que la case choisie par le joueur est valide (pas une case vide ni une case de l'adversaire)
 *@param $case la case choisie
 *@param $joueur le joueur actif
 *@param $plateau le plateau de jeu
 *@return bool vrai si le choix est autorisé 
  */
  function verifChoixCase($case,$joueur,$plateau){
    $c=$plateau[$case[0]][$case[1]];
    return $c[0]==$joueur;
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
            if($plateau[$ligne][$colonne][0]==typeCase::Vide){
                break;
            }
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

/**
 * procede à l'échange des deux cases sans aucune vérification
 */
function swap($plateau,$ligneDep,$colonneDep,$ligneArr,$colonneArr){
    $mem=$plateau[$ligneArr][$colonneArr];
    $plateau[$ligneArr][$colonneArr]=$plateau[$ligneDep][$colonneDep];
    $plateau[$ligneDep][$colonneDep]=$mem;
    return $plateau;
}

/**
 * insere la case dans la premiere case vide de la ligne
 */
function insereListe($ligne,$case){
    $retour=array();
    $done=false;
    foreach($ligne as $c){
        if($c[0]->name=="Vide" && !$done){
            $c=$case;
            $done=true;
        }
        $retour[]=$c;
    }
    return $retour;
}

/**
 * ejecte la case du plateau
 */
function ejecteCase($plateau,$ligne,$colonne){
    $case=$plateau[$ligne][$colonne];
    switch($case[0]){
        case typeCase::Montagne:
            $plateau[7][0]=array(typeCase::Montagne,Direction::Neutre);
            break;
        case typeCase::Rhinoceros:
            $plateau[6]=insereListe($plateau[6],array(typeCase::Rhinoceros,Direction::Haut));
            break;
        case typeCase::Elephant:
            $plateau[5]=insereListe($plateau[5],array(typeCase::Elephant,Direction::Haut));
            break;
        default:
            break;
    }
    $plateau[$ligne][$colonne]=array(typeCase::Vide,Direction::Neutre);
    return $plateau;
}

/**
 * effectue la poussee sans verification
 * @param $plateau le plateau de jeu
 * @param $ligne la ligne de depart de la poussee
 * @param $colonne la colonne de depart de la poussee
 * @param $directionPoussee la direction de poussee
 */
function pousse($plateau,$ligne,$colonne,$directionPoussee){
    $borneInfLigne=0;
    $borneSupLigne=4;
    $borneInfColonne=0;
    $borneSupColonne=4;
    $nextLigne=function()use(&$ligne){
        return $ligne;
    };
    $nextColonne=function()use(&$colonne){
        return $colonne;
    };
    switch($directionPoussee){//traitement de la direction de poussee
        case Direction::Haut:
            $nextLigne =function()use(&$ligne){//fonction d'incrementation de la boucle
                return $ligne-1;
            };
            $borneSupLigne=$ligne;
            break;
        case Direction::Bas:
            $nextLigne =function()use(&$ligne){
                return $ligne+1;
            };
            $borneInfLigne=$ligne;
            break;
        case Direction::Gauche:
            $nextColonne =function()use(&$colonne){
                return $colonne-1;
            };
            $borneSupColonne=$colonne;
            break;
        case Direction::Droite:
            $nextColonne =function()use(&$colonne){
                return $colonne+1;
            };
            $borneInfColonne=$colonne;
            break;
        default:
            break;
    }
    
    //premire boucle parcourt jusqu'à trouver la dernière case à pousser
    while($nextLigne()<=$borneSupLigne && $nextLigne() >=$borneInfLigne
    && $nextColonne()<=$borneSupColonne && $nextColonne() >=$borneInfColonne){
        if($plateau[$ligne][$colonne]==typeCase::Vide){
            break;
        }
        $ligne=$nextLigne();
        $colonne=$nextColonne();
    }
    
    
    if($ligne==0||$ligne==4||$colonne==0||$colonne==4){
        $plateau=ejecteCase($plateau,$ligne,$colonne);
    }
    
    //deuxieme boucle parcourt à l'envers depuis la dernière case à déplacer
    switch($directionPoussee){//traitement de la direction de poussee
        case Direction::Haut:
            $nextLigne =function()use(&$ligne){//fonction d'incrementation de la boucle
                return $ligne+1;
            };
            
            break;
        case Direction::Bas:
            $nextLigne =function()use(&$ligne){
                return $ligne-1;
            };
            
            break;
        case Direction::Gauche:
            $nextColonne =function()use(&$colonne){
                return $colonne+1;
            };
            
            break;
        case Direction::Droite:
            $nextColonne =function()use(&$colonne){
                return $colonne-1;
            };
            
            break;
        default:
            break;
    }
    while($nextLigne()<=$borneSupLigne && $nextLigne() >=$borneInfLigne
    && $nextColonne()<=$borneSupColonne && $nextColonne() >=$borneInfColonne){
        
        $plateau=swap($plateau, $ligne,$colonne,$nextLigne(),$nextColonne());
        $ligne=$nextLigne();
        $colonne=$nextColonne();
    }
    $plateau[$ligne][$colonne]=array(typeCase::Vide,Direction::Neutre);

    return $plateau;
}

/**
 * retourne un tableau contenant l'ensemble des actions possibles pour chaque case
 */
function actionsPossiblesPlateau($plateau){
    $retour=array();

    for($i=0;$i<7;$i++){
        $ligneRetour=array();
        for($j=0;$j<4;$j++){
            $ligneRetour[]=actionsPossiblesCase($plateau,$i,$j);
        }
        $retour[]=$ligneRetour;
    }
    return $retour;
}

/**
 * retourne un tableau contenant les actions possibles pour une case
*/
function actionsPossiblesCase($plateau,$ligne,$colonne){
    $retour=array();
    $case=$plateau[$ligne][$colonne];
    if($case[0]!=typeCase::Elephant && $case[0]!=typeCase::Rhinoceros){
        return $retour;
    }
    if($ligne<5){
        if(verifPousse($plateau,$ligne+1,$colonne,$case[1],Direction::Bas)){
            $retour[]=array($ligne+1,$colonne);
        }
        if(verifPousse($plateau,$ligne-1,$colonne,$case[1],Direction::Haut)){
            $retour[]=array($ligne-1,$colonne);
        }
        if(verifPousse($plateau,$ligne,$colonne+1,$case[1],Direction::Droite)){
            $retour[]=array($ligne,$colonne+1);
        }
        if(verifPousse($plateau,$ligne,$colonne-1,$case[1],Direction::Gauche)){
            $retour[]=array($ligne,$colonne-1);
        }
    }
    elseif($ligne<7){
        for($i=0;$i<5;$i++){
            if(verifPousse($plateau,$i,0,$case[1],Direction::Droite)){
                $retour[]=array($i,0);
            }
            if(verifPousse($plateau,$i,4,$case[1],Direction::Gauche)){
                $retour[]=array($i,4);
            }
            if(verifPousse($plateau,0,$i,$case[1],Direction::Bas)){
                $retour[]=array(0,$i);
            }
            if(verifPousse($plateau,4,$i,$case[1],Direction::Haut)){
                $retour[]=array(4,$i);
            }
        }
    }
    return $retour;
}