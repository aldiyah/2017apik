<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * vabsensi.php
 * Nov 15, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Vabsensi extends Back_end {

    protected $auto_load_model = FALSE;

    public function __construct() {
        parent::__construct('validasi_bawahan', 'Validasi Bawahan');
    }

    public function index() {
        parent::index();
    }

}
