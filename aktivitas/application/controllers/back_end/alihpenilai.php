<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of anggota
 *
 * @author Rinaldi
 */
class Alihpenilai extends Back_end {

    public $model = 'model_master_alih_penilai';

    public function __construct() {
        parent::__construct('kelola_master_alih_penilai', 'Pengalihan Penilai');
//        $this->load->model(array("model_user", "model_backbone_user", "model_backbone_profil", "model_backbone_user_role", "model_backbone_role"));
    }

    public function index() {
        parent::index();
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => 'Daftar ' . $this->_header_title
        ));
    }

    public function detail($id = FALSE) {
        parent::detail($id, array('pegawai_id', 'penilai_id'));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => 'Daftar ' . $this->_header_title,
            "#" => 'Formulir ' . $this->_header_title
        ));
        $this->load->model('model_master_pegawai');
        $pegawais = $this->model_master_pegawai->get_all();
//        $pegawais = array(
//            array(
//                'id' => '112',
//                'nip' => '1128218229129',
//                'nama' => 'Budi Sularso'
//            ),
//            array(
//                'id' => '113',
//                'nip' => '1128218229130',
//                'nama' => 'Rudi Suhartono'
//            )
//        );
        $this->set('pegawais', $pegawais);
    }

}
