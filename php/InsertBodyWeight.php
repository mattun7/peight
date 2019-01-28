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
        $dto->setWeight($_POST['weight']);

        InsertBodyWeightLogic::registInstrumentationDays($pdo, $dto);
    }

    //$result = DetailGraphDao::getPetDetail($pdo, $id);
    if($result === false || count($result) != 1) {
        throw new Exception('DB検索失敗');
    }
} catch (Exception $e) {
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
<link rel="stylesheet" href="../css/Element.css">
<link rel="stylesheet" href="../css/pet.css">
<script src="../js/c3.js"></script>
<script src="../js/d3.min.js"></script>
<script src="../js/InsertBodyWeight.js"></script>
<script src="../js/Util.js"></script>
<script src="../js/DetailGraph.js"></script>
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
        <div class="underLineNav">
            <nav>
                    <form action="" method="GET" id="form">
                    <a onclick="formSubmit('DetailGraph.php');" >体重グラフ</a>
                    <a onclick="formSubmit('');" style="border-bottom-color: #e36209">体重入力</a>
                    <input type="hidden" name="id" value="<?php echo $id ?>" />
                </form>
            </nav>
        </div>
        <section>
            <form action="" method="POST" >
                <table class="insertBodyWeightTable">
                    <colgroup width="150"></colgroup>
                    <colgroup width="300"></colgroup>
                    <tr>
                        <th>
                            計測日
                        </th>
                        <td>
                            <input type="date" id="instrumentationDays" name="instrumentationDays" require />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            体重
                        </th>
                        <td>
                            <input type="tel" id="weight" name="weight" require />
                        </td>
                    </tr>
                </table>
                <div class="center">
                    <input type="submit" id="send" value="登録" onclick="checkMessage();"/>
                </div>
                <input type="hidden" name="id" value="<?php echo $id ?>" />
            </form>
        </section>
    </article>
</body>
</html>