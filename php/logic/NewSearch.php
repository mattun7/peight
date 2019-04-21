<?php
session_start();
if(empty($_SESSION['select_dto'])){
    session_destroy();
}
header('Location: /php/SearchExecution');
?>