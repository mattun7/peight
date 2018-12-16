<?php
require_once(dirname(__FILE__).'/Dto/PetInfoSelectDto.php');
session_start();

if(empty($_GET['page'])){
    $page = 1;
} else {
    $page = (int)$_GET['page'];
}

$referer = $_SERVER['HTTP_REFERER'];

if(preg_match('/SearchExecution.php/', $referer)){
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

try{
    $pdo = DbConnection::getConnection();
    $result = PetInfoSelectDao::getPetInfo($pdo, $selectDto);
    $count = PetInfoSelectDao::getCount($pdo, $selectDto);
} catch (Exception $e) {

}

$_SESSION['selectDto'] = $selectDto;

$typeOptions = ['', 'デグー'];
$colorOptions = ['', 'サンド', 'ブルーパイド'];

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ペット情報</title>
<link rel="stylesheet" href="../css/Element.css">
<link rel="stylesheet" href="../css/pet.css">
<script src="../js/Util.js"></script>
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
            <form action="" method="GET">
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
                            <input type="text" id="pet_name" name="pet_name" class="searchText" value="<?php echo $pet_name ?>">
                        </td>
                        <td>
                            <select id="type" name="type" class="searchSelect">
                                <?php foreach($typeOptions as $typeOption): ?>
                                    <option <?php echo $typeOption == $type ? 'selected' : '' ?>>
                                        <?php echo $typeOption; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </td>
                        <td>
                            <select id="color" name="color" class="searchSelect">
                                <?php foreach($colorOptions as $colorOption): ?>
                                    <option <?php echo $colorOption == $color ? 'selected' : '' ?>>
                                        <?php echo $colorOption; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <input type="submit" id="search" value="検索" />
            </form>
        </section>
        <section>
            <h1>検索結果<?php echo $count ?>件</h1>
            <div class="flex">
                <?php foreach($result as $key): ?>
                    <section class="searchResult">
                        <form action="DetailGraph.php" method="GET" id="petInfo">
                            <a onclick="formSubmit('petInfo');">
                                <figure class="selectFigure">
                                    <img src="<?php echo $key['IMAGE_PATH'] ?>" class="selectImage">
                                </figure>
                                <div>
                                    <h3 class="petName">
                                        <?php echo $key['PET_NAME'] ?>
                                    </h3>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $key['ID']; ?>" />
                            </a>
                        </form>
                    </section>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="paging">
            <form action="" method="GET" name="pagination" >
                <ul>
                    <?php if(($page) >= 2){ ?>
                        <li>
                            <a href="?page=1">
                                <<
                            </a>
                        </li>
                        <li>
                            <a href="?page=<?php echo $page-1; ?>">
                                <
                            </a>
                        </li>
                    <?php } ?>
                    <?php if(ceil($count/3) >= 2) { 
                        for($i=0; $i<3 && ($page+$i-1) <= ceil($count/3); $i++){ ?>
                            <?php if(($page+$i) != 1){ ?>
                                <li>
                                    <a href="?page=<?php echo $page+$i-1 ?>" class="<?php if($i == 1) echo 'active' ?>" >
                                        <?php echo $page+$i-1; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    <?php if($page != ceil($count/3)){ ?>
                        <li>
                            <a href="?page=<?php echo $page+1 ?>">
                                >
                            </a>
                        </li>
                        <li>
                            <a href="?page=<?php echo ceil($count/3); ?>">
                                >>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </form>
        </section>
    </article>
    <footer>
        
    </footer>
</body>
</html>