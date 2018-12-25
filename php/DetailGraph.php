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

try{
    $pdo = DbConnection::getConnection();
    $petDetail = DetailGraphDao::getPetDetail($pdo, $id);
    if($petDetail === false || count($petDetail) != 1) {
        throw new Exception('DB検索失敗');
    }

    $weightList = DetailGraphDao::getWeight($pdo, $id, $start, $end);
} catch (Exception $e) {

} finally {
    $pdo = null;
}

$array = array();
$key_i = 0;

for($i=0; $i < count($weightList); $i++){
    $list = $weightList[$i];
    $array += array($i=>array('INSTRUMENTANTION_DAYS' => $list['INSTRUMENTANTION_DAYS'],
                          'WEIGHT' => $list['WEIGHT']));
}


$json_weightList = json_encode($array);

$pet_name = $petDetail[0]['PET_NAME'];
$birthday = date('Y年n月j日', strtotime($petDetail[0]['BIRTHDAY']));
$age = DateUtil::getAgeFromBirthday($petDetail[0]['BIRTHDAY']);
$type = $petDetail[0]['PET_TYPE'];
$color = $petDetail[0]['COLOR'];
$remarks = $petDetail[0]['REMARKS'];
$image_path = $petDetail[0]['IMAGE_PATH'];


?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ペット詳細</title>
<link rel="stylesheet" href="../css/Element.css">
<link rel="stylesheet" href="../css/pet.css">
<script src="../js/DetailGraph.js" date-param="<?php echo json_encode($array); ?>"></script>
<script src="../js/c3.js"></script>
<script src="../js/d3.min.js"></script>
<script src="../js/Util.js"></script>
<link rel="stylesheet" href="../css/c3.css">
</head>
<body>
    <header>
        <h1>ペット詳細</h1>
    </header>
    <aside>
        <ul>
            <li><a href="Select.php">ペット一覧</a></li>
            <li><a href="InsertPetInfo.php">ペット情報登録</a></li>
        </ul>
    </aside>
    <article>
        <section>
            <h2><?php echo $pet_name ?></h2>
            <div class="flex">
                <img src="<?php echo $image_path ?>" class="detailImage">
                <table class="detailTable">
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
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            
                        </td>
                    </tr>
                </table>
            </div>
        </section>
        <form action="" method="POST" id="form">
            <div class="underLineNav">
                <nav>
                    <a onclick="formSubmit('');"  style="border-bottom-color: #e36209">体重グラフ</a>
                    <a onclick="formSubmit('InsertBodyWeight.php');" >体重入力</a>
                    <input type="hidden" name="id" value="<?php echo $id ?>" />
                </nav>
            </div>
            <section>
                <div id="graph">
                </div>
                <label>
                    体重表示日程
                    <input type="date" name="start" value="<?php echo $start ?>" />
                    -
                    <input type="date" name="end" value="<?php echo $end ?>" />
                </label>
                <input type="button" value="体重表示" />
            </section>
        </form>
    </article>
    <input type="hidden" id="json_weightList" name="json_weightList" value='<?php echo $json_weightList; ?>' />
</body>
</html>