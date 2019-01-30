<?php
class WebAPIException extends Exception{
    public static function errorLog($e, $message='') {
        error_log($e->getCode() . '\n', 3, '/var/log/test.log');
        error_log($e->getFile() . '\n', 3, './test.log');
        error_log($e->getLine() . '\n', 3, './test.log');
        error_log($e->getMessage() . '\n', 3, './test.log');
        //header("HTTP/1.0 404 Not Found");
        header('Location: /php/Exception/500.php');
    }
}
?>