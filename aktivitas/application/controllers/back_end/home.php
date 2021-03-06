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
        $this->load->model(array(
            'model_master_pegawai',
            'model_master_tpp'
        ));
        $id_pegawai = $this->pegawai_id;
        $holidays = array();
        $hari_kerja_efektif = get_working_day_monthly($holidays)->total;
        $bln = date('n');
        $thn = date('Y');

        // Ambil data tpp
        $tpp_dasar = $this->model_master_tpp->get_detail('master_tpp.pegawai_id = ' . $id_pegawai);
        $tpp_aktivitas_dasar = $tpp_dasar ? $tpp_dasar->tpp_beban_kerja * $this->config->item('perwal')['aktivitas']['bobot'] : 0;
        $tpp_aktivitas_over = $tpp_dasar ? $tpp_dasar->tpp_beban_kerja * $this->config->item('perwal')['aktivitas']['overtime'] : 0;
        $tpp_presensi_dasar = $tpp_dasar ? $tpp_dasar->tpp_beban_kerja * $this->config->item('perwal')['presensi']['bobot'] : 0;
        $tpp_ppk_dasar = $tpp_dasar ? $tpp_dasar->tpp_beban_kerja * $this->config->item('perwal')['ppk']['bobot'] : 0;

        // Hitung tpp absensi
        $pinalty_absensi = $this->model_master_tpp->get_pinalty_absensi($id_pegawai, $thn, $bln);
        $tpp_presensi_real = (100 - $pinalty_absensi) / 100 * $tpp_presensi_dasar;

        // Hitung tpp aktivitas
        $tpp_harian_dasar = $tpp_aktivitas_dasar > 0 ? $tpp_aktivitas_dasar / $hari_kerja_efektif : 0;
        $tpp_harian_over = $tpp_aktivitas_over > 0 ? $tpp_aktivitas_over / $hari_kerja_efektif : 0;
        $rekap_aktifitas = $this->model_master_tpp->get_aktivitas_bulanan($id_pegawai, $bln, $thn);
        $tpp_aktivitas_real = 0;
        if ($rekap_aktifitas) {
            foreach ($rekap_aktifitas as $row) {
                $waktu = $row->aktifitas_waktu * $row->tr_aktifitas_volume;
                $tpp_aktivitas_real += ($waktu > 300 ? $tpp_harian_dasar + $tpp_harian_over : $waktu / 300 * $tpp_harian_dasar);
            }
        }

        // Hitung tpp ppk
        $skpb = $this->model_master_tpp->get_all_skpb_by_id($id_pegawai, $thn, $bln);
        $nilai_capaian = $skpb->jumlah > 0 ? $skpb->nilai / $skpb->jumlah : 0;
        $nilai_perilaku = 0;

        $perilaku = $this->model_master_tpp->get_perilaku_by_id($id_pegawai, $thn, $bln);
        if ($perilaku) {
            if ($perilaku->perilaku_kepemimpinan > 0) {
                $nilai_perilaku = ($perilaku->perilaku_pelayanan + $perilaku->perilaku_integritas + $perilaku->perilaku_komitmen + $perilaku->perilaku_disiplin + $perilaku->perilaku_kerjasama + $perilaku->perilaku_kepemimpinan) / 6;
            } else {
                $nilai_perilaku = ($perilaku->perilaku_pelayanan + $perilaku->perilaku_integritas + $perilaku->perilaku_komitmen + $perilaku->perilaku_disiplin + $perilaku->perilaku_kerjasama) / 5;
            }
        }
        $nilai_final = ((0.6 * $nilai_capaian) + (0.4 * $nilai_perilaku));
        $tpp_ppk_real = 0;
        if ($nilai_final <= 0) {
            $tpp_ppk_real = 0.0 * $tpp_ppk_dasar;
        } elseif ($nilai_final < 15) {
            $tpp_ppk_real = 0.2 * $tpp_ppk_dasar;
        } elseif ($nilai_final < 25) {
            $tpp_ppk_real = 0.3 * $tpp_ppk_dasar;
        } elseif ($nilai_final < 35) {
            $tpp_ppk_real = 0.4 * $tpp_ppk_dasar;
        } elseif ($nilai_final < 45) {
            $tpp_ppk_real = 0.5 * $tpp_ppk_dasar;
        } elseif ($nilai_final < 55) {
            $tpp_ppk_real = 0.6 * $tpp_ppk_dasar;
        } elseif ($nilai_final < 65) {
            $tpp_ppk_real = 0.7 * $tpp_ppk_dasar;
        } elseif ($nilai_final < 75) {
            $tpp_ppk_real = 0.8 * $tpp_ppk_dasar;
        } elseif ($nilai_final < 85) {
            $tpp_ppk_real = 0.9 * $tpp_ppk_dasar;
        } else {
            $tpp_ppk_real = 1.0 * $tpp_ppk_dasar;
        }
        $this->set("tpp_presensi", $tpp_presensi_real);
        $this->set("tpp_aktivitas", $tpp_aktivitas_real);
        $this->set("tpp_ppk", $tpp_ppk_real);
        $this->_layout = 'atlant_landing';
    }

    public function to_landing() {
        $url = "http://" . $_SERVER['SERVER_NAME'] . "/presensi/back_end/home/landingpage";
        header('Location: ' . $url);
        exit;
    }

    public function to_presensi() {
        $url = "http://" . $_SERVER['SERVER_NAME'] . "/presensi/";
        header('Location: ' . $url);
        exit;
    }

    public function to_ppk() {
        $url = "http://" . $_SERVER['SERVER_NAME'] . "/ppk/";
        header('Location: ' . $url);
        exit;
    }

    public function to_aktivitas() {
        redirect('back_end/home');
    }

    public function index() {
        parent::index();
        // Hitung TPP
        $id_pegawai = $this->pegawai_id;
        $this->load_model(array('model_master_tpp', 'model_tr_aktifitas'));
        $data_tpp = $this->model_master_tpp->get_detail('master_tpp.pegawai_id = ' . $id_pegawai);
        $holidays = array();
        $hari_kerja_efektif = get_working_day_monthly($holidays)->total;
        $tpp_harian = $data_tpp ? $data_tpp->tpp_beban_kerja * $this->config->item('perwal')['aktivitas']['bobot'] / $hari_kerja_efektif : 0;
        $bln = date('n');
        $thn = date('Y');

        $aktifitas = $this->model_tr_aktifitas->get_rekap_bulanan($id_pegawai, $bln, $thn);
        $total_tpp = 0;
        if ($aktifitas) {
            foreach ($aktifitas as $row) {
                $waktu = $row->aktifitas_waktu * $row->tr_aktifitas_volume;
                $total_tpp += ($waktu / 300 * $tpp_harian);
            }
        }
        $this->set('total_tpp', $total_tpp);

        // Total Aktifitas Bulan Ini

        $this->load->model('model_tr_aktifitas');
        $this->set('total_aktivitas', $this->model_tr_aktifitas->count_aktifitas($this->pegawai_id, $bln, $thn));
        $this->set('total_ditolak', $this->model_tr_aktifitas->count_aktifitas($this->pegawai_id, $bln, $thn, 2));

        // Total Aktifitas Ditolak Bulan Ini
    }

}
