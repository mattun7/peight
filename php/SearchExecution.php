<?php
require_once(dirname(__FILE__).'/Dto/PetInfoSelectDto.php');
session_start();
if(empty($_GET['page'])){
    $page = 1;
} else {
    $page = (int)$_GET['page'];
}

$referer = $_SERVER['HTTP_REFERER'];

if(preg_match('/SearchExecution.php/', $referer) || empty($_SESSION['selectDto'])){
    // 検索ボタンを押下
    $pet_name = $_GET['pet_name'];
    $type = $_GET['type'];
    $color = $_GET['color'];

    $selectDto = new PetInfoSelectDto();
    
    $selectDto->setPetName($pet_name);
    $selectDto->setType($type);
    $selectDto->setColor($color);
    $selectDto->setPage($page);
    
} else {
    // ヘッダーを押下
    if(empty($_SESSION['selectDto'])){
        exit;
    }
    $selectDto = $_SESSION['selectDto'];
    $pet_name = $selectDto->getPetName();
    $type = $selectDto->getType();
    $color = $selectDto->getColor();

    $selectDto->setPage($page);
}

require_once(dirname(__FILE__).'/Util/DbConnection.php');
require_once(dirname(__FILE__).'/Dao/PetInfoSelectDao.php');
require_once(dirname(__FILE__).'/Dao/PetTypeDao.php');
require_once(dirname(__FILE__).'/Dao/PetTypeColorDao.php');

try{
    $pdo = DbConnection::getConnection();
    $result = PetInfoSelectDao::getPetInfo($pdo, $selectDto);
    $count = PetInfoSelectDao::getCount($pdo, $selectDto);

    $petTypeResult = PetTypeDao::fetchPetTypeAll($pdo);
    $petTypeColorResult = PetTypeColorDao::getColorIdAll($pdo);
} catch (Exception $e) {
    require_once(dirname(__FILE__).'/Exception/WebAPIException.php');
    WebAPIException::errorLog($e);
} finally {
    $pdo = null;
}

$_SESSION['selectDto'] = $selectDto;

$json_petTypeResult = json_encode($petTypeResult);
$json_petTypeColorResult = json_encode($petTypeColorResult);

$url = '?pet_name=' . $pet_name . '&type=' . $type  . '&color=' . $color . '&page=';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Peight</title>
<link rel="stylesheet" href="../css/bulma.css">
<link rel="stylesheet" href="../css/pet.css">
<script src="../js/Util.js"></script>
<script src="../js/SearchExecution.js"></script>
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
                                <li><a href="../">ホーム</a></li>
                                <li class="is-active"><a href="#"class="is-active">ぺットを探す</a></li>
                            </ul>
                        </nav>
                        <form action="SearchExecution.php" method="GET">
                            <div class="columns">
                                <div class="column">
                                    <label class="label">ぺット名</label>
                                    <div class="control">
                                        <input type="text" class="input" id="pet_name" name="pet_name" class="searchText">
                                    </div>
                                </div>
                                <div class="column">
                                    <label class="label">品種</label>
                                    <div class="control">
                                        <div class="select is-success">
                                            <select id="type" name="type" onchange="setColor()">
                                                <option></option>
                                                <?php foreach($petTypeResult as $petType): ?>
                                                    <option value="<?php echo $petType['ID'] ?>"><?php echo $petType['PET_TYPE'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <label class="label">カラー</label>
                                    <div class="control" style="width: 100%;">
                                        <div class="select is-success">
                                            <select id="color" name="color">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" id="search" class="button is-primary is-medium" value="検索" onclick="setSelectedColorIndex()"/>
                        </form>
                        <input type="hidden" id="pet_type" value="<?php echo $json_petTypeResult ?>"> 
                        <input type="hidden" id="json_petTypeColorResult" name="json_petTypeColorResult" value='<?php echo $json_petTypeColorResult; ?>' />
                        <section class="section" style="margin-top: 2rem;">
                            <div class="container">
                                <h1 class="subtitle">検索結果<?php echo $count ?>件</h1>
                            </div>
                        </section>
                        <div class="columns petImageWidth">
                            <?php foreach($result as $key): ?>
                                <div class="column">
                                    <div class="card">
                                        <form action="DetailGraph.php" method="GET" id="petInfo_<?php echo $key['ID'] ?>">
                                            <a onclick="formSubmit(<?php echo $key['ID'] ?>);">
                                                <div class="card-image">
                                                    <figure class="image is-square">
                                                        <img src="<?php echo $key['IMAGE_PATH']; ?>" class="selectImage">
                                                    </figure>
                                                </div>
                                                <div class="card-content">
                                                    <div class="media">
                                                        <div class="media-content">
                                                            <p class="subtitle is-4">
                                                                <?php echo $key['PET_NAME'] ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="id" value="<?php echo $key['ID']; ?>" />
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php for($i=count($result); $i < 3; $i++) { ?>
                                <div class="column"></div>
                            <?php } ?>
                        </div>
                        <nav class="pagination is-rounded is-centered" style="margin-top: 2rem;" role="navigation" aria-label="pagination">
                            <ul class="pagination-list">
                                <?php if(($page) > 2){ ?>
                                    <li>
                                        <a class="pagination-link" href="<?php echo $url . '1' ?>">
                                            1
                                        </a>
                                    </li>
                                    <li>
                                        <span class="pagination-ellipsis is-mobile">...</span>
                                    </li>
                                <?php } else { ?>
                                    <li>
                                        <a class="pagination-link" style="visibility: hidden;">
                                            1
                                        </a>
                                    </li>
                                    <li>
                                        <span class="pagination-ellipsis is-mobile" style="visibility: hidden;">...</span>
                                    </li>
                                <?php } ?>
                                <?php if($page == ceil($count/3) && ceil($count/3) != 1) { ?>
                                        <li>
                                            <a class="pagination-link" href="<?php echo $url . (ceil($count/3) - 2) ?>">
                                                <?php echo ceil($count/3) - 2 ?>
                                            </a>
                                        </li>
                                <?php } ?>
                                <?php if(ceil($count/3) >= 2) { 
                                    for($i=0; $i<3 && ($page+$i-1) <= ceil($count/3); $i++){ ?>
                                        <?php if(($page+$i) != 1){ ?>
                                            <li>
                                                <a class="pagination-link <?php if($i == 1) echo 'is-primary' ?>" href="<?php echo $url . ($page+$i-1) ?>" >
                                                    <?php echo $page+$i-1; ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if($page === 1) { ?>
                                            <li>
                                                <a class="pagination-link" href="<?php echo $url . 3 ?>">
                                                    3
                                                </a>
                                            </li>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($page < ceil($count/3) - 1){ ?>
                                    <li>
                                        <span class="pagination-ellipsis is-mobile">...</span>
                                    </li>
                                    <li>
                                        <a class="pagination-link" href="<?php echo $url . ceil($count/3) ?>">
                                            <?php echo ceil($count/3) ?>
                                        </a>
                                    </li>
                                <?php } else { ?>
                                    <li>
                                        <span class="pagination-ellipsis" style="visibility: hidden;">...</span>
                                    </li>
                                    <li>
                                        <a class="pagination-link" style="visibility: hidden;">
                                            <?php echo ceil($count/3) ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>