<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * msupacara.php
 * Oct 22, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Msupacara extends Back_end {

    public $model = 'model_master_upacara';

    public function __construct() {
        parent::__construct('kelola_master_upacara', 'Daftar Upacara');
    }

    public function index() {
        parent::index();
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function detail($id = FALSE) {
        parent::detail($id, array("upacara_tanggal", "upacara_keterangan", "upacara_tempat", "upacara_pakaian"));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Data ' . $this->_header_title
        ));
    }

}
