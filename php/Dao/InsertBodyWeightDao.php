<?php
class InsertBodyWeightDao {
    /**
     * IDと計測日が既に登録されているかチェック
     * @return true:未登録　false:登録済み
     */
    public static function checkInstrumentationDays($pdo, $dto) {
        $id = $dto->getId();
        $instrumentationDays = $dto->getInstrumentationDays();

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

    /**
     * 計測日・体重登録
     */
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

        $stmt = $pdo->prepare($sql);

        $stmt = Dao::setParam($stmt, ':id', $id);
        $stmt = Dao::setParam($stmt, ':instrumentationDays', $instrumentationDays);
        $stmt = Dao::setParam($stmt, ':weight', $weight);
        
        $stmt->execute();
    }

    /**
     * 計測日・体重更新
     */
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

        $stmt = $pdo->prepare($sql);

        $stmt = Dao::setParam($stmt, ':id', $id);
        $stmt = Dao::setParam($stmt, ':instrumentationDays', $instrumentationDays);
        $stmt = Dao::setParam($stmt, ':weight', $weight);

        $stmt->execute();
    }
}
?>