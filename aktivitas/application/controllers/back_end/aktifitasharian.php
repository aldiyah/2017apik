<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modul Aktifitas Harian
 * 
 * Dalam modul ini, user bisa menginput aktifitas hariannya
 * 
 * @author Rinaldi
 */
class Aktifitasharian extends Back_end {

    public $model = 'model_tr_aktifitas';

    public function __construct() {
        parent::__construct('kelola_transaksi_aktifitas', 'Aktivitas Harian');
        $this->load->model(array(
            'model_master_aktifitas'
        ));
    }

    /**
     * Index Aktifitas Harian
     * @param date $date Tanggal input aktifitas harian
     */
    public function index($date = FALSE) {
        $tgl = $date != FALSE ? $date : date('Y-m-d');
        $this->set('tanggal', $tgl);
        $this->set('header_title', $this->_header_title . ' per ' . $tgl);
        $this->set('keyword', array('date'));
        $records = $this->model_tr_aktifitas->get_aktifitas_harian($this->pegawai_id, $tgl);

//        $utama = FALSE;
//        if ($aktifitas) {
//            foreach ($aktifitas as $row) {
//                $utama[] = array(
//                    'aktifitas' => $row,
//                    'kegiatan' => $this->model_set_tugas->get_aktifitas($row->setaktif_id),
//                    'laporan' => $this->model_tr_aktifitas->get_laporan($this->pegawai_id, $row->aktifitas_id, $tgl)
//                );
//            }
//        }
//        $umum = $this->model_tr_aktifitas->get_laporan($this->pegawai_id, 0, $tgl);
//        $absensi = $this->_call_api('checkInOut', array(
//            'checkInOutIn' => array(
//                'nip' => $this->pegawai_nip,
//                'checkTime' => date('d-m-Y', strtotime($tgl))
//            )
//        ));
//        $this->set('id_pegawai', $this->pegawai_id);
////        $this->set('absensi', isset($absensi['checkInOutOut']->checkInOutList->checkInOut) ? TRUE : FALSE);
        $this->set('absensi', TRUE);
//        $this->set('aktifitas', $this->model_master_aktifitas->get_all());
//        $this->set('access_rules', $this->access_rules());
        $this->set('records', $records);
        $this->set('additional_js', "back_end/" . $this->_name . '/js/index_js');
        $this->add_jsfiles(array('atlant/plugins/fullcalendar/fullcalendar.min.js'));
        $this->add_jsfiles(array('atlant/plugins/fullcalendar/lang/id.js'));
        $this->set("bread_crumb", array(
            "#" => 'Daftar ' . $this->_header_title
        ));
    }

    public function detail($date = FALSE, $id = FALSE) {
        if ($id) {
            $this->session->set_flashdata("id_aktifitas", $id);
        }

        parent::detail($id, array("pegawai_id", "aktifitas_id", "tr_aktifitas_tanggal", "tr_aktifitas_volume", "tr_aktifitas_mulai", "tr_aktifitas_selesai", "tr_aktifitas_keterangan", "tr_valid_by_al", "tr_valid_by_aa"));
        $tgl = $date != FALSE ? $date : date('Y-m-d');
        $this->set('pegawai_id', $this->pegawai_id);
        $this->set('tanggal', $tgl);
        $this->set('aktifitas', $this->model_master_aktifitas->get_all());
        $this->set('additional_js', "back_end/" . $this->_name . '/js/detail_js');
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => 'Daftar ' . $this->_header_title,
            "#" => 'Formulir ' . $this->_header_title
        ));
    }

    protected function after_detail($id = FALSE) {
        $this->upload_dokumen_aktifitas($id);
    }

    public function upload_dokumen_aktifitas($tr_aktifitas_id = FALSE) {
        if (array_key_exists("tr_aktifitas_dokumen", $_FILES)) {
            $application_uploaded = $this->model_tr_aktifitas->upload_file($tr_aktifitas_id, "tr_aktifitas_dokumen", TRUE, "tr_aktifitas_dokumen");
            if ($application_uploaded && is_array($application_uploaded) && !empty($application_uploaded)) {
                if ($application_uploaded["success_upload"]) {
                    $tr_aktifitas_id = $this->saved_id;
                    $this->db->where("tr_aktifitas_id", $tr_aktifitas_id);
                    $this->db->update("sc_akrifwz.tr_aktifitas", array("tr_aktifitas_dokumen" => $application_uploaded["upload_data_response"]["file_name_uploaded"]));
                }
                $this->attention_messages .= $application_uploaded["message"];
            }
            unset($application_uploaded);
        }
    }

    public function get_waktu($aktivitas_id) {
        $detail = $this->model_master_aktifitas->get_detail('aktifitas_id = ' . $aktivitas_id);
        $this->to_json($detail->aktifitas_waktu);
    }

    public function rkbulanan($tahun = FALSE, $bulan = FALSE) {
        $this->load_model('model_master_tpp');
        $data_tpp = $this->model_master_tpp->get_detail('master_tpp.pegawai_id = ' . $this->pegawai_id);
        $holidays = array();
        $hari_kerja_efektif = get_working_day_monthly($holidays);
//        $tpp_harian = $data_tpp && property_exists($data_tpp, 'tpp_beban_kerja') ? $data_tpp->tpp_beban_kerja * $this->perwal['aktivitas']['bobot'] / $hari_kerja_efektif->total : 0;
        $tpp_harian = $data_tpp ? $data_tpp->tpp_beban_kerja * $this->perwal['aktivitas']['bobot'] / $hari_kerja_efektif->total : 0;
        $bln = $bulan ? $bulan : date('n');
        $thn = $tahun ? $tahun : date('Y');
        $id_pegawai = $this->pegawai_id;
        $this->set('tpp_harian', $tpp_harian);
        $this->set('bulan', $bln);
        $this->set('tahun', $thn);
        $this->set('records', $this->model_tr_aktifitas->get_rekap_bulanan($id_pegawai, $bln, $thn));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => 'Daftar ' . $this->_header_title,
            "#" => 'Rekap Bulanan ' . $this->_header_title
        ));
    }

}
