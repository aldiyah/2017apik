<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * model_ab_pegawai.php
 * Nov 12, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_ab_pegawai extends Adms_model {

    public function __construct() {
        parent::__construct();
    }

    public function all() {
        $this->dbo->limit(10);
        $query = $this->dbo->get('userinfo');
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }

}
