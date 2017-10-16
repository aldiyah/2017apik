<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class kelompok_aktifitas extends MY_Model {

    public $sort_by = 'kelompok_nama';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct("kelompok_aktifitas");
        $this->primary_key = "kelompok_id";
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(
        "kelompok_id" => array("kelompok_id", "ID Kelompok"),
        "kelompok_nama" => array("kelompok_nama", "Nama Kelompok"),
        "kelompok_keterangan" => array("kelompok_keterangan", "Keterangan Kelompok")
    );
    protected $rules = array(
        array("kelompok_nama", "required|min_length[3]|max_length[20]"),
        array("kelompok_keterangan", "required|min_length[3]|max_length[200]")
    );
    protected $related_tables = array();
    protected $attribute_types = array();

}
