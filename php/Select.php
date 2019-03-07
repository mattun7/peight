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
    $petTypeResult = PetTypeDao::fetchPetTypeAll($pdo);
    $petTypeColorResult = PetTypeColorDao::getColorIdAll($pdo);
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
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ペット情報</title>
<link rel="stylesheet" href="../css/bulma.css">
<script src="../js/Util.js"></script>
<script src="../js/Select.js"></script>
</head>
<body>
    <?php include('Header.php'); ?>
    <main class="bd-main">
        <div class="bd-side-background"></div>
        <div class="bd-main-container container">
            <div class="bd-duo">
                <div class="bd-lead">
                    <div class="bd-breadcrumb">
                        <nav class="breadcrumb" aria-label="breadcrumbs">
                            <ul>
                                <li><a href="#">ホーム</a></li>
                                <li class="is-active"><a href="#">ぺットを探す</a></li>
                            </ul>
                        </nav>
                        <form action="SearchExecution.php" method="GET">
                            <div class="columns">
                                <div class="column">
                                    <div class="field">
                                    <label class="label">ぺット名</label>
                                        <div class="control">
                                            <input type="text" class="input" id="pet_name" name="pet_name" class="searchText">
                                        </div>
                                    </div>
                                </div>
                                <div class="column field">
                                    <labell class="label">品種</labell>
                                    <div class="control">
                                        <div class="select is-success">
                                            <select id="type" name="type" onchange="setColor()">
                                                <option></option>
                                                <?php foreach($petTypeResult as $petType): ?>
                                                    <option value="<?php echo $petType['ID'] ?>"><?php echo $petType['PET_TYPE'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <input type="hidden" id="pet_type" value="<?php echo $petTypeResult ?>"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="column field">
                                    <label class="label">カラー</label>
                                    <div class="control" style="width: 100%;">
                                        <div class="select is-success">
                                            <select id="color" name="color">
                                                <option></option>
                                            </select>
                                            <input type="hidden" id="json_petTypeColorResult" name="json_petTypeColorResult" value='<?php echo $json_petTypeColorResult; ?>' />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" id="search" class="button is-primary is-medium" value="検索" onclick="setSelectedColorIndex()"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>