<?php

defined("BASEPATH") OR exit("No direct script access allowed");
include_once "entity/master_alih_penilai.php";

class model_master_alih_penilai extends master_alih_penilai {

    public function __construct() {
        parent::__construct();
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array(
                    "pegawai_id", "penilai_id"
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_bawahan($pegawai_id) {
        $this->db->where('penilai_id', $pegawai_id);
        $this->db->join('sc_akrifwz.master_pegawai', 'sc_akrifwz.master_pegawai.pegawai_id = sc_akrifwz.master_alih_penilai.pegawai_id', 'left');
        $query = $this->db->get($this->table_name);
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }

}
