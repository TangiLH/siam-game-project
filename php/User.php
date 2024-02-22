<?php 

class User {
   private $pseudo;
    private $mdp;
    private $estAdmin;


    function getPseudo(){
        return $this->pseudo;
    }
    function getMdp(){
        return $this->mdp;
    }
    function getEstAdmin(){
        return $this->estAdmin;
    }
    function __construct($pseudo,$mdp,$estAdmin){
        $this->pseudo=$pseudo;
        $this->mdp=$mdp;
        $this->estAdmin=$estAdmin;
    }
}
?>