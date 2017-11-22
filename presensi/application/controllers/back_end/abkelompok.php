<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * abkelompok.php
 * Nov 12, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Abkelompok extends Back_end {

    protected $auto_load_model = FALSE;

    public function __construct() {
        parent::__construct('adms_kelompok', 'Daftar Kelompok');
        $this->load->model(array(
            "model_ab_kelompok"
        ));
    }

    public function index() {
        $this->set('keyword', '');
        $this->set('bulan', date('n'));
        $this->set('tahun', date('Y'));
        $this->set('records', $this->model_ab_kelompok->all());
    }

}