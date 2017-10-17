<?php

defined("BASEPATH") OR exit("No direct script access allowed");
include_once "entity/identitas.php";

class model_identitas extends identitas {

    public function __construct() {
        parent::__construct();
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array(
                    "nip",
                    "nip_lama",
                    "ktp",
                    "hp1",
                    "email1",
                    "nama",
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

    public function get_by_nip($nip = FALSE) {
        $response = NULL;
        if ($nip) {
//            $response = $this->get_detail("nip = '" . $nip . "'");
            $this->db->select('i.nip,i.nama,'
                    . 'i.idLokasi,tl.kabupaten,tl.nama_propinsi,'
                    . 'rj.kd_tipe_jabatan,tjp.nama_jenis tipe_jabatan,'
                    . 'rj.kd_jenis_jabatan,'
                    . 'rj.kd_jabatan,tj.nama_jabatan,'
                    . 'rj.kd_eselon,tes.nama_eselon,'
                    . 'rj.kd_fungsional,'
                    . 'rj.kd_instansi,tin.nama_instansi,'
                    . 'rj.kd_organisasi,tor.nama_organisasi,'
                    . 'rj.kd_satuan_organisasi,tso.nama_satuan_organisasi,'
                    . 'rj.kd_unit_organisasi,tuo.nama_unit_organisasi,'
                    . 'rj.kd_unit_kerja,tuk.nama_unit_kerja');
            $this->db->join('tbl_lokasi tl', 'tl.idLokasi=i.idLokasi', 'left');
            $this->db->join('riwayat_jabatan rj', 'rj.id_identitas=i.id_identitas', 'left');
            $this->db->join('tabel_jenis_pegawai tjp', 'tjp.kd_jenis=rj.kd_tipe_jabatan', 'left');
            $this->db->join('tabel_jabatan tj', 'tj.kd_jabatan=rj.kd_jabatan', 'left');
            $this->db->join('tabel_eselon tes', 'tes.kd_eselon=rj.kd_eselon', 'left');
            $this->db->join('tbl_instansi tin', 'tin.kd_instansi=rj.kd_instansi', 'left');
            $this->db->join('tbl_organisasi tor', 'tor.kd_organisasi=rj.kd_organisasi', 'left');
            $this->db->join('tbl_satuan_organisasi tso', 'tso.kd_satuan_organisasi=rj.kd_satuan_organisasi', 'left');
            $this->db->join('tbl_unit_organisasi tuo', 'tuo.kd_unit_organisasi=rj.kd_unit_organisasi', 'left');
            $this->db->join('tbl_unit_kerja tuk', 'tuk.kd_unit_kerja=rj.kd_unit_kerja', 'left');
            $this->db->where('i.nip', $nip);
            $this->db->order_by('rj.mytmt', 'desc');
            $query = $this->db->get($this->table_name . ' i');
            $response = $query->num_rows() > 0 ? $query->row() : FALSE;
        }
        return $response;
    }

    public function get_like_nip($nip = FALSE) {
        $response = NULL;
        if ($nip) {
            $response = $this->get_where($this->table_name . ".nip LIKE '%" . $nip . "%'");
        }
        return $response;
    }

    public function get_bawahan($kolom = FALSE, $kode = FALSE, $eselon_bawah = array()) {
        $eselon = implode(',', $eselon_bawah);
        $sql = 'select i.nip, i.nama from('
                . 'select * from riwayat_jabatan'
                . ' where ' . $kolom . ' = "' . $kode . '"'
                . ' and kd_eselon in (' . $eselon . ')'
                . ' order by mytmt desc) rj'
                . ' left join identitas i on i.id_identitas = rj.id_identitas'
                . ' group by rj.id_identitas';
        $query = $this->db->query($sql);
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }

}
