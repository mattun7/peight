<?php
$id = $_GET['id'];
if(empty($id)) exit;

if(empty($_GET['start']) && empty($_GET['end'])){
    $start = date('Y-m-d', strtotime('-10 day'));
    $end = date('Y-m-d');
} else {
    $start = $_GET['start'];
    $end = $_GET['end'];
}

require_once(dirname(__FILE__).'/Util/DbConnection.php');
require_once(dirname(__FILE__).'/Util/DateUtil.php');
require_once(dirname(__FILE__).'/Dao/DetailGraphDao.php');
require_once(dirname(__FILE__).'/Dao/PetTypeDao.php');
require_once(dirname(__FILE__).'/Dto/PetTypeDto.php');
require_once(dirname(__FILE__).'/Dao/PetTypeColorDao.php');
require_once(dirname(__FILE__).'/Dto/PetTypeColorDto.php');

try{
    $pdo = DbConnection::getConnection();
    $petDetail = DetailGraphDao::getPetDetail($pdo, $id);
    if($petDetail === false || count($petDetail) != 1) {
        throw new Exception('DB検索失敗');
    }

    $weightList = DetailGraphDao::getWeight($pdo, $id, $start, $end);

    $petTypeDto = new PetTypeDto();
    $petTypeDto->setId($petDetail[0]['PET_TYPE']);
    $resultType = PetTypeDao::fetchPetType($pdo, $petTypeDto);

    $petTypeColorDto = new PetTypeColorDto();
    $petTypeColorDto->setPetTypeId($petDetail[0]['PET_TYPE']);
    $petTypeColorDto->setId($petDetail[0]['COLOR']);
    $resultColor = PetTypeColorDao::fetchColor($pdo, $petTypeColorDto);
} catch (Exception $e) {
    require_once(dirname(__FILE__).'/Exception/WebAPIException.php');
    WebAPIException::errorLog($e);
} finally {
    $pdo = null;
}
$json_weightList = json_encode($weightList);

$pet_name = $petDetail[0]['PET_NAME'];
$birthday = date('Y年n月j日', strtotime($petDetail[0]['BIRTHDAY']));
$age = DateUtil::getAgeFromBirthday($petDetail[0]['BIRTHDAY']);
$type = $resultType[0]['PET_TYPE'];
$color = $resultColor[0]['COLOR'];
$remarks = $petDetail[0]['REMARKS'];
$image_path = $petDetail[0]['IMAGE_PATH'];


?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ペット詳細</title>
<link rel="stylesheet" href="../css/bulma.css">
<link rel="stylesheet" href="../css/c3.css">
<script src="../js/DetailGraph.js"></script>
<script src="../js/c3.js"></script>
<script src="../js/d3.min.js"></script>
<script src="../js/Util.js"></script>
</head>
<body class="layout-documentation">
    <?php include('Header.php'); ?>
    <main class="bd-main">
        <div class="bd-side-background"></div>
        <div class="bd-main-container container">
            <div class="bd-duo">
                <div class="bd-lead" style="padding: 1.5rem;">
                    <div class="bd-breadcrumb">
                        <nav class="breadcrumb" aria-label="breadcrumbs">
                            <ul>
                                <li><a href="#">ホーム</a></li>
                                <li><a href="SearchExecution">ぺットを探す</a></li>
                                <li class="is-active"><a><?php echo $pet_name ?></a></li>
                            </ul>
                        </nav>
                        <div class="columns is-multiline">
                            <div class="column is-half">
                            <figure class="image is-1by1">
                                <img src="<?php echo $image_path ?>">
                            </figure>
                            </div>
                            <div class="column is-half">
                                <table class="table is-bordered is-striped is-narrow is-fullwidth">
                                    <thead></thead>
                                    <tbody>
                                        <tr>
                                            <th>
                                                ペット名
                                            </th>
                                            <td>
                                                <?php echo $pet_name ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                誕生日
                                            </th>
                                            <td>
                                                <?php echo $birthday ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                年齢
                                            </th>
                                            <td>
                                                <?php echo $age ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                品種
                                            </th>
                                            <td>
                                                <?php echo $type ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                カラー
                                            </th>
                                            <td>
                                                <?php echo $color ?>
                                            </td>
                                        </tr>
                                        <tr style="height: 100px;">
                                            <th>
                                                備考
                                            </th>
                                            <td>
                                                <?php echo $remarks ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tabs">
                            <ul>
                                <li id="a_DetailGraph">
                                    <a onclick="changePage('DetailGraph');">体重グラフ</a>
                                </li>
                                <li id="a_InsertBodyWeight">
                                    <a onclick="changePage('InsertBodyWeight');" >体重入力</a>
                                </li>
                                <input type="hidden" id="id" name="id" value="<?php echo $id ?>" />
                            </ul>
                        </div>
                        <div id="DetailGraph">
                            <div class="field is-horizontal" style="padding-bottom: 1rem;">
                                <div class="field-label is-normal">
                                    <label class="label">体重表示日程</label>
                                </div>
                                <div class="field-body">
                                    <div class="field" style="flex-grow: 0;">
                                        <p class="control is-expanded">
                                            <input type="date" class="input" style="width: 10rem;" id="start" name="start" value="<?php echo $start ?>" />
                                        </p>
                                    </div>
                                    <div class="field" style="flex-grow: 0;">
                                        <label class="label">_</label>
                                    </div>
                                    <div class="field">
                                        <p class="control is-expanded">
                                            <input type="date" class="input" style="width: 10rem;" id="end" name="end" value="<?php echo $end ?>" />
                                        </p>
                                    </div>
                                    <div class="field">
                                        <p class="control is-expanded">
                                        <input type="button" class="button is-primary" id="bodyWeightDisplay" value="体重表示" onclick="ajaxGraph()" />
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div id="chart">
                            <input type="hidden" id="json_weightList" name="json_weightList" value='<?php echo $json_weightList; ?>' />
                        </div>
                    </div>
                    <div id="InsertBodyWeight" style="height: 350px;">
                        <div class="field">
                            <label class="label">計測日</label>
                            <div class="control">
                                <input type="date" class="input" id="instrumentationDays" name="instrumentationDays" require />
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">体重</label>
                            <div class="control">
                                <input type="tel" class="input" id="weight" name="weight" require />
                            </div>
                        </div>
                        <section class="section" style="text-align: right;">
                            <input type="submit" id="send" class="button is-primary is-medium" value="登録" onclick="ajaxInsertBodyWeight()" />
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>