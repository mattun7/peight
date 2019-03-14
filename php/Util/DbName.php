<?php
class DbName {
    public static function id($host) {
        return $host === 'localhost' ? 'ID' : 'id';
    }

    public static function pet_name($host) {
        return $host === 'localhost' ? 'PET_NAME' : 'pet_name';
    }

    public static function pet_type($host) {
        return $host === 'localhost' ? 'PET_TYPE' : 'pet_type';
    }

    public static function color($host) {
        return $host === 'localhost' ? 'COLOR' : 'color';
    }

    public static function birthday($host) {
        return $host === 'localhost' ? 'BIRTHDAY' : 'birthday';
    }

    public static function remarks($host) {
        return $host === 'localhost' ? 'REMARKS' : 'remarks';
    }
    
    public static function image_path($host) {
        return $host === 'localhost' ? 'IMAGE_PATH' : 'image_path';
    }
    public static function instrumentantion_days($host) {
      return $host === 'localhost' ? 'INSTRUMENTANTION_DAYS' : 'instrumentantion_days';
    }
    
    public static function weight($host) {
      return $host === 'localhost' ? 'WEIGHT' : 'weight';
    }
}
?>