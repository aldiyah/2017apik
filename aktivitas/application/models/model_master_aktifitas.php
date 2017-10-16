<?php

defined("BASEPATH") OR exit("No direct script access allowed");
include_once "entity/master_aktifitas.php";

class model_master_aktifitas extends Master_aktifitas {

    public function __construct() {
        parent::__construct();
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array(
                    "aktifitas_nama"
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_like($keyword = FALSE) {
        $result = FALSE;
        if ($keyword) {
//            $this->db->order_by("aktifitas_nama", "asc");
//            $this->db->where(" lower(" . $this->table_name . ".aktifitas_kode) LIKE lower('%" . $keyword . "%') OR lower(" . $this->table_name . ".aktifitas_nama) LIKE lower('%" . $keyword . "%')", NULL, FALSE);
            $this->db->where(" lower(" . $this->table_name . ".aktifitas_nama) LIKE lower('%" . $keyword . "%')", NULL, FALSE);
            $result = $this->get_where();
        }
        return $result;
    }
}
