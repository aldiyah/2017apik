<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * master_perilaku.php
 * Oct 19, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_perilaku extends MY_Model {

    public $sort_by = 'perilaku_id';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct("master_perilaku");
        $this->primary_key = "perilaku_id";
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(
        "perilaku_id" => array("perilaku_id", "ID Perilaku"),
        "perilaku_nama" => array("perilaku_nama", "Nama Perilaku")
    );
    protected $rules = array(
        array("perilaku_nama", "")
    );
    protected $related_tables = array();
    protected $attribute_types = array();

}
