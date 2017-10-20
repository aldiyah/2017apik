<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * pperilaku.php
 * Oct 20, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Pperilaku extends Back_end {

    protected $auto_load_model = FALSE;

    public function __construct() {
        parent::__construct('penilaian_perilaku', 'Penilaian Perilaku');
    }

    public function index() {
        $bln = $this->input->get('bulan', TRUE);
        $thn = $this->input->get('tahun', TRUE);
        $bulan = $bln ? $bln : date('n');
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
        $list_bawahan = isset($data['response']) ? $data['response'] : FALSE;
        $arr_nip_bawahan = array();
        if ($list_bawahan) {
            foreach ($list_bawahan as $row) {
                $arr_nip_bawahan[] = $row->nip;
            }
        }
        $this->load->model('model_master_pegawai');
        $records = $this->model_master_pegawai->get_all_perilaku_bawahan(implode("','", $arr_nip_bawahan), $tahun, $bulan);
        $this->set('records', $records->record_set);
        $this->set('total_record', $records->record_found);
        $this->set('keyword', $records->keyword);
        $this->set('bulan', $bulan);
        $this->set('tahun', $tahun);
//        $this->set("additional_js", "back_end/" . $this->_name . "/js/index_js");
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function detail($tahun = 0, $bulan = 0, $pegawai_id = FALSE) {
        $nilai = $this->input->post('perilaku', TRUE);
        if ($nilai) {
            $data = array();
            foreach ($nilai as $key => $value) {
                $data[] = array(
                    'pegawai_id' => $pegawai_id,
                    'pperilaku_bulan' => $bulan,
                    'pperilaku_tahun' => $tahun,
                    'perilaku_id' => $key,
                    'pperilaku_nilai' => $value
                );
            }
            $this->load->model('model_tr_perilaku');
            if ($this->model_tr_perilaku->save_data($data)) {
                redirect('back_end/pperilaku');
            }
        }
        $this->load->model(array('model_master_pegawai', 'model_master_perilaku'));
        $this->set('pegawai', $this->model_master_pegawai->get_pegawai_by_id($pegawai_id));
        $this->set('perilaku', $this->model_master_perilaku->get_all());
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Formulir Data Perilaku'
        ));
    }

    public function get_like() {
        $keyword = $this->input->post("keyword");
        $data_found = $this->{$this->model}->get_like($keyword, $id_skpd);
        $this->to_json($data_found);
    }

}
