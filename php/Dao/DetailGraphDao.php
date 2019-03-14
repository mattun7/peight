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

    public static function getWeight($pdo, $id, $start, $end){

        $start = str_replace('-', '', $start);
        $end = str_replace('-', '', $end);
        $sql = ("
            SELECT INSTRUMENTANTION_DAYS, WEIGHT
            FROM PET_WEIGHT
            WHERE ID = :id 
            AND CAST(REPLACE(INSTRUMENTANTION_DAYS, '-', '') AS INTEGER) >= :start
            AND CAST(REPLACE(INSTRUMENTANTION_DAYS, '-', '') AS INTEGER) <= :end
            ORDER BY INSTRUMENTANTION_DAYS
        ");

        require_once(dirname(__FILE__).'/Dao.php');
        require_once(dirname(__FILE__).'/../Util/DbName.php');
        
        $stmt = $pdo->prepare($sql);
        $stmt = Dao::setParam($stmt, ':id', $id);
        $stmt = Dao::setParam($stmt, ':start', $start);
        $stmt = Dao::setParam($stmt, ':end', $end);
        
        $stmt->execute();
        $result = $stmt->fetchAll();

        $array = array();
        $host = $_SERVER['HTTP_HOST'];
        for($i=0; $i < count($result); $i++){
            $list = $result[$i];
            $instrumentationDays = date('Y年n月j日', strtotime($list[DbName::instrumentantion_days($host)]));
            $array += array($i=>array(DbName::instrumentantion_days($host) => $instrumentationDays,
                                  DbName::weight($host) => $list[DbName::weight($host)]));
        }
        return $array;
    }
}

?>