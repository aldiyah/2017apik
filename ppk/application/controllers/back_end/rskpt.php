<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rskpt extends Back_end {

    public $model = 'model_tr_skp_tahunan';

    public function __construct() {
        parent::__construct('kelola_realisasi_skp_tahunan', 'Realisasi SKP Tahunan');
        $this->load->model('model_tr_skp_bulanan');
    }

    public function index() {
        $thn = $this->input->get('tahun', TRUE);
        $tahun = $thn ? $thn : date('Y');
        $this->get_attention_message_from_session();
        $records = $this->model_tr_skp_tahunan->get_realisasi_tahunan($this->pegawai_id, $tahun);
        $this->set('records', $records->record_set);
        $this->set('total_record', $records->record_found);
        $this->set('keyword', $records->keyword);
        $this->set('tahun', $tahun);
//        $this->set("additional_js", "back_end/" . $this->_name . "/js/index_js");
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function read($id = FALSE) {
        $this->set('skpt', $this->model_tr_skp_tahunan->get_realisasi($id));
        $this->set('pegawai_id', $this->pegawai_id);
        $this->set('skpb', $this->model_tr_skp_bulanan->get_data_setahun($id, TRUE));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Laporan ' . $this->_header_title
        ));
    }

    public function laporan($tahun = FALSE) {
        $tahun = $tahun ? $tahun : date('Y');
        $this->load->model(array('model_master_pegawai', 'model_tr_perilaku'));
        $this->set('pegawai', $this->model_master_pegawai->get_pegawai_by_id($this->pegawai_id));
        $this->set('skpt', $this->model_tr_skp_tahunan->get_realisasi_tahunan($this->pegawai_id, $tahun)->record_set);
        $this->set('perilaku', $this->model_tr_perilaku->get_perilaku_setahun($this->pegawai_id, $tahun));
        $this->set('tahun', $tahun);
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Laporan SKP Tahunan'
        ));
    }

}
