<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lwpustaka_data extends Main {

    protected $_header_title = '';
    protected $cmodul_name = '';
    protected $auto_load_model = TRUE;
    public $model = '';
    private $loaded_model = array();
    protected $before_save_response = FALSE;
    protected $after_save_response = FALSE;

    public function __construct($cmodul_name = FALSE, $header_title = FALSE) {
        if ($this->auto_load_model && ($this->model == '' || !$cmodul_name || !$header_title)) {
            show_error('Modul name/Header Title/Model tidak ditemukan<br />Cek Kembali Controller yang dipanggil.', 500, 'LW Pustaka Data Error');
        }

        $this->cmodul_name = $cmodul_name;
        $this->_header_title = $header_title;

        $this->set("header_title", $this->_header_title);

        parent::__construct();

        if ($this->auto_load_model && $this->model != '') {
            $this->load_model($this->model);
        }
    }

    protected function load_model($model_name) {
        if (!in_array($model_name, $this->loaded_model)) {
            $this->load->model($model_name);
            $this->loaded_model[] = $model_name;
        }
    }

    protected function before_load_paging() {
        return TRUE;
    }

    /**
     * sementara masih support satu tabel saja
     */
    protected function get_sorting_pre_url_query() {
        
        $current_location = $this->get_current_location();
        $slash = '/';
        if (substr($current_location, -1) == '/') {
            $slash = '';
        }
        
        $sort_by = $this->input->get('sort_by');
        $sort_mode = $this->input->get('sort_mode');
        
        $arr_query_url = $this->get_arr_query_url();

        $arr_key_name = array("sort_by", "sort_mode");

        foreach ($arr_key_name as $key_name) {
            if ($arr_query_url !== FALSE && array_key_exists($key_name, $arr_query_url)) {
                unset($arr_query_url[$key_name]);
            }
        }

        if (count($arr_query_url) == 0) {
            $arr_query_url = FALSE;
        }
        
        $pre_url_query = $slash . '?a';
        if ($arr_query_url !== FALSE) {
            $pre_url_query = $slash . '?' . http_build_query($arr_query_url);
        }
        
        if ($sort_mode == 'asc') {
            $sort_mode = "desc";
        }else{
            $sort_mode = "asc";
        }
        
        $sort_url_query = $pre_url_query;
        if($sort_by){
            $sort_url_query.="&sort_mode=".$sort_mode;
        }
        return array($sort_url_query, $sort_by, $sort_mode);
    }

    protected function load_paging($model_name, $modul_name, $array_record_attribute = array("records" => "records", "keyword" => "keyword", "field_id" => "field_id", "paging_set" => "paging_set", "next_list_number" => "next_list_number"), $get_all_function_name = "all", $get_all_param = NULL) {
        $this->load_model($model_name);

        list($sort_url_query, $sort_by, $sort_mode) = $this->get_sorting_pre_url_query();

        if ($sort_by) {
            $this->{$model_name}->sort_by = $sort_by;
            $this->{$model_name}->sort_mode = $sort_mode;
        }

        $this->{$model_name}->change_offset_param($modul_name);
        $records = $this->{$model_name}->{$get_all_function_name}($get_all_param);
        $records->record_set = $this->after_get_paging($records->record_set);
        $paging_set = $this->get_paging($this->get_current_location(), $records->record_found, $this->default_limit_paging, $this->cmodul_name);
        $this->set($array_record_attribute['records'], $records->record_set);
        $this->set($array_record_attribute["keyword"], $records->keyword);
        $this->set($array_record_attribute["field_id"], $this->{$model_name}->primary_key);
        $this->set($array_record_attribute["paging_set"], $paging_set);
//        list($sort_url_query, $sort_by, $sort_mode) = $this->get_sorting_pre_url_query();
        $this->set("sort_url_query", $sort_url_query);
        $this->set("sort_mode", $this->{$model_name}->sort_by);
        $this->set("sort_by", $this->{$model_name}->sort_mode);

        $this->set($array_record_attribute["next_list_number"], $this->{$model_name}->get_next_record_number_list());
    }
    
    /**
     * 
     * Must return $record_set
     * 
     * @param type $record_set
     * @return type
     */
    protected function after_get_paging($record_set){
        return $record_set;
    }

    public function index() {
        $this->get_attention_message_from_session();
        if ($this->auto_load_model && $this->model != '' && $this->before_load_paging()) {
            $this->load_paging($this->model, "currpage_" . $this->cmodul_name);
        }
        $this->set("additional_js", "back_end/" . $this->_name . "/js/index_js");
    }

    protected function before_save($posted_data) {
        return TRUE;
    }

    protected function after_save($id = FALSE, $saved_id = FALSE) {
        return TRUE;
    }

    /**
     * @abstract
     * @param integer $id NULLABLE
     * @return integer saved id
     */
    protected function save_detail($id = FALSE) {
        return $this->{$this->model}->save($id);
    }

    protected function detail($id = FALSE, $posted_data = array()) {
//        var_dump(array_diff(array_keys($_POST), $posted_data), $this->{$this->model}->get_data_post(FALSE, $posted_data), $this->{$this->model}->is_valid(), $this->{$this->model});exit;
        if ($this->{$this->model}->get_data_post(FALSE, $posted_data)) {
            if ($this->{$this->model}->is_valid()) {

                $this->before_save_response = $this->before_save($posted_data);

                $saved_id = FALSE;
                if ($this->before_save_response !== FALSE) {
                    $saved_id = $this->save_detail($id);
                }

                $this->after_save_response = $this->after_save($id, $saved_id);

                if (!$id) {
                    $id = $saved_id;
                }

                if ($this->before_save_response) {
                    $this->attention_messages = "Data baru telah disimpan.";
                    if ($id) {
                        $this->attention_messages = "Perubahan telah disimpan.";
                    }
                    redirect('back_end/' . $this->_name);
                }
                $this->attention_messages = "Terdapat Kesalahan, Periksa kembali isian anda.";
            } else {
                $this->attention_messages = $this->{$this->model}->errors->get_html_errors("<br />", "line-wrap");
            }
        }

        $detail = $this->{$this->model}->show_detail($id);
//        var_dump($this->db->last_query(), $detail);exit;
        $this->set("detail", $detail);

//        $this->set("bread_crumb", array(
//            "back_end/cjenis_diklat" => 'Jenis Diklat',
//            "#" => 'Pendaftaran Jenis Diklat'
//        ));
//        $this->add_jsfiles(array("avant/plugins/form-jasnyupload/fileinput.min.js"));
    }

    public function delete($id = FALSE) {
        if ($id) {
            $this->{$this->model}->set_non_active($id);
            $this->store_attention_message_to_session("Data berhasil dihapus.");
        } else {
            $this->store_attention_message_to_session("Data tidak ditemukan.");
        }
        redirect($this->my_location . $this->_name . "/index/");
    }

}

?>