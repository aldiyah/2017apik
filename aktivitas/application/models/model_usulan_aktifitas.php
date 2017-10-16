<?php

defined("BASEPATH") OR exit("No direct script access allowed");
include_once "entity/usulan_aktifitas.php";

class model_usulan_aktifitas extends usulan_aktifitas {

    public function __construct() {
        parent::__construct();
    }

    public function all($id_pegawai = FALSE, $force_limit = FALSE, $force_offset = FALSE) {
        if ($id_pegawai) {
            $this->db->where($this->table_name . ".pegawai_id = '" . $id_pegawai . "'");
        } else {
            $this->db->where($this->table_name . ".usulan_status = 0");
        }
        return parent::get_all(array(
                    "usulan_nama"
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_like($keyword = FALSE) {
        $result = FALSE;
        if ($keyword) {
//            $this->db->order_by("usulan_nama", "asc");
            $this->db->where(" lower(" . $this->table_name . ".usulan_nama) LIKE lower('%" . $keyword . "%')", NULL, FALSE);
            $result = $this->get_where();
        }
        return $result;
    }

}
