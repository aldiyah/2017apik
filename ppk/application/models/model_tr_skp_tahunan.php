<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once "entity/tr_skp_tahunan.php";

class Model_tr_skp_tahunan extends Tr_skp_tahunan {

    public function __construct() {
        parent::__construct();
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array("skpt_kegiatan", "pegawai_nama"), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function all_skp_plan($pegawai_id = FALSE, $tahun = FALSE, $force_limit = FALSE, $force_offset = FALSE) {
        $conditions = array(
            $this->table_name . ".pegawai_id = '" . $pegawai_id . "'",
            $this->table_name . ".skpt_tahun = '" . $tahun . "'",
//            $this->table_name . ".skpt_status < 2"
        );
        return parent::get_all(array("skpt_kegiatan"), $conditions, TRUE, TRUE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_persetujuan($id_bawahan = array(), $tahun = FALSE, $force_limit = FALSE, $force_offset = FALSE) {
        $conditions[] = $this->table_name . ".skpt_status > 0";
        if ($id_bawahan) {
            $bawahan = implode(',', $id_bawahan);
            $conditions[] = $this->table_name . ".pegawai_id in (" . $bawahan . ")";
        } else {
            $conditions[] = $this->table_name . ".pegawai_id = 0";
        }
        if ($tahun) {
            $conditions[] = $this->table_name . ".skpt_tahun = '" . $tahun . "'";
        }
        return parent::get_all(array("skpt_kegiatan"), $conditions, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_realisasi_tahunan($id_pegawai = FALSE, $tahun = FALSE, $force_limit = FALSE, $force_offset = FALSE) {
        $this->db->select("skpt.skpt_id,skpt.skpt_kegiatan,skpt.skpt_kuantitas,skpt.skpt_output,skpt.skpt_waktu,skpt.skpt_biaya,skpt.skpt_status,skpt.skpt_kualitas,count(skpb.skpb_id) jml");
        $this->db->select_sum("skpb_real_kuantitas", "real_kuantitas");
        $this->db->select_sum("skpb_real_biaya", "real_biaya");
        $this->db->select_sum("skpb_real_kualitas", "real_kualitas");
        $this->db->select_sum("skpb_hitung", "real_hitung");
        $this->db->select_sum("skpb_nilai", "real_nilai");
        $this->db->from($this->table_name . " skpt");
        $this->db->join("sc_ppk.tr_skp_bulanan skpb", "skpb.skpt_id = skpt.skpt_id and skpb.skpb_kuantitas > 0", "left");
        $this->db->join("sc_master.master_pegawai p", "p.pegawai_id = skpt.pegawai_id", "left");
        $this->db->where("skpt.pegawai_id", $id_pegawai);
        $this->db->where("skpt.skpt_tahun", $tahun);
        $this->db->where("skpt.skpt_status in (2,3,4)");
        $this->db->group_by('skpt.skpt_id');
        $this->db->group_by('p.pegawai_id');
        $query = $this->db->get();
//        print_r($this->db->last_query());
//        var_dump($query);
//        exit();
        return (object) array(
                    "record_set" => $query->num_rows() > 0 ? $query->result() : FALSE,
                    "record_found" => $query->num_rows(),
                    "keyword" => $this->get_keyword()
        );
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
