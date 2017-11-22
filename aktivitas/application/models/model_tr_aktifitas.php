<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once "entity/tr_aktifitas.php";

class model_tr_aktifitas extends tr_aktifitas {

    public $upload_rule = array(
        "upload_path" => "",
        "allowed_types" => "jpg|jpeg|png|bmp|pdf"
    );
    public $is_update = FALSE;

    public function __construct() {
        parent::__construct();
    }

    public function all($id_pegawai = FALSE, $date = FALSE, $force_limit = FALSE, $force_offset = FALSE) {
        $where = $this->table_name . ".pegawai_id = '" . $id_pegawai . "'";
        if ($date) {
            $where .= " AND " . $this->table_name . ".tr_aktifitas_tanggal = '" . $date . "'";
        }
        return parent::get_all(array("aktifitas_nama", "tr_aktifitas_keterangan"), $where
                        , TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    /**
     * lihat upload_data untuk mengetahui nilai balik fungsi upload_data
     * @param type $username
     * @param type $upload_type
     * @param type $detail_application
     * @param type $input_name
     * @return boolean
     */
    private function _upload_file($tr_aktifitas_id = FALSE, $upload_type = FALSE, $detail_application = FALSE, $input_name = FALSE) {
        $file_posted_ok = FALSE;
        $response = array(
            "success_upload" => FALSE,
            "upload_data_response" => FALSE,
            "message" => "Upload gagal dilakukan.",
            "file_uploaded" => "",
        );
        if ($tr_aktifitas_id && $input_name &&
                $detail_application && $upload_type !== FALSE &&
                is_array($this->upload_rule) && !empty($this->upload_rule)) {
            $upload_location = get_upload_location("aktifitas/" . $tr_aktifitas_id);
            if ($upload_location) {
                $cfg = $this->upload_rule;
                $cfg["upload_path"] = $upload_location;
                $cfg["ignore_mime_check"] = TRUE;
                $response["upload_data_response"] = upload_data($input_name, $cfg, $tr_aktifitas_id, TRUE);
                $response["message"] = $response["upload_data_response"]["message"];
                $response["success_upload"] = !$response["upload_data_response"]["uploadfailed"];
                if (!$response["upload_data_response"]["uploadfailed"]) {
                    $response["file_uploaded"] = $upload_location . "/" . $response["upload_data_response"]["file_name_uploaded"];
                }
            } else {
                $response["message"].="<br />Lokasi tidak dikenali.";
            }
        }
        return $response;
    }

    public function upload_file($tr_aktifitas_id = FALSE, $upload_type = FALSE, $detail_application = FALSE, $input_name = FALSE) {
        $response = FALSE;
        if ($tr_aktifitas_id && $input_name && $detail_application && $upload_type !== FALSE) {
            $response = array();
            if (is_array($input_name)) {
                foreach ($input_name as $_input_name) {
                    $response[] = $this->_upload_file($tr_aktifitas_id, $upload_type, $detail_application, $_input_name);
                }
            } else {
                $response = $this->_upload_file($tr_aktifitas_id, $upload_type, $detail_application, $input_name);
            }
        }
        return $response;
    }

//    public function before_count_all() {
//        $this->db->join($this->schema_name . ".master_aktifitas", $this->table_name . ".aktifitas_id = " . $this->schema_name . ".master_aktifitas.aktifitas_id", 'left');
//    }
//    public function get_aktifitas($id_pegawai) {
//        return $this->get_where('pegawai_id = '.$id_pegawai, NULL, 'tr_aktifitas_tanggal');
//    }
    public function get_laporan($id_pegawai = FALSE, $id_aktifitas = 0, $tanggal = FALSE) {
        $this->get_select_referenced_table();
        return $this->get_where($this->table_name . ".pegawai_id = " . $id_pegawai . " and " .
                        $this->table_name . ".aktifitas_id = " . $id_aktifitas . " and " .
                        $this->table_name . ".tr_aktifitas_tanggal = '" . $tanggal . "'", '*');
    }

    public function get_aktifitas_harian($id_pegawai = FALSE, $tanggal = FALSE) {
        $where = $this->table_name . ".pegawai_id = " . $id_pegawai;
        $where .= " and " . $this->table_name . ".tr_aktifitas_tanggal = '" . $tanggal . "'";
        $this->get_select_referenced_table();
        return $this->get_where($where, '*, ' . $this->table_name . '.tr_aktifitas_dokumen as aktifitas_dok');
    }

    public function get_aktifitas($id_pegawai = FALSE, $tahun = 2017, $bulan = 1) {
        if ($id_pegawai) {
            $conditions[] = $this->table_name . ".pegawai_id = " . $id_pegawai;
        }
        if ($tahun) {
            $conditions[] = "EXTRACT(YEAR FROM " . $this->table_name . ".tr_aktifitas_tanggal) = " . $tahun;
        }
        if ($bulan) {
            $conditions[] = "EXTRACT(MONTH FROM " . $this->table_name . ".tr_aktifitas_tanggal) = " . $bulan;
        }
        return $this->get_all(NULL, $conditions, TRUE, TRUE);
    }

    public function count_aktifitas($id_pegawai = FALSE, $bulan = 1, $tahun = 2017, $status = FALSE) {
        $where = $this->table_name . ".pegawai_id = " . $id_pegawai;
        $where .= " and EXTRACT(MONTH FROM " . $this->table_name . ".tr_aktifitas_tanggal) = " . $bulan;
        $where .= " and EXTRACT(YEAR FROM " . $this->table_name . ".tr_aktifitas_tanggal) = " . $tahun;
        if ($status) {
            $where .= " and " . $this->table_name . ".tr_aktifitas_status = " . $status;
        }
        return $this->db->get_where($this->table_name, $where)->num_rows();
    }

    public function validasi_aktifitas($all_id_bawahan = FALSE, $batas = FALSE) {
        $where = $this->master_schema . ".master_pegawai.pegawai_nip in ('" . $all_id_bawahan . "')";
        $where .= " and " . $this->table_name . ".tr_aktifitas_tanggal > '" . $batas . "'";
        $where .= " and " . $this->table_name . ".tr_aktifitas_status = 0";
        return $this->get_all(null, $where);
    }

    public function validasi($id = FALSE, $value = FALSE) {
        $this->db->set('tr_aktifitas_status', $value);
        $this->db->where('tr_aktifitas_id', $id);
        $this->db->update($this->table_name);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    public function get_rekap_bulanan($id_pegawai = FALSE, $bulan = 1, $tahun = 2017) {
        $this->db->select($this->table_name . '.tr_aktifitas_tanggal');
        $this->db->select_sum($this->schema_name . '.master_aktifitas.aktifitas_waktu');
        $this->db->select($this->table_name . '.tr_aktifitas_volume');
//        $this->db->select('EXTRACT(MONTH FROM ' . $this->table_name . '.tr_aktifitas_tanggal)');
//        $this->db->select('EXTRACT(YEAR FROM ' . $this->table_name . '.tr_aktifitas_tanggal)');
//        $this->db->select($this->table_name . '.pegawai_id');
        $this->db->join($this->master_schema . '.master_pegawai', $this->master_schema . '.master_pegawai.pegawai_id = ' . $this->schema_name . '.tr_aktifitas.pegawai_id');
        $this->db->join($this->schema_name . '.master_aktifitas', $this->schema_name . '.master_aktifitas.aktifitas_id = ' . $this->schema_name . '.tr_aktifitas.aktifitas_id');
        $this->db->where($this->table_name . ".pegawai_id = ", $id_pegawai);
        $this->db->where('EXTRACT(MONTH FROM ' . $this->table_name . '.tr_aktifitas_tanggal) = ', $bulan);
        $this->db->where('EXTRACT(YEAR FROM ' . $this->table_name . '.tr_aktifitas_tanggal) = ', $tahun);
        $this->db->where($this->table_name . ".tr_aktifitas_status = 1");
//        $this->db->group_by($this->table_name . '.pegawai_id');
        $this->db->group_by($this->table_name . '.tr_aktifitas_tanggal');
        $this->db->group_by('EXTRACT(MONTH FROM ' . $this->table_name . '.tr_aktifitas_tanggal)');
        $this->db->group_by('EXTRACT(YEAR FROM ' . $this->table_name . '.tr_aktifitas_tanggal)');
        $this->db->group_by($this->table_name . '.tr_aktifitas_volume');
        $this->db->order_by($this->table_name . '.tr_aktifitas_tanggal');
        $query = $this->db->get($this->table_name);
//        print_r($this->db->last_query());
//        var_dump($query->result());
//        exit();
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }

}
