<?php
class PetInfoSelectDao {
    public static function get_pet_info($pdo, $dto) {
        $stmt = $pdo->prepare('SELECT ID, PET_NAME, '
            + 'BIRTHDAY, PET_TYPE, COLOR, REMARKS, IMAGE_PATH'
            + 'FROM PET_INFO'
            + 'WHERE PET_NAME LIKE :pet_name'
            + 'AND PET_TYPE = :pet_type'
            + 'AND COLOR = :color');

        $dto->set_pet_name('%'. $dto->get_pet_name() .'%');

        $stmt->bindParam(':pet_name', $dto->get_pet_name(), PDO::PARAM_STR);
        $stmt->bindParam(':pet_type', $dto->get_type(), PDO::PARAM_STR);
        $stmt->bindParam(':color', $dto->get_color(), PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetch();
    }
}
?>