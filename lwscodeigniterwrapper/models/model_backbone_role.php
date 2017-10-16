<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/backbone_role.php";

class model_backbone_role extends backbone_role {

    public function __construct() {
        parent::__construct();
        $this->primary_key = "id_role";
    }

    public function get_public_role() {
        return $this->get_detail("is_public_role = '1' and ".$this->record_active_column_name." = '1'");
    }
    
    public function get_all() {
        return parent::get_all(array("nama_role"), FALSE, TRUE, FALSE, 1, TRUE );
    }

}

?>