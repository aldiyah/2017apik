<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * model_master_perilaku.php
 * Oct 19, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

include_once "entity/master_perilaku.php";

class Model_master_perilaku extends Master_perilaku {

    public function __construct() {
        parent::__construct();
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array(
                    "perilaku_nama"
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_like($keyword = FALSE) {
        $result = FALSE;
        if ($keyword) {
            $this->db->order_by("perilaku_nama", "asc");
            $this->db->where(" lower(" . $this->table_name . ".perilaku_nama) LIKE lower('%" . $keyword . "%')", NULL, FALSE);
            $result = $this->get_where();
        }
        return $result;
    }

}
