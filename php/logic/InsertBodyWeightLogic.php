<?php
class InsertBodyWeightLogic {

    public static function registInstrumentationDays($pdo, $dto){
        $id = $dto->getId();
        $instrumentationDays = $dto->getInstrumentationDays();
        $weight = $dto->getWeight();

        if(is_null($id, $instrumentationDays, $weight)){
            return;
        }

        require_once(dirname(__FILE__).'../Dao/InsertBodyWeightDao.php');
        $result = checkInstrumentationDays($pdo, $dto);

        $pdo->beginTransaction();
        if($result) {
            insertPetWeight($pdo, $dto);
        } else {
            updatePetWeight($pdo, $dto);
        }
        $pdo->commit();
    }
}
?>