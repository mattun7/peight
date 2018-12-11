<?php
class PetInfoSelectDto {
    private $pet_name;
    private $type;
    private $color;

    function getPetName(){
        return $this->pet_name;
    }

    function setPetName($pet_name){
        $this->pet_name = $pet_name;
    }

    function getType(){
        return $this->type;
    }

    function setType($type){
        $this->type = $type;
    }

    function getColor(){
        return $this->color;
    }

    function setColor($color) {
        $this->color = $color;
    }
}
?>