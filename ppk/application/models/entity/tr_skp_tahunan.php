<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tr_skp_tahunan extends MY_Model {

    public $sort_by = 'skpt_id';
    public $sort_mode = 'asc';
    public $master_schema = "sc_master";

    public function __construct() {
        parent::__construct("tr_skp_tahunan");
        $this->primary_key = "skpt_id";
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(
        "skpt_id" => array("skpt_id", "ID SKP Tahunan"),
        "pegawai_id" => array("pegawai_id", "ID Pegawai"),
        "skpt_kegiatan" => array("skpt_kegiatan", "Nama Kegiatan"),
        "skpt_tahun" => array("skpt_tahun", "Periode Tahun"),
        "skpt_waktu" => array("skpt_waktu", "Lama Kegiatan"),
        "skpt_kuantitas" => array("skpt_kuantitas", "Kuantitas Output"),
        "skpt_output" => array("skpt_output", "Jenis Output"),
        "skpt_kualitas" => array("skpt_kualitas", "Kualitas Output"),
        "skpt_kredit" => array("skpt_kredit", "Kredit Kegiatan"),
        "skpt_biaya" => array("skpt_biaya", "Biaya Kegiatan"),
        "skpt_status" => array("skpt_status", "Status Kegiatan")
    );
    protected $rules = array(
        array("pegawai_id", "required|integer"),
        array("skpt_kegiatan", "required|min[10]|max[200]"),
        array("skpt_tahun", "required|integer"),
        array("skpt_waktu", "required|integer"),
        array("skpt_kuantitas", "required|integer"),
        array("skpt_output", "required|integer"),
        array("skpt_kualitas", "required|integer"),
        array("skpt_kredit", "integer"),
        array("skpt_biaya", "required|integer"),
        array("skpt_status", "integer")
    );
    protected $related_tables = array(
        "sc_master.master_pegawai" => array(
            "fkey" => "pegawai_id",
            "columns" => array(
                "pegawai_nama",
                "pegawai_nip"
            ),
            "referenced" => "LEFT"
        )
    );
    protected $attribute_types = array();

}
