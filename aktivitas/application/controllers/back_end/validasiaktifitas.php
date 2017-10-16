<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Validasiaktifitas extends Back_end {

    public $model = 'model_tr_aktifitas';

    public function __construct() {
        parent::__construct('kelola_validasi_aktifitas', 'Validasi Aktivitas');
        $this->load->model(array(
            'model_master_pegawai',
            'model_tr_aktifitas'
        ));
    }

    public function index() {
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

        $batas = date('Y-m-d', mktime(0, 0, 0, date('n'), date('j') - 100, date('Y')));
        $this->load->model('model_master_alih_penilai');

        $records = $this->model_tr_aktifitas->validasi_aktifitas(implode("','", $arr_nip_bawahan), $batas);
        $this->set('records', $records);
        $this->set('keyword', NULL);
        $this->set('additional_js', 'back_end/' . $this->_name . '/js/index_js');
        $this->set("bread_crumb", array(
            "#" => 'Daftar ' . $this->_header_title
        ));
    }

    public function validasi($id) {
        if ($this->model_tr_aktifitas->validasi($id, 1)) {
            $this->set_attention_message('Validasi berhasil...');
        } else {
            $this->set_attention_message('Validasi gagal dilakukan...');
        }
        redirect('back_end/validasiaktifitas');
    }

    public function reject($id) {
        if ($this->model_tr_aktifitas->validasi($id, 2)) {
            $this->set_attention_message('Penolakan berhasil...');
        } else {
            $this->set_attention_message('Penolakan gagal dilakukan...');
        }
        redirect('back_end/validasiaktifitas');
    }

}
