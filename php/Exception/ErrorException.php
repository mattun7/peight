<?php
class ErrorException extends Exception{
    public function __construct($message) {
        error_log($message . '\n');
        header("HTTP/1.0 404 Not Found");
    }
}
?>