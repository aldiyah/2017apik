<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mstpp extends Back_end {

    public $model = 'model_master_tpp';

    public function __construct() {
        parent::__construct('kelola_master_tpp', 'Master TPP');
        $this->load->model('model_master_pegawai');
    }

    public function index() {
        parent::index();
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function detail($id = FALSE) {
//        parent::detail($id, array("kelompok_id", "dinas_id", "aktifitas_kode", "aktifitas_nama", "aktifitas_output", "aktifitas_waktu"));
        parent::detail($id, array("pegawai_id", "tpp_beban_kerja", "tpp_objective", "tahun"));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Formulir ' . $this->_header_title
        ));
        $this->set('pegawai', $this->model_master_pegawai->get_all());
//        $this->load->model('model_kelompok_aktifitas');
//        $this->set('dinas', (object) array(
//                    (object) array(
//                        'dinas_id' => 1,
//                        'dinas_nama' => 'Dinas A'
//                    ),
//                    (object) array(
//                        'dinas_id' => 2,
//                        'dinas_nama' => 'Dinas B'
//                    ),
//                    (object) array(
//                        'dinas_id' => 3,
//                        'dinas_nama' => 'Dinas C'
//                    ),
//                    (object) array(
//                        'dinas_id' => 4,
//                        'dinas_nama' => 'Dinas D'
//                    )
//        ));
    }

    public function get_like() {
        $keyword = $this->input->post("keyword");
        $kelompok_found = $this->model_master_aktifitas->get_like($keyword);
        $this->to_json($kelompok_found);
    }

}
