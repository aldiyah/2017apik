<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * cuti.php
 * Oct 22, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti extends Back_end {

    public $model = 'model_tr_cuti';

    public function __construct() {
        parent::__construct('kelola_daftar_cuti', 'Pengajuan Izin');
    }

    public function index() {
//        $this->load->helper('perwal');
        $thn = $this->input->get('tahun', TRUE);
        $tahun = $thn ? $thn : date('Y');
//        $this->get_attention_message_from_session();
        $records = $this->model_tr_cuti->all($this->pegawai_id, $tahun);
        $this->set('records', $records->record_set);
        $this->set('total_record', $records->record_found);
        $this->set('keyword', $records->keyword);
        $this->set('tahun', $tahun);
        $this->set('jenis_cuti', $this->config->item('jenis_cuti'));
        $this->set('jenis_absensi', $this->config->item('jenis_absensi'));
        $this->set('jenis_status', $this->config->item('jenis_status_ijin'));
        $this->set('bread_crumb', array(
            '#' => $this->_header_title
        ));
    }

    public function detail($id = FALSE) {
        parent::detail($id, array("pegawai_id", "cuti_tanggal", "cuti_jenis", "cuti_lama", "cuti_keterangan"));
        $this->set('pegawai_id', $this->pegawai_id);
        $this->set('jenis_cuti', $this->config->item('jenis_cuti'));
        $this->set('additional_js', 'back_end/' . $this->_name . '/js/detail_js');
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Data ' . $this->_header_title
        ));
    }

    public function ajukan($id) {
        if ($this->model_tr_cuti->update_status($id, 1)) {
            $this->set_attention_message('Pengajuan berhasil...');
        } else {
            $this->set_attention_message('Pengajuan gagal dilakukan...');
        }
        redirect('back_end/cuti');
    }

}
