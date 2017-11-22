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

    public $sort_by = 'perilaku_id';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct("tr_perilaku");
        $this->primary_key = "perilaku_id";
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(
        "perilaku_id" => array("perilaku_id", "ID Penilaian Perilaku"),
        "pegawai_id" => array("pegawai_id", "ID Pegawai"),
        "perilaku_bulan" => array("perilaku_bulan", "Bulan Penilaian Perilaku"),
        "perilaku_tahun" => array("perilaku_tahun", "Tahun Penilaian Perilaku"),
        "perilaku_pelayanan" => array("perilaku_pelayanan", "Perilaku Orientasi Pelayanan"),
        "perilaku_integritas" => array("perilaku_integritas", "Perilaku Integritas"),
        "perilaku_komitmen" => array("perilaku_komitmen", "Perilaku Komitmen"),
        "perilaku_disiplin" => array("perilaku_disiplin", "Perilaku Disiplin"),
        "perilaku_kerjasama" => array("perilaku_kerjasama", "Perilaku Kerjasama"),
        "perilaku_kepemimpinan" => array("perilaku_kepemimpinan", "Perilaku Kepemimpinan")
    );
    protected $rules = array(
        array("perilaku_id", "integer"),
        array("pegawai_id", "integer"),
        array("perilaku_bulan", "number"),
        array("perilaku_tahun", "number"),
        array("perilaku_pelayanan", "number"),
        array("perilaku_integritas", "number"),
        array("perilaku_komitmen", "number"),
        array("perilaku_disiplin", "number"),
        array("perilaku_kerjasama", "number"),
        array("perilaku_kepemimpinan", "number")
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
