<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class tr_aktifitas extends MY_Model {

    public function __construct() {
        parent::__construct("tr_aktifitas", "sc_aktivitas");
        $this->primary_key = "tr_aktifitas_id";
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(
        "tr_aktifitas_id" => array("tr_aktifitas_id", "ID Input Aktifitas"),
        "pegawai_id" => array("pegawai_id", "Pilih Pegawai"),
        "aktifitas_id" => array("aktifitas_id", "Pilih Aktifitas"),
        "tr_aktifitas_tanggal" => array("tr_aktifitas_tanggal", "Tanggal Aktifitas"),
        "tr_aktifitas_volume" => array("tr_aktifitas_volume", "Aktifitas Volume"),
        "tr_aktifitas_mulai" => array("tr_aktifitas_mulai", "Aktifitas Mulai"),
        "tr_aktifitas_selesai" => array("tr_aktifitas_selesai", "Aktifitas Selesai"),
        "tr_aktifitas_keterangan" => array("tr_aktifitas_keterangan", "Aktifitas Keterangan"),
        "tr_aktifitas_status" => array("tr_aktifitas_status", "Status Aktifitas"),
        "tr_aktifitas_dokumen" => array("tr_aktifitas_dokumen", "Dokumen Pendukung"),
        "tr_valid_al" => array("tr_valid_al", "Validasi Atasan Langsung"),
        "tr_valid_aa" => array("tr_valid_aa", "Validasi Atasan Atasan"),
        "tr_valid_by_al" => array("tr_valid_by_al", "Validasi Oleh Atasan Langsung"),
        "tr_valid_by_aa" => array("tr_valid_by_aa", "Validasi Oleh Atasan Atasan")
    );
    protected $rules = array(
        array("pegawai_id", "required|is_natural_no_zero"),
        array("aktifitas_id", "required|is_natural_no_zero"),
        array("tr_aktifitas_tanggal", "required|valid_date[dd/mm/yyyy]"),
        array("tr_aktifitas_volume", "required|numeric"),
        array("tr_aktifitas_mulai", "required"),
        array("tr_aktifitas_selesai", "required"),
        array("tr_aktifitas_keterangan", "required|min_length[3]|max_length[200]"),
        array("tr_aktifitas_dokumen", ""),
        array("tr_valid_al", "numeric"),
        array("tr_valid_aa", "numeric"),
        array("tr_valid_by_al", "numeric"),
        array("tr_valid_by_aa", "numeric")
    );
    protected $related_tables = array(
        "master_aktifitas" => array(
            "fkey" => "aktifitas_id",
            "columns" => array(
                "aktifitas_kode",
                "aktifitas_nama",
                "aktifitas_waktu",
                "aktifitas_output"
            ),
            "referenced" => "LEFT"
        ),
        "sc_master.master_pegawai" => array(
            "fkey" => "pegawai_id",
            "columns" => array(
                "pegawai_nip",
                "pegawai_nama"
            ),
            "referenced" => "LEFT"
        ),
        'satu' => array(
            'table_name' => 'sc_master.master_pegawai',
            'fkey' => array('tr_valid_by_al', 'pegawai_id'),
            'table_alias' => 'satu',
            'columns' => array(
                'pegawai_nip as satu_nip',
                'pegawai_nama as satu_nama'
            ),
            "referenced" => 'LEFT'
        ),
        'dua' => array(
            'table_name' => 'sc_master.master_pegawai',
            'fkey' => array('tr_valid_by_aa', 'pegawai_id'),
            'table_alias' => 'dua',
            'columns' => array(
                'pegawai_nip as dua_nip',
                'pegawai_nama as dua_nama'
            ),
            "referenced" => 'LEFT'
        )
    );
    protected $attribute_types = array();

}
