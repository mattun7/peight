<?php
class PetTypeColorDto {
    private $petTypeId;
    private $id;
    private $color;

    function getPetTypeId(){
        return $this->petTypeid;
    }

    function setPetTypeId($petTypeid){
        $this->petTypeid = $petTypeid;
    }

    function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }

    function getColor(){
        return $this->color;
    }

    function setColor($color){
        $this->color = $color;
    }
}
?>