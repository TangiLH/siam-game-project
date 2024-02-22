<?php 

class User {
   private $id;
   private $pseudo;
    private $mdp;
    private $estAdmin;

    function getId(){
        return $this->id;
    }
    function getPseudo(){
        return $this->pseudo;
    }
    function getMdp(){
        return $this->mdp;
    }
    function getEstAdmin(){
        return $this->estAdmin;
    }
    function __construct($id,$pseudo,$mdp,$estAdmin){
        $this->id=$id;
        $this->pseudo=$pseudo;
        $this->mdp=$mdp;
        $this->estAdmin=$estAdmin;
    }
}
?>