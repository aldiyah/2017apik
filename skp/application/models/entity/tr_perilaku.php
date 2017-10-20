<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * tr_perilaku.php
 * Oct 20, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Tr_perilaku extends MY_Model {

    public $sort_by = 'pperilaku_id';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct("tr_perilaku");
        $this->primary_key = "pperilaku_id";
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(
        "pperilaku_id" => array("pperilaku_id", "ID Penilaian Perilaku"),
        "pegawai_id" => array("pegawai_id", "ID Pegawai"),
        "pperilaku_bulan" => array("pperilaku_bulan", "Bulan Penilaian Perilaku"),
        "pperilaku_tahun" => array("pperilaku_tahun", "Tahun Penilaian Perilaku"),
        "perilaku_id" => array("perilaku_id", "ID Perilaku"),
        "pperilaku_nilai" => array("pperilaku_nilai", "Nilai Perilaku")
    );
    protected $rules = array(
        array("pperilaku_id", "integer"),
        array("pegawai_id", "integer"),
        array("pperilaku_bulan", "number"),
        array("pperilaku_tahun", "number"),
        array("perilaku_id", "integer"),
        array("pperilaku_nilai", "number")
    );
    protected $related_tables = array(
        "master_pegawai" => array(
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
