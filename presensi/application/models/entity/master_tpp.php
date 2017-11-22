<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_tpp extends MY_Model {

    public $sort_by = 'tpp_id';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct("master_tpp","sc_master");
        $this->primary_key = "tpp_id";
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(
        "tpp_id" => array("tpp_id", "ID TPP"),
        "pegawai_id" => array("pegawai_id", "ID Pegawai"),
        "tpp_beban_kerja" => array("tpp_beban_kerja", "TPP Beban Kerja"),
        "tpp_objective" => array("tpp_objective", "TPP Objektif"),
        "tahun" => array("tahun", "Tahun")
    );
    protected $rules = array(
        array("pegawai_id", "required|integer"),
        array("tpp_beban_kerja", "required|numeric"),
        array("tpp_objective", "required|numeric"),
        array("tahun", "required|numeric")
    );
    protected $related_tables = array(
        "master_pegawai" => array(
            "fkey" => "pegawai_id",
            "columns" => array(
                "pegawai_nip",
                "pegawai_nama"
            ),
            "referenced" => "LEFT"
        )
    );
    protected $attribute_types = array();

}
