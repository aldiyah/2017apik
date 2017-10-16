<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pn
 *
 * @author nurfadillah
 */
class Pegawai extends Main {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('model_identitas');
    }

    public function nip_auto_complete() {
        $nip = $this->input->post('nip');
        $this->response = $this->status_code["200"];
        if ($nip) {
            $this->response['response'] = $this->model_identitas->get_like_nip($nip);
        }
    }

    public function info() {
        $nip = $this->input->post('nip');
        if ($nip) {
            $this->response = $this->status_code['200'];
            $this->response['response'] = $this->model_identitas->get_by_nip($nip);
        }
    }

    public function get_bawahan() {
        $nip = $this->input->post('nip');
        $kd_eselon = $this->input->post('kd_eselon');
        $kd_instansi = $this->input->post('kd_instansi');
        $kd_organisasi = $this->input->post('kd_organisasi');
        $kd_satuan_organisasi = $this->input->post('kd_satuan_organisasi');
        $kd_unit_organisasi = $this->input->post('kd_unit_organisasi');
        $kolom = '';
        $kode = '';
        if ($nip) {
            $this->response = $this->status_code['200'];
            if ($kd_unit_organisasi) {
                $kolom = 'kd_unit_organisasi';
                $kode = $kd_unit_organisasi;
            } elseif ($kd_satuan_organisasi) {
                $kolom = 'kd_satuan_organisasi';
                $kode = $kd_satuan_organisasi;
            } elseif ($kd_organisasi) {
                $kolom = 'kd_organisasi';
                $kode = $kd_organisasi;
            } elseif ($kd_instansi) {
                $kolom = 'kd_instansi';
                $kode = $kd_instansi;
            }
            $tingkat = array(
                '01' => array('03', '04'),
                '02' => array('03', '04'),
                '03' => array('05', '06'),
                '04' => array('05', '06'),
                '05' => array('07', '08'),
                '06' => array('07', '08'),
                '07' => array('09', '10'),
                '08' => array('09', '10')
            );
            $this->response['response'] = $this->model_identitas->get_bawahan($kolom, $kode, $tingkat[$kd_eselon]);
        }
    }

}
