<?php

/**
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * perwal_helper.php
 * Oct 18, 2017
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists("pinalty_absensi")) {

    function pinalty_absensi($absensi_status = 0, $absensi_masuk = FALSE, $absensi_keluar = FALSE) {
        $pinalty = 0;
        $jam_masuk = 7;
        $menit_masuk = 30;
        switch ($absensi_status) {
            case 0: $pinalty = 4;
                break;
            case 1:
                $masuk = explode(':', $absensi_masuk);
                $telat = (($masuk[0] - $jam_masuk) * 60) + ($masuk[1] - $menit_masuk);
                if ($telat < 1) {
                    $pinalty = 0;
                } elseif ($telat < 16) {
                    $pinalty = 0.25;
                } elseif ($telat < 31) {
                    $pinalty = 0.5;
                } elseif ($telat < 46) {
                    $pinalty = 0.75;
                } elseif ($telat < 61) {
                    $pinalty = 1;
                } elseif ($telat < 76) {
                    $pinalty = 1.25;
                } elseif ($telat < 91) {
                    $pinalty = 1.5;
                } elseif ($telat < 106) {
                    $pinalty = 1.75;
                } elseif ($telat < 121) {
                    $pinalty = 2;
                } else {
                    $pinalty = 2.25;
                }
                break;
            case 2: $pinalty = 1;
                break;
            case 3: $pinalty = 2;
                break;
            case 4: $pinalty = 4;
                break;
        }
        return $pinalty;
    }

}