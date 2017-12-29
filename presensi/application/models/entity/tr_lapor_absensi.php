<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * tr_lapor_absensi.php
 * Dec 28, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Tr_lapor_absensi extends MY_Model {

    public $sort_by = 'abs_id';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct('tr_lapor_absensi');
        $this->primary_key = 'abs_id';
    }

    protected $attribute_labels = array(
        "abs_id" => array("abs_id", ""),
        "la_lapor" => array("la_lapor", ""),
        "la_dokumen" => array("la_dokumen", ""),
        "la_approval_al" => array("la_approval_al", ""),
        "la_approval_by_al" => array("la_approval_by_al", ""),
        "la_pinalty_al" => array("la_pinalty_al", ""),
        "la_approval_aa" => array("la_approval_aa", ""),
        "la_approval_by_aa" => array("la_approval_by_aa", ""),
        "la_pinalty_aa" => array("la_pinalty_aa", "")
    );
    protected $rules = array(
        array("abs_id", ""),
        array("la_lapor", ""),
        array("la_dokumen", ""),
        array("la_approval_al", ""),
        array("la_approval_by_al", ""),
        array("la_pinalty_al", ""),
        array("la_approval_aa", ""),
        array("la_approval_by_aa", ""),
        array("la_pinalty_aa", "")
    );
    protected $related_tables = array(
        "sc_presensi.tr_absensi" => array(
            "fkey" => "abs_id",
            "columns" => array(
                "pegawai_id",
                "abs_tanggal"
            ),
            "referenced" => "LEFT"
        )
    );
    protected $attribute_types = array();

}
