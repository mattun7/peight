<?php
session_start();
if(empty($_SESSION['select_dto'])){
    session_destroy();
}

require_once(dirname(__FILE__).'/Dao/PetTypeDao.php');
require_once(dirname(__FILE__).'/Dao/PetTypeColorDao.php');
require_once(dirname(__FILE__).'/Util/DbConnection.php');
try{
    $pdo = DbConnection::getConnection();
    $petTypeResult = PetTypeDao::getPetType($pdo);
    $petTypeColorResult = PetTypeColorDao::getPetTypeColor($pdo);
} catch (Exception $e) {
    require_once(dirname(__FILE__).'/Exception/WebAPIException.php');
    WebAPIException::errorLog($e);
} finally {
    $pdo = null;
}
$json_petTypeColorResult = json_encode($petTypeColorResult);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ペット情報</title>
<link rel="stylesheet" href="../css/Element.css">
<link rel="stylesheet" href="../css/pet.css">
<script src="../js/Util.js"></script>
<script src="../js/Select.js"></script>
</head>
<body>
    <header>
        <h1>ペット一覧</h1>
    </header>
    <aside>
        <ul>
            <li><a href="Select.php">ペット一覧</a></li>
            <li><a href="InsertPetInfo.php">ペット情報登録</a></li>
        </ul>
    </aside>
    <article>
        <section>
            <h1>ぺットを探す</h1>
        </section>
        <section>
            <form action="SearchExecution.php" method="GET">
                <table>
                    <tr>
                        <th>
                            <label>ぺット名</label>
                        </th>
                        <th>
                            <label>品種</label>
                        </th>
                        <th>
                            <label>カラー</label>
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="pet_name" name="pet_name" class="searchText">
                        </td>
                        <td>
                            <select id="type" name="type" class="searchSelect" onchange="setColor()">
                                <option></option>
                                <?php foreach($petTypeResult as $petType): ?>
                                <option value="<?php echo $petType['ID'] ?>"><?php echo $petType['PET_TYPE'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </td>
                        <td>
                            <select id="color" name="color" class="searchSelect">
                                <option></option>
                            </select>
                            <input type="hidden" id="json_petTypeColorResult" name="json_petTypeColorResult" value='<?php echo $json_petTypeColorResult; ?>' />
                        </td>
                    </tr>
                </table>
                <input type="submit" id="search" value="検索" onclick="setSelectedColorIndex()"/>
            </form>
        </section>
    </article>
    <footer>
        
    </footer>
</body>
</html>