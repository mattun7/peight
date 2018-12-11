<?php
session_start();
if(empty($_SESSION['select_dto'])){
    // 検索ボタンを押下
    $pet_name = $_GET['pet_name'];
    $type = $_GET['type'];
    $color = $_GET['color'];

    require_once(dirname(__FILE__).'/Dto/PetInfoSelectDto.php');
    $selectDto = new PetInfoSelectDto();

    $selectDto->setPetName($pet_name);
    $selectDto->setType($type);
    $selectDto->setColor($color);

    require_once(dirname(__FILE__).'/Util/DbConnection.php');

    $result = "";

    try{
        $pdo = DbConnection::getConnection();
        require_once(dirname(__FILE__).'/Dao/PetInfoSelectDao.php');
        $result = PetInfoSelectDao::getPetInfo($pdo, $selectDto);
    } catch (Exception $e) {

    }

} else {
    // ヘッダーを押下
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ペット情報</title>
<link rel="stylesheet" href="../css/Element.css">
<link rel="stylesheet" href="../css/pet.css">
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
                            <input type="text" id="pet_name" name="pet_name" class="searchText">
                        </td>
                        <td>
                            <select id="type" name="type" class="searchSelect">
                                <option></option>
                                <option>デグー</option>
                            </select>
                        </td>
                        <td>
                            <select id="color" name="color" class="searchSelect">
                                <option></option>
                                <option>サンド</option>
                                <option>ブルーパイド</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <input type="submit" id="search" value="検索" />
            </form>
        </section>
        <section>
            <h1>検索結果<?php echo count($result) ?>件</h1>
            <div class="flex">
                <?php foreach($result as $key): ?>
                    <section class="searchResult">
                        <a href="DetailGraph.html">
                            <figure class="selectFigure">
                                <img src="<?php echo $key['IMAGE_PATH'] ?>" class="selectImage">
                            </figure>
                            <div>
                                <h3 class="petName">
                                    <?php echo $key['PET_NAME'] ?>
                                </h3>
                            </div>
                        </a>
                    </section>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="paging">
            <ul>
                <li>
                    1
                </li>
                <li>
                    <a href="#">2</a>
                </li>
                <li>
                    <a href="#">3</a>
                </li>
            </ul>
        </section>
    </article>
    <footer>
        
    </footer>
</body>
</html>