<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Back_end {

    protected $auto_load_model = FALSE;

    public function can_access() {
        return TRUE;
    }

    public function __construct() {
        parent::__construct();
        $this->load->model(array(
            'model_master_pegawai',
            'model_tr_aktifitas'
        ));
    }

    public function landingpage() {
        $this->_layout = 'atlant_landing';

        /**
          protected 'pegawai_id' => int 0
          protected 'pegawai_nip' => int 0
          protected 'kode_jabatan' => int 0
          protected 'kode_organisasi' => int 0
         * 
         */
    }

    public function to_presensi() {
        $url = "http://" . $_SERVER['SERVER_NAME'] . "/2017apik/presensi/";
        header('Location: ' . $url);
        exit;
    }

    public function to_ppk() {
        $url = "http://" . $_SERVER['SERVER_NAME'] . "/2017apik/skp/";
        header('Location: ' . $url);
        exit;
    }

    public function to_aktivitas() {
        redirect('back_end/home');
    }

    public function index() {
        parent::index();
        // Hitung TPP
        $id_pegawai = isset($this->user_detail['pegawai_id']) && $this->user_detail['pegawai_id'] != NULL ? $this->user_detail['pegawai_id'] : 0;
        $this->load_model('model_master_tpp');
        $data_tpp = $this->model_master_tpp->get_detail('master_tpp.pegawai_id = ' . $id_pegawai);
        $hari_kerja_efektif = 20;
        $tpp_harian = $data_tpp ? $data_tpp->tpp_beban_kerja * 0.3 / $hari_kerja_efektif : 0;
        $bln = date('n');
        $thn = date('Y');

        $aktifitas = $this->model_tr_aktifitas->get_rekap_bulanan($id_pegawai, $bln, $thn);
        $total_tpp = 0;
        if ($aktifitas) {
            foreach ($aktifitas as $row) {
                $waktu = $row->aktifitas_waktu * $row->tr_aktifitas_volume;
                $total_tpp += ($waktu > 300 ? 1 : $waktu / 300) * $tpp_harian;
            }
        }
        $this->set('total_tpp', $total_tpp);

        // Total Aktifitas Bulan Ini

        $this->load->model('model_tr_aktifitas');
        $this->set('total_aktivitas', $this->model_tr_aktifitas->count_aktifitas($this->pegawai_id, $bln, $thn));
        $this->set('total_ditolak', $this->model_tr_aktifitas->count_aktifitas($this->pegawai_id, $bln, $thn, 2));

        // Total Aktifitas Ditolak Bulan Ini
    }

}
