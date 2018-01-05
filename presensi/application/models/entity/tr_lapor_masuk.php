<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * tr_lapor_masuk.php
 * Dec 28, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Tr_lapor_masuk extends MY_Model {

    public $sort_by = 'abs_id';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct('tr_lapor_masuk');
        $this->primary_key = 'abs_id';
    }

    protected $attribute_labels = array(
        "abs_id" => array("abs_id", ""),
        "lm_lapor" => array("lm_lapor", ""),
        "lm_dokumen" => array("lm_dokumen", ""),
        "lm_approval_al" => array("lm_approval_al", ""),
        "lm_approval_by_al" => array("lm_approval_by_al", ""),
        "lm_pinalty_al" => array("lm_pinalty_al", ""),
        "lm_approval_aa" => array("lm_approval_aa", ""),
        "lm_approval_by_aa" => array("lm_approval_by_aa", ""),
        "lm_pinalty_aa" => array("lm_pinalty_aa", "")
    );
    protected $rules = array(
        array("abs_id", ""),
        array("lm_lapor", ""),
        array("lm_dokumen", ""),
        array("lm_approval_al", ""),
        array("lm_approval_by_al", ""),
        array("lm_pinalty_al", ""),
        array("lm_approval_aa", ""),
        array("lm_approval_by_aa", ""),
        array("lm_pinalty_aa", "")
    );
    protected $related_tables = array(
        "sc_presensi.tr_absensi" => array(
            "fkey" => "abs_id",
            "columns" => array(
                "pegawai_id",
                "abs_tanggal"
            ),
            "referenced" => "LEFT"
        ),
        "sc_master.master_pegawai" => array(
            "reference_to" => "tr_absensi",
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
