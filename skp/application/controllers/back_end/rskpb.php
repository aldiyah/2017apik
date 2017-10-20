<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rskpb extends Back_end {

    public $model = 'model_tr_skp_bulanan';

    public function __construct() {
        parent::__construct('kelola_realisasi_skp_bulanan', 'Realisasi SKP Bulanan');
    }

    public function index() {
        $bln = $this->input->get('bulan', TRUE);
        $thn = $this->input->get('tahun', TRUE);
        $bulan = $bln ? $bln : date('n');
        $tahun = $thn ? $thn : date('Y');
        $this->get_attention_message_from_session();
        $records = $this->model_tr_skp_bulanan->all($this->pegawai_id, $tahun, $bulan);
        $this->set('records', $records->record_set);
        $this->set('total_record', $records->record_found);
        $this->set('keyword', $records->keyword);
        $this->set('bulan', $bulan);
        $this->set('tahun', $tahun);
//        $this->set("additional_js", "back_end/" . $this->_name . "/js/index_js");
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function update($id = FALSE) {
        parent::detail($id, array('skpb_real_kuantitas', 'skpb_real_biaya'));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Laporan ' . $this->_header_title
        ));
    }

    public function read($id = FALSE) {
        parent::detail($id);
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Laporan ' . $this->_header_title
        ));
    }

    public function ajukan($id = FALSE) {
        if ($this->model_tr_skp_bulanan->update_status($id, 1)) {
            $this->set_attention_message('Pengajuan berhasil...');
        } else {
            $this->set_attention_message('Pengajuan gagal dilakukan...');
        }
        redirect('back_end/rskpb');
    }

}
