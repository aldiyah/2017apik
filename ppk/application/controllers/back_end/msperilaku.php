<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * msperilaku.php
 * Oct 19, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Msperilaku extends Back_end {

    public $model = 'model_master_perilaku';

    public function __construct() {
        parent::__construct('kelola_master_perilaku', 'Daftar Perilaku');
    }

    public function index() {
        parent::index();
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function detail($id = FALSE) {
        parent::detail($id, array("perilaku_nama"));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Formulir Data Perilaku'
        ));
    }

    public function get_like() {
        $keyword = $this->input->post("keyword");
        $data_found = $this->{$this->model}->get_like($keyword, $id_skpd);
        $this->to_json($data_found);
    }

}
