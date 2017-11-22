<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * master_upacara.php
 * Oct 22, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_upacara extends MY_Model {

    public $sort_by = 'upacara_tanggal';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct("master_upacara");
        $this->primary_key = "upacara_tanggal";
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(
        "upacara_tanggal" => array("upacara_tanggal", "Tanggal Upacara"),
        "upacara_keterangan" => array("upacara_keterangan", "Keterangan Upacara"),
        "upacara_tempat" => array("upacara_tempat", "Tempat Upacara"),
        "upacara_pakaian" => array("upacara_pakaian", "Pakaian Upacara")
    );
    protected $rules = array(
        array("upacara_keterangan", "required|min_length[3]|max_length[200]"),
        array("upacara_tempat", "required|min_length[3]|max_length[100]"),
        array("upacara_pakaian", "required|min_length[3]|max_length[50]")
    );
    protected $related_tables = array();
    protected $attribute_types = array();

}
