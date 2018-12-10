<?php
class FileUtil{
    public static function imageUpload($image_path){

        if(empty($image_path)){
            return;
        }
        $tmp_name = $_FILES['pet_image']['tmp_name'];
        $result = move_uploaded_file($tmp_name, $image_path);

        if(!$result){
            throw new Exception('ファイルが登録できませんでした。');
        }
    }
}
?>