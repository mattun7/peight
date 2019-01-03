<?php
class InsertPetInfoDao {

    public static function insertPetInfo($pdo, $dto) {

        $pet_name = $dto->getPetName();
        $birthday = $dto->getBirthday();
        $pet_type = $dto->getPetType();
        $color = $dto->getColor();
        $remarks = $dto->getRemarks();
        $image_path = $dto->getImagePath();

        $stmt = $pdo->prepare('
            INSERT INTO PET_INFO 
                (PET_NAME
                , BIRTHDAY
                , PET_TYPE
                , COLOR
                , REMARKS
                , IMAGE_PATH
                , CREATE_TIME) 
            VALUES 
                (:pet_name
                , :birthday
                , :pet_type
                , :color
                , :remarks
                , :image_path
                , NOW())
            ');

        require_once(dirname(__FILE__).'/Dao.php');
        $stmt = Dao::setParam($stmt, ':pet_name', $pet_name);
        $stmt = Dao::setParam($stmt, ':birthday', $birthday);
        $stmt = Dao::setParam($stmt, ':pet_type', $pet_type);
        $stmt = Dao::setParam($stmt, ':color', $color);
        $stmt = Dao::setParam($stmt, ':remarks', $remarks);
        $stmt = Dao::setParam($stmt, ':image_path', $image_path);
        
        $pdo->beginTransaction();
        $stmt->execute();
        $pdo->commit();
    }
}
?>