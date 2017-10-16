<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * jenis_absensi.php
 * October 16, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_absensi extends MY_Model {

    public function __construct() {
        parent::__construct("jenis_absensi");
        $this->primary_key = "absensi_id";
    }

    protected $attribute_labels = array(
        "absensi_id" => array("absensi_id", ""),
        "absensi_nama" => array("absensi_nama", ""),
        "absensi_max_ambil" => array("absensi_max_ambil", "")
    );
    protected $rules = array(
        array("absensi_id", ""),
        array("absensi_nama", ""),
        array("absensi_max_ambil", "")
    );
    protected $related_tables = array();
    protected $attribute_types = array();

}
