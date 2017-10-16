<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Back_end {

    protected $auto_load_model = FALSE;
    
    public function can_access() {
        return TRUE;
    }

    public function __construct() {
        parent::__construct();
    }

    public function landingpage() {
        $this->_layout = 'atlant_landing';

        /**
          protected 'pegawai_id' => int 0
          protected 'pegawai_nip' => int 0
          protected 'kode_jabatan' => int 0
          protected 'kode_organisasi' => int 0
         * 
         */
    }

    public function to_presensi() {
        $url = "http://".$_SERVER['SERVER_NAME']."/2017apik/presensi/";
        header('Location: '.$url);
        exit;
    }

    public function to_ppk() {
        redirect('back_end/home');
    }

    public function to_aktivitas() {
        $url = "http://".$_SERVER['SERVER_NAME']."/2017apik/aktivitas/";
        header('Location: '.$url);
        exit;
    }

    public function index() {
        $this->set("total_tpp", 0);
        $this->set("total_skp_diterima", 0);
        $this->set("total_skp_ditolak", 0);
//        echo "eko dipanggil";exit;
//        $this->load->model(array("model_tr_pembayaran", "model_ref_penghuni"));
//        $terbayar_perbulan = toJsonString($this->model_tr_pembayaran->get_record_terbayar_perbulan(), FALSE);
//        $pendaftar_perbulan = toJsonString($this->model_ref_penghuni->get_record_pendaftar_perbulan(), FALSE);
//        $this->set("terbayar_perbulan", $terbayar_perbulan);
//        $this->set("pendaftar_perbulan", $pendaftar_perbulan);
//        $this->set("var_bulan", $this->month());
//        $this->set("additional_js", "back_end/home/js/index_js");
//        $this->add_jsfiles(array(
//            "avant/plugins/charts-flot/jquery.flot.min.js",
//            "avant/plugins/charts-flot/jquery.flot.resize.min.js",
//        ));
    }

    private function month() {
        $month = array_month(FALSE, TRUE);

        foreach ($month as $key => $val) {
            $month[$key] = array($key, $val);
        }
        return toJsonString($month, FALSE);
    }

}

