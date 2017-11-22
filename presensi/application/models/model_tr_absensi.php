<?php

/**
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * model_tr_absensi.php
 * Oct 18, 2017
 */
defined('BASEPATH') OR exit('No direct script access allowed');

include_once "entity/tr_absensi.php";

class Model_tr_absensi extends Tr_absensi {

    function __construct() {
        parent::__construct();
    }

    public function all($pegawai_id = FALSE, $tahun = FALSE, $bulan = FALSE, $force_limit = FALSE, $force_offset = FALSE) {
        $conditions = array();
        if ($pegawai_id) {
            $conditions[] = $this->table_name . ".pegawai_id = '" . $pegawai_id . "'";
        }
        if ($tahun) {
            $conditions[] = "EXTRACT(YEAR FROM " . $this->table_name . ".abs_tanggal) = '" . $tahun . "'";
        }
        if ($bulan) {
            $conditions[] = "EXTRACT(MONTH FROM " . $this->table_name . ".abs_tanggal) = '" . $bulan . "'";
        }
        return parent::get_all(NULL, $conditions, TRUE, TRUE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_pinalty($pegawai_id, $tahun, $bulan) {
        $this->db->select_sum('(abs_pinalty_masuk + abs_pinalty_pulang)', 'pinalty');
        $this->db->where('pegawai_id', $pegawai_id);
        $this->db->where('EXTRACT(YEAR FROM abs_tanggal) = ' . $tahun);
        $this->db->where('EXTRACT(MONTH FROM abs_tanggal) = ' . $bulan);
        $query = $this->db->get($this->table_name);
        return $query->num_rows() > 0 ? $query->row(0)->pinalty : 0;
    }

    public function get_last_day($pegawai_id) {
        $this->db->select_max("abs_tanggal", "maxtgl");
        $this->db->where("pegawai_id", $pegawai_id);
        $query = $this->db->get($this->table_name);
        return $query->row(0)->maxtgl;
    }

    public function transfer_absensi($new_absensi) {
        $this->db->insert_batch($this->table_name, $new_absensi);
    }

}
