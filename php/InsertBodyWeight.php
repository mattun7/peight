<?php
$id = $_POST['id'];
if(empty($id)) exit;

require_once(dirname(__FILE__).'/Util/DbConnection.php');
require_once(dirname(__FILE__).'/Util/DateUtil.php');
require_once(dirname(__FILE__).'/Dao/DetailGraphDao.php');
require_once(dirname(__FILE__).'/Dto/InsertBodyWeightDto.php');
require_once(dirname(__FILE__).'/logic/InsertBodyWeightLogic.php');

try{
    $pdo = DbConnection::getConnection();
    if(!(empty($_POST['instrumentationDays']) && empty($_POST['weight']))){
        $dto = new InsertBodyWeightDto();
        $dto->setId($id);
        $dto->setInstrumentationDays($_POST['instrumentationDays']);
        $weight = $_POST['weight'];
        $dto->setWeight((int)mb_convert_kana($weight, 'kvrn'));

        InsertBodyWeightLogic::registInstrumentationDays($pdo, $dto);
    }

    $result = DetailGraphDao::getPetDetail($pdo, $id);
    if($result === false || count($result) != 1) {
        throw new Exception('DB検索失敗');
    }
} catch (Exception $e) {
    $pdo->rollback();
    require_once(dirname(__FILE__).'/Exception/WebAPIException.php');
    WebAPIException::errorLog($e);
} finally {
    $pdo = null;
}

$pet_name = $result[0]['PET_NAME'];
$birthday = date('Y年n月j日', strtotime($result[0]['BIRTHDAY']));
$age = DateUtil::getAgeFromBirthday($result[0]['BIRTHDAY']);
$type = $result[0]['PET_TYPE'];
$color = $result[0]['COLOR'];
$remarks = $result[0]['REMARKS'];
$image_path = $result[0]['IMAGE_PATH'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ペット詳細</title>
<link rel="stylesheet" href="../css/bulma.css">
<script src="../js/c3.js"></script>
<script src="../js/d3.min.js"></script>
<script src="../js/InsertBodyWeight.js"></script>
<script src="../js/Util.js"></script>
<script src="../js/DetailGraph.js"></script>
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
                                <li><a href="#">ぺットを探す</a></li>
                                <li class="is-active"><a><?php echo $pet_name ?></a></li>
                            </ul>
                        </nav>
                        <div class="columns is-multiline">
                            <div class="column is-half" style="padding-left: 3rem;">
                            <figure class="image is-1by1">
                                <img src="<?php echo $image_path ?>">
                            </figure>
                            </div>
                            <div class="column is-half" style="padding-right: 3rem;">
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
                            <form action="" method="GET" id="form">
                                <ul>
                                    <li>
                                        <a onclick="formSubmit('DetailGraph.php');">体重グラフ</a>
                                    </li>
                                    <li class="is-active">
                                        <a onclick="formSubmit('');" >体重入力</a>
                                    </li>
                                    <input type="hidden" id="id" name="id" value="<?php echo $id ?>" />
                                </ul>
                            </form>
                        </div>
                        <form action="" method="POST" >
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
                            <section class="section">
                                <div class="container">
                                    <div class="control" style="text-align: right;" >
                                        <input type="submit" id="send" class="button is-primary is-medium" value="登録"/>
                                        <input type="hidden" name="id" value="<?php echo $id ?>" />
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>