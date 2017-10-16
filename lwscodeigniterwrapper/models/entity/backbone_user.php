<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class backbone_user extends LWS_model {

    public function __construct() {
        parent::__construct("backbone_user");
        $this->primary_key = "id_user";
        
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(array("id_user", "Id User"), array("username", "Username"), array("password", "Password"), array("last_login", "Last Login"), array("last_ip", "Last Ip"));
    protected $rules = array(
        array("id_user", ""),
        array("username", "required|min_length[6]|max_length[59]"),
        array("password", ""),
        array("last_login", ""),
        array("last_ip", "")
    );
    protected $related_tables = array();
    protected $attribute_types = array();

}

?>