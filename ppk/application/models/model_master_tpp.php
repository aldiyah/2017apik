<?php

defined("BASEPATH") OR exit("No direct script access allowed");
include_once "entity/master_tpp.php";

class Model_master_tpp extends Master_tpp {

    public function __construct() {
        parent::__construct();
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array(
                    "pegawai_nama"
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

//    public function get_like($keyword = FALSE) {
//        $result = FALSE;
//        if ($keyword) {
////            $this->db->order_by("aktifitas_nama", "asc");
////            $this->db->where(" lower(" . $this->table_name . ".aktifitas_kode) LIKE lower('%" . $keyword . "%') OR lower(" . $this->table_name . ".aktifitas_nama) LIKE lower('%" . $keyword . "%')", NULL, FALSE);
//            $this->db->where(" lower(" . $this->table_name . ".aktifitas_nama) LIKE lower('%" . $keyword . "%')", NULL, FALSE);
//            $result = $this->get_where();
//        }
//        return $result;
//    }
    public function get_aktivitas_bulanan($id_pegawai = FALSE, $bulan = 1, $tahun = 2017) {
        $this->db->select("sc_aktivitas.tr_aktifitas.tr_aktifitas_tanggal");
        $this->db->select_sum("sc_aktivitas.master_aktifitas.aktifitas_waktu");
        $this->db->select("sc_aktivitas.tr_aktifitas.tr_aktifitas_volume");
        $this->db->join("sc_master.master_pegawai", "sc_master.master_pegawai.pegawai_id = sc_aktivitas.tr_aktifitas.pegawai_id");
        $this->db->join("sc_aktivitas.master_aktifitas", "sc_aktivitas.master_aktifitas.aktifitas_id = sc_aktivitas.tr_aktifitas.aktifitas_id");
        $this->db->where("sc_aktivitas.tr_aktifitas.pegawai_id = ", $id_pegawai);
        $this->db->where("EXTRACT(MONTH FROM sc_aktivitas.tr_aktifitas.tr_aktifitas_tanggal) = ", $bulan);
        $this->db->where("EXTRACT(YEAR FROM sc_aktivitas.tr_aktifitas.tr_aktifitas_tanggal) = ", $tahun);
        $this->db->where("sc_aktivitas.tr_aktifitas.tr_aktifitas_status = 1");
        $this->db->group_by("sc_aktivitas.tr_aktifitas.tr_aktifitas_tanggal");
        $this->db->group_by("EXTRACT(MONTH FROM sc_aktivitas.tr_aktifitas.tr_aktifitas_tanggal)");
        $this->db->group_by("EXTRACT(YEAR FROM sc_aktivitas.tr_aktifitas.tr_aktifitas_tanggal)");
        $this->db->group_by("sc_aktivitas.tr_aktifitas.tr_aktifitas_volume");
        $this->db->order_by("sc_aktivitas.tr_aktifitas.tr_aktifitas_tanggal");
        $query = $this->db->get("sc_aktivitas.tr_aktifitas");
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }

    public function get_pinalty_absensi($pegawai_id, $tahun, $bulan) {
        $this->db->select_sum('(abs_pinalty_masuk + abs_pinalty_pulang)', 'pinalty');
        $this->db->where('pegawai_id', $pegawai_id);
        $this->db->where('EXTRACT(YEAR FROM abs_tanggal) = ' . $tahun);
        $this->db->where('EXTRACT(MONTH FROM abs_tanggal) = ' . $bulan);
        $query = $this->db->get("sc_presensi.tr_absensi");
        return $query->row(0)->pinalty;
    }

    public function get_all_skpb_by_id($pegawai_id, $tahun, $bulan) {
        $this->db->select("COUNT(sc_ppk.tr_skp_bulanan.skpb_id) jumlah");
        $this->db->select_sum("sc_ppk.tr_skp_bulanan.skpb_nilai", "nilai");
        $this->db->join("sc_ppk.tr_skp_tahunan", "sc_ppk.tr_skp_tahunan.skpt_id = sc_ppk.tr_skp_bulanan.skpt_id");
        $this->db->where("sc_ppk.tr_skp_tahunan.pegawai_id = " . $pegawai_id);
        $this->db->where("sc_ppk.tr_skp_tahunan.skpt_tahun = " . $tahun);
        $this->db->where("sc_ppk.tr_skp_tahunan.skpt_status > 1");
        $this->db->where("sc_ppk.tr_skp_bulanan.skpb_bulan = " . $bulan);
        $this->db->where("sc_ppk.tr_skp_bulanan.skpb_kuantitas > 0");
        $query = $this->db->get("sc_ppk.tr_skp_bulanan");
        return $query->num_rows() > 0 ? $query->row() : FALSE;
    }

    public function get_perilaku_by_id($pegawai_id, $tahun, $bulan) {
        $this->db->where("pegawai_id", $pegawai_id);
        $this->db->where("perilaku_tahun", $tahun);
        $this->db->where("perilaku_bulan", $bulan);
        $query = $this->db->get("sc_ppk.tr_perilaku");
        return $query->num_rows() > 0 ? $query->row(0) : FALSE;
    }

}
