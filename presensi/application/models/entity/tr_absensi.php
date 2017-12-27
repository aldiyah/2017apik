<?php

/**
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * tr_absensi.php
 * Oct 18, 2017
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Tr_absensi extends MY_Model {

    public $sort_by = 'abs_tanggal';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct('tr_absensi');
        $this->primary_key = 'abs_id';
    }

    protected $attribute_labels = array(
        "abs_id" => array("abs_id", ""),
        "pegawai_id" => array("pegawai_id", ""),
        "abs_tanggal" => array("abs_tanggal", ""),
        "abs_masuk" => array("abs_masuk", ""),
        "abs_pulang" => array("abs_pulang", ""),
        "abs_mesin" => array("abs_mesin", ""),
        "abs_masuk_status" => array("abs_masuk_status", ""),
        "abs_pulang_status" => array("abs_pulang_status", ""),
        "abs_status" => array("abs_status", ""),
        "abs_masuk_lapor" => array("abs_masuk_lapor", ""),
        "abs_pulang_lapor" => array("abs_pulang_lapor", ""),
        "abs_lapor" => array("abs_lapor", ""),
        "abs_pinalty_masuk" => array("abs_pinalty_masuk", ""),
        "abs_pinalty_pulang" => array("abs_pinalty_pulang", ""),
        "abs_pinalty_absensi" => array("abs_pinalty_absensi", "")
    );
    protected $rules = array(
        array("pegawai_id", ""),
        array("abs_tanggal", ""),
        array("abs_masuk", ""),
        array("abs_pulang", ""),
        array("abs_mesin", ""),
        array("abs_masuk_status", ""),
        array("abs_pulang_status", ""),
        array("abs_status", ""),
        array("abs_masuk_lapor", ""),
        array("abs_pulang_lapor", ""),
        array("abs_lapor", ""),
        array("abs_pinalty_masuk", ""),
        array("abs_pinalty_pulang", ""),
        array("abs_pinalty_absensi", "")
    );
    protected $related_tables = array(
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
