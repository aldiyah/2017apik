<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usaktifitas extends Back_end {

    public $model = 'model_usulan_aktifitas';

    public function __construct() {
        parent::__construct('kelola_usulan_aktifitas', 'Usulan Aktivitas');
        $this->set('access_rules', $this->access_rules());
    }

    public function index() {
        $this->get_attention_message_from_session();
        $this->model_usulan_aktifitas->change_offset_param("currpage_" . $this->cmodul_name);
        $records = $this->model_usulan_aktifitas->all($this->pegawai_id);

        $paging_set = $this->get_paging($this->get_current_location(), $records->record_found, $this->default_limit_paging, $this->cmodul_name);
        $this->set('records', $records->record_set);
        $this->set('keyword', $records->keyword);
        $this->set('field_id', $this->model_usulan_aktifitas->primary_key);
        $this->set('paging_set', $paging_set);
        $this->set('next_list_number', $this->{$this->model}->get_next_record_number_list());

        $this->set('additional_js', 'back_end/' . $this->_name . '/js/index_js');

        $this->set('bread_crumb', array(
            '#' => $this->_header_title
        ));
    }

    public function detail($id = FALSE) {
        parent::detail($id, array("kelompok_id", "dinas_id", "usulan_nama", "usulan_output", "usulan_waktu", "pegawai_id"));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Formulir ' . $this->_header_title
        ));
        $this->load->model('model_kelompok_aktifitas');
        $this->set('pegawai_id', $this->pegawai_id);
        $this->set('kelompok', $this->model_kelompok_aktifitas->get_all());
        $this->set('dinas', (object) array(
                    (object) array(
                        'dinas_id' => 1,
                        'dinas_nama' => 'Dinas A'
                    ),
                    (object) array(
                        'dinas_id' => 2,
                        'dinas_nama' => 'Dinas B'
                    ),
                    (object) array(
                        'dinas_id' => 3,
                        'dinas_nama' => 'Dinas C'
                    ),
                    (object) array(
                        'dinas_id' => 4,
                        'dinas_nama' => 'Dinas D'
                    )
        ));
    }

    public function get_like() {
        $keyword = $this->input->post("keyword");
        $kelompok_found = $this->model_master_aktifitas->get_like($keyword);
        $this->to_json($kelompok_found);
    }

}
