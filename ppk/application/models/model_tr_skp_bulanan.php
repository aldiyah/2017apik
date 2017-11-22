<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include_once "entity/tr_skp_bulanan.php";

class Model_tr_skp_bulanan extends Tr_skp_bulanan {

    public function __construct() {
        parent::__construct();
    }

    public function all($id_pegawai = FALSE, $tahun = FALSE, $bulan = FALSE, $force_limit = FALSE, $force_offset = FALSE) {
        $conditions = array(
            "sc_ppk.tr_skp_tahunan.pegawai_id = '" . $id_pegawai . "'",
            "sc_ppk.tr_skp_tahunan.skpt_tahun = '" . $tahun . "'",
            "sc_ppk.tr_skp_bulanan.skpb_bulan = '" . $bulan . "'",
            "sc_ppk.tr_skp_bulanan.skpb_kuantitas > 0"
        );
        $this->db->order_by('sc_ppk.tr_skp_tahunan.skpt_tahun', 'asc');
        $this->db->order_by('sc_ppk.tr_skp_bulanan.skpb_bulan', 'asc');
        return parent::get_all(array("skpt_id"), $conditions, TRUE, TRUE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_data_setahun($skpt_id, $full = FALSE) {
        $this->db->where('skpt_id', $skpt_id);
        $this->db->order_by('skpb_bulan');
        $query = $this->db->get($this->table_name);
        if ($full) {
            return $query->num_rows() > 0 ? $query->result() : FALSE;
        } else {
            $result = array();
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $result[$row->skpb_bulan] = array(
                        'kuantitas' => $row->skpb_kuantitas,
                        'biaya' => $row->skpb_biaya
                    );
                }
                return $result;
            }
            return FALSE;
        }
    }

    public function get_all_skpb_by_id($pegawai_id, $tahun, $bulan) {
        $conditions = array(
            'sc_ppk.tr_skp_tahunan.pegawai_id = ' . $pegawai_id,
            'sc_ppk.tr_skp_tahunan.skpt_tahun = ' . $tahun,
            'sc_ppk.tr_skp_tahunan.skpt_status > 1',
            $this->table_name . '.skpb_bulan = ' . $bulan,
            $this->table_name . '.skpb_kuantitas > 0'
        );
        return $this->get_all(FALSE, $conditions, TRUE, TRUE);
    }

    public function get_realisasi($id = FALSE) {
        return $this->get_detail('skpb_id = ' . $id, '*');
    }

    public function save_data($old_data = FALSE, $data_skpb = FALSE) {
        foreach ($data_skpb as $row) {
            if ($old_data) {
                $this->db->update($this->table_name, $row, 'skpt_id = ' . $row['skpt_id'] . ' AND skpb_bulan = ' . $row['skpb_bulan']);
            } else {
                $this->db->insert($this->table_name, $row);
            }
        }
    }

    public function update_status($id = FALSE, $value = FALSE) {
        $this->db->set('skpb_status', $value);
        $this->db->where('skpb_id', $id);
        $this->db->update($this->table_name);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    public function get_persetujuan($id_bawahan = array(), $tahun = FALSE, $force_limit = FALSE, $force_offset = FALSE) {
        $conditions = array(
            "sc_ppk.tr_skp_tahunan.skpt_status = 2",
            "sc_ppk.tr_skp_tahunan.skpt_tahun = " . $tahun,
            "sc_ppk.tr_skp_bulanan.skpb_status = 1"
        );
        if ($id_bawahan) {
            $bawahan = implode(',', $id_bawahan);
            $conditions[] = "sc_ppk.tr_skp_tahunan.pegawai_id in (" . $bawahan . ")";
        } else {
            $conditions[] = "sc_ppk.tr_skp_tahunan.pegawai_id = 0";
        }
        $bawahan = implode(',', $id_bawahan);
        return parent::get_all(array("skpt_kegiatan"), $conditions, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    protected function before_data_update($data = FALSE) {
        if ($data['skpb_real_kualitas'] > 0) {
            $data['skpb_status'] = 2;
        }
        return $data;
    }

}
