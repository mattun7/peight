<?php
class InsertBodyWeightDao {
    public static function checkInstrumentationDays($pdo, $dto) {
        $id = $dto->getId();
        $instrumentationDays = $dto->getInstrumentationDays();
        $weight = $dto->getWeight();

        $sql = 'SELECT COUNT(*) FROM PET_WEIGHT ';

        require_once(dirname(__FILE__).'/Dao.php');
        $sql = Dao::where($sql, 'ID = :id', $id);
        $sql = Dao::where($sql, 'INSTRUMENTANTION_DAYS = :instrumentationDays', $instrumentationDays);

        $stmt = $pdo->prepare($sql);

        $stmt = Dao::setParam($stmt, ':id', $id);
        $stmt = Dao::setParam($stmt, ':instrumentationDays', $instrumentationDays);

        $stmt->execute();
        $resultCount = $stmt->fetchColumn();

        return $resultCount == 0 ? true : false;
    }

    public static function insertPetWeight($pdo, $dto) {
        $id = $dto->getId();
        $instrumentationDays = $dto->getInstrumentationDays();
        $weight = $dto->getWeight();

        $sql = ('
            INSERT INTO PET_WEIGHT 
                (ID, INSTRUMENTANTION_DAYS, WEIGHT) 
            VALUES 
                (:id, :instrumentationDays, :weight)
        ');

        require_once(dirname(__FILE__).'/Dao.php');

        $stmt = Dao::setParam($stmt, ':id', $id);
        $stmt = Dao::setParam($stmt, ':instrumentationDays', $instrumentationDays);
        $stmt = Dao::setParam($stmt, ':weight', $weight);
        
        $stmt->execute();

    }

    public static function updatePetWeight($pdo, $dto) {
        $id = $dto->getId();
        $instrumentationDays = $dto->getInstrumentationDays();
        $weight = $dto->getWeight();

        $sql = ('
            UPDATE PET_WEIGHT
            SET WEIGHT = :weight
            WHERE ID = :id AND INSTRUMENTANTION_DAYS = :instrumentationDays
        ');

        require_once(dirname(__FILE__).'/Dao.php');

        $stmt = Dao::setParam($stmt, ':id', $id);
        $stmt = Dao::setParam($stmt, ':instrumentationDays', $instrumentationDays);
        $stmt = Dao::setParam($stmt, ':weight', $weight);

        $stmt->execute();
    }
}
?>