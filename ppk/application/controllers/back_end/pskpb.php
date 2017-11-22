<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pskpb extends Back_end {

    public $model = 'model_tr_skp_bulanan';

    public function __construct() {
        parent::__construct('kelola_penilaian_skpb', 'Penilaian SKP Bulanan');
        $this->load->model(array('model_tr_skp_tahunan', 'model_master_pegawai'));
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
        $thn = $this->input->post('tahun');
        $tahun = $thn ? $thn : date('Y');
        $this->get_attention_message_from_session();
        if ($this->auto_load_model && $this->model != '' && $this->before_load_paging()) {
            list($sort_url_query, $sort_by, $sort_mode) = $this->get_sorting_pre_url_query();
            if ($sort_by) {
                $this->model_tr_skp_bulanan->sort_by = $sort_by;
                $this->model_tr_skp_bulanan->sort_mode = $sort_mode;
            }
            $this->model_tr_skp_bulanan->change_offset_param("currpage_" . $this->cmodul_name);
            $records = $this->model_tr_skp_bulanan->get_persetujuan($arr_id_bawahan, $tahun);
            $records->record_set = $this->after_get_paging($records->record_set);
            $paging_set = $this->get_paging($this->get_current_location(), $records->record_found, $this->default_limit_paging, $this->cmodul_name);
            $this->set('records', $records->record_set);
            $this->set('keyword', $records->keyword);
            $this->set('field_id', $this->model_tr_skp_bulanan->primary_key);
            $this->set('paging_set', $paging_set);
            $this->set('sort_url_query', $sort_url_query);
            $this->set('sort_mode', $this->model_tr_skp_bulanan->sort_by);
            $this->set('sort_by', $this->model_tr_skp_bulanan->sort_mode);
            $this->set('next_list_number', $this->model_tr_skp_bulanan->get_next_record_number_list());
        }
        $this->set("additional_js", "back_end/" . $this->_name . "/js/index_js");
        $this->set("bread_crumb", array(
            "#" => $this->_header_title
        ));
    }

    public function update($id = FALSE) {
        parent::detail($id, array("skpb_real_kualitas"));
        $this->set('pegawai_id', $this->pegawai_id);
        $this->set('skpb', $this->model_tr_skp_bulanan->get_realisasi($id));
        $this->set("bread_crumb", array(
            "back_end/" . $this->_name => $this->_header_title,
            "#" => 'Formulir ' . $this->_header_title
        ));
    }

}
