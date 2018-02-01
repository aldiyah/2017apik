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
        $this->db->select("ta.abs_id,ta.pegawai_id,ta.abs_tanggal,"
                . "tu.upacara_id,tu.upacara_hadir,tu.upacara_status,tu.upacara_lapor,tu.upacara_approval_al,tu.upacara_approval_aa,tu.upacara_pinalty,"
                . "ta.abs_masuk,ta.abs_masuk_status,ta.abs_masuk_lapor,tm.lm_lapor,tm.lm_approval_al,tm.lm_approval_aa,"
                . "ta.abs_pulang,ta.abs_pulang_status,ta.abs_pulang_lapor,tp.lp_lapor,tp.lp_approval_al,tp.lp_approval_aa,"
                . "ta.abs_status,ta.abs_lapor,tl.la_lapor,tl.la_approval_al,tl.la_approval_aa,"
                . "ta.abs_pinalty_masuk,ta.abs_pinalty_pulang,ta.abs_pinalty_absensi");
        $this->db->from($this->table_name . " as ta");
        $this->db->join("sc_master.master_pegawai as mp", "mp.pegawai_id = ta.pegawai_id", "left");
        $this->db->join("sc_presensi.master_upacara as mu", "mu.upacara_tanggal = ta.abs_tanggal", "left");
        $this->db->join("sc_presensi.tr_upacara as tu", "tu.upacara_tanggal = mu.upacara_tanggal", "left");
        $this->db->join("sc_presensi.tr_lapor_masuk as tm", "tm.abs_id = ta.abs_id", "left");
        $this->db->join("sc_presensi.tr_lapor_pulang as tp", "tp.abs_id = ta.abs_id", "left");
        $this->db->join("sc_presensi.tr_lapor_absensi as tl", "tl.abs_id = ta.abs_id", "left");
        if ($pegawai_id) {
            $this->db->where("ta.pegawai_id", $pegawai_id);
        }
        if ($tahun) {
            $this->db->where("EXTRACT(YEAR FROM ta.abs_tanggal) = '" . $tahun . "'");
        }
        if ($bulan) {
            $this->db->where("EXTRACT(MONTH FROM ta.abs_tanggal) = '" . $bulan . "'");
        }
        $this->db->where("ta.record_active = 1");
        $this->db->order_by('ta.abs_tanggal', 'asc');
        $query = $this->db->get();
        return $query->num_rows() > 0 ? $query->result() : FALSE;


//        $conditions = array();
//        if ($pegawai_id) {
//            $conditions[] = $this->table_name . ".pegawai_id = '" . $pegawai_id . "'";
//        }
//        if ($tahun) {
//            $conditions[] = "EXTRACT(YEAR FROM " . $this->table_name . ".abs_tanggal) = '" . $tahun . "'";
//        }
//        if ($bulan) {
//            $conditions[] = "EXTRACT(MONTH FROM " . $this->table_name . ".abs_tanggal) = '" . $bulan . "'";
//        }
//        return parent::get_all(NULL, $conditions, TRUE, TRUE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_pinalty($pegawai_id, $tahun, $bulan) {
        $this->db->select_sum('(abs_pinalty_masuk + abs_pinalty_pulang)', 'pinalty');
        $this->db->where('pegawai_id', $pegawai_id);
        $this->db->where('EXTRACT(YEAR FROM abs_tanggal) = ' . $tahun);
        $this->db->where('EXTRACT(MONTH FROM abs_tanggal) = ' . $bulan);
        $query = $this->db->get($this->table_name);
        return $query->num_rows() > 0 ? $query->row(0)->pinalty : 0;
    }

    public function get_validasi($bawahan = array(), $tahun = FALSE) {
        $conditions = array(
            "sc_master.master_pegawai.pegawai_nip in ('" . $bawahan . "')",
            "EXTRACT(YEAR FROM " . $this->table_name . ".abs_tanggal) = '" . $tahun . "'",
            "(" . $this->table_name . ".abs_masuk_lapor > 0 OR " . $this->table_name . ".abs_pulang_lapor > 0 OR " . $this->table_name . ".abs_lapor > 0)"
        );
        return parent::get_all(array('pegawai_nama'), $conditions, TRUE, TRUE, 1, TRUE);
    }

//    public function get_last_day($pegawai_id) {
//        $this->db->select_max("abs_tanggal", "maxtgl");
//        $this->db->where("pegawai_id", $pegawai_id);
//        $query = $this->db->get($this->table_name);
//        return $query->row(0)->maxtgl;
//    }
//
    public function get_last_data($pegawai_id = FALSE) {
        $this->db->select_max("abs_tanggal", "maxtgl");
        $this->db->select_max("abs_masuk", "maxmasuk");
        $this->db->select_max("abs_pulang", "maxpulang");
        if ($pegawai_id) {
            $this->db->where("pegawai_id", $pegawai_id);
        }
        $query = $this->db->get($this->table_name);
        return $query->row(0);
    }

    public function transfer_absensi($new_absensi) {
        $this->db->insert_batch($this->table_name, $new_absensi);
    }

    public function update_absensi($old_absensi) {
        if ($old_absensi) {
            foreach ($old_absensi as $value) {
                $this->db->set('abs_masuk', $old_absensi['abs_masuk']);
                $this->db->set('abs_pulang', $old_absensi['abs_pulang']);
                $this->db->where('pegawai_id', $old_absensi['pegawai_id']);
                $this->db->where('abs_tanggal', $old_absensi['abs_tanggal']);
                $this->db->update($this->table_name);
            }
        }
    }

}
