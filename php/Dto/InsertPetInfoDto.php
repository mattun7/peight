<?php
class InsertPetInfoDto {
    private $pet_name;
    private $birthday;
    private $pet_type;
    private $color;
    private $remarks;
    private $image_path;
    private $pet_file;

    public function getPetName() {
        return $this->pet_name;
    }

    public function setPetName($pet_name) {
        $this->pet_name = $pet_name;
    }

    public function getBirthday() {
        return $this->birthday;
    }

    public function setBirthday($birthday) {
        $this->birthday = $birthday;
    }

    public function getPetType() {
        return $this->pet_type;
    }

    public function setPetType($pet_type) {
        $this->pet_type = $pet_type;
    }

    public function getColor() {
        return $this->color;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    public function getRemarks() {
        return $this->remarks;
    }

    public function setRemarks($remarks) {
        $this->remarks = $remarks;
    }

    public function getImagePath() {
        return $this->image_path;
    }

    public function setImagePath($image_path) {
        $this->image_path = $image_path;
    }

    public function getPetFile() {
        return $this->pet_file;
    }

    public function setPetFile($pet_file) {
        $this->pet_file = $pet_file;
    }
}
?>