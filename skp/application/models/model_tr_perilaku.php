<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * model_tr_perilaku.php
 * Oct 20, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

include_once "entity/tr_perilaku.php";

class Model_tr_perilaku extends Tr_perilaku {

    public function __construct() {
        parent::__construct();
    }

    public function all($id_pegawai = FALSE, $tahun = FALSE, $bulan = FALSE, $force_limit = FALSE, $force_offset = FALSE) {
        $conditions = array(
            "sc_skp.tr_perilaku.pegawai_id = '" . $id_pegawai . "'",
            "sc_skp.tr_perilaku.pperilaku_tahun = '" . $tahun . "'",
            "sc_skp.tr_perilaku.pperilaku_bulan = '" . $bulan . "'"
        );
        $this->db->order_by('sc_skp.tr_perilaku.pperilaku_tahun', 'asc');
        $this->db->order_by('sc_skp.tr_perilaku.pperilaku_bulan', 'asc');
        return parent::get_all(array("pperilaku_id"), $conditions, TRUE, TRUE, 1, TRUE, $force_limit, $force_offset);
    }

//    public function get_data_setahun($skpt_id, $full = FALSE) {
//        $this->db->where('skpt_id', $skpt_id);
//        $this->db->order_by('skpb_bulan');
//        $query = $this->db->get($this->table_name);
//        if ($full) {
//            return $query->num_rows() > 0 ? $query->result() : FALSE;
//        } else {
//            $result = array();
//            if ($query->num_rows() > 0) {
//                foreach ($query->result() as $row) {
//                    $result[$row->skpb_bulan] = array(
//                        'kuantitas' => $row->skpb_kuantitas,
//                        'biaya' => $row->skpb_biaya
//                    );
//                }
//                return $result;
//            }
//            return FALSE;
//        }
//    }

    public function save_data($data_nilai = FALSE) {
        $this->db->trans_start();
        $this->db->insert_batch($this->table_name, $data_nilai);
        return $this->db->trans_complete();
    }

//    protected function before_data_update($data = FALSE) {
//        if ($data['skpb_kualitas'] > 0) {
//            $data['skpb_status'] = 2;
//        }
//        return $data;
//    }
}
