<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Role extends Back_bone {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_backbone_role');
    }

    public function index() {
        $this->get_attention_message_from_session();
        $this->model_backbone_role->change_offset_param("currpage_kelola_role");
        $records = $this->model_backbone_role->get_all();
        $paging_set = $this->get_paging($this->get_current_location(), $records->record_found, $this->default_limit_paging, "kelola_role");
        
        $this->set("additional_js", "back_bone/role/" . $this->_layout . "/js/index_js");
        
        $this->set('records', $records->record_set);
        $this->set("keyword", $records->keyword);
        $this->set('field_id', $this->model_backbone_role->primary_key);
        $this->set("paging_set", $paging_set);
        $this->set("header_title", "Role");
        
        $this->set("bread_crumb", array(
            "#" => 'Daftar Role'
        ));
        
        $this->set("next_list_number", $this->model_backbone_role->get_next_record_number_list());
    }

    public function detail($id = FALSE) {
        $this->load->model(array("model_backbone_modul_role", "model_backbone_modul"));
        if ($this->model_backbone_role->get_data_post(FALSE, array("nama_role"))) {
//            var_dump($_POST);exit;
            if ($this->model_backbone_role->is_valid()) {
                $saved_id = $this->model_backbone_role->save($id);

                if (!$id) {
                    $id = $saved_id;
                }

                $this->attention_messages = "Data baru telah disimpan.";
                if ($id) {
                    $this->attention_messages = "Perubahan telah disimpan.";
                }

                /**
                 * collect all modul role
                 */
                
                $this->model_backbone_modul_role->save_permission($id);
                redirect('back_bone/role');
            } else {
                $this->attention_messages = $this->model_ref_role->errors->get_html_errors("<br />", "line-wrap");
            }
        }

        $detail = $this->model_backbone_role->show_detail($id);
        
        /**
         * get all modul combined with access by this role
         * $id int id role
         */
        $modul_role_access = $this->model_backbone_modul_role->get_access_by_role($id);

        $this->set("detail", $detail);
        $this->set("modul_role_access", $modul_role_access);
//        $this->add_jsfiles(array("avant/plugins/form-jasnyupload/fileinput.min.js"));
        
        $this->set("bread_crumb", array(
            "back_bone/role" => 'Daftar Role',
            "#" => 'Pendaftaran Role'
        ));
        
        $this->set("additional_js", "back_bone/role/" . $this->_layout . "/js/detail_js");
    }

    public function delete($id = FALSE) {
        if ($id) {
            $this->model_backbone_role->set_non_active($id);
            $this->store_attention_message_to_session("Data berhasil dihapus.");
        } else {
            $this->store_attention_message_to_session("Data tidak ditemukan.");
        }
        redirect($this->backbone_controller_location);
    }

}

?>