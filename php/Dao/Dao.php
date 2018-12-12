<?php
class Dao {
    /**
     * WHERE文作成
     */
    public static function where($sql, $where, $param){
        if(is_null($param) || $param === ""){
            // カラムに何もセットされていない場合なにもしない
        } else {
            if(!preg_match('/WHERE/', $sql)){
                $sql .= 'WHERE ' . $where;
            } else {
                $sql .= ' AND ' . $where;
            }
        }
        return $sql;
    }

    /**
     * bindParamの設定
     */
    public static function setParam($stmt, $parameter, $variable){
        if(!empty($variable)){
            $type = gettype($variable);
            if($type === 'string'){
                $stmt->bindParam($parameter, $variable, PDO::PARAM_STR);
            } else if($type === 'integer'){
                $stmt->bindParam($parameter, $variable, PDO::PARAM_INT);
            }
        }
        return $stmt;
    }
}
?>