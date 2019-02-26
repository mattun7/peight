<?php

class DbConnection {
    public static $pdo = NULL;

    public static function getConnection(){
        if(is_null(self::$pdo)){
            $host = $_SERVER["HTTP_HOST"];
            if($host === 'localhost'){
                $dsn = 'mysql:dbname=PetWeightInfo;host=localhost;charset=utf8mb4';
            } else {
                
            }
            $username = 'root';
            $password = '';
            try{
                self::$pdo = new PDO($dsn, $username, $password);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
        return self::$pdo;
    }
}
?>