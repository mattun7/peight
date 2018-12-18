<?php
$id = $_GET['id'];
if(empty($id)) exit;

require_once(dirname(__FILE__).'/Util/DbConnection.php');
require_once(dirname(__FILE__).'/Util/DateUtil.php');
require_once(dirname(__FILE__).'/Dao/DetailGraphDao.php');

try{
    $pdo = DbConnection::getConnection();
    $result = DetailGraphDao::getPetDetail($pdo, $id);
    if($result === false || count($result) != 0) {
        throw new Exception('DB検索失敗');
    }
} catch (Exception $e) {

} finally {
    $pdo = null;
}

$pet_name = $result[0]['PET_NAME'];
$birthday = $result[0]['BIRTHDAY'];
$age = DateUtil::getAgeFromBirthday($birthday);
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
<script src="../js/DetailGraph.js"></script>
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
        <div class="underLineNav">
            <nav>
                <a href="DetailGraph.html" style="border-bottom-color: #e36209">体重グラフ</a>
                <a href="InsertBodyWeight.html" >体重入力</a>
            </nav>
        </div>
        <section>
            <div id="graph">
            </div>
            <label>
                体重表示日程
                <input type="date" id="start" />
                -
                <input type="date" id="end" />
            </label>
            <input type="button" value="体重表示" />
        </section>
    </article>
</body>
</html>