<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * model_jenis_absensi.php
 * October 16, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class jnsabsensi extends Back_end {

    public $model = 'model_jenis_absensi';

    public function __construct() {
        parent::__construct('kelola_jenis_absensi', 'Jenis Absensi');
    }

    public function index() {
        parent::index();
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function detail($id = FALSE) {
        parent::detail($id, array("absensi_nama"));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Data ' . $this->_header_title
        ));
    }

    public function get_like() {
        $keyword = $this->input->post("keyword");
        $records_found = $this->model_jenis_absensi->get_like($keyword);
        $this->to_json($records_found);
    }

}
