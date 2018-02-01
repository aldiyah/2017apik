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
    protected $user_profil = NULL;

    public function __construct() {

        parent::__construct();
        $this->load->model(array("model_user", "model_backbone_user", "model_backbone_profil", "model_backbone_user_role", "model_backbone_role"));
    }

//    protected function get_user_detail($item = FALSE) {
//        $response = parent::get_user_detail();
//        return $response;
//    }
//
    protected function after_login_success() {
//        $this->get_user_detail();
//        $data = $this->_call_api('get_profile', ["nip" => $this->user_detail['pegawai_nip']]);
////        var_dump($data);
//        if (!empty($data)) {
//            $info = $data['profile'][0];
//            $this->lmanuser->set_user_detail('nama_jabatan', $info->jabatan);
//            $this->lmanuser->set_user_detail('nama_eselon', $info->eselon);
//            $this->lmanuser->set_user_detail('nama_organisasi', $info->opd);
//        }
//        $atasan = $this->_call_api('get_atasan', ["nip" => $this->user_detail['pegawai_nip']]);
////        var_dump($atasan);
//        if (!empty($atasan)) {
//            $this->lmanuser->set_user_detail('atasan', $atasan['atasan']);
//        }
//        $bawahan = $this->_call_api('get_bawahan', ["nip" => $this->user_detail['pegawai_nip']]);
////        var_dump($bawahan);
//        if (!empty($bawahan)) {
//            $this->lmanuser->set_user_detail('bawahan', $bawahan['bawahan']);
//        }
////        var_dump($this->get_user_detail());
////        exit();
////        $data = $this->_call_api('pegawai/info', ["nip" => $this->user_detail['pegawai_nip']]);
////        if ($data['code'] == 200 && $data['response']) {
////            $info = $data['response'];
////            $this->lmanuser->set_user_detail('idLokasi', $info->idLokasi);
////            $this->lmanuser->set_user_detail('kabupaten', $info->kabupaten);
////            $this->lmanuser->set_user_detail('nama_propinsi', $info->nama_propinsi);
////            $this->lmanuser->set_user_detail('kd_tipe_jabatan', $info->kd_tipe_jabatan);
////            $this->lmanuser->set_user_detail('tipe_jabatan', $info->tipe_jabatan);
////            $this->lmanuser->set_user_detail('kd_jenis_jabatan', $info->kd_jenis_jabatan);
////            $this->lmanuser->set_user_detail('kd_jabatan', $info->kd_jabatan);
////            $this->lmanuser->set_user_detail('nama_jabatan', $info->nama_jabatan);
////            $this->lmanuser->set_user_detail('kd_eselon', $info->kd_eselon);
////            $this->lmanuser->set_user_detail('nama_eselon', $info->nama_eselon);
////            $this->lmanuser->set_user_detail('kd_fungsional', $info->kd_fungsional);
////            $this->lmanuser->set_user_detail('kd_instansi', $info->kd_instansi);
////            $this->lmanuser->set_user_detail('nama_instansi', $info->nama_instansi);
////            $this->lmanuser->set_user_detail('kd_organisasi', $info->kd_organisasi);
////            $this->lmanuser->set_user_detail('nama_organisasi', $info->nama_organisasi);
////            $this->lmanuser->set_user_detail('kd_satuan_organisasi', $info->kd_satuan_organisasi);
////            $this->lmanuser->set_user_detail('nama_satuan_organisasi', $info->nama_satuan_organisasi);
////            $this->lmanuser->set_user_detail('kd_unit_organisasi', $info->kd_unit_organisasi);
////            $this->lmanuser->set_user_detail('nama_unit_organisasi', $info->nama_unit_organisasi);
////            $this->lmanuser->set_user_detail('kd_unit_kerja', $info->kd_unit_kerja);
////            $this->lmanuser->set_user_detail('nama_unit_kerja', $info->nama_unit_kerja);
////        }
//        var_dump($info, $this->lmanuser);
//        exit();
        $this->lmanuser->set_user_detail('user_foto', $this->user_profil->foto_url);
        $this->lmanuser->set_user_detail('nama_jabatan', $this->user_profil->data_akhir->nama_jabatan);
        $this->lmanuser->set_user_detail('nama_organisasi', $this->user_profil->data_akhir->nama_organisasi);
        if (!empty($this->user_profil->atasan)) {
            $atasan = array();
            foreach ($this->user_profil->atasan as $row) {
                $a = array_map('trim', array_keys((array) $row));
                $b = array_map('trim', (array) $row);
                $atasan[] = array_combine($a, $b);
            }
            if (isset($atasan[0])) {
                $this->lmanuser->set_user_detail('atasan_langsung', $atasan[0]);
            }
            if (isset($atasan[1])) {
                $this->lmanuser->set_user_detail('atasan_atasan', $atasan[1]);
            }
        }
        if (!empty($this->user_profil->bawahan)) {
            $bawahan = array();
            foreach ($this->user_profil->bawahan as $row) {
                $a = array_map('trim', array_keys((array) $row));
                $b = array_map('trim', (array) $row);
                $bawahan[] = array_combine($a, $b);
            }
            $this->lmanuser->set_user_detail('bawahan', $bawahan);
        }
        $url = "http://" . $_SERVER['SERVER_NAME'] . "/presensi/back_end/home/landingpage";
        header('Location: ' . $url);
        exit;
    }

    public function login() {
        if ($this->is_authenticated()) {
            $this->go_to_session_location();
        }

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        if (!empty($username) && !empty($password)) {
            $data = array('u' => sha1($username), 'p' => sha1(md5($password)), 't' => sha1('apik'));
            $login = $this->_call_api('login', $data);
//            var_dump($login['data']);
//            exit();
            if ($login['status'] == 1) {
                $user = $login['data']->user;
                $this->load->model(array('model_user', 'model_backbone_user', 'model_backbone_user_role', 'model_backbone_profil', 'model_master_pegawai'));
                $ada = $this->model_user->get_user_detail_username($username);
                if (!$ada) {
                    $user_data = array(
                        'username' => $username,
                        'password' => $this->lmanuser->generate_password($username, $password)
                    );
                    $id_user = $this->model_backbone_user->data_insert($user_data);
                    $profil_data = array(
                        'id_user' => $id_user,
                        'nama_profil' => $user->nama,
                        'email_profil' => $user->email
                    );
                    $id_profil = $this->model_backbone_profil->data_insert($profil_data);
                    $pegawai_data = array(
                        'pegawai_id' => $user->id,
                        'id_profil' => $id_profil,
                        'pegawai_nip' => $username,
                        'pegawai_nama' => $user->nama,
                        'id_organisasi' => $login->data->data_akhir->id_organisasi
                    );
                    $this->model_master_pegawai->data_insert($pegawai_data);
                    $this->model_backbone_user_role->save($id_user, 5);
                    if (!empty($login['data']->bawahan)) {
                        $this->model_backbone_user_role->save($id_user, 4);
                    }
                } else {
                    if ($login['data']->data_akhir->id_organisasi != $ada->id_organisasi) {
                        $data_pegawai = array(
                            'id_organisasi' => $login['data']->data_akhir->id_organisasi
                        );
                        $this->model_master_pegawai->data_update($data_pegawai, 'pegawai_id = ' . $ada->pegawai_id);
                    }
                }
                $this->user_profil = $login['data'];

                // Cek role

                $roles = $this->model_backbone_user_role->get_roles_by_user($ada->id_user);
//                var_dump($ada, $roles);
//                exit();
            }
        }

        $login_success = FALSE;
        $this->attention_messages = "";
        $this->model_user->set_login_rules();
        if ($this->model_user->get_data_post()) {
            if ($this->model_user->login($this->my_side)) {
                $login_success = TRUE;
            } else {
                if ($ada && $login['status'] == 1) {
                    $id_user = $ada->id_user;
                    $user_data = array(
                        'username' => $username,
                        'password' => $this->lmanuser->generate_password($username, $password)
                    );
                    $this->model_backbone_user->data_update($user_data, 'id_user = ' . $id_user);
                    $login_success = TRUE;
                } else {
                    $this->attention_messages = $this->model_user->errors->get_html_errors("<br />", "line-wrap");
                    if (trim($this->attention_messages) == "<div id=\"model_error\" class=\"line-wrap\"></div>") {
                        $this->attention_messages = "<div id=\"model_error\" class=\"line-wrap\">Username atau password tidak ditemukan.</div>";
                    }
                }
            }
        }

        if ($login_success) {
            $this->after_login_success();
            $this->go_to_session_location();
        }

        $this->set_login_layout();

        if ($this->is_front_end && $this->front_end_css_files) {
            $this->add_cssfiles($this->front_end_css_files);
        } else {
            if ($login_success) {
                redirect("/");
            }
        }
        $this->set('login_success', $login_success);
        $this->set('model_user_attributes', $this->model_user->get_attributes());
    }

}
