<?php if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class ref_jenis_file extends LWS_model {

    public function __construct() {
        parent::__construct("ref_jenis_file");
        $this->primary_key = "id_jenis_file";
        
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(array("id_jenis_file", "Id Jenis File"), array("kode_jenis_file", "Kode Jenis File"), array("nama_jenis_file", "Nama Jenis File"), array("ekstensi_diperbolehkan", "Ekstensi Diperbolehkan"), array("ukuran_maksimum", "Ukuran Maksimum"));
    protected $rules = array(array("id_jenis_file", ""), array("kode_jenis_file", ""), array("nama_jenis_file", ""), array("ekstensi_diperbolehkan", ""), array("ukuran_maksimum", ""));
    protected $related_tables = array();
    protected $attribute_types = array();

} ?>