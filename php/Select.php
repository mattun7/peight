<?php
$session = $_SESSION['select_dto'];
if(is_null($session)){
    // 検索ボタンを押下
    $pet_name = $_GET['pet_name'];
    $type = $_GET['type'];
    $color = $_GET['color'];

    require_once(dirname(__FILE__).'/Dto/PetInfoSelectDto.php');
    $selectDto = new PetInfoSelectDto;

    $selectDto->set_pet_name($pet_name);
    $selectDto->set_type($type);
    $selectDto->set_color($color);

    require_once(dirname(__FILE__).'/Util/DbConnection.php');

    try{
        $pdo = DbConnection::get_connection();
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
            <li><a href="Select.html">ペット一覧</a></li>
            <li><a href="InsertPetInfo.html">ペット情報登録</a></li>
        </ul>
    </aside>
    <article>
        <section>
            <h1>ぺットを探す</h1>
        </section>
        <section>
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
                        <select id="type" name="type" class="searchSelect"></select>
                    </td>
                    <td>
                        <select id="color" name="color" class="searchSelect"></select>
                    </td>
                </tr>
            </table>
        </section>
        <section>
            <h1>検索結果3件</h1>
            <div class="flex">
                <section class="searchResult">
                    <a href="DetailGraph.html">
                        <figure class="selectFigure">
                            <img src="../img/jerikichi.jpg" class="selectImage">
                        </figure>
                        <div>
                            <h3 class="petName">じぇり吉</h3>
                        </div>
                    </a>
                </section>
                <section class="searchResult">
                    <a href="DetailGraph.html">
                        <figure class="selectFigure">
                            <img src="../img/hima.jpg" class="selectImage">
                        </figure>
                        <div>
                            <h3 class="petName">ひまり</h3>
                        </div>
                    </a>
                </section>
                <section class="searchResult">
                    <a href="DetailGraph.html">
                        <figure class="selectFigure">
                            <img src="../img/fuku.jpg" class="selectImage">
                        </figure>
                        <div>
                            <h3 class="petName">ふく</h3>
                        </div>
                    </a>
                </section>
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