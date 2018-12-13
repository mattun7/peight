<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ペット詳細</title>
<link rel="stylesheet" href="../css/Element.css">
<link rel="stylesheet" href="../css/pet.css">
<script src="../js/InsertBodyWeight.js"></script>
<script src="../js/Util.js"></script>
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
            <h2>じぇり吉</h2>
            <div class="flex">
                <img src="../img/jerikichi.jpg" class="detailImage">
                <table class="detailTable">
                    <tr>
                        <th>
                            ペット名
                        </th>
                        <td>
                            じぇり吉
                        </td>
                    </tr>
                    <tr>
                        <th>
                            誕生日
                        </th>
                        <td>
                            18/04 下旬
                        </td>
                    </tr>
                    <tr>
                        <th>
                            年齢
                        </th>
                        <td>
                            7ヶ月
                        </td>
                    </tr>
                    <tr>
                        <th>
                            品種
                        </th>
                        <td>
                            デグー
                        </td>
                    </tr>
                    <tr>
                        <th>
                            カラー
                        </th>
                        <td>
                            オレンジ
                        </td>
                    </tr>
                    <tr style="height: 100px;">
                        <th>
                            備考
                        </th>
                        <td>
                            好きなこと：ぴるぴるダンス
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
                <a href="DetailGraph.html">体重グラフ</a>
                <a href="InsertBodyWeight.html" style="border-bottom-color: #e36209">体重入力</a>
            </nav>
        </div>
        <section>
            <table class="insertBodyWeightTable">
                <colgroup width="150"></colgroup>
                <colgroup width="300"></colgroup>
                <tr>
                    <th>
                        計測日
                    </th>
                    <td>
                        <input type="date" id="measurementDate" />
                    </td>
                </tr>
                <tr>
                    <th>
                        体重
                    </th>
                    <td>
                        <input type="text" id="weight" />
                    </td>
                </tr>
            </table>
            <div class="center">
                <input type="button" id="send" value="登録" onclick="checkMessage();"/>
            </div>
        </section>
    </article>
</body>
</html>