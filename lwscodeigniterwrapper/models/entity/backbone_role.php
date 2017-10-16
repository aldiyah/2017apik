<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class backbone_role extends LWS_model {

    public function __construct() {
        parent::__construct("backbone_role");
        $this->primary_key = "id_role";
        
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(
        "id_role" => array("id_role", "Id Role"),
        "nama_role" => array("nama_role", "Nama Role"),
        "is_public_role" => array("is_public_role", "Is Public Role")
    );
    
    protected $rules = array(
        array("id_role", ""),
        array("nama_role", ""),
        array("is_public_role", "")
    );
    protected $related_tables = array();
    protected $attribute_types = array();

}

?>