<?php

class DbConnection {
    public static $pdo = NULL;

    public static function getConnection(){
        if(is_null(self::$pdo)){
            $dsn = 'mysql:dbname=PetWeightInfo;host=localhost;charset=utf8mb4';
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