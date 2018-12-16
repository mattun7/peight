<?php
class PetInfoSelectDao {
    public static function getPetInfo($pdo, $dto) {

        $petName = $dto->getPetName();
        if(!empty($petName)){
            $petName = '%'. $petName .'%';
        }
        $type = $dto->getType();
        $color = $dto->getColor();
        require_once(dirname(__FILE__).'/../Util/Json.php');
        $pagination = Json::getJson('pagination');
        $limitStart = ($dto->getPage()-1) * $pagination;
        $limitEnd = (int)$pagination;

        $sql = 'SELECT ID, PET_NAME, '
            . 'BIRTHDAY, PET_TYPE, COLOR, REMARKS, IMAGE_PATH ' 
            . 'FROM PET_INFO ';

        require_once(dirname(__FILE__).'/Dao.php');

        $sql = Dao::where($sql, 'PET_NAME LIKE :pet_name', $petName);
        $sql = Dao::where($sql, 'PET_TYPE = :pet_type', $type);
        $sql = Dao::where($sql, 'COLOR = :color', $color);

        $sql .= ' LIMIT :limitStart, :limitEnd';

        $stmt = $pdo->prepare($sql);

        $stmt = Dao::setParam($stmt, ':pet_name', $petName);
        $stmt = Dao::setParam($stmt, ':pet_type', $type);
        $stmt = Dao::setParam($stmt, ':color', $color);
        $stmt = Dao::setParam($stmt, ':limitStart', $limitStart);
        $stmt = Dao::setParam($stmt, ':limitEnd', $limitEnd);

        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }

    public static function getCount($pdo, $dto){

        $petName = $dto->getPetName();
        if(!empty($petName)){
            $petName = '%'. $petName .'%';
        }
        $type = $dto->getType();
        $color = $dto->getColor();

        $sql = 'SELECT COUNT(*) FROM PET_INFO ';

        require_once(dirname(__FILE__).'/Dao.php');

        $sql = Dao::where($sql, 'PET_NAME LIKE :pet_name', $petName);
        $sql = Dao::where($sql, 'PET_TYPE = :pet_type', $type);
        $sql = Dao::where($sql, 'COLOR = :color', $color);

        $stmt = $pdo->prepare($sql);

        $stmt = Dao::setParam($stmt, ':pet_name', $petName);
        $stmt = Dao::setParam($stmt, ':pet_type', $type);
        $stmt = Dao::setParam($stmt, ':color', $color);

        $stmt->execute();

        return $stmt->fetchColumn();
    }
}
?>