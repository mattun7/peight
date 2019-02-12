<?php
class PetTypeDao {

    /**
     * 引数のDTOにある種類がPET_TYPEテーブルに存在するか
     * @return true:存在している　false:存在していない
     */
    public static function fetchId($pdo, $dto) {
        require_once(dirname(__FILE__).'/Dao.php');
        $petType = $dto->getPetType();

        $stmt = $pdo->prepare('
            SELECT ID
            FROM PET_TYPE
            WHERE PET_TYPE = :pet_type
        ');
        $stmt = Dao::setParam($stmt, ':pet_type', $petType);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if(Count($result) != 1) {
            PetTypeDao::insertPetType($pdo, $dto);
            return PetTypeDao::fetchId($pdo, $dto);
        } else {
            return $result[0]['ID'];
        }
    }

    /**
     * PET_TYPEを取得
     */
    public static function fetchPetType($pdo, $dto) {
        require_once(dirname(__FILE__).'/Dao.php');
        $id = $dto->getId();

        $stmt = $pdo->prepare('
            SELECT PET_TYPE
            FROM PET_TYPE
            WHERE ID = :id
        ');

        $stmt = Dao::setParam($stmt, ':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * PET_TYPEテーブルを全件取得する
     */
    public static function fetchPetTypeAll($pdo) {
        $stmt = $pdo->prepare('
            SELECT ID, PET_TYPE
            FROM PET_TYPE
        ');

        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * PET_TYPEテーブルに１件登録する
     */
    private static function insertPetType($pdo, $dto) {
        require_once(dirname(__FILE__).'/Dao.php');
        $petType = $dto->getPetType();
        
        $stmt = $pdo->prepare('
            INSERT INTO PET_TYPE 
                (PET_TYPE)
            VALUES
                (:pet_type)
        ');

        $stmt = Dao::setParam($stmt, ':pet_type', $petType);
        $stmt->execute();
    }
}
?>