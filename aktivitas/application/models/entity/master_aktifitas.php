<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class master_aktifitas extends MY_Model {

    public $sort_by = 'aktifitas_nama';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct("master_aktifitas");
        $this->primary_key = "aktifitas_id";
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(
        "aktifitas_id" => array("aktifitas_id", "ID Aktifitas"),
        "kelompok_id" => array("kelompok_id", "ID Kelompok"),
        "dinas_id" => array("dinas_id", "ID Dinas"),
        "aktifitas_kode" => array("aktifitas_kode", "Kode Aktifitas"),
        "aktifitas_nama" => array("aktifitas_nama", "Nama Aktifitas"),
        "aktifitas_output" => array("aktifitas_output", "Satuan Output"),
        "aktifitas_waktu" => array("aktifitas_waktu", "Lama Waktu"),
        "aktifitas_status" => array("aktifitas_status", "Status Aktifitas")
    );
    protected $rules = array(
//        array("kelompok_id", "required|is_natural_no_zero"),
//        array("dinas_id", "required|is_natural_no_zero"),
//        array("aktifitas_kode", "required|min_length[3]|max_length[20]"),
        array("aktifitas_nama", "required|min_length[3]|max_length[200]"),
        array("aktifitas_output", "required|min_length[3]|max_length[50]"),
        array("aktifitas_waktu", "required|numeric"),
        array("aktifitas_status", "numeric")
    );
    protected $related_tables = array(
//        "kelompok_aktifitas" => array(
//            "fkey" => "kelompok_id",
//            "columns" => array(
//                "kelompok_nama",
//                "kelompok_keterangan"
//            ),
//            "referenced" => "LEFT"
//        )
    );
    protected $attribute_types = array();

}
