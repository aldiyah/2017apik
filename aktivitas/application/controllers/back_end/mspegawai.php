<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * mspegawai.php
 * Oct 17, 2017
 */
class Mspegawai extends Back_end {

    public $model = 'model_master_pegawai';

    public function __construct() {
        parent::__construct('kelola_master_pegawai', 'Daftar Pegawai');
    }

    public function index() {
        parent::index();
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

}
