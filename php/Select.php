<?php
session_start();
if(empty($_SESSION['select_dto'])){
    session_destroy();
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
    </article>
    <footer>
        
    </footer>
</body>
</html>