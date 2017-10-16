<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class master_alih_penilai extends MY_Model {

    public $sort_by = "alih_id";
    public $sort_mode = "asc";

    public function __construct() {
        parent::__construct("master_alih_penilai");
        $this->primary_key = "alih_id";
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(
        'alih_id' => array('alih_id', 'Pengalihan ID'),
        'pegawai_id' => array('pegawai_id', 'Pegawai ID'),
        'penilai_id' => array('penilai_id', 'Penilai ID')
    );
    protected $rules = array(
        array('pegawai_id', 'required|integer'),
        array('penilai_id', 'required|integer')
    );
    protected $related_tables = array(
        'master_pegawai' => array(
            'fkey' => 'pegawai_id',
            'table_alias' => 'b',
            'columns' => array(
                'pegawai_nip as b_nip',
                'pegawai_nama as b_nama'
            ),
            'referenced' => 'LEFT'
        ),
        'a' => array(
            'table_name' => 'master_pegawai',
            'fkey' => array('penilai_id', 'pegawai_id'),
            'table_alias' => 'a',
            'columns' => array(
                'pegawai_nip as a_nip',
                'pegawai_nama as a_nama'
            ),
            "referenced" => 'LEFT'
        )
    );
    protected $attribute_types = array();

}
