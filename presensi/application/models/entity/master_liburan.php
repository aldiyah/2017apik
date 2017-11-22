<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * master_liburan.php
 * Oct 20, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_liburan extends MY_Model {

    public $sort_by = 'libur_tanggal';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct("master_liburan");
        $this->primary_key = "libur_tanggal";
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(
        "libur_tanggal" => array("libur_tanggal", "Tanggal Libur"),
        "libur_keterangan" => array("libur_keterangan", "Keterangan Libur")
    );
    protected $rules = array(
        array("libur_keterangan", "required|min_length[3]|max_length[200]")
    );
    protected $related_tables = array();
    protected $attribute_types = array();

}
