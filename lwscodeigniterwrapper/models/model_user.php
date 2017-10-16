<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class model_user extends LWS_Model {

    public function __construct() {
        parent::__construct();
        $this->set_table_name();

        $this->username_rules[1] .= "model_is_unique[" . $this->get_schema_name(FALSE, TRUE) . ".backbone_user.username]";
        $this->rules[] = $this->username_rules;
        $this->register_rules = $this->rules;
    }

//    const ROLE_TAMU = '4';
//    const ROLE_ANGGOTA = '3';
//    const ROLE_PENGEMBANG = '2';
//    const ROLE_ADMINISTRATOR = '1';
//    const ROLE_TAMU_STRING = "tamu";
//    const ROLE_ANGGOTA_STRING = "anggota";
//    const ROLE_PENGEMBANG_STRING = "pengembang";
//    const ROLE_ADMINISTRATOR_STRING = "administrator";

    private $in_profile_update = FALSE;
    private $update_password = FALSE;
    private $in_front_register_user = FALSE;
    private $array_role_names = array(
        "role", "role_name", "nama_role", "name", "nama"
    );

    private function set_table_name($table_name = NULL) {
        $this->table_name = $table_name;
    }

    protected $attribute_labels = array(
        "username" => "Username",
        "password" => "Password",
        "nama_profil" => "Nama Profil",
        "email_profil" => "Email Profil",
    );
    private $username_rules = array("username", "required|max_length[60]|min_length[6]|alpha_dash|");
    protected $rules = array(
        array("password", "required|max_length[60]|min_length[6]"),
        array("nama_profil", "required|max_length[200]|min_length[6]"),
//        array("email_profil", "required|valid_email|max_length[100]|is_unique[tr_profil.email_profil]"),
        array("email_profil", "valid_email|max_length[100]"),
    );
    protected $register_rules = NULL;
    protected $register_attribute_labels = array(
        "username" => "Username",
        "password" => "Password",
//        "input_captcha" => "Captcha",
        "nama_profil" => "Nama Profil",
        "email_profil" => "Email Profil",
    );
    protected $profile_attribute_labels = array(
        "oldpassword" => "Password (Lama)",
        "newpassword" => "Password (Baru)",
        "nama_profil" => "Nama Profil",
        "email_profil" => "Email Profil",
    );
    protected $profile_rules = array(
        array("oldpassword", ""),
        array("newpassword", "max_length[60]|min_length[6]"),
        array("nama_profil", "required|max_length[200]|min_length[6]"),
//        array("email_profil", "required|valid_email|max_length[100]"),
        array("email_profil", "valid_email|max_length[100]"),
    );
    protected $login_attribute_labels = array(
        "username" => "Username",
        "password" => "Password",
    );
    protected $login_rules = array(
        array("username", "required"),
        array("password", "required"),
    );

//    public function show_role_administrator() {
//        return self::ROLE_ADMINISTRATOR;
//    }
//
//    public function show_role_pengembang() {
//        return self::ROLE_PENGEMBANG;
//    }
//
//    public function show_role_anggota() {
//        return self::ROLE_ANGGOTA;
//    }
//
//    public function show_role_tamu() {
//        return self::ROLE_TAMU;
//    }

    public function apply_password() {
        $this->password = $this->lmanuser->generate_password($this->username, $this->password);
    }

    public function set_login_rules() {
        $this->attribute_labels = $this->login_attribute_labels;
        $this->rules = $this->login_rules;
    }

    public function is_update_password() {
        return $this->update_password;
    }

    private function is_newpassword_exists() {
        return isset($this->attributes["newpassword"]) && have_value($this->attributes["newpassword"]);
    }

    public function is_user_exists() {
        return $this->get_user_detail_username($this->username);
    }

    private function set_rule_oldpassword() {
        if ($this->is_newpassword_exists()) {
            $this->rules[0] = array("oldpassword", "required");
            $this->update_password = TRUE;
        } else {
            unset($this->attributes["oldpassword"], $this->attributes["newpassword"]);
        }
    }

    protected function after_run_validation($is_valid) {
        if ($is_valid && $this->in_profile_update && $this->is_newpassword_exists()) {
            $this->password = $this->newpassword;
        }
    }

    protected function after_get_data_post() {
        if ($this->in_profile_update) {
            $this->set_rule_oldpassword();
        }
    }

    protected function before_run_validation() {
        if ($this->in_profile_update &&
                isset($this->attributes["username"]) &&
                have_value($this->attributes["username"]) &&
                $this->update_password) {

            $detail_user = $this->get_user_detail_username($this->username);

            if ($detail_user) {
                if (!$this->lmanuser->is_valid_password($this->username, $detail_user->password, $this->oldpassword)) {
                    $this->errors->add("oldpassword", "Password lama tidak sesuai.");
                    $this->errors->error_found = TRUE;
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        }

        if ($this->in_front_register_user) {
            $captcha_number = $this->session->userdata("captcha_number");
            if ($captcha_number && ($captcha_number != $this->input_captcha)) {
                $this->errors->add("input_captcha", "Angka yang dimasukkan tidak sesuai.");
                return FALSE;
            } else {
                unset($this->attributes["input_captcha"]);
            }
        }
        return TRUE;
    }

    public function set_profile_rules() {
        $this->attribute_labels = $this->profile_attribute_labels;
        $this->rules = $this->profile_rules;
        $this->in_profile_update = TRUE;
    }

    public function set_register_rules($front_end = FALSE) {
        $this->attribute_labels = $this->register_attribute_labels;
        $this->rules = $this->register_rules;
        if ($front_end) {
            $this->in_front_register_user = TRUE;
        }
    }

    public function get_captcha($refresh = FALSE) {
        $this->load->library('lcaptcha', array(
            'random_word' => true,
            'img_path' => APPPATH . '../_assets/img/captcha/',
            'img_url' => img("captcha") . '/',
        ));
        $captcha_response = $this->lcaptcha->generate();
        $captcha_image = FALSE;
        if ($captcha_response) {
            $this->session->set_userdata(array(
                "captcha_number" => $captcha_response["random_number"]
            ));
            $captcha_image = $captcha_response["image"];
            if ($refresh) {
                $captcha_image = $captcha_response["img_src"];
            }
        }
        return $captcha_image;
    }

    /**
     * Ekstrak record role menjadi array misal 
     * array(2) {
      [0]=>
      object(stdClass)#15 (1) {
      ["nama_role"]=> string(10) "administrator"
      }
      [1]=>
      object(stdClass)#16 (1) {
      ["nama_role"]=> string(7) "guest"
      }
      }
     * akan menjadi array(2){
     *  [0]=>"administrator", [1]=>"guest"
     * }
     * @author Lahir Wisada <lahirwisada@gamail.com>
     * @param (object)array $record
     * @param bool $return_bool Jika diset TRUE maka jika $record = FALSE return akan FALSE, jika diset FALSE maka jika $record = FALSE return akan array()
     * @return array Array dari role
     */
    private function extract_role($record_set = FALSE, $return_bool = FALSE) {
        if ($record_set && array_have_value($record_set)) {
            $array_roles = array();
            $sample = $record_set[0];
            $role_name = "";
            foreach ($this->array_role_names as $name) {
                if (property_exists($sample, $name)) {
                    $role_name = $name;
                    break;
                }
            }
            if ($role_name != "") {
                foreach ($record_set as $record) {
                    $array_roles[] = $record->{$role_name};
                }

                unset($sample, $role_name);
                return $array_roles;
            }
        }
        if ($return_bool) {
            return FALSE;
        }
        return array();
    }

    public function reset() {
        $this->in_profile_update = FALSE;
        $this->update_password = FALSE;
        $this->set_login_rules();
    }

    public function get_user_role_by_username($username = FALSE, $extract_role = FALSE) {
        if ($username) {
            $this->db->join($this->get_schema_name('backbone_user_role', TRUE), $this->get_schema_name('backbone_user_role', TRUE) . '.id_user = ' . $this->get_schema_name('backbone_user', TRUE) . '.id_user');
            $this->db->join($this->get_schema_name('backbone_role', TRUE), $this->get_schema_name('backbone_user_role', TRUE) . '.id_role = ' . $this->get_schema_name('backbone_role', TRUE) . '.id_role');
            $this->db->join($this->get_schema_name('backbone_profil', TRUE), $this->get_schema_name('backbone_user', TRUE) . '.id_user = ' . $this->get_schema_name('backbone_profil', TRUE) . '.id_user');
            $this->set_table_name($this->get_schema_name('backbone_user', TRUE));
            $record = $this->get_where($this->get_schema_name('backbone_user', TRUE) . ".username = '" . $username . "' and " . $this->get_schema_name('backbone_user', TRUE) . "." . $this->record_active_column_name . " = '1'", $this->get_schema_name('backbone_role', TRUE) . ".nama_role");
            $this->set_table_name();
            if ($extract_role) {
                return $this->extract_role($record);
            }
            return $record;
        }
        return FALSE;
    }

    public function join_to_another_profile_table() {
        $another_profil_table_name = $this->config->item("another_profil_tablename");
        $another_profil_table_properties = $this->config->item("another_profil_properties");
        if ($another_profil_table_name && $another_profil_table_properties) {

            $this->db->join($another_profil_table_name, $another_profil_table_name . '.id_profil = ' . $this->get_schema_name('backbone_profil', TRUE) . '.id_profil', "LEFT");

            if (array_key_exists("columns", $another_profil_table_properties) && array_have_value($another_profil_table_properties["columns"])) {
                $this->db->select(implode(",", $another_profil_table_properties["columns"]), FALSE);
            }

            if (array_key_exists("related_tables", $another_profil_table_properties) && array_have_value($another_profil_table_properties["related_tables"])) {
                $this->get_select_referenced_table($another_profil_table_properties["related_tables"]);
            }
        }
    }

    public function get_user_detail_username($username = FALSE, $using_record_active = TRUE) {
        if ($username) {
//            $this->db->join('ref_user_role', 'ref_user_role.id_user = ref_user.id_user');
//            $this->db->join('ref_role', 'ref_user_role.id_role = ref_role.id_role');
            $this->db->join($this->get_schema_name('backbone_profil', TRUE), $this->get_schema_name('backbone_user', TRUE) . '.id_user = ' . $this->get_schema_name('backbone_profil', TRUE) . '.id_user');
            $this->set_table_name($this->get_schema_name('backbone_user', TRUE));
            $where_record_active = "";
            if ($using_record_active) {
                $where_record_active = " and " . $this->get_schema_name('backbone_user', TRUE) . "." . $this->record_active_column_name . " = '1'";
            }

            $this->join_to_another_profile_table();

            $record = $this->get_detail(
                    $this->get_schema_name('backbone_user', TRUE) . ".username = '" . $username . "'" . $where_record_active, $this->get_schema_name('backbone_user', TRUE) . ".id_user, " . $this->get_schema_name('backbone_user', TRUE) . ".username, " . $this->get_schema_name('backbone_user', TRUE) . ".password, " . $this->get_schema_name('backbone_user', TRUE) . "." . $this->record_active_column_name . ", " .
                    $this->get_schema_name('backbone_profil', TRUE) . ".id_profil, " . $this->get_schema_name('backbone_profil', TRUE) . ".nama_profil, " . $this->get_schema_name('backbone_profil', TRUE) . ".email_profil"
            );
            $this->set_table_name();
            if ($record) {
                $record->roles = $this->get_user_role_by_username($username, TRUE);
            }
            return $record;
        }
        return FALSE;
    }

    public function set_login($detail_user, $side_end_login) {
        if ($detail_user && $this->lmanuser->is_valid_password($this->username, $detail_user->password, $this->password)) {
            unset($detail_user->password);
            $this->lmanuser->login($detail_user, $detail_user->roles, $side_end_login);
            return TRUE;
        }
        return FALSE;
    }

    public function login($side_end_login = "FRONT_END") {
        if ($this->is_valid()) {
            $record = $this->get_user_detail_username($this->username);

            $login_ok = TRUE;
            if ($this->using_backend_front_end) {
                $login_ok = FALSE;
                if ($record && $side_end_login == Lmanuser::FRONT_END) {
                    $login_ok = TRUE;
                } elseif ($record && $side_end_login == Lmanuser::BACK_END) {
                    $login_ok = TRUE;
                }
            }

            if ($login_ok) {
                return $this->set_login($record, $side_end_login);
            }
            unset($record);
        }
        return FALSE;
    }

    public function call_view_user_application($conditions = FALSE) {
        $view_name = $this->get_schema_name('v_user', TRUE);

        $temp_where = array();
        $search_condition = $this->get_keyword_where(array("username", "nama_profil", "email_profil"));
        if ($conditions) {
            $temp_where[] = $this->collect_condition($conditions) . " ";
        }
        if ($search_condition) {
            $temp_where[] = $search_condition;
        }
        $where = implode(" and ", $temp_where);

        unset($temp_where, $search_condition, $conditions);
        list($limit, $offset) = $this->get_limitoffset();
        $this->db->limit($limit, $offset);
        $this->table_name = $this->get_schema_name('backbone_user');
        $record_set = $this->get_where($where, NULL, "username asc", FALSE, $view_name);
        $this->table_name = NULL;
//        echo $this->db->last_query();exit;
        $record_found = $this->count_all($where, $view_name);

        return (object) array(
                    "record_set" => $record_set,
                    "record_found" => $record_found,
                    "keyword" => $this->get_keyword()
        );
    }

    /**
      public function show_anggota($condition = FALSE) {
      return $this->call_view_user_gurita_store("v_user_anggota", $condition);
      }

      public function show_administrator($condition = FALSE) {
      return $this->call_view_user_gurita_store("v_user_administrator", $condition);
      }

      public function show_pengembang($condition = FALSE) {
      return $this->call_view_user_gurita_store("v_user_pengembang", $condition);
      }
     */
}

?>