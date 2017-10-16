<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once "entity/tr_skp_tahunan.php";

class Model_tr_skp_tahunan extends Tr_skp_tahunan {

    public function __construct() {
        parent::__construct();
    }

    public function all($id_pegawai = FALSE, $tahun = FALSE, $force_limit = FALSE, $force_offset = FALSE) {
        $conditions = array(
            $this->table_name . ".pegawai_id = '" . $id_pegawai . "'",
            $this->table_name . ".skpt_tahun = '" . $tahun . "'"
        );
        return parent::get_all(array("skpt_kegiatan", "pegawai_nama"), $conditions, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_persetujuan($id_bawahan = array(), $tahun = FALSE, $force_limit = FALSE, $force_offset = FALSE) {
        $bawahan = implode(',', $id_bawahan);
        $conditions = array(
            $this->table_name . ".pegawai_id in (" . $bawahan . ")",
            $this->table_name . ".skpt_tahun = '" . $tahun . "'",
            $this->table_name . ".skpt_status = 1"
        );
        return parent::get_all(array("skpt_kegiatan"), $conditions, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_realisasi_tahunan($id_pegawai = FALSE, $tahun = FALSE, $force_limit = FALSE, $force_offset = FALSE) {
        $conditions = array(
            $this->table_name . ".pegawai_id = '" . $id_pegawai . "'",
            $this->table_name . ".skpt_tahun = '" . $tahun . "'"
        );
        $this->db->select_sum('skpb_kuantitas', 'kuantitas');
        $this->db->select_sum('skpb_biaya', 'biaya');
        $this->db->select_sum('skpb_real_kuantitas', 'real_kuantitas');
        $this->db->select_sum('skpb_real_biaya', 'real_biaya');
        $this->db->select_sum('skpb_kualitas', 'kualitas');
        $this->db->join($this->schema_name . '.tr_skp_bulanan', $this->schema_name . '.tr_skp_bulanan.skpt_id = ' . $this->table_name . '.skpt_id', 'left');
        $this->db->where($this->table_name . '.skpt_status >', 1);
        $this->db->group_by($this->table_name . '.skpt_id');
        $this->db->group_by($this->schema_name . '.master_pegawai.pegawai_id');
        return parent::get_all(array("skpt_kegiatan"), $conditions, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_realisasi($skpt_id = FALSE) {
        $this->db->select($this->table_name . '.*', FALSE);
        $this->db->select_sum('skpb_kuantitas', 'kuantitas');
        $this->db->select_sum('skpb_biaya', 'biaya');
        $this->db->select_sum('skpb_real_kuantitas', 'real_kuantitas');
        $this->db->select_sum('skpb_real_biaya', 'real_biaya');
        $this->db->select_sum('skpb_kualitas', 'kualitas');
        $this->db->join($this->schema_name . '.tr_skp_bulanan', $this->schema_name . '.tr_skp_bulanan.skpt_id = ' . $this->table_name . '.skpt_id', 'left');
        $this->db->where($this->table_name . '.skpt_id', $skpt_id);
//        $this->db->where($this->table_name . '.skpt_status >', 1);
        $this->db->where($this->table_name . '.record_active', 1);
        $this->db->group_by($this->table_name . '.skpt_id');
        $query = $this->db->get($this->table_name);
        return $query->num_rows() > 0 ? $query->row() : FALSE;
    }

    public function update_status($id = FALSE, $value = FALSE) {
        $this->db->set('skpt_status', $value);
        $this->db->where('skpt_id', $id);
        $this->db->update($this->table_name);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

}
