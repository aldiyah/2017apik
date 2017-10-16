<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Member extends Back_bone {

    public function __construct() {
        parent::__construct();
//        $this->load->model(array("model_user"));
        $this->load->model(array("model_user", "model_backbone_user", "model_backbone_profil", "model_backbone_user_role", "model_backbone_role"));
    }

    private function set_backend_member_redirect($location_uri) {
        $this->session->set_userdata("backend_member_redirect", $location_uri);
    }

    private function init_show_member($function_name, $header_title = "Anggota") {
        $this->get_attention_message_from_session();
        $this->model_user->change_offset_param("currpage_kelola_member");
        $records = $this->model_user->{$function_name}();
        $paging_set = $this->get_paging($this->get_current_location(), $records->record_found, $this->default_limit_paging, "kelola_member");
        $this->set('records', $records->record_set);
        $this->set("keyword", $records->keyword);
        $this->set("paging_set", $paging_set);
        $this->set("header_title", $header_title . " Gurita Store");
        $this->set("next_list_number", $this->model_user->get_next_record_number_list());
    }

    public function index() {
        $this->get_attention_message_from_session();
//        $this->model_user->change_offset_param("currpage_kelola_member");
        $records = $this->model_user->call_view_user_application();
        $paging_set = $this->get_paging($this->get_current_location(), $records->record_found, $this->default_limit_paging);
        $this->set("records", $records->record_set);
        $this->set("record_active_column_name", $this->model_user->get_record_active_column_name);
        $this->set("keyword", $records->keyword);
        $this->set("header_title", "Pengelola");
        $this->set("paging_set", $paging_set);
        $this->set("additional_js", "back_bone/member/" . $this->_layout . "/js/index_js");
        $this->set("next_list_number", $this->model_user->get_next_record_number_list());

        $this->set("bread_crumb", array(
            "#" => 'Daftar Pengguna'
        ));

        $this->add_jsfiles(array(
            "atlant/plugins/noty/jquery.noty.js",
            "atlant/plugins/noty/layouts/topCenter.js",
            "atlant/plugins/noty/layouts/topLeft.js",
            "atlant/plugins/noty/layouts/topRight.js",
            "atlant/plugins/noty/themes/default.js",
        ));

        $this->set_backend_member_redirect("back_bone/member");
    }

    public function update_status_active($username = FALSE) {
        $redirect_uri = $this->session->userdata("backend_member_redirect");
        if ($username) {
            $records = $this->model_user->get_user_detail_username($username, FALSE);
            if ($records) {
                $this->load->model("model_backbone_user");
                $status_active = 0;
                if ($records->record_active != 1) {
                    $status_active = 1;
                }
                $this->model_backbone_user->update_status_active($records->id_user, $status_active);
                unset($records);
                $this->store_attention_message_to_session("Perubahan telah disimpan.");
            } else {
                $this->store_attention_message_to_session("Pengguna tidak ditemukan.");
            }
        } else {
            $this->store_attention_message_to_session("Pengguna tidak ditemukan.");
        }
        redirect($redirect_uri);
    }

    /**
     * @see front_end/member/register
     */
    public function detail() {
        $register_success = FALSE;
        $this->attention_messages = "";
        $this->model_user->set_register_rules();
        $model_user_attributes = $this->model_user->get_attributes();

        /**
         * only in backend
         */
//        $id_role = $this->session->userdata("backend_add_role");
        $redirect_uri = "back_bone/member";
        if ($this->model_user->get_data_post()) {
            if ($this->model_user->is_user_exists()) {
                $this->store_attention_message_to_session("Pengguna telah terdaftar.");
                redirect($redirect_uri);
            }

            if ($this->model_user->is_valid()) {
                $this->model_user->apply_password();
                $this->load->model(array('model_backbone_user', 'model_backbone_user_role', 'model_backbone_profil'));
                
                /**
                 * Attribute dari model_user
                 * 
                    array(4) {
                      ["username"]=>
                      string(21) "helpdeskadministrator"
                      ["password"]=>
                      string(50) "934fd75dbf1b6d1935a540d2b26eb610::WYx0PggpQCKhfuSQ"
                      ["nama_profil"]=>
                      string(9) "Help Desk"
                      ["email_profil"]=>
                      string(0) ""
                    }
                 * 
                 */
                $model_user_attributes = $this->model_user->get_attributes();
                $this->model_backbone_user->set_userdata_from_model_user($model_user_attributes);
                $id_user = $this->model_backbone_user->save();
//                $this->model_backbone_user_role->save($id_user, $id_role);
                $this->model_backbone_profil->set_userdata_from_model_user($model_user_attributes, $id_user);
                $this->model_backbone_profil->save();
                $register_success = TRUE;
                $this->store_attention_message_to_session("Pengguna baru telah didaftarkan.");
                redirect($redirect_uri);
            } else {
                $this->attention_messages = $this->model_user->errors->get_html_errors("<br />", "line-wrap");
            }
        }

        $another_profil_table_name = $this->config->item("another_profil_tablename");
        $another_profil_table_properties = $this->config->item("another_profil_properties");

        $additional_js = array();
        $add_js = array();
        $add_css = array();

        if ($another_profil_table_name &&
                $another_profil_table_properties &&
                array_key_exists("partial_form_view", $another_profil_table_properties) &&
                array_key_exists("form_config", $another_profil_table_properties)) {

            $this->set("partial_form_view", $another_profil_table_properties["partial_form_view"]);

            /**
             * collect additional view information from additional profile conf
             */
            if (array_key_exists("additional_js", $another_profil_table_properties["form_config"])) {
                $additional_js = array_merge($another_profil_table_properties["form_config"]["additional_js"], $additional_js);
            }

            if (array_key_exists("add_jsfiles", $another_profil_table_properties["form_config"])) {
                $add_js = array_merge($another_profil_table_properties["form_config"]["add_jsfiles"], $add_js);
            }

            if (array_key_exists("add_cssfiles", $another_profil_table_properties["form_config"])) {
                $add_css = array_merge($another_profil_table_properties["form_config"]["add_cssfiles"], $add_css);
            }
        }

        $this->set("additional_js", $additional_js);
        $this->add_cssfiles($add_css);
        $this->add_jsfiles($add_js);

        $this->set('register_success', $register_success);
        $this->set('redirect_uri', $redirect_uri);

        $this->set("bread_crumb", array(
            "back_bone/member" => 'Daftar Pengguna',
            "#" => 'Pendaftaran Pengguna'
        ));

        $this->set('model_user_attributes', $model_user_attributes);
    }

    public function role($user_id = FALSE) {
        if (!$user_id) {
            redirect('back_bone/user');
        }

        $detail = $this->model_backbone_user->show_detail($user_id);

        $data_post = $this->input->post("ck_role");

        if ($data_post) {
            $this->model_backbone_user_role->save_roles($user_id, $data_post);
            $this->attention_messages = "Perubahan telah disimpan.";
        }

        /**
         * ge var_dump($detail);exit;t all modul combined with access by this role
         * $id int id role
         */
        $user_roles = $this->model_backbone_user_role->get_roles_by_user($user_id);
        $this->set("detail", $detail);

        $this->set("bread_crumb", array(
            "back_bone/member" => 'Daftar Pengguna',
            "#" => 'Role Pengguna'
        ));

        $this->set("user_roles", $user_roles);
    }

    public function login() {
        $this->_layout = $this->_layout."_login";
        parent::login();
    }

}

?>