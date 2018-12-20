<?php
class InsertBodyWeightDto{
    private $id;
    private $instrumentationDays;
    private $weight;

    public function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }

    public function getInstrumentationDays(){
        return $this->instrumentationDays;
    }

    function setInstrumentationDays($instrumentationDays){
        $this->instrumentationDays = $instrumentationDays;
    }

    public function getWeight(){
        return $this->weight;
    }

    function setWeight($weight){
        $this->weight = $weight;
    }
}
?>