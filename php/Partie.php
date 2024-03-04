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
    
    function __construct($id,$pseudo,$mdp,$estAdmin){
        $this->id=$id;
        $this->pseudo=$pseudo;
        $this->mdp=$mdp;
        $this->estAdmin=$estAdmin;
    }
    
}
?>