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
        $image_path = '../img/';
        $pet_image = $_FILES['pet_image']['name'];
        $pet_file = file_get_contents($_FILES['pet_image']['tmp_name']);
        
        // 画像アップロード
        if(empty($pet_image)){
            $image_path = '';
            $pet_file = null;
        } else {
            $host = $_SERVER["HTTP_HOST"];
            if($host !== 'localhost'){
                $pet_file = null;
                $image_path .= $pet_image;
            } else {
                $image_path .= '';
            }
        }

        // dto設定
        $insertPetInfoDto = new InsertPetInfoDto();
        $insertPetInfoDto->setPetName($_POST['pet_name']);
        $insertPetInfoDto->setBirthday($_POST['birthday']);
        $insertPetInfoDto->setRemarks($_POST['remarks']);
        $insertPetInfoDto->setImagePath($image_path);
        $insertPetInfoDto->setPetFile($pet_file);

        $petTypeDto = new PetTypeDto();
        $petTypeDto->setPetType($_POST['pet_type']);
        
        $petTypeColorDto = new PetTypeColorDto();
        $petTypeColorDto->setColor($_POST['color']);

        try{
            $pdo = DbConnection::getConnection();
            $pdo->beginTransaction();

            // DBから品種とカラーを取得
            $pet_type = PetTypeDao::fetchId($pdo, $petTypeDto);
            $petTypeDto->setId($pet_type);
            $petTypeColorDto->setPetTypeId($pet_type);
            $color = PetTypeColorDao::getColorId($pdo, $petTypeColorDto);

            // DBからの取得結果をぺット情報DTOに登録
            $insertPetInfoDto->setPetType($pet_type);
            $insertPetInfoDto->setColor($color);

            // ぺット情報の登録
            InsertPetInfoDao::insertPetInfo($pdo, $insertPetInfoDto);
            if($host !== 'localhost'){
                FileUtil::imageUpload($image_path);
            }
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
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ペット情報</title>
<link rel="stylesheet" href="../css/bulma.css">
<script src="../js/InsertPetInfo.js"></script>
<script src="../js/Util.js"></script>
</head>
    <?php include('Header.php'); ?>
    <main class="bd-main">
        <div class="bd-side-background"></div>
        <div class="bd-main-container container">
            <div class="bd-duo">
                <div class="bd-lead" style="padding: 1.5rem;">
                    <div class="bd-breadcrumb">
                        <nav class="breadcrumb" aria-label="breadcrumbs">
                            <ul>
                                <li><a href="#">ホーム</a></li>
                                <li class="is-active"><a href="#">ぺット情報登録</a></li>
                            </ul>
                        </nav>
                        <form action="" method="post" enctype="multipart/form-data" >
                            <div class="field">
                                <label class="label">ぺット名</label>
                                <div class="control">
                                    <input type="text" id="pet_name" class="input" name="pet_name" required />
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">誕生日</label>
                                <div class="control">
                                    <input type="date" id="birthday" class="input" name="birthday" required />
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">品種</label>
                                <div class="control">
                                <input type="text" id="pet_type" class="input" name="pet_type" required />
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">カラー</label>
                                <div class="control">
                                    <input type="text" id="color" class="input" name="color" required />
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">備考</label>
                                <div class="control">
                                    <textarea id="remarks" class="textarea" rows="5" name="remarks"></textarea>
                                </div>
                            </div>
                            <div class="field" style="margin: 2em 0;">
                                <div class="file has-name is-fullwidth">
                                    <label class="file-label">
                                        <input type="file" class="file-input" id="pet_image" name="pet_image" onchange="fileName()" />
                                        <span class="file-cta">
                                            <span class="file-label">
                                                ぺットの写真
                                            </span>
                                        </span>
                                        <span id="file_name" class="file-name">
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <section class="section">
                                <div class="container">
                                    <div class="control" style="text-align: right;" >
                                        <input type="submit" id="insert" class="button is-primary is-medium" value="登録" onclick="checkMessage();"/>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>