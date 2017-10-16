<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/backbone_user.php";

class model_backbone_user extends backbone_user {

    public function __construct() {
        parent::__construct();
        $this->primary_key = "id_user";
    }

    public function set_userdata_from_model_user($model_user_attribute = array()) {
        $username_column = $this->backbone_user_username;
        $password_column = $this->backbone_user_password;
        if (array_have_value($model_user_attribute)) {
            $this->{$username_column} = $model_user_attribute[$username_column];
            $this->{$password_column} = $model_user_attribute[$password_column];
        }
    }

    public function update_status_active($id_user, $status) {
        $this->data_update(array($this->record_active_column_name => $status), $this->table_name . "." . $this->primary_key . " = '" . $id_user . "'");
        return;
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array(
                    $this->backbone_user_username,
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

}