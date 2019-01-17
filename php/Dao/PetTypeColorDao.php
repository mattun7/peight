<?php
class PetTypeColorDao {

    /**
     * 引数のDTOにある種類がPET_TYPE_COLORテーブルに存在するか
     * @return true:存在している　false:存在していない
     */
    public static function fetchPetTypeColor($pdo, $petTypeDto, $petColorDto) {
        require_once(dirname(__FILE__).'/Dao.php');
        $petTypeId = $petTypeDto->getId();
        $petColor = $petColorDto->getColor();

        $stmt = $pdo->prepare('
            SELECT ID
            FROM PET_TYPE_COLOR
            WHERE PET_TYPE_ID = :pet_type_id and COLOR = :color
        ');
        $stmt = Dao::setParam($stmt, ':pet_type_id', $petTypeId);
        $stmt = Dao::setParam($stmt, ':color', $petColor);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if(count($result) != 1) {
            $petColorDto->setPetTypeId($petTypeId);
            PetTypeColorDao::insertPetTypeColor($pdo, $petColorDto);
            return PetTypeColorDao::fetchPetTypeColor($pdo, $petTypeDto, $petColorDto);
        } else {
            return $result[0]['ID'];
        }
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
    private static function insertPetTypeColor($pdo, $petColorDto) {
        require_once(dirname(__FILE__).'/Dao.php');
        $petTypeId = $petColorDto->getPetTypeId();
        $id = strval(intval(PetTypeColorDao::fetchId($pdo, $petTypeId)) + 1);
        $color = $petColorDto->getColor();

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

    private static function fetchId($pdo, $petTypeId){
        $stmt = $pdo->prepare('
            SELECT ID
            FROM PET_TYPE_COLOR
            WHERE PET_TYPE_ID = :petTypeId
            ORDER BY ID DESC
            LIMIT 1
        ');

        $stmt = Dao::setParam($stmt, ':petTypeId', $petTypeId);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result[0]['ID'];
    }
}
?>