<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * msliburan.php
 * Oct 21, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Msliburan extends Back_end {

    public $model = 'model_master_liburan';

    public function __construct() {
        parent::__construct('kelola_master_liburan', 'Daftar Liburan');
    }

    public function index() {
        parent::index();
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function detail($id = FALSE) {
        parent::detail($id, array("libur_tanggal", "libur_keterangan"));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Data ' . $this->_header_title
        ));
    }

}
