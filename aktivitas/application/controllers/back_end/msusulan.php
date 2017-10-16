<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Msusulan extends Back_end {

    public $model = 'model_usulan_aktifitas';

    public function __construct() {
        parent::__construct('kelola_usulan_aktifitas', 'Daftar Usulan Aktifitas');
        $this->load->model(array(
            'model_master_aktifitas',
            'model_kelompok_aktifitas'
        ));
    }

    public function index() {
        parent::index();
        $this->set('bread_crumb', array(
            '#' => $this->_header_title
        ));
    }

    public function validasi($id = FALSE) {
        $posted_data = array('kelompok_id', 'dinas_id', 'aktifitas_kode', 'aktifitas_nama', 'aktifitas_output', 'aktifitas_waktu');

        if ($this->model_master_aktifitas->get_data_post(FALSE, $posted_data)) {
            if ($this->model_master_aktifitas->is_valid()) {
                $this->before_save_response = $this->before_save($posted_data);

                $saved_id = FALSE;
                if ($this->before_save_response !== FALSE) {
                    $saved_id = $this->model_master_aktifitas->save();
                }
                if ($saved_id) {
                    $usulan['usulan_status'] = 1;
                    $this->model_usulan_aktifitas->data_update($usulan, 'usulan_id =' . $id);
                    $this->attention_messages = 'Usulan aktifitas sudah divalidasi.';
                    redirect('back_end/' . $this->_name);
                }
                $this->attention_messages = 'Terdapat Kesalahan, Periksa kembali isian anda.';
            } else {
                $this->attention_messages = $this->model_master_aktifitas->errors->get_html_errors('<br />', 'line-wrap');
            }
        } else {
            $this->set('bread_crumb', array(
                'back_end/' . $this->_name => $this->_header_title,
                '#' => 'Validasi Usulan Aktifitas'
            ));
            $this->set('usulan', $this->model_usulan_aktifitas->get_detail('usulan_id = ' . $id));
            $this->set('kelompok', $this->model_kelompok_aktifitas->get_all());
            $this->set('dinas', (object) array(
                        (object) array(
                            'dinas_id' => 1,
                            'dinas_nama' => 'Dinas A'
                        ),
                        (object) array(
                            'dinas_id' => 2,
                            'dinas_nama' => 'Dinas B'
                        ),
                        (object) array(
                            'dinas_id' => 3,
                            'dinas_nama' => 'Dinas C'
                        ),
                        (object) array(
                            'dinas_id' => 4,
                            'dinas_nama' => 'Dinas D'
                        )
            ));
        }
    }

}
