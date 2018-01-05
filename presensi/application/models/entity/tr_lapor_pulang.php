<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * tr_lapor_pulang.php
 * Dec 28, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Tr_lapor_pulang extends MY_Model {
    
    public $sort_by = 'abs_id';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct('tr_lapor_pulang');
        $this->primary_key = 'abs_id';
    }

    protected $attribute_labels = array(
        "abs_id" => array("abs_id", ""),
        "lp_lapor" => array("lp_lapor", ""),
        "lp_dokumen" => array("lp_dokumen", ""),
        "lp_approval_al" => array("lp_approval_al", ""),
        "lp_approval_by_al" => array("lp_approval_by_al", ""),
        "lp_pinalty_al" => array("lp_pinalty_al", ""),
        "lp_approval_aa" => array("lp_approval_aa", ""),
        "lp_approval_by_aa" => array("lp_approval_by_aa", ""),
        "lp_pinalty_aa" => array("lp_pinalty_aa", "")
    );
    protected $rules = array(
        array("abs_id", ""),
        array("lp_lapor", ""),
        array("lp_dokumen", ""),
        array("lp_approval_al", ""),
        array("lp_approval_by_al", ""),
        array("lp_pinalty_al", ""),
        array("lp_approval_aa", ""),
        array("lp_approval_by_aa", ""),
        array("lp_pinalty_aa", "")
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
