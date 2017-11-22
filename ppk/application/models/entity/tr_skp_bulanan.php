<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tr_skp_bulanan extends MY_Model {

    public $sort_by = 'skpb_id';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct("tr_skp_bulanan");
        $this->primary_key = "skpb_id";
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(
        "skpb_id" => array("skpb_id", "ID SKP Bulanan"),
        "skpt_id" => array("skpt_id", "ID SKP Tahunan"),
        "skpb_bulan" => array("skpb_bulan", "SKPB Bulan"),
        "skpb_kuantitas" => array("skpb_kuantitas", "Kuantitas SKPB"),
        "skpb_biaya" => array("skpb_biaya", "Biaya SKPB"),
        "skpb_kualitas" => array("skpb_kualitas", "Kualitas SKPB"),
        "skpb_real_kuantitas" => array("skpb_real_kuantitas", "Kuantitas Realisasi SKPB"),
        "skpb_real_biaya" => array("skpb_real_biaya", "Biaya Realisasi SKPB"),
        "skpb_real_kualitas" => array("skpb_real_kualitas", "Kualitas Realisasi SKPB"),
        "skpb_status" => array("skpb_status", "Status SKPB"),
        "skpb_nilai" => array("skpb_nilai", "Nilai SKPB"),
        "skpb_hitung" => array("skpb_hitung", "Hitung SKPB")
    );
    protected $rules = array(
        array("skpb_id", "integer"),
        array("skpt_id", "integer"),
        array("skpb_bulan", "integer"),
        array("skpb_kuantitas", "integer"),
        array("skpb_biaya", "number"),
        array("skpb_kualitas", "number|min[0]|max[100]"),
        array("skpb_real_kuantitas", "integer"),
        array("skpb_real_biaya", "number"),
        array("skpb_real_kualitas", "number|min[0]|max[100]"),
        array("skpb_status", "integer"),
        array("skpb_nilai", "number"),
        array("skpb_hitung", "number")
    );
    protected $related_tables = array(
        "tr_skp_tahunan" => array(
            "fkey" => "skpt_id",
            "columns" => array(
                "skpt_tahun",
                "skpt_kegiatan",
                "skpt_output"
            ),
            "referenced" => "LEFT"
        ),
        "sc_master.master_pegawai" => array(
            "fkey" => "pegawai_id",
            "reference_to" => "tr_skp_tahunan",
            "columns" => array(
                "pegawai_nama",
                "pegawai_nip"
            ),
            "referenced" => "LEFT"
        )
    );
    protected $attribute_types = array();

}
