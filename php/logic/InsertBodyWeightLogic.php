<?php
class InsertBodyWeightLogic {

    /**
     * 計測日・体重登録
     */
    public static function registInstrumentationDays($pdo, $dto){

        require_once(dirname(__FILE__).'/../Dao/InsertBodyWeightDao.php');
        $result = InsertBodyWeightDao::checkInstrumentationDays($pdo, $dto);

        $pdo->beginTransaction();
        if($result) {
            InsertBodyWeightDao::insertPetWeight($pdo, $dto);
        } else {
            InsertBodyWeightDao::updatePetWeight($pdo, $dto);
        }
        $pdo->commit();
    }
}
?>