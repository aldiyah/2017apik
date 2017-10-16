<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class backbone_modul extends LWS_model {

    public function __construct() {
        parent::__construct("backbone_modul");
        $this->primary_key = "id_modul";
        
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(
        "id_modul" => array("id_modul", "Id Modul"),
        "nama_modul" => array("nama_modul", "nama_modul"),
        "deskripsi_modul" => array("deskripsi_modul", "deskripsi_modul"),
        "turunan_dari" => array("turunan_dari", "turunan_dari"),
        "no_urut" => array("no_urut", "no_urut"),
        "show_on_menu" => array("show_on_menu", "no_urut"),
//        "created_date" => array("created_date", "created_date"),
//        "created_by" => array("created_by", "created_by"),
//        "modified_date" => array("modified_date", "modified_date"),
//        "modified_by" => array("modified_by", "modified_by"),
//        "record_active" => array("record_active", "record_active"),
    );
    protected $rules = array(
        array("id_modul", ""),
        array("nama_modul", ""),
        array("deskripsi_modul", ""),
        array("turunan_dari", ""),
        array("no_urut", ""),
        array("show_on_menu", ""),
//        array("created_date", ""),
//        array("created_by", ""),
//        array("modified_date", ""),
//        array("modified_by", ""),
//        array("record_active", ""),
    );
    protected $related_tables = array();
    protected $attribute_types = array();

}

?>