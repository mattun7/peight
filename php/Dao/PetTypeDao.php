<?php
class PetTypeDao {

    /**
     * 引数のDTOにある種類がPET_TYPEテーブルに存在するか
     * @return true:存在している　false:存在していない
     */
    public static function exeistPetType($pdo, $dto) {
        require_once(dirname(__FILE__).'/Dao.php');
        $petType = $dto->getPetType();

        $stmt = $pdo->prepare('
            SELECT COUNT(*)
            FROM PET_TYPE
            WHERE PET_TYPE = :pet_type
        ');
        $stmt = Dao::setParam($stmt, ':pet_type', $petType);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count != 0 ? true : false;
    }

    /**
     * PET_TYPEテーブルを全件取得する
     */
    public static function getPetType($pdo) {
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
    public static function insertPetType($pdo, $dto) {
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