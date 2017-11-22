<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * model_master_upacara.php
 * Oct 22, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'entity/master_upacara.php';

class Model_master_upacara extends Master_upacara {

    public function __construct() {
        parent::__construct();
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array(
                    "upacara_keterangan"
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_like($keyword = FALSE) {
        $result = FALSE;
        if ($keyword) {
            $this->db->order_by("upacara_tanggal", "asc");
            $this->db->where(" lower(" . $this->table_name . ".upacara_keterangan) LIKE lower('%" . $keyword . "%')", NULL, FALSE);
            $result = $this->get_where();
        }
        return $result;
    }

}
