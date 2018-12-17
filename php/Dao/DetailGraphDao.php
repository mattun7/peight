<?php
class DetailGraphDao{
    public static function getPetDetail($pdo, $id) {
        $sql = ('
            SELECT PET_NAME, 
                BIRTHDAY, PET_TYPE, COLOR, REMARKS, IMAGE_PATH 
            FROM PET_INFO 
        ');

        require_once(dirname(__FILE__).'/Dao.php');
        
        $sql = Dao::where($sql, 'ID = :id', $id);
        $stmt = $pdo->prepare($sql);
        $stmt = Dao::setParam($stmt, ':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}

?>