<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * model_tr_lapor_absensi.php
 * Dec 28, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

include_once "entity/tr_lapor_absensi.php";

class Model_tr_lapor_absensi extends Tr_lapor_absensi {

    function __construct() {
        parent::__construct();
    }

    public function get_validasi_bawahan($id = 0) {
        $conditions = array(
//            "sc_master.master_pegawai.pegawai_nip in ('" . $bawahan . "')",
//            "EXTRACT(YEAR FROM " . $this->table_name . ".abs_tanggal) = '" . $tahun . "'",
            "((" . $this->table_name . ".la_approval_al = " . $id . " AND " . $this->table_name . ".la_approval_by_al = 0 AND " . $this->table_name . ".la_approval_by_aa = 0 ) OR "
            . "(" . $this->table_name . ".la_approval_aa = " . $id . " AND " . $this->table_name . ".la_approval_by_aa = 0 AND " . $this->table_name . ".la_approval_by_al = 0))"
        );
        return parent::get_all(array(), $conditions, TRUE, TRUE, 1, TRUE);
    }

}
