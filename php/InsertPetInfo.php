<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once(dirname(__FILE__).'/Dao/InsertPetInfoDao.php');
    require_once(dirname(__FILE__).'/Dto/InsertPetInfoDto.php');
    require_once(dirname(__FILE__).'/Dao/PetTypeDao.php');
    require_once(dirname(__FILE__).'/Dto/PetTypeDto.php');
    require_once(dirname(__FILE__).'/Dao/PetTypeColorDao.php');
    require_once(dirname(__FILE__).'/Dto/PetTypeColorDto.php');
    require_once(dirname(__FILE__).'/Util/DbConnection.php');
    require_once(dirname(__FILE__).'/Util/FileUtil.php');
    require_once(dirname(__FILE__).'/Util/Json.php');

    if(isset($_POST['pet_name'])){

        // 画像データを保存するファイルパスを取得
        $image_path = Json::getJson('petImagePath');
        $pet_image = $_FILES['pet_image']['name'];
        
        // 画像アップロード
        if(empty($pet_image)){
            $image_path = '';
        } else {
            $image_path .= $pet_image;
        }

        // dto設定
        $insertPetInfoDto = new InsertPetInfoDto();
        $insertPetInfoDto->setPetName($_POST['pet_name']);
        $insertPetInfoDto->setBirthday($_POST['birthday']);
        $insertPetInfoDto->setRemarks($_POST['remarks']);
        $insertPetInfoDto->setImagePath($image_path);

        $petTypeDto = new PetTypeDto();
        $petTypeDto->setPetType($_POST['pet_type']);
        
        $petTypeColorDto = new PetTypeColorDto();
        $petTypeColorDto->setColor($_POST['color']);

        try{
            $pdo = DbConnection::getConnection();
            $pdo->beginTransaction();

            // DBから品種とカラーを取得
            $pet_type = PetTypeDao::fetchPetType($pdo, $petTypeDto);
            $petTypeDto->setId($pet_type);
            $color = PetTypeColorDao::fetchPetTypeColor($pdo, $petTypeDto, $petTypeColorDto);

            // DBからの取得結果をぺット情報DTOに登録
            $insertPetInfoDto->setPetType($pet_type);
            $insertPetInfoDto->setColor($color);

            // ぺット情報の登録
            InsertPetInfoDao::insertPetInfo($pdo, $insertPetInfoDto);
            FileUtil::imageUpload($image_path);
            $pdo->commit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            require_once(dirname(__FILE__).'/Exception/WebAPIException.php');
            WebAPIException::errorLog($e);
        } finally {
            $pdo = null;
        }
    }
?>
<!DOCTYPE html>
<html lang="ja" class="route-documentation fontawesome-i2svg-active fontawesome-i2svg-complete translated-ltr">
<head>
<meta charset="utf-8">
<title>ペット情報</title>
<link rel="stylesheet" href="../css/bulma.css">
<script src="../js/InsertPetInfo.js"></script>
<script src="../js/Util.js"></script>
</head>
<body class="layout-documentation page-layout">
    <nav class="navbar">
        <div class="navbar has-shadow is-spaced">
            <div class="container">
                <div class="navbar-brand">
                    <div class="navbar-item">
                        <h2 class="title is-2">ぺット体調管理</h2>
                    </div>
                    <div class="navbar-burger burger" data-target="navMenu" aria-label="menu" aria-expanded="false">
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </div>
                </div>
                <div class="navbar-menu" id="navMenu">
                    <a href="Select.php" class="navbar-item">ペット一覧</a>
                    <a href="InsertPetInfo.php" class="navbar-item">ペット情報登録</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="bd-main">
        <div class="bd-side-background"></div>
        <div class="bd-main-container container">
            <div class="bd-duo">
                <div class="bd-lead" style="padding: 1.5rem;">
                    <div class="bd-breadcrumb">
                        <nav class="breadcrumb" aria-label="breadcrumbs">
                            <ul>
                                <li><a href="#">ホーム</a></li>
                                <li><a href="#">ぺット情報登録</a></li>
                            </ul>
                        </nav>
                        <form action="" method="post" enctype="multipart/form-data" >
                            <table>
                                <tr>
                                    <th>
                                        ぺット名
                                    </th>
                                    <td class="control">
                                        <input type="text" id="pet_name" class="input" name="pet_name" required />
                                    </td>
                                <tr>
                                    <th>
                                        誕生日
                                    </th>
                                    <td class="control">
                                        <input type="date" id="birthday" class="input" name="birthday" required />
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        品種
                                    </th>
                                    <td class="control">
                                        <input type="text" id="pet_type" class="input" name="pet_type" required />
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        カラー
                                    </th>
                                    <td class="control">
                                        <input type="text" id="color" class="input" name="color" required />
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        備考
                                    </th>
                                    <td>
                                        <textarea id="remarks" class="textarea" rows="5" name="remarks"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="file has-name">
                                            <label class="file-label">
                                                <input type="file" class="file-input" id="pet_image" name="pet_image" onchange="fileName()" />
                                                <span class="file-cta">
                                                    <span class="file-icon">
                                                        <i class="fas fa-upload"></i>
                                                    </span>
                                                    <span class="file-label">
                                                        ぺットの写真
                                                    </span>
                                                </span>
                                                <span id="file_name" class="file-name">
                                                </span>
                                            </label>
                                        </div>
                                        
                                    </td>
                                </tr>
                            </table>
                            <div class="center">
                                <input type="submit" id="insert" class="button is-primary is-outlined" value="登録" onclick="checkMessage();"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
document.addEventListener('DOMContentLoaded', function () { //①

  var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0); //②

  if ($navbarBurgers.length > 0) {

    $navbarBurgers.forEach(function ($el) {
      $el.addEventListener('click', function () { //③

        var target = $el.dataset.target; //④
        var $target = document.getElementById(target); //④

        $el.classList.toggle('is-active'); //⑤
        $target.classList.toggle('is-active'); //⑤

      });
    });
  }
});
</script>
</body>
</html>