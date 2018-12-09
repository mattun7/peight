<?php
namespace Json;

class Json {
    public static function get_json($path){
        $json = file_get_contents('../json/const.json');
        $json = mb_convert_encoding($json, 'utf8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $json_arr = json_decode($json, true);
        $json_value = $json_arr[$path];
        return $json_value;
    }
}
?>