<?php
class PetTypeColorDao {

    /**
     * 引数のDTOにある種類がPET_TYPE_COLORテーブルに存在するか
     * @return true:存在している　false:存在していない
     */
    public static function fetchPetTypeColor($pdo, $dto) {
        require_once(dirname(__FILE__).'/Dao.php');
        $pet_type_id = $dto->getPetTypeId();
        $petType = $dto->getPetType();

        $stmt = $pdo->prepare('
            SELECT ID
            FROM PET_TYPE_COLOR
            WHERE PET_TYPE_ID = :pet_type_id and COLOR = :color
        ');
        $stmt = Dao::setParam($stmt, ':pet_type_id', $petTypeId);
        $stmt = Dao::setParam($stmt, ':color', $petType);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if($result.count() != 1) {
            insertPetTypeColor($pdo, $dto);
            $result = fetchPetTypeColor($pdo, $dto);
        } 

        return $result[0]['ID'];
    }

    /**
     * PET_TYPE_COLORテーブルを全件取得する
     */
    public static function getPetTypeColor($pdo) {
        $stmt = $pdo->prepare('
            SELECT PET_TYPE_ID, ID, COLOR
            FROM PET_TYPE_COLOR
        ');

        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * PET_TYPE_COLORテーブルに１件登録する
     */
    public static function insertPetTypeColor($pdo, $dto) {
        require_once(dirname(__FILE__).'/Dao.php');
        $petTypeId = $dto->getPetTypeId();
        $id = $dto->getId();
        $color = $dto->getColor();

        $stmt = $pdo->prepare('
            INSERT INTO PET_TYPE_COLOR
                (PET_TYPE_ID, ID, COLOR)
            VALUES
                (:pet_type_id, :id, :color)
        ');

        $stmt = Dao::setParam($stmt, ':pet_type_id', $petTypeId);
        $stmt = Dao::setParam($stmt, ':id', $id);
        $stmt = Dao::setParam($stmt, ':color', $color);

        $stmt->execute();
    }
}
?>