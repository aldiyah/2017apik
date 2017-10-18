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
        "absensi_id" => array("absensi_id", ""),
        "abs_masuk" => array("abs_masuk", ""),
        "abs_pulang" => array("abs_pulang", ""),
        "abs_mesin" => array("abs_mesin", ""),
        "abs_approval" => array("abs_approval", ""),
        "abs_approval_by" => array("abs_approval_by", "")
    );
    protected $rules = array(
        array("pegawai_id", ""),
        array("abs_tanggal", ""),
        array("absensi_id", ""),
        array("abs_masuk", ""),
        array("abs_pulang", ""),
        array("abs_mesin", ""),
        array("abs_approval", ""),
        array("abs_approval_by", "")
    );
    protected $related_tables = array(
        "jenis_absensi" => array(
            "fkey" => "absensi_id",
            "columns" => array(
                "absensi_nama"
            ),
            "referenced" => "LEFT"
        )
    );
    protected $attribute_types = array();

}
