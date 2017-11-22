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

    protected function get_user_detail($item = FALSE) {
        $response = parent::get_user_detail();
        return $response;
    }

    protected function after_login_success() {
        $this->get_user_detail();
        $data = $this->_call_api('pegawai/info', ["nip" => $this->user_detail['pegawai_nip']]);
        if ($data['code'] == 200 && $data['response']) {
            $info = $data['response'];
            $this->lmanuser->set_user_detail('idLokasi', $info->idLokasi);
            $this->lmanuser->set_user_detail('kabupaten', $info->kabupaten);
            $this->lmanuser->set_user_detail('nama_propinsi', $info->nama_propinsi);
            $this->lmanuser->set_user_detail('kd_tipe_jabatan', $info->kd_tipe_jabatan);
            $this->lmanuser->set_user_detail('tipe_jabatan', $info->tipe_jabatan);
            $this->lmanuser->set_user_detail('kd_jenis_jabatan', $info->kd_jenis_jabatan);
            $this->lmanuser->set_user_detail('kd_jabatan', $info->kd_jabatan);
            $this->lmanuser->set_user_detail('nama_jabatan', $info->nama_jabatan);
            $this->lmanuser->set_user_detail('kd_eselon', $info->kd_eselon);
            $this->lmanuser->set_user_detail('nama_eselon', $info->nama_eselon);
            $this->lmanuser->set_user_detail('kd_fungsional', $info->kd_fungsional);
            $this->lmanuser->set_user_detail('kd_instansi', $info->kd_instansi);
            $this->lmanuser->set_user_detail('nama_instansi', $info->nama_instansi);
            $this->lmanuser->set_user_detail('kd_organisasi', $info->kd_organisasi);
            $this->lmanuser->set_user_detail('nama_organisasi', $info->nama_organisasi);
            $this->lmanuser->set_user_detail('kd_satuan_organisasi', $info->kd_satuan_organisasi);
            $this->lmanuser->set_user_detail('nama_satuan_organisasi', $info->nama_satuan_organisasi);
            $this->lmanuser->set_user_detail('kd_unit_organisasi', $info->kd_unit_organisasi);
            $this->lmanuser->set_user_detail('nama_unit_organisasi', $info->nama_unit_organisasi);
            $this->lmanuser->set_user_detail('kd_unit_kerja', $info->kd_unit_kerja);
            $this->lmanuser->set_user_detail('nama_unit_kerja', $info->nama_unit_kerja);
        }
        $url = "http://" . $_SERVER['SERVER_NAME'] . "/presensi/back_end/home/landingpage";
        header('Location: ' . $url);
        exit;
    }

}
