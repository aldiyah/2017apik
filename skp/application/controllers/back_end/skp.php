<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Skp extends Back_end {

    public $model = 'model_tr_skp_tahunan';

    public function __construct() {
        parent::__construct('kelola_skp', 'Sasaran Kerja Pegawai');
        $this->load->model('model_tr_skp_bulanan');
    }

    public function index() {
        $thn = $this->input->post('tahun');
        $tahun = $thn ? $thn : date('Y');
        $this->get_attention_message_from_session();
        if ($this->auto_load_model && $this->model != '' && $this->before_load_paging()) {
            list($sort_url_query, $sort_by, $sort_mode) = $this->get_sorting_pre_url_query();
            if ($sort_by) {
                $this->model_tr_skp_tahunan->sort_by = $sort_by;
                $this->model_tr_skp_tahunan->sort_mode = $sort_mode;
            }
            $this->model_tr_skp_tahunan->change_offset_param("currpage_" . $this->cmodul_name);
            $records = $this->model_tr_skp_tahunan->all($this->pegawai_id, $tahun);
            $records->record_set = $this->after_get_paging($records->record_set);
            $paging_set = $this->get_paging($this->get_current_location(), $records->record_found, $this->default_limit_paging, $this->cmodul_name);
            $this->set('records', $records->record_set);
            $this->set('keyword', $records->keyword);
            $this->set('field_id', $this->model_tr_skp_tahunan->primary_key);
            $this->set('paging_set', $paging_set);
            $this->set('sort_url_query', $sort_url_query);
            $this->set('sort_mode', $this->model_tr_skp_tahunan->sort_by);
            $this->set('sort_by', $this->model_tr_skp_tahunan->sort_mode);
            $this->set('next_list_number', $this->model_tr_skp_tahunan->get_next_record_number_list());
        }
        $this->set("additional_js", "back_end/" . $this->_name . "/js/index_js");
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function detail($id = FALSE) {
        parent::detail($id, array("pegawai_id", "skpt_tahun", "skpt_kegiatan", "skpt_waktu", "skpt_kuantitas", "skpt_kualitas", "skpt_biaya"));
        $this->set('pegawai_id', $this->pegawai_id);
        $this->set('skpb', $this->model_tr_skp_bulanan->get_data_setahun($id));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Formulir ' . $this->_header_title
        ));
        $this->add_cssfiles(array("plugins/select2/select2.min.css"));
        $this->add_jsfiles(array("plugins/select2/select2.full.min.js"));
        $this->add_jsfiles(array("plugins/smartwizard/jquery.smartWizard-2.0.min.js"));
        $this->add_jsfiles(array("plugins/jquery-validation/jquery.validate.js"));
    }

    public function ajukan($id = FALSE) {
        if ($this->model_tr_skp_tahunan->update_status($id, 1)) {
            $this->set_attention_message('Pengajuan berhasil...');
        } else {
            $this->set_attention_message('Pengajuan gagal dilakukan...');
        }
        redirect('back_end/skp');
    }

    public function lihat($id = FALSE) {
        $this->set('skpt', $skpt = $this->model_tr_skp_tahunan->get_realisasi($id));
        $this->set('pegawai_id', $this->pegawai_id);
        $this->set('skpb', $this->model_tr_skp_bulanan->get_data_setahun($id, TRUE));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Formulir ' . $this->_header_title
        ));
    }

    public function get_like() {
        $keyword = $this->input->post("keyword");
        $id_skpd = $this->input->post("id_skpd");
        $data_found = $this->{$this->model}->get_like($keyword, $id_skpd);
        $this->to_json($data_found);
    }

    public function after_save($id = FALSE, $saved_id = FALSE) {
        $kuantitas = $this->input->post('kuantitas');
        $biaya = $this->input->post('biaya');
        $data = array();
        for ($i = 1; $i <= 12; $i++) {
            $data[] = array(
                'skpt_id' => $saved_id,
                'skpb_bulan' => $i,
                'skpb_kuantitas' => $kuantitas[$i],
                'skpb_biaya' => $biaya[$i]
            );
        }
        $this->model_tr_skp_bulanan->save_data($id == $saved_id, $data);
        unset($data);
    }

}