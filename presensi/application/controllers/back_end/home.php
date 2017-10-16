<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Back_end {

    protected $auto_load_model = FALSE;

    public function can_access() {
        return TRUE;
    }

    public function __construct() {
        parent::__construct();
        $this->load->model(array(
            'model_master_pegawai',
        ));
        
        $user_detail = $this->lmanuser->get_by_prefix('auth.','user_detail');
        
        $tpp_sementara = ($this->sementara_tpp($user_detail["pegawai_id"])*0.5);
        
        if($user_detail["pegawai_id"] == '3'){
            $tpp_sementara = $tpp_sementara-($tpp_sementara*0.04);
        }
        
        $this->set('master_tpp', $tpp_sementara);
        $this->set('pegawai_id', $user_detail["pegawai_id"]);
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
        redirect('back_end/home');
    }

    public function to_ppk() {
        $url = "http://" . $_SERVER['SERVER_NAME'] . "/2017apik/skp/";
        header('Location: ' . $url);
        exit;
    }

    public function to_aktivitas() {
        $url = "http://" . $_SERVER['SERVER_NAME'] . "/2017apik/aktivitas";
        header('Location: ' . $url);
        exit;
    }

    public function index() {
// api by triasada start
//        $url = 'http://192.168.100.15:8080/BkppRestFulServices-Api/login';
//        $param = array('loginIn'=>array('nip'=>'195404061978031009',
//            'password'=>'2001b9264899b6035395ce4d1a8c1139')
//                
//            );
//        $ch = curl_init($url);
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
////        curl_setopt($ch, CURLOPT_HEADER, 'Content-Type: application/json');
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//    'Content-Type: application/json',
//    'Accept: application/json'
//));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        $result = curl_exec($ch);
//
//
//
//        var_dump($result);exit();
//        api by triasada end
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

