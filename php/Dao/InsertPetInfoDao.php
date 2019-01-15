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
        $stmt->bindParam(':pet_name', $pet_name, PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        $stmt->bindParam(':pet_type', $pet_type, PDO::PARAM_STR);
        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt->bindParam(':remarks', $remarks, PDO::PARAM_STR);
        $stmt->bindParam(':image_path', $image_path, PDO::PARAM_STR);
        
        $stmt->execute();
    }
}
?>