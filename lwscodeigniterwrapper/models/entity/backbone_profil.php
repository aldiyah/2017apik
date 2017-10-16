<?php if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class backbone_profil extends LWS_model {

    public function __construct() {
        parent::__construct("backbone_profil");
        $this->primary_key = "id_profil";
        
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(array("id_profil", "Id Profil"), array("id_user", "Id User"), array("nama_profil", "Nama Profil"), array("email_profil", "Email Profil"));
    protected $rules = array(array("id_profil", ""), array("id_user", ""), array("nama_profil", ""), array("email_profil", ""));
    protected $related_tables = array();
    protected $attribute_types = array();

} ?>