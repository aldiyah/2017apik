<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Usulan_aktifitas extends MY_Model {

    public $sort_by = "usulan_nama";
    public $sort_mode = "asc";

    public function __construct() {
        parent::__construct("usulan_aktifitas", "sc_aktivitas");
        $this->primary_key = "usulan_id";
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(
        "usulan_id" => array("usulan_id", "ID Usulan"),
        "kelompok_id" => array("kelompok_id", "ID Kelompok"),
        "dinas_id" => array("dinas_id", "ID Dinas"),
        "usulan_nama" => array("usulan_nama", "Nama Aktifitas"),
        "usulan_output" => array("usulan_output", "Satuan Output"),
        "usulan_waktu" => array("usulan_waktu", "Lama Waktu"),
        "usulan_status" => array("usulan_status", "Status Usulan"),
        "pegawai_id" => array("pegawai_id", "Pegawai ID")
    );
    protected $rules = array(
//        array("kelompok_id", "required|is_natural_no_zero"),
//        array("dinas_id", "required|is_natural_no_zero"),
        array("usulan_nama", "required|min_length[3]|max_length[200]"),
        array("usulan_output", "required|min_length[3]|max_length[50]"),
        array("usulan_waktu", "required|numeric")
    );
    protected $related_tables = array(
//        "kelompok_aktifitas" => array(
//            "fkey" => "kelompok_id",
//            "columns" => array(
//                "kelompok_nama",
//                "kelompok_keterangan"
//            ),
//            "referenced" => "LEFT"
//        ),
        "sc_master.master_pegawai" => array(
            "fkey" => "pegawai_id",
            "columns" => array(
                "pegawai_nip",
                "pegawai_nama"
            ),
            "referenced" => "LEFT"
        )
    );
    protected $attribute_types = array();

}
