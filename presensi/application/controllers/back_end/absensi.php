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
        $this->load->helper('perwal');
        $this->get_attention_message_from_session();
        $conditions = 'EXTRACT(MONTH FROM abs_tanggal) = ' . date('m');
        $conditions .= ' AND pegawai_id = ' . $this->pegawai_id;
        $records = $this->model_tr_absensi->all($conditions);
        $this->set('records', $records->record_set);
        $this->set('bread_crumb', array(
            '#' => $this->_header_title
        ));
    }

    public function lapor($id = FALSE) {
        parent::detail($id, array('absensi_id'));
        $this->load->model('model_jenis_absensi');
        $this->set('absensi', $this->model_jenis_absensi->all('absensi_id <> 1')->record_set);
        $this->set('bread_crumb', array(
            'back_end/' . $this->_name => $this->_header_title,
            '#' => 'Lapor Absensi'
        ));
    }

}
