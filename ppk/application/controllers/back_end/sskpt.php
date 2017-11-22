<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sskpt extends Back_end {

    public $model = 'model_tr_skp_tahunan';

    public function __construct() {
        parent::__construct('kelola_persetujuan_skpt', 'SKP Tahunan Bawahan');
        $this->load->model(array('model_tr_skp_bulanan', 'model_master_pegawai'));
    }

    public function index() {
        $profil = array(
            'nip' => $this->pegawai_nip,
            'kd_eselon' => $this->kode_eselon,
            'kd_instansi' => $this->kode_instansi,
            'kd_organisasi' => $this->kode_organisasi,
            'kd_satuan_organisasi' => $this->kode_satuan_organisasi,
            'kd_unit_organisasi' => $this->kode_unit_organisasi
        );
        $data = $this->_call_api('pegawai/get_bawahan', $profil);
        $bawahan = isset($data['response']) ? $data['response'] : FALSE;
        $arr_nip_bawahan = array();
        if ($bawahan) {
            foreach ($bawahan as $row) {
                $arr_nip_bawahan[] = $row->nip;
            }
        }
        $data_bawahan = $this->model_master_pegawai->get_all_bawahan_by_nip(implode("','", $arr_nip_bawahan))->record_set;
        $arr_id_bawahan = array();
        if ($data_bawahan) {
            foreach ($data_bawahan as $row) {
                $arr_id_bawahan[] = $row->pegawai_id;
            }
        }
        $thn = $this->input->get('tahun', TRUE);
        $tahun = $thn ? $thn : date('Y');
        $this->get_attention_message_from_session();
        if ($this->auto_load_model && $this->model != '' && $this->before_load_paging()) {
            list($sort_url_query, $sort_by, $sort_mode) = $this->get_sorting_pre_url_query();
            if ($sort_by) {
                $this->model_tr_skp_tahunan->sort_by = $sort_by;
                $this->model_tr_skp_tahunan->sort_mode = $sort_mode;
            }
            $this->model_tr_skp_tahunan->change_offset_param("currpage_" . $this->cmodul_name);
            $records = $this->model_tr_skp_tahunan->get_persetujuan($arr_id_bawahan, $tahun);
            $records->record_set = $this->after_get_paging($records->record_set);
            $paging_set = $this->get_paging($this->get_current_location(), $records->record_found, $this->default_limit_paging, $this->cmodul_name);
            $this->set('records', $records->record_set);
            $this->set('keyword', $records->keyword);
            $this->set('tahun', $tahun);
            $this->set('field_id', $this->model_tr_skp_tahunan->primary_key);
            $this->set('paging_set', $paging_set);
            $this->set('sort_url_query', $sort_url_query);
            $this->set('sort_mode', $this->model_tr_skp_tahunan->sort_by);
            $this->set('sort_by', $this->model_tr_skp_tahunan->sort_mode);
            $this->set('next_list_number', $this->model_tr_skp_tahunan->get_next_record_number_list());
        }
        $this->set("additional_js", "back_end/" . $this->_name . "/js/index_js");
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function persetujuan($id = FALSE) {
        $info = $this->input->post();
        if ($info) {
            if (array_key_exists('tolak', $info)) {
                if ($this->model_tr_skp_tahunan->update_status($id, 4)) {
                    $this->set_attention_message('SKP berhasil ditolak...');
                } else {
                    $this->set_attention_message('SKP gagal ditolak...');
                }
            }
            if (array_key_exists('setuju', $info)) {
                if ($this->model_tr_skp_tahunan->update_status($id, 2)) {
                    $this->set_attention_message('SKP berhasil disetujui...');
                } else {
                    $this->set_attention_message('SKP gagal disetujui...');
                }
            }
            redirect('back_end/sskpt');
        } else {
            $this->set('skpt', $skpt = $this->model_tr_skp_tahunan->get_realisasi($id));
            $this->set('pegawai_id', $this->pegawai_id);
            $this->set('skpb', $this->model_tr_skp_bulanan->get_data_setahun($id, TRUE));
            $this->set("bread_crumb", array(
                "back_end/" . $this->_name => $this->_header_title,
                "#" => 'Formulir ' . $this->_header_title
            ));
        }
    }

    public function lihat($id = FALSE) {
        $this->set('skpt', $skpt = $this->model_tr_skp_tahunan->get_realisasi($id));
        $this->set('skpb', $this->model_tr_skp_bulanan->get_data_setahun($id, TRUE));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Formulir ' . $this->_header_title
        ));
    }

    public function detail($id = FALSE) {
        parent::detail($id, array("pegawai_id", "skpt_tahun", "skpt_kegiatan", "skpt_waktu", "skpt_kuantitas", "skpt_kualitas", "skpt_biaya"));
        $this->set('pegawai_id', $this->pegawai_id);
        $this->set('skpb', $this->model_tr_skp_bulanan->get_data_setahun($id));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Formulir ' . $this->_header_title
        ));
        $this->add_cssfiles(array("plugins/select2/select2.min.css"));
        $this->add_jsfiles(array("plugins/select2/select2.full.min.js"));
        $this->add_jsfiles(array("plugins/smartwizard/jquery.smartWizard-2.0.min.js"));
        $this->add_jsfiles(array("plugins/jquery-validation/jquery.validate.js"));
    }

    public function get_like() {
        $keyword = $this->input->post("keyword");
        $id_skpd = $this->input->post("id_skpd");
        $data_found = $this->{$this->model}->get_like($keyword, $id_skpd);
        $this->to_json($data_found);
    }

    public function after_save($id = FALSE, $saved_id = FALSE) {
        $kuantitas = $this->input->post('kuantitas');
        $biaya = $this->input->post('biaya');
        $data = array();
        for ($i = 1; $i <= 12; $i++) {
            $data[] = array(
                'skpt_id' => $id,
                'skpb_bulan' => $i,
                'skpb_kuantitas' => $kuantitas[$i],
                'skpb_biaya' => $biaya[$i]
            );
        }
        $this->model_tr_skp_bulanan->save($id == $saved_id, $data);
        unset($data);
    }

}
