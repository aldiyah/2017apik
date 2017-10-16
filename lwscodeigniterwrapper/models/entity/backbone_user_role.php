<?php if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class backbone_user_role extends LWS_model {

    public function __construct() {
        parent::__construct("backbone_user_role");
        $this->primary_key = "id_user_role";
        
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(array("id_user_role", "Id User Role"), array("id_user", "Id User"), array("id_role", "Id Role"));
    protected $rules = array(array("id_user_role", ""), array("id_user", ""), array("id_role", ""));
    protected $related_tables = array();
    protected $attribute_types = array();

}
