<?php 

class Partie {
   private $id;
   private $plateau;
    private $idJoueur1;
    private $idJoueur2;
    private $idJoueurGagnant;
    private $idJoueurTour;


    function getPlateau(){
        return $this->plateau;
    }
    function getId(){
        return $this->id;
    }
    function getIdJoueur1(){
        return $this->idJoueur1;
    }
    function getIdJoueur2(){
        return $this->idJoueur2;
    }
    function getIdJoueurGagnant(){
        return $this->idJoueurGagnant;
    }
    function getIdJoueurTour(){
        return $this->idJoueurTour;
    }

    function __construct($id,$plateau,$idJoueur1,$idJoueur2,$idJoueurGagnant,$idJoueurTour){
        $this->id=$id;
        $this->plateau=$plateau;
        $this->idJoueur1=$idJoueur1;
        $this->idJoueur2=$idJoueur2;
        $this->idJoueurGagnant=$idJoueurGagnant;
        $this->idJoueurTour=$idJoueurTour;
    }
    
}
?>