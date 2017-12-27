<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * model_master_liburan.php
 * October 21, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

include_once "entity/master_liburan.php";

class Model_master_liburan extends Master_liburan {

    public function __construct() {
        parent::__construct();
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array(
                    "libur_keterangan"
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_like($keyword = FALSE) {
        $result = FALSE;
        if ($keyword) {
            $this->db->order_by("libur_tanggal", "asc");
            $this->db->where(" lower(" . $this->table_name . ".libur_keterangan) LIKE lower('%" . $keyword . "%')", NULL, FALSE);
            $result = $this->get_where();
        }
        return $result;
    }

    public function get_bulanan($tahun = FALSE, $bulan = FALSE) {
        $this->db->select("libur_tanggal");
        if ($tahun) {
            $this->db->where("EXTRACT(YEAR FROM " . $this->table_name . ".libur_tanggal) = '" . $tahun . "'");
        }
        if ($bulan) {
            $this->db->where("EXTRACT(MONTH FROM " . $this->table_name . ".libur_tanggal) = '" . $bulan . "'");
        }
        $query = $this->db->get($this->table_name);
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }

    protected function before_data_insert($data = FALSE) {
        parent::before_data_insert($data);
    }

}
