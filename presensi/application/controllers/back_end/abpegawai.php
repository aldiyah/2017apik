<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * abpegawai.php
 * Nov 12, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Abpegawai extends Back_end {

    protected $auto_load_model = FALSE;

    public function __construct() {
        parent::__construct('adms_pegawai', 'Daftar Pegawai');
        $this->load->model(array(
            "model_ab_pegawai"
        ));
    }

    public function index() {
        $this->set('keyword', '');
        $this->set('bulan', date('n'));
        $this->set('tahun', date('Y'));
        $this->set('records', $this->model_ab_pegawai->all());
    }

}
