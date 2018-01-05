<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * anggota.php
 * September 16, 2017
 */

class Anggota extends Back_end {

    protected $auto_load_model = FALSE;

    public function __construct() {

        parent::__construct();
        $this->load->model(array("model_user", "model_backbone_user", "model_backbone_profil", "model_backbone_user_role", "model_backbone_role"));
    }

    protected function after_login_success() {
        $this->get_user_detail();
        $data = $this->_call_api('get_profile', ["nip" => $this->user_detail['pegawai_nip']]);
        if (!empty($data)) {
            $info = $data['profile'][0];
            $this->lmanuser->set_user_detail('nama_jabatan', $info->jabatan);
            $this->lmanuser->set_user_detail('nama_eselon', $info->eselon);
            $this->lmanuser->set_user_detail('nama_organisasi', $info->opd);
        }
        $atasan = $this->_call_api('get_atasan', ["nip" => $this->user_detail['pegawai_nip']]);
        if (!empty($atasan)) {
            $this->lmanuser->set_user_detail('atasan', $atasan['atasan']);
        }
        $bawahan = $this->_call_api('get_bawahan', ["nip" => $this->user_detail['pegawai_nip']]);
        if (!empty($bawahan)) {
            $this->lmanuser->set_user_detail('bawahan', $bawahan['bawahan']);
        }
        $url = "http://" . $_SERVER['SERVER_NAME'] . "/presensi/back_end/home/landingpage";
        header('Location: ' . $url);
        exit;
    }

    public function login() {
        $url = "http://" . $_SERVER['SERVER_NAME'] . "/aktivitas/login";
        header('Location: ' . $url);
        exit;
    }

}
