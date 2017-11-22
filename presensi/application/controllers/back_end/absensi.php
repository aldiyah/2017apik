<?php

/**
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * absensi.php
 * Oct 18, 2017
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends Back_end {

    public $model = 'model_tr_absensi';

    public function __construct() {
        parent::__construct('kelola_daftar_absensi', 'Daftar Absensi');
    }

    public function index() {
        $bln = $this->input->get('bulan', TRUE);
        $thn = $this->input->get('tahun', TRUE);
        $bulan = $bln ? $bln : date('n');
        $tahun = $thn ? $thn : date('Y');
        $holidays = array();
        $hari_kerja_efektif = get_working_day_monthly($holidays, $tahun, $bulan);
        $this->get_attention_message_from_session();
        $records = $this->model_tr_absensi->all($this->pegawai_id, $tahun, $bulan);
        $this->set('tanggal', $hari_kerja_efektif->dates);
        $this->set('records', $records->record_set);
        $this->set('total_record', $records->record_found);
        $this->set('keyword', $records->keyword);
        $this->set('bulan', $bulan);
        $this->set('tahun', $tahun);
        $this->set('jenis_cuti', $this->config->item('jenis_cuti'));
        $this->set('jenis_absensi', $this->config->item('jenis_absensi'));
        $this->set('bread_crumb', array(
            '#' => $this->_header_title
        ));
    }

    public function ulapor($id = FALSE) {
        parent::detail($id, array('absensi_id'));
        $this->set('absensi', $this->config->item('lapor_absensi'));
        $this->set('bread_crumb', array(
            'back_end/' . $this->_name => $this->_header_title,
            '#' => 'Lapor Absensi'
        ));
    }

    public function mlapor($id = FALSE) {
        parent::detail($id, array('abs_masuk_status'));
        $this->set('absensi', $this->config->item('lapor_absensi'));
        $this->set('bread_crumb', array(
            'back_end/' . $this->_name => $this->_header_title,
            '#' => 'Lapor Absensi'
        ));
    }

    public function plapor($id = FALSE) {
        parent::detail($id, array('abs_pulang_status'));
        $this->set('absensi', $this->config->item('lapor_absensi'));
        $this->set('bread_crumb', array(
            'back_end/' . $this->_name => $this->_header_title,
            '#' => 'Lapor Absensi'
        ));
    }

    public function lapor($id = FALSE) {
        parent::detail($id, array('abs_status'));
        $this->set('absensi', $this->config->item('lapor_absensi'));
        $this->set('bread_crumb', array(
            'back_end/' . $this->_name => $this->_header_title,
            '#' => 'Lapor Absensi'
        ));
    }

}
