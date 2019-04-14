<?php
require_once(dirname(__FILE__).'/../Util/DbConnection.php');
require_once(dirname(__FILE__).'/../Util/DateUtil.php');
require_once(dirname(__FILE__).'/../Dao/DetailGraphDao.php');

$id = $_POST['id'];
$start = $_POST['start'];
$end = $_POST['end'];

$array = array();            
$array += array(0=>array('id' => $id,
        'start' => $start,
        'end' => $end));

echo json_encode($array);
?>