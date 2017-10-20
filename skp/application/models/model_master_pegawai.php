<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include_once "entity/master_pegawai.php";

class Model_master_pegawai extends Master_pegawai {

    public function __construct() {
        parent::__construct();
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array("pegawai_nip", "pegawai_nama"), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_pegawai_by_id($id_pegawai) {
        $this->get_select_referenced_table();
        $data = $this->get_detail('pegawai_id = ' . $id_pegawai, '*');
        return $data;
    }

    public function get_all_bawahan_by_nip($all_nip_bawahan) {
        $conditions = $this->table_name . ".pegawai_nip in ('" . $all_nip_bawahan . "')";
        return $this->get_all(array("pegawai_nip", "pegawai_nama"), $conditions, TRUE);
    }

    public function get_all_perilaku_bawahan($all_nip_bawahan, $tahun = 0, $bulan = 0) {
        $keyword = $this->get_keyword();
        $this->db->select('p.pegawai_id,p.pegawai_nip,p.pegawai_nama');
        $this->db->select_avg('tp.pperilaku_nilai', 'tpn');
        $this->db->join('sc_skp.tr_perilaku tp', 'tp.pegawai_id = p.pegawai_id and tp.pperilaku_tahun = ' . $tahun . ' and tp.pperilaku_bulan = ' . $bulan, 'left');
        if ($keyword) {
            $this->db->where($this->get_keyword_where(array('pegawai_nama')));
        }
        $this->db->where("p.pegawai_nip in ('" . $all_nip_bawahan . "')");
        $this->db->group_by('p.pegawai_id');
        $query = $this->db->get('sc_skp.master_pegawai p');
//        print_r($this->db->last_query());
//        var_dump($query);
//        exit();
        return (object) array(
                    "record_set" => $query->result(),
                    "record_found" => $query->num_rows(),
                    "keyword" => $keyword
        );
    }

    public function get_like($keyword = FALSE) {
        $result = FALSE;
        if ($keyword) {
            $this->db->order_by("pegawai_nama", "asc");
            $this->db->where(" lower(" . $this->table_name . ".pegawai_nip) LIKE lower('%" . $keyword . "%') OR lower(" . $this->table_name . ".pegawai_nama) LIKE lower('%" . $keyword . "%')", NULL, FALSE);
            $result = $this->get_where();
        }
        return $result;
    }

}
