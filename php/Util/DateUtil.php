<?php
class DateUtil{
    public static function getAgeFromBirthday($birthday) {
        $year = substr($birthday, 0, 4);
        $month = substr($birthday, 5, 2);
        $day = substr($birthday, 8, 2);
        $now = new DateTime();
        $age = new DateTime($year.sprintf('%02d', $month). sprintf('%02d', $day));
        $interval = $now->diff($age);
        $y_age = $interval->y === 0 ? '' : $interval->y . '歳';
        $m_age = $interval->m === 0 ? '' : $interval->m . 'ヶ月';
        return $y_age . $m_age;
    }
}
?>