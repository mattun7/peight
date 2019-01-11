<?php
class PetTypeDto {
    private $id;
    private $petType;

    function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }

    function getPetType(){
        return $this->petType;
    }

    function setPetType($petType){
        $this->petType = $petType;
    }
}
?>