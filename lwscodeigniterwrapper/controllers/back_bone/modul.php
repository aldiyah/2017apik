<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modul extends Back_bone {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_backbone_modul');
    }

    public function index() {
        $this->get_attention_message_from_session();
        $this->model_backbone_modul->change_offset_param("currpage_kelola_modul");
        $records = $this->model_backbone_modul->all();
        
        $paging_set = $this->get_paging($this->get_current_location(), $records->record_found, $this->default_limit_paging, "kelola_modul");
        $this->set('records', $records->record_set);
        $this->set("keyword", $records->keyword);
        $this->set('field_id', $this->model_backbone_modul->primary_key);
        $this->set("paging_set", $paging_set);
        $this->set("header_title", "Modul");
        
        $this->set("additional_js", "back_bone/modul/" . $this->_layout . "/js/index_js");
        
        $this->set("bread_crumb", array(
            "#" => 'Daftar Modul'
        ));
        
        $this->set("next_list_number", $this->model_backbone_modul->get_next_record_number_list());
    }

    public function detail($id = FALSE) {
        if ($this->model_backbone_modul->get_data_post(FALSE, array("nama_modul", "deskripsi_modul", "turunan_dari", "no_urut", "show_on_menu"))) {
            if ($this->model_backbone_modul->is_valid()) {

                $saved_id = $this->model_backbone_modul->save($id);

                if (!$id) {
                    $id = $saved_id;
                }

                $this->attention_messages = "Data baru telah disimpan.";
                if ($id) {
                    $this->attention_messages = "Perubahan telah disimpan.";
                }
                redirect('back_bone/modul');
            } else {
                $this->attention_messages = $this->model_backbone_modul->errors->get_html_errors("<br />", "line-wrap");
            }
        }

        $detail = $this->model_backbone_modul->show_detail($id);

        $this->set("detail", $detail);
        
        $this->set("bread_crumb", array(
            "back_bone/modul" => 'Daftar Modul',
            "#" => 'Pendaftaran Modul'
        ));
//        $this->add_jsfiles(array("avant/plugins/form-jasnyupload/fileinput.min.js"));
    }

    public function delete($id = FALSE) {
        if ($id) {
            $this->model_backbone_modul->set_non_active($id);
            $this->store_attention_message_to_session("Data berhasil dihapus.");
        } else {
            $this->store_attention_message_to_session("Data tidak ditemukan.");
        }
        redirect($this->my_location . "modul/index/");
    }

    /**
     * Example
     * @param type $id
     */
    /*
      public function delete($id = FALSE) {
      if ($id) {
      $this->load->model("model_tr_aplikasi");
      $application_found = $this->model_tr_aplikasi->get_all(NULL, $id);
      if (!$application_found->record_set) {
      $this->model_ref_kategori->remove($id);
      $this->store_attention_message_to_session("Data berhasil dihapus.");
      } else {
      $this->store_attention_message_to_session("Kategori digunakan oleh beberapa aplikasi.<br />Gagal menghapus data");
      }
      unset($application_found);
      } else {
      $this->store_attention_message_to_session("Kategori tidak ditemukan.");
      }
      redirect($this->my_location . "mskategori/index/");
      }
     */
}

?>