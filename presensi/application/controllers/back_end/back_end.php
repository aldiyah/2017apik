<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Back_end extends Lwpustaka_data {

    protected $backend_controller_location = "back_end/";
    protected $myid = 0;
    protected $pegawai_id = 0;
    protected $pegawai_nip = 0;
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

    protected function __get_absensi_from_adms() {
        $this->load->model(array('model_ab_absensi', 'model_tr_absensi'));
        $last_data = $this->model_tr_absensi->get_last_data($this->pegawai_id);
        $last_date = $last_data->maxtgl;
        $max_masuk = $last_data->maxmasuk;
        $max_pulang = $last_data->maxpulang;
        $last_time = $max_masuk && $max_pulang ? max($max_masuk, $max_pulang) : ($max_masuk ? $max_masuk : ($max_pulang ? $max_pulang : NULL));
        $data_absensi = $this->model_ab_absensi->get_absensi($this->pegawai_nip, $last_time);
        if ($data_absensi) {
            $old_absensi = array();
            $new_absensi = array();
            foreach ($data_absensi as $row) {
                if (date("Y-m-d", strtotime($row->ctime)) != $last_date) {
                    $new_absensi[] = array(
                        "pegawai_id" => $this->pegawai_id,
                        "abs_tanggal" => $row->ctime,
                        "abs_masuk" => (date("H", strtotime($row->mintime)) < 12 ? $row->mintime : NULL),
                        "abs_pulang" => (date("H", strtotime($row->maxtime)) > 12 ? $row->maxtime : NULL),
                        "abs_masuk_status" => 0
                    );
                } else {
                    if ((date('H', strtotime($row->mintime)) < 12 && $row->mintime < $max_masuk) || (date("H", strtotime($row->maxtime)) > 12 && $row->maxtime > $max_pulang)) {
                        $old_absensi[] = array(
                            "pegawai_id" => $this->pegawai_id,
                            "abs_tanggal" => $row->ctime,
                            "abs_masuk" => (date("H", strtotime($row->mintime)) < 12 ? ($max_masuk < $row->mintime ? $max_masuk : $row->mintime) : NULL),
                            "abs_pulang" => (date("H", strtotime($row->maxtime)) > 12 ? ($max_pulang > $row->maxtime ? $max_pulang : $row->maxtime) : NULL),
                            "abs_masuk_status" => 0
                        );
                    }
                }
            }
        }
        if (!empty($old_absensi)) {
            $this->model_tr_absensi->update_absensi($new_absensi);
        }
        if (!empty($new_absensi)) {
            $this->model_tr_absensi->transfer_absensi($new_absensi);
        }
    }

}
