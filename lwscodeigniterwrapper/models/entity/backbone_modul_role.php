<?php if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class backbone_modul_role extends LWS_model {

    public function __construct() {
        parent::__construct("backbone_modul_role");
        $this->primary_key = "id_module_role";
        
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(array("id_module_role", "Id Module Role"), array("id_role", "Id Role"), array("id_modul", "Id Modul"), array("is_read", "Is Read"), array("is_write", "Is Write"), array("is_delete", "Is Delete"), array("is_update", "Is Update"));
    protected $rules = array(array("id_module_role", ""), array("id_role", ""), array("id_modul", ""), array("is_read", ""), array("is_write", ""), array("is_delete", ""), array("is_update", ""));
    protected $related_tables = array();
    protected $attribute_types = array();

} ?>