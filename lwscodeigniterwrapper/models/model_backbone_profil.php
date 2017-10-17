<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/backbone_profil.php";

class model_backbone_profil extends backbone_profil {

    public function __construct() {
        parent::__construct();
    }

    public function set_userdata_from_model_user($model_user_attribute = array(), $id_user = FALSE) {
        if (array_have_value($model_user_attribute) && $id_user) {
            $this->nama_profil = $model_user_attribute['nama_profil'];
            $this->email_profil = $model_user_attribute['email_profil'];
            $this->id_user = $id_user;
        }
    }

    protected function associate_with_another_profil_table($insert_response) {
        $another_profil_table_name = $this->config->item("another_profil_tablename");
        $another_profil_table_properties = $this->config->item("another_profil_properties");
        $another_profil_table_properties_columns = $another_profil_table_properties["columns"];

        if ($insert_response && $another_profil_table_name &&
                !is_null($another_profil_table_name) &&
                $another_profil_table_properties &&
                array_key_exists("foreign_key", $another_profil_table_properties) &&
                array_key_exists("foreign_key_to_another_profile", $another_profil_table_properties)
        ) {

            $fk_another_profile_value = $this->input->post($another_profil_table_properties["foreign_key_to_another_profile"]);

            // Penambahan data baru berdasarkan column another tables --- ALDIYAH

            $new_data = array(
                $another_profil_table_properties["foreign_key_to_another_profile"] => $fk_another_profile_value,
                $another_profil_table_properties["foreign_key"] => $insert_response
            );
            if (isset($another_profil_table_properties_columns)) {
                foreach ($another_profil_table_properties_columns as $column) {
                    $new_data[$column] = $this->input->post($column);
                }
            }

            if ($fk_another_profile_value) {
                $this->db->insert($another_profil_table_name, $new_data);
            }
        }
    }

    protected function after_save($insert_response) {
        $this->associate_with_another_profil_table($insert_response);
        return;
    }

}
