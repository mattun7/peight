<?php
class PetInfoSelectDao {
    public static function get_pet_info($pdo, $dto) {
        $stmt = $pdo->prepare('SELECT ID, PET_NAME, '
            + 'BIRTHDAY, PET_TYPE, COLOR, REMARKS, IMAGE_PATH'
            + 'FROM PET_INFO';
        
        if()
            + 'WHERE PET_NAME LIKE :pet_name'
            + 'AND PET_TYPE = :pet_type'
            + 'AND COLOR = :color');

        $dto->setPetName('%'. $dto->getPetName() .'%');

        $stmt->bindParam(':pet_name', $dto->getPetName(), PDO::PARAM_STR);
        $stmt->bindParam(':pet_type', $dto->getType(), PDO::PARAM_STR);
        $stmt->bindParam(':color', $dto->getColor(), PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetch();
    }
}
?>