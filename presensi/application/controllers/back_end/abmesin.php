<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * abmesin.php
 * Nov 12, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Abmesin extends Back_end {

    protected $auto_load_model = FALSE;

    public function __construct() {
        parent::__construct('adms_mesin', 'Daftar Mesin');
        $this->load->model(array(
            "model_ab_mesin"
        ));
    }

    public function index() {
        $this->set('keyword', '');
        $this->set('bulan', date('n'));
        $this->set('tahun', date('Y'));
        $this->set('records', $this->model_ab_mesin->all());
    }

}
