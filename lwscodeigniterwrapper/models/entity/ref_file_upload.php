<?php if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class ref_file_upload extends LWS_model {

    public function __construct() {
        parent::__construct("ref_file_upload");
        $this->primary_key = "id_file_upload";
        
        $this->attribute_labels = array_merge_recursive($this->_continuously_attribute_label, $this->attribute_labels);
        $this->rules = array_merge_recursive($this->_continuously_rules, $this->rules);
    }

    protected $attribute_labels = array(array("id_file_upload", "Id File Upload"), array("id_jenis_file", "Id Jenis File"), array("nama", "Nama"), array("deskripsi", "Deskripsi"), array("nama_file", "Nama File"), array("lokasi_path", "Lokasi Path"), array("url_sumber_luar", "Url Sumber Luar"), array("ditayangkan", "Ditayangkan"));
    protected $rules = array(array("id_file_upload", ""), array("id_jenis_file", ""), array("nama", ""), array("deskripsi", ""), array("nama_file", ""), array("lokasi_path", ""), array("url_sumber_luar", ""), array("ditayangkan", ""));
    protected $related_tables = array();
    protected $attribute_types = array();

} ?>