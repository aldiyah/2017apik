<?php

/**
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * model_tr_absensi.php
 * Oct 18, 2017
 */
defined('BASEPATH') OR exit('No direct script access allowed');

include_once "entity/tr_absensi.php";

class Model_tr_absensi extends Tr_absensi {

    function __construct() {
        parent::__construct();
    }

    public function all($conditions = FALSE, $force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array('abs_tanggal'), $conditions, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

}
