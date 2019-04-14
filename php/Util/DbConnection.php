<?php

class DbConnection {
    public static $pdo = NULL;

    public static function getConnection(){
        require_once(dirname(__FILE__).'/Json.php');
        if(is_null(self::$pdo)){
            $host = $_SERVER["HTTP_HOST"];
            if($host === 'localhost'){
                $db_local = 'mysql:dbname=PetWeightInfo;host=localhost;charset=utf8mb4';
                $dsn = $db_local;
                $username = 'root';
                $password = '';
            } else {
                $url = parse_url(getenv('DATABASE_URL'));
                $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $url['host'], substr($url['path'], 1));
                $username = $url['user'];
                $password = $url['pass'];
            }
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