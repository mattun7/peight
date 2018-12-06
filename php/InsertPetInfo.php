<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    if(isset($_POST['pet_name'])){
        $pet_name = $_POST['pet_name'];
        $birthday = $_POST['birthday'];
        $pet_type = $_POST['pet_type'];
        $color = $_POST['color'];
        $remarks = $_POST['remarks'];
        $pet_image = $_FILES['pet_image']['name'];

        // 画像データを保存するファイルパスを取得
        $json = file_get_contents('../json/const.json');
        $json = mb_convert_encoding($json, 'utf8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $json_arr = json_decode($json, true);
        $image_path = $json_arr['petImagePath'];
    
        $dsn = 'mysql:dbname=PetWeightInfo;host=localhost;charset=utf8mb4';
        $username = 'root';
        $password = '';
        $driver_options = '';
        
        try{
            $pdo = new PDO($dsn, $username, $password);
            $print = 0;
            /*
            foreach($pdo->query('SELECT 1 as value FROM DUAL') as $row) {
                $print += $row['value'];
            }*/

            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO PET_INFO (PET_NAME, BIRTHDAY, PET_TYPE, COLOR, REMARKS, IMAGE_PATH, CREATE_TIME) VALUES (:pet_name, :birthday, :pet_type, :color, :remarks, :image_path, NOW())");

            $stmt->bindParam(':pet_name', $pet_name, PDO::PARAM_STR);
            $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
            $stmt->bindParam(':pet_type', $pet_type, PDO::PARAM_STR);
            $stmt->bindParam(':color', $color, PDO::PARAM_STR);
            $stmt->bindParam(':remarks', $remarks, PDO::PARAM_STR);
            $stmt->bindParam(':image_path', $image_path, PDO::PARAM_STR);
            
            $stmt->execute();

            $pdo->commit();

            $pdo = null;

        } catch (PDOException $e) {
            
            echo '<script>alert("' + $e->getMessage() + '")</script>';
        }
        
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ペット情報</title>
<link rel="stylesheet" href="../css/Element.css">
<link rel="stylesheet" href="../css/pet.css">
<script src="../js/InsertPetInfo.js"></script>
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
    <form action="" method="post" enctype="multipart/form-data" >
        <article>
            <h2>
                ぺット情報登録
            </h2>
            <table class="insertPetInfoTable">
                <colgroup width="150"></colgroup>
                <colgroup width="300"></colgroup>
                <tr>
                    <th>
                        ぺット名
                    </th>
                    <td>
                        <input type="text" id="pet_name" name="pet_name" required />
                    </td>
                <tr>
                    <th>
                        誕生日
                    </th>
                    <td>
                        <input type="date" id="birthday" name="birthday" required />
                    </td>
                </tr>
                <tr>
                    <th>
                        品種
                    </th>
                    <td>
                        <input type="text" id="pet_type" name="pet_type" required />
                    </td>
                </tr>
                <tr>
                    <th>
                        カラー
                    </th>
                    <td>
                        <input type="text" id="color" name="color" required />
                    </td>
                </tr>
                <tr>
                    <th>
                        備考
                    </th>
                    <td>
                        <textarea id="remarks" name="remarks"></textarea>
                    </td>
                </tr>
                <tr>
                    <th>
                        画像
                    </th>
                    <td>
                        <input type="file" id="pet_image" name="pet_image" />
                    </td>
                </tr>
            </table>
            <div class="center">
                <input type="submit" id="insert" value="登録" onclick="checkMessage();"/>
            </div>
        </article>
    </form>
</body>
</html>