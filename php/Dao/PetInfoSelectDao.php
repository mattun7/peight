<?php
class PetInfoSelectDao {
    public static function getPetInfo($pdo, $dto) {

        $petName = $dto->getPetName();
        if(!empty($petName)){
            $petName = '%'. $petName .'%';
        }
        $type = $dto->getType();
        $color = $dto->getColor();

        $sql = 'SELECT ID, PET_NAME, '
            . 'BIRTHDAY, PET_TYPE, COLOR, REMARKS, IMAGE_PATH ' 
            . 'FROM PET_INFO ';

        if(!(empty($petName) && empty($type) && empty($color))){
            $sql .= 'WHERE ';
        }

        if(!empty($petName)){
            $sql .= 'PET_NAME LIKE :pet_name ';
        }

        if(!empty($petName) && !empty($type)){
            $sql .= 'AND ';
        }

        if(!empty($dto->getType())){
            $sql .= 'PET_TYPE = :pet_type ';
        }

        if((!empty($petName) || !empty($type)) && !empty($color)){
            $sql .= 'AND ';
        }

        if(!empty($dto->getColor())){
            $sql .= 'COLOR = :color ';
        }

        $stmt = $pdo->prepare($sql);


        if(!empty($petName)){
            $stmt->bindParam(':pet_name', $petName, PDO::PARAM_STR);
        }

        if(!empty($type)){
            $stmt->bindParam(':pet_type', $type, PDO::PARAM_STR);
        }

        if(!empty($color)){
            $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        }

        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }
}
?>