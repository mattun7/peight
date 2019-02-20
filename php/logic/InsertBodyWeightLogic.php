<?php
require_once(dirname(__FILE__).'/../Util/DbConnection.php');
require_once(dirname(__FILE__).'/../Dao/InsertBodyWeightDao.php');
require_once(dirname(__FILE__).'/../Dao/DetailGraphDao.php');
require_once(dirname(__FILE__).'/../Dto/InsertBodyWeightDto.php');

$id = $_GET['id'];
$instrumentationDays = $_GET['instrumentationDays'];
$weight = (int)mb_convert_kana($_GET['weight'], 'kvrn');
$start = $_GET['start'];
$end = $_GET['end'];

$dto = new InsertBodyWeightDto();
$dto->setId($id);
$dto->setInstrumentationDays($instrumentationDays);
$dto->setWeight($weight);

try{
    $pdo = DbConnection::getConnection();
    $result = InsertBodyWeightDao::checkInstrumentationDays($pdo, $dto);

    $pdo->beginTransaction();
    if($result) {
        InsertBodyWeightDao::insertPetWeight($pdo, $dto);
    } else {
        InsertBodyWeightDao::updatePetWeight($pdo, $dto);
    }
    $pdo->commit();
    $weightList = DetailGraphDao::getWeight($pdo, $id, $start, $end);
} catch (Exception $e) {
    require_once(dirname(__FILE__).'/Exception/WebAPIException.php');
    WebAPIException::errorLog($e);
} finally {
    $pdo = null;
}
echo json_encode($weightList);
?>