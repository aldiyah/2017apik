<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * vabsensi.php
 * Nov 15, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Vabsensi extends Back_end {

    protected $auto_load_model = FALSE;

    public function __construct() {
        parent::__construct('validasi_bawahan', 'Validasi Bawahan');
        $this->load->model('model_tr_absensi');
    }

    public function index() {
        $thn = $this->input->get('tahun', TRUE);
        $tahun = $thn ? $thn : date('Y');
//        $profil = array(
//            'nip' => $this->pegawai_nip,
//            'kd_eselon' => $this->kode_eselon,
//            'kd_instansi' => $this->kode_instansi,
//            'kd_organisasi' => $this->kode_organisasi,
//            'kd_satuan_organisasi' => $this->kode_satuan_organisasi,
//            'kd_unit_organisasi' => $this->kode_unit_organisasi
//        );
//        $data = $this->_call_api('pegawai/get_bawahan', ["nip" => $this->pegawai_nip]);
//        $bawahan = isset($this->user_detail['bawahan']) ? $this->user_detail['bawahan'] : FALSE;
//        $arr_nip_bawahan = array();
//        if ($bawahan) {
//            foreach ($bawahan as $row) {
//                $arr_nip_bawahan[] = $row->NIP;
//            }
//        }
//        $this->load->model('model_tr_lapor_upacara');
        $this->load->model(array('model_tr_lapor_masuk', 'model_tr_lapor_pulang', 'model_tr_lapor_absensi'));
//        $records = $arr_nip_bawahan ? $this->model_tr_absensi->get_validasi(implode("','", $arr_nip_bawahan), $tahun) : FALSE;
//        $records = $this->model_tr_lapor_masuk->get_validasi_bawahan($this->pegawai_id);
//        var_dump($records);
//        exit();
        $this->set('masuk', $this->model_tr_lapor_masuk->get_validasi_bawahan($this->pegawai_id)->record_set);
        $this->set('pulang', $this->model_tr_lapor_pulang->get_validasi_bawahan($this->pegawai_id)->record_set);
        $this->set('absensi', $this->model_tr_lapor_absensi->get_validasi_bawahan($this->pegawai_id)->record_set);
//        $this->set('records', $records ? $records->record_set : FALSE);
//        $this->set('total_record', $records ? $records->record_found : 0);
//        $this->set('keyword', $records ? $records->keyword : '');
        $this->set('tahun', $tahun);
        $this->set('lapor_masuk', $this->config->item('lapor_masuk'));
        $this->set('lapor_pulang', $this->config->item('lapor_pulang'));
        $this->set('lapor_absensi', $this->config->item('lapor_absensi'));
        $this->set('bread_crumb', array(
            '#' => $this->_header_title
        ));
    }

    public function validasi($jenis, $id, $validasi) {
        $validator = array(
            'setuju' => 1,
            'tolak' => 2
        );
        if (array_key_exists($validasi, $validator)) {
            $this->load->model(array('model_tr_lapor_masuk', 'model_tr_lapor_pulang', 'model_tr_lapor_absensi'));
            switch ($jenis) {
                case 'm': $this->model_tr_lapor_masuk->validasi($id, $validator[$validasi]);
                    break;
                case 'p': $this->model_tr_lapor_pulang->validasi($id, $validator[$validasi]);
                    break;
                case 'a': $this->model_tr_lapor_absensi->validasi($id, $validator[$validasi]);
                    break;
                case 'u': $this->model_tr_lapor_upacara->validasi($id, $validator[$validasi]);
                    break;
            }
            $this->attention_messages = "Sukses melakukan validasi absensi pegawai."; // PR nih
        } else {
            $this->attention_messages = "Terdapat Kesalahan, Periksa kembali isian anda.";
        }
        redirect('back_end/' . $this->_name);
    }

}
