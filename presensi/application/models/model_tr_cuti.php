<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * model_tr_cuti.php
 * Oct 21, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

include_once "entity/tr_cuti.php";

class Model_tr_cuti extends Tr_cuti {

    function __construct() {
        parent::__construct();
    }

    public function all($pegawai_id = FALSE, $tahun = FALSE, $bulan = FALSE, $force_limit = FALSE, $force_offset = FALSE) {
        $conditions = array();
        if ($pegawai_id) {
            $conditions[] = $this->table_name . ".pegawai_id = '" . $pegawai_id . "'";
        }
        if ($tahun) {
            $conditions[] = "EXTRACT(YEAR FROM " . $this->table_name . ".cuti_tanggal) = '" . $tahun . "'";
        }
        if ($bulan) {
            $conditions[] = "EXTRACT(MONTH FROM " . $this->table_name . ".cuti_tanggal) = '" . $bulan . "'";
        }
        return parent::get_all(array('cuti_keterangan'), $conditions, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_validasi($bawahan = array(), $tahun = FALSE) {
        $conditions = array(
            "sc_master.master_pegawai.pegawai_nip in ('" . $bawahan . "')",
            "EXTRACT(YEAR FROM " . $this->table_name . ".cuti_tanggal) = '" . $tahun . "'",
            $this->table_name . ".cuti_status = 1",
        );
        return parent::get_all(array('pegawai_nama'), $conditions, TRUE, TRUE, 1, TRUE);
    }

    public function update_status($id, $status) {
        $this->db->set('cuti_status', $status);
        $this->db->set('cuti_approval_by', $user_detail['pegawai_id']);
        $this->db->where('cuti_id', $id);
        $this->db->update($this->table_name);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

}
