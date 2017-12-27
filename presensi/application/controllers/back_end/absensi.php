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
        $this->__get_absensi_from_adms();
        $bln = $this->input->get('bulan', TRUE);
        $thn = $this->input->get('tahun', TRUE);
        $bulan = $bln ? $bln : date('n');
        $tahun = $thn ? $thn : date('Y');
        $this->load->model('model_master_liburan');
        $holidays = $this->model_master_liburan->get_bulanan($thn, $bln);
        $holy = array();
        if ($holidays) {
            foreach ($holidays as $key => $row) {
                $holy[] = $row->libur_tanggal;
            }
        }
        $hari_kerja_efektif = get_working_day_monthly($holy, $tahun, $bulan);
        $this->get_attention_message_from_session();
        $records = $this->model_tr_absensi->all($this->pegawai_id, $tahun, $bulan);
        $this->set('tanggal', $hari_kerja_efektif->dates);
        $this->set('records', $records);
        $this->set('bulan', $bulan);
        $this->set('tahun', $tahun);
        $this->set('status_masuk', $this->config->item('status_masuk'));
        $this->set('status_pulang', $this->config->item('status_pulang'));
        $this->set('status', $this->config->item('status_absensi'));
        $this->set('lapor_masuk', $this->config->item('status_lapor_masuk'));
        $this->set('lapor_pulang', $this->config->item('status_lapor_pulang'));
        $this->set('lapor', $this->config->item('status_lapor_absensi'));
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
        parent::detail($id, array('abs_masuk_lapor'));
        $this->set('absensi', $this->config->item('lapor_masuk'));
        $this->set('bread_crumb', array(
            'back_end/' . $this->_name => $this->_header_title,
            '#' => 'Lapor Absensi'
        ));
    }

    public function plapor($id = FALSE) {
        parent::detail($id, array('abs_pulang_lapor'));
        $this->set('absensi', $this->config->item('lapor_pulang'));
        $this->set('bread_crumb', array(
            'back_end/' . $this->_name => $this->_header_title,
            '#' => 'Lapor Absensi'
        ));
    }

    public function lapor($id = FALSE) {
        parent::detail($id, array('abs_lapor'));
        $this->set('absensi', $this->config->item('lapor_absensi'));
        $this->set('bread_crumb', array(
            'back_end/' . $this->_name => $this->_header_title,
            '#' => 'Lapor Absensi'
        ));
    }

}
