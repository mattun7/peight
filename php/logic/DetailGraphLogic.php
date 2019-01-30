<?php
require_once(dirname(__FILE__).'/../Util/DbConnection.php');
require_once(dirname(__FILE__).'/../Util/DateUtil.php');
require_once(dirname(__FILE__).'/../Dao/DetailGraphDao.php');

$id = $_GET['id'];
$start = $_GET['start'];
$end = $_GET['end'];

try{
    $pdo = DbConnection::getConnection();
    $weightList = DetailGraphDao::getWeight($pdo, $id, $start, $end);
} catch (Exception $e) {
    require_once(dirname(__FILE__).'/Exception/WebAPIException.php');
    WebAPIException::errorLog($e);
} finally {
    $pdo = null;
}

echo json_encode($weightList);
?>