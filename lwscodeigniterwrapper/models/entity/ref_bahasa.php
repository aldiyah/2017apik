<?php if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class ref_bahasa extends LWS_model {

    public function __construct() {
        parent::__construct("ref_bahasa");
        $this->primary_key = "id_bahasa";
        
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(array("id_bahasa", "Id Bahasa"), array("kode_bahasa", "Kode Bahasa"), array("nama_bahasa", "Nama Bahasa"));
    protected $rules = array(array("id_bahasa", ""), array("kode_bahasa", ""), array("nama_bahasa", ""));
    protected $related_tables = array();
    protected $attribute_types = array();

} ?>