<?php

defined("BASEPATH") OR exit("No direct script access allowed");
include_once "entity/kelompok_aktifitas.php";

class model_kelompok_aktifitas extends kelompok_aktifitas {

    public function __construct() {
        parent::__construct();
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array(
                    "kelompok_nama", "kelompok_keterangan"
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_like($keyword = FALSE) {
        $result = FALSE;
        if ($keyword) {
            $this->db->where(" lower(" . $this->table_name . ".kelompok_nama) LIKE lower('%" . $keyword . "%') OR lower(" . $this->table_name . ".kelompok_keterangan) LIKE lower('%" . $keyword . "%')", NULL, FALSE);
            $result = $this->get_where();
        }
        return $result;
    }

}
