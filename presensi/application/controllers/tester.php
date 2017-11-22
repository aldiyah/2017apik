<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * tester.php
 * Nov 14, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Tester extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $holidays = array('23-01-2017', '12-01-2017');
        $hari_kerja = get_working_day_monthly($holidays, 2017, 1);
        var_dump($hari_kerja);
    }

}
