<?php
class PetInfoSelectDto {
    private $pet_name;
    private $type;
    private $color;

    function get_pet_name(){
        return $this->pet_name;
    }

    function set_pet_name($pet_name){
        $this->pet_name = $pet_name;
    }

    function get_type(){
        return $this->type;
    }

    function set_type($type){
        $this->type = $type;
    }

    function get_color(){
        return $this->color;
    }

    function set_color($color) {
        $this->color = $color;
    }
}
?>