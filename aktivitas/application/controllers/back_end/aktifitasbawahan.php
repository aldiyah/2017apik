<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aktifitasbawahan extends Back_end {

    public $model = 'model_tr_aktifitas';

    public function __construct() {
        parent::__construct('kelola_aktivitas_bawahan', 'Aktivitas Bawahan');
        $this->load->model(array(
            'model_master_pegawai',
            'model_tr_aktifitas'
        ));
    }

    public function index() {
//        $profil = array(
//            'nip' => $this->pegawai_nip,
//            'kd_eselon' => $this->kode_eselon,
//            'kd_instansi' => $this->kode_instansi,
//            'kd_organisasi' => $this->kode_organisasi,
//            'kd_satuan_organisasi' => $this->kode_satuan_organisasi,
//            'kd_unit_organisasi' => $this->kode_unit_organisasi
//        );
//        $data = $this->_call_api('pegawai/get_bawahan', $profil);
        $bawahan = isset($this->user_detail['bawahan']) ? $this->user_detail['bawahan'] : FALSE;
        $arr_nip_bawahan = array();
        if ($bawahan) {
            foreach ($bawahan as $row) {
                $arr_nip_bawahan[] = $row->NIP;
            }
        }
        $records = $this->model_master_pegawai->get_all_bawahan_by_nip(implode("','", $arr_nip_bawahan))->record_set;
//        $this->load->model('model_master_alih_penilai');
//        $pegawai = $this->model_master_alih_penilai->get_bawahan($this->user_detail['pegawai_id']);
        $bulan = $this->input->get('bulan', TRUE);
        $tahun = $this->input->get('tahun', TRUE);
        $this->set('bulan', $bulan ? $bulan : date('n'));
        $this->set('tahun', $tahun ? $tahun : date('Y'));
        $this->set('records', $records);
        $this->set('keyword', NULL);
        $this->set('additional_js', "back_end/" . $this->_name . '/js/index_js');
        $this->set("bread_crumb", array(
            "#" => 'Daftar ' . $this->_header_title
        ));
    }

//    public function get_api($path = FALSE) {
//        switch ($path) {
//            case 'skpdAutoComplete':
//                $params = array('skpdAutoCompleteIn' => array('namaOrganisasi' => 'SEKRETARIAT'));
//                break;
//            case 'nipAutoComplete':
//                $params = array('nipAutoCompleteIn' => array('nip' => '197001222'));
//                break;
//            case 'anakBuah':
//                $params = array('anakBuahIn' => array('parent' => '200108', 'kdOrganisasi' => '367401000000'));
//                break;
//        }
//        $data = $this->_call_api($path, $params);
//        var_dump($data);
//    }
//
    public function lihataktifitas($id_pegawai, $tahun, $bulan) {
        $data['aktifitas'] = $this->model_tr_aktifitas->get_aktifitas($id_pegawai, $tahun, $bulan)->record_set;
        return $this->load->view('back_end/aktifitasbawahan/lihataktifitas', $data);
    }

}
