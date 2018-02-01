<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * perwal_helper.php
 * Oct 18, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_working_day_monthly')) {

    function get_working_day_monthly($holidays = array(), $year = FALSE, $month = FALSE) {
        $m = $month ? $month : date('n');
        $y = $year ? $year : date('Y');
        $days = days_in_month($m, $y);
        $wd = 0;
        $arr_day = array();
        for ($d = 1; $d <= $days; $d++) {
            $date = mktime(0, 0, 0, $m, $d, $y);
            if (date('N', $date) < 6 && is_array($holidays) && !in_array(date('Y-m-d', $date), $holidays)) {
                $arr_day[] = date('Y-m-d', $date);
                $wd++;
            }
        }
        return (object) array(
                    'total' => $wd,
                    'dates' => $arr_day
        );
    }

}