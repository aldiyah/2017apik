<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * vcuti.php
 * Nov 12, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Vcuti extends Back_end {

    protected $auto_load_model = FALSE;

    public function __construct() {
        parent::__construct('validasi_cuti', 'Validasi Izin Cuti');
        $this->load->model('model_tr_cuti');
    }

    public function index() {
        parent::index();
        $thn = $this->input->get('tahun', TRUE);
        $tahun = $thn ? $thn : date('Y');
        $profil = array(
            'nip' => $this->pegawai_nip,
            'kd_eselon' => $this->kode_eselon,
            'kd_instansi' => $this->kode_instansi,
            'kd_organisasi' => $this->kode_organisasi,
            'kd_satuan_organisasi' => $this->kode_satuan_organisasi,
            'kd_unit_organisasi' => $this->kode_unit_organisasi
        );
        $data = $this->_call_api('pegawai/get_bawahan', $profil);
        $bawahan = isset($data['response']) ? $data['response'] : FALSE;
        $arr_nip_bawahan = array();
        if ($bawahan) {
            foreach ($bawahan as $row) {
                $arr_nip_bawahan[] = $row->nip;
            }
        }
        $records = $arr_nip_bawahan ? $this->model_tr_cuti->get_validasi(implode("','", $arr_nip_bawahan), $tahun) : FALSE;
        $this->set('records', $records ? $records->record_set : FALSE);
        $this->set('total_record', $records ? $records->record_found : 0);
        $this->set('keyword', $records ? $records->keyword : '');
        $this->set('tahun', $tahun);
        $this->set('jenis_cuti', $this->config->item('jenis_cuti'));
        $this->set('bread_crumb', array(
            '#' => $this->_header_title
        ));
    }

    public function validasi($id) {
        if ($this->model_tr_cuti->update_status($id, 2)) {
            $this->set_attention_message('Validasi berhasil...');
        } else {
            $this->set_attention_message('Validasi gagal dilakukan...');
        }
        redirect('back_end/vcuti');
    }

    public function reject($id) {
        if ($this->model_tr_cuti->update_status($id, 3)) {
            $this->set_attention_message('Penolakan berhasil...');
        } else {
            $this->set_attention_message('Penolakan gagal dilakukan...');
        }
        redirect('back_end/vcuti');
    }

}
