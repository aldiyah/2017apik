<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Back_end extends Lwpustaka_data {

    protected $backend_controller_location = "back_end/";
    protected $myid = 0;
    protected $pegawai_id = 0;
    protected $pegawai_nip = 0;
//    protected $kode_eselon = 0;
//    protected $kode_jabatan = 0;
//    protected $kode_instansi = 0;
//    protected $kode_organisasi = 0;
//    protected $kode_satuan_organisasi = 0;
//    protected $kode_unit_organisasi = 0;
    protected $resource_api_link = NULL;
    protected $saved_id = FALSE;
    public $perwal = NULL;

    protected function after_login_success() {
        
    }

    public function __construct($cmodul_name = FALSE, $header_title = FALSE) {
        $this->is_front_end = FALSE;
        parent::__construct($cmodul_name, $header_title);
        $this->_layout = $this->config->item('application_active_layout');
        $this->resource_api_link = $this->config->item('resource_api_link');
        $this->init_back_end();

        $called_class = get_called_class();

        if (!$this->is_authenticated() && $called_class != "Anggota") {
            redirect('login');
        }
        $this->myid = $this->user_detail['id_user'];
        $this->pegawai_id = is_array($this->user_detail) && array_key_exists('pegawai_id', $this->user_detail) && $this->user_detail['pegawai_id'] != NULL ? $this->user_detail['pegawai_id'] : 0;
        $this->pegawai_nip = is_array($this->user_detail) && array_key_exists('pegawai_nip', $this->user_detail) ? $this->user_detail['pegawai_nip'] : '';
//        $this->kode_eselon = is_array($this->user_detail) && array_key_exists('kd_eselon', $this->user_detail) ? $this->user_detail['kd_eselon'] : '';
//        $this->kode_jabatan = is_array($this->user_detail) && array_key_exists('kd_jabatan', $this->user_detail) ? $this->user_detail['kd_jabatan'] : '';
//        $this->kode_instansi = is_array($this->user_detail) && array_key_exists('kd_instansi', $this->user_detail) ? $this->user_detail['kd_instansi'] : '';
//        $this->kode_organisasi = is_array($this->user_detail) && array_key_exists('kd_organisasi', $this->user_detail) ? $this->user_detail['kd_organisasi'] : '';
//        $this->kode_satuan_organisasi = is_array($this->user_detail) && array_key_exists('kd_satuan_organisasi', $this->user_detail) ? $this->user_detail['kd_satuan_organisasi'] : '';
//        $this->kode_unit_organisasi = is_array($this->user_detail) && array_key_exists('kd_unit_organisasi', $this->user_detail) ? $this->user_detail['kd_unit_organisasi'] : '';
        $this->set('access_rules', $this->access_rules());
//        $this->set('user_detail', $this->user_detail);
        $this->perwal = $this->config->item('perwal');
        $this->set('referer', $this->agent->referrer());
    }

    protected function after_detail($id = FALSE) {
        return;
    }

    protected function detail($id = FALSE, $posted_data = array(), $parent_id = FALSE) {
//        var_dump(array_diff(array_keys($_POST), $posted_data), $this->{$this->model}->get_data_post(FALSE, $posted_data), $this->{$this->model}->is_valid(), $this->{$this->model});exit;
        if ($this->{$this->model}->get_data_post(FALSE, $posted_data)) {
            if ($this->{$this->model}->is_valid()) {

                $this->before_save_response = $this->before_save($posted_data);

                $saved_id = FALSE;
                if ($this->before_save_response !== FALSE) {
                    $saved_id = $this->save_detail($id);
                }

                $this->after_save_response = $this->after_save($id, $saved_id);

                $this->saved_id = $id;
                if (!$id) {
                    $id = $saved_id;
                    $this->saved_id = $saved_id;
                }

                $this->after_detail($id);

                if ($this->before_save_response) {
                    $this->attention_messages = "Data baru telah disimpan.";
                    if ($id) {
                        $this->attention_messages = "Perubahan telah disimpan.";
                    }
                    if ($parent_id) {
                        redirect('back_end/' . $this->_name . '/index/' . $parent_id);
                    }
                    redirect('back_end/' . $this->_name);
                }
                $this->attention_messages = "Terdapat Kesalahan, Periksa kembali isian anda.";
            } else {
                $this->attention_messages = $this->{$this->model}->errors->get_html_errors("<br />", "line-wrap");
            }
        }

        $detail = $this->{$this->model}->show_detail($id);
//        var_dump($this->db->last_query(), $detail);exit;
        $this->set("detail", $detail);

//        $this->set("bread_crumb", array(
//            "back_end/cjenis_diklat" => 'Jenis Diklat',
//            "#" => 'Pendaftaran Jenis Diklat'
//        ));
//        $this->add_jsfiles(array("avant/plugins/form-jasnyupload/fileinput.min.js"));
    }

    public function _call_api($path, $params) {
        $url = $this->resource_api_link . $path;
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($params),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return (array) json_decode($result);
        
        // API CURL
//        $ch = curl_init($url);
//        $params["apitoken"] = $this->get_api_token();
//        curl_setopt($ch, CURLOPT_POST, 1);
////        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
////        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
////            'Content-Type:application/json',
////            'Accept:application/json'
////        ));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//        $data = curl_exec($ch);
//        return (array) json_decode($data);
    }

    private function init_back_end() {
        $this->my_location = "back_end/";
        $this->init_backend_menu();
        $this->backend_controller_location = $this->my_location . $this->_name;
        $this->set("controller_location", $this->backend_controller_location);

        $user_detail = $this->lmanuser->get("user_detail");
        $this->set("active_user_detail", $user_detail);
    }

    private function get_api_token() {
        return md5(date('d') . md5("api_bkpp") . date("Y"));
    }

}
