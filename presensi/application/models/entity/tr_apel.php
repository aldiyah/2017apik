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

class Tr_upacara extends MY_Model {

    public $sort_by = 'upacara_tanggal';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct('tr_absensi');
        $this->primary_key = 'upacara_id';
    }

    protected $attribute_labels = array(
        "upacara_id" => array("upacara_id", ""),
        "upacara_tanggal" => array("upacara_tanggal", ""),
        "pegawai_id" => array("pegawai_id", ""),
        "upacara_hadir" => array("upacara_hadir", ""),
        "upacara_status" => array("upacara_status", ""),
        "upacara_lapor" => array("upacara_lapor", ""),
        "upacara_pinalty" => array("upacara_pinalty", ""),
        "upacara_approval_al" => array("upacara_approval_al", ""),
        "upacara_approval_by_al" => array("upacara_approval_by_al", ""),
        "upacara_pinalty_al" => array("upacara_pinalty_al", ""),
        "upacara_approval_aa" => array("upacara_approval_aa", ""),
        "upacara_approval_by_aa" => array("upacara_approval_by_aa", ""),
        "upacara_pinalty_aa" => array("upacara_pinalty_aa", "")
    );
    protected $rules = array(
        array("upacara_tanggal", ""),
        array("pegawai_id", ""),
        array("upacara_hadir", ""),
        array("upacara_status", ""),
        array("upacara_lapor", ""),
        array("upacara_pinalty", ""),
        array("upacara_approval_al", ""),
        array("upacara_approval_by_al", ""),
        array("upacara_pinalty_al", ""),
        array("upacara_approval_aa", ""),
        array("upacara_approval_by_aa", ""),
        array("upacara_pinalty_aa", "")
    );
    protected $related_tables = array(
        "sc_master.master_upacara" => array(
            "fkey" => "upacara_tanggal",
            "columns" => array(
                "upacara_keterangan",
                "upacara_tempat",
                "upacara_pakaian"
            ),
            "referenced" => "LEFT"
        ),
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
