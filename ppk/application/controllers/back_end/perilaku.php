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

class Perilaku extends Back_end {

    public $model = 'model_tr_perilaku';

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

    public function penilaian($pegawai_id = FALSE, $tahun = FALSE, $bulan = FALSE) {
        if ($pegawai_id && $tahun && $bulan) {
            $id = $this->model_tr_perilaku->check_data($pegawai_id, $tahun, $bulan);
            parent::detail($id, array("pegawai_id", "perilaku_bulan", "perilaku_tahun", "perilaku_pelayanan", "perilaku_integritas", "perilaku_komitmen", "perilaku_disiplin", "perilaku_kerjasama", "perilaku_kepemimpinan"));
            $this->load->model('model_master_pegawai');
            $this->set('pegawai', $this->model_master_pegawai->get_pegawai_by_id($pegawai_id));
            $this->set('bulan', $bulan);
            $this->set('tahun', $tahun);
            $this->set("bread_crumb", array(
                "back_end/" . $this->_name => $this->_header_title,
                "#" => 'Penilaian Perilaku Pegawai'
            ));
        } else {
            redirect('back_end/perilaku');
        }
    }

}
