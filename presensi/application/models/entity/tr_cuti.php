<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * tr_cuti.php
 * Oct 21, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Tr_cuti extends MY_Model {

    public $sort_by = 'cuti_id';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct('tr_cuti');
        $this->primary_key = 'cuti_id';
    }

    protected $attribute_labels = array(
        "cuti_id" => array("cuti_id", ""),
        "pegawai_id" => array("pegawai_id", ""),
        "cuti_tanggal" => array("cuti_tanggal", ""),
        "cuti_jenis" => array("cuti_jenis", ""),
        "cuti_lama" => array("cuti_lama", ""),
        "cuti_keterangan" => array("cuti_keterangan", ""),
        "cuti_status" => array("cuti_status", ""),
        "cuti_approval_by" => array("cuti_approval_by", ""),
        "cuti_banding_by" => array("cuti_banding_by", "")
    );
    protected $rules = array(
        array("pegawai_id", ""),
        array("cuti_tanggal", ""),
        array("cuti_jenis", ""),
        array("cuti_lama", ""),
        array("cuti_keterangan", ""),
        array("cuti_status", ""),
        array("cuti_approval_by", ""),
        array("cuti_banding_by", "")
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
