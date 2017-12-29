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
        $this->load->model('model_tr_lapor_masuk');
        $posted_data = array('abs_id', 'lm_lapor');
        if ($this->model_tr_lapor_masuk->get_data_post(FALSE, $posted_data)) {
            if ($this->model_tr_lapor_masuk->is_valid()) {
                $saved_id = $this->model_tr_lapor_masuk->save();
                $this->saved_id = $id;
                if (!$id) {
                    $id = $saved_id;
                    $this->saved_id = $saved_id;
                }
                $this->upload_laporan_masuk_dokumen($id);
                $this->attention_messages = "Data baru telah disimpan.";
                redirect('back_end/' . $this->_name);
                $this->attention_messages = "Terdapat Kesalahan, Periksa kembali isian anda.";
            } else {
                $this->attention_messages = $this->model_tr_lapor_masuk->errors->get_html_errors("<br />", "line-wrap");
            }
        }
        $detail = $this->{$this->model}->show_detail($id);
        $this->set("detail", $detail);
        $this->set('absensi', $this->config->item('lapor_masuk'));
        $this->set('bread_crumb', array(
            'back_end/' . $this->_name => $this->_header_title,
            '#' => 'Lapor Absensi'
        ));
    }

    public function upload_laporan_masuk_dokumen($id = FALSE) {
        
    }

    public function plapor($id = FALSE) {
        $this->load->model('model_tr_lapor_pulang');
        $posted_data = array('abs_id', 'lp_lapor');
        if ($this->model_tr_lapor_pulang->get_data_post(FALSE, $posted_data)) {
            if ($this->model_tr_lapor_pulang->is_valid()) {
                $saved_id = $this->model_tr_lapor_pulang->save();
                $this->saved_id = $id;
                if (!$id) {
                    $id = $saved_id;
                    $this->saved_id = $saved_id;
                }
                $this->upload_laporan_pulang_dokumen($id);
                $this->attention_messages = "Data baru telah disimpan.";
                redirect('back_end/' . $this->_name);
                $this->attention_messages = "Terdapat Kesalahan, Periksa kembali isian anda.";
            } else {
                $this->attention_messages = $this->model_tr_lapor_pulang->errors->get_html_errors("<br />", "line-wrap");
            }
        }
        $detail = $this->{$this->model}->show_detail($id);
        $this->set("detail", $detail);
        $this->set('absensi', $this->config->item('lapor_pulang'));
        $this->set('bread_crumb', array(
            'back_end/' . $this->_name => $this->_header_title,
            '#' => 'Lapor Absensi'
        ));
    }

    public function upload_laporan_pulang_dokumen($id = FALSE) {
        
    }

    public function lapor($id = FALSE) {
        $this->load->model('model_tr_lapor_absensi');
        $posted_data = array('abs_id', 'la_lapor');
        if ($this->model_tr_lapor_absensi->get_data_post(FALSE, $posted_data)) {
            if ($this->model_tr_lapor_absensi->is_valid()) {
                $saved_id = $this->model_tr_lapor_absensi->save();
                $this->saved_id = $id;
                if (!$id) {
                    $id = $saved_id;
                    $this->saved_id = $saved_id;
                }
                $this->upload_laporan_absensi_dokumen($id);
                $this->attention_messages = "Data baru telah disimpan.";
                redirect('back_end/' . $this->_name);
                $this->attention_messages = "Terdapat Kesalahan, Periksa kembali isian anda.";
            } else {
                $this->attention_messages = $this->model_tr_lapor_absensi->errors->get_html_errors("<br />", "line-wrap");
            }
        }
        $detail = $this->{$this->model}->show_detail($id);
        $this->set("detail", $detail);
        $this->set('absensi', $this->config->item('lapor_absensi'));
        $this->set('bread_crumb', array(
            'back_end/' . $this->_name => $this->_header_title,
            '#' => 'Lapor Absensi'
        ));
    }

    public function upload_laporan_absensi_dokumen($id = FALSE) {
        
    }

}
