<?php
class Exception {
    public static function errorPage($message) {
        error_log($message . '\n');
    }
}
?>