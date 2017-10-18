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

include_once "entity/jenis_absensi.php";

class Model_jenis_absensi extends Jenis_absensi {

    function __construct() {
        parent::__construct();
    }

    public function all($conditions = FALSE, $force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array(
                    "absensi_nama"
                        ), $conditions, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_like($keyword = FALSE) {
        $result = FALSE;
        if ($keyword) {
            $this->db->order_by("absensi_nama", "asc");
            $this->db->where(" lower(" . $this->table_name . ".absensi_nama) LIKE lower('%" . $keyword . "%')", NULL, FALSE);
            $result = $this->get_where();
        }
        return $result;
    }

}
