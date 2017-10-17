<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class identitas extends MY_Model {

    public $sort_by = 'nip';
    public $sort_mode = 'asc';

    public function __construct() {
        parent::__construct("identitas");
        $this->primary_key = "id_identitas";
    }

    protected $attribute_labels = array(
        "id_identitas" => array("id_identitas", "id_identitas"),
        "kd_status_pegawai" => array("kd_status_pegawai", "kd_status_pegawai"),
        "nip" => array("nip", "nip"),
        "nip_lama" => array("nip_lama", "nip_lama"),
        "tempat_lhr" => array("tempat_lhr", "tempat_lhr"),
        "tanggal_lhr" => array("tanggal_lhr", "tanggal_lhr"),
        "id_agama" => array("id_agama", "id_agama"),
        "gender" => array("gender", "gender"),
        "alamat_rtrw" => array("alamat_rtrw", "alamat_rtrw"),
        "ktp" => array("ktp", "ktp"),
        "askes" => array("askes", "askes"),
        "taspen" => array("taspen", "taspen"),
        "alamat_kelurahan" => array("alamat_kelurahan", "alamat_kelurahan"),
        "alamat_kecamatan" => array("alamat_kecamatan", "alamat_kecamatan"),
        "alamat_jalan" => array("alamat_jalan", "alamat_jalan"),
        "alamat_desa" => array("alamat_desa", "alamat_desa"),
        "alamat_kabkota" => array("alamat_kabkota", "alamat_kabkota"),
        "tmt_kgb" => array("tmt_kgb", "tmt_kgb"),
        "kartu_pegawai" => array("kartu_pegawai", "kartu_pegawai"),
        "kpe" => array("kpe", "kpe"),
        "golongan_darah" => array("golongan_darah", "golongan_darah"),
        "status_kawin" => array("status_kawin", "status_kawin"),
        "npwp" => array("npwp", "npwp"),
        "id_suku" => array("id_suku", "id_suku"),
        "hp1" => array("hp1", "hp1"),
        "hp2" => array("hp2", "hp2"),
        "email1" => array("email1", "email1"),
        "foto" => array("foto", "foto"),
        "nama" => array("nama", "nama"),
        "gelar_dp" => array("gelar_dp", "gelar_dp"),
        "gelar_bl" => array("gelar_bl", "gelar_bl"),
        "flag" => array("flag", "flag"),
        "email2" => array("email2", "email2"),
        "alamat_temp" => array("alamat_temp", "alamat_temp"),
        "tgl_skmulaikerja" => array("tgl_skmulaikerja", "tgl_skmulaikerja"),
        "tgl_tmtcpns" => array("tgl_tmtcpns", "tgl_tmtcpns"),
        "tgl_tmtpns" => array("tgl_tmtpns", "tgl_tmtpns"),
        "sumpah" => array("sumpah", "sumpah"),
        "id_statuskepegawaian" => array("id_statuskepegawaian", "id_statuskepegawaian"),
        "kd_jenis_pegawai" => array("kd_jenis_pegawai", "kd_jenis_pegawai"),
        "create_op" => array("create_op", "create_op"),
        "create_tgl" => array("create_tgl", "create_tgl"),
        "update_op" => array("update_op", "update_op"),
        "update_tgl" => array("update_tgl", "update_tgl"),
        "kd_instansi_induk" => array("kd_instansi_induk", "kd_instansi_induk"),
        "gelar_gb2" => array("gelar_gb2", "gelar_gb2"),
        "gelar_gb3" => array("gelar_gb3", "gelar_gb3"),
        "gelar_gb4" => array("gelar_gb4", "gelar_gb4"),
        "kp_selanjutnya" => array("kp_selanjutnya", "kp_selanjutnya"),
        "idLokasi" => array("idLokasi", "idLokasi"),
        "bapertarum" => array("bapertarum", "bapertarum"),
        "kedudukan_pns" => array("kedudukan_pns", "kedudukan_pns"),
        "no_sumpah" => array("no_sumpah", "no_sumpah"),
    );
    protected $rules = array(
        array("id_identitas", ""),
        array("kd_status_pegawai", ""),
        array("nip", ""),
        array("nip_lama", ""),
        array("tempat_lhr", ""),
        array("tanggal_lhr", ""),
        array("id_agama", ""),
        array("gender", ""),
        array("alamat_rtrw", ""),
        array("ktp", ""),
        array("askes", ""),
        array("taspen", ""),
        array("alamat_kelurahan", ""),
        array("alamat_kecamatan", ""),
        array("alamat_jalan", ""),
        array("alamat_desa", ""),
        array("alamat_kabkota", ""),
        array("tmt_kgb", ""),
        array("kartu_pegawai", ""),
        array("kpe", ""),
        array("golongan_darah", ""),
        array("status_kawin", ""),
        array("npwp", ""),
        array("id_suku", ""),
        array("hp1", ""),
        array("hp2", ""),
        array("email1", ""),
        array("foto", ""),
        array("nama", ""),
        array("gelar_dp", ""),
        array("gelar_bl", ""),
        array("flag", ""),
        array("email2", ""),
        array("alamat_temp", ""),
        array("tgl_skmulaikerja", ""),
        array("tgl_tmtcpns", ""),
        array("tgl_tmtpns", ""),
        array("sumpah", ""),
        array("id_statuskepegawaian", ""),
        array("kd_jenis_pegawai", ""),
        array("create_op", ""),
        array("create_tgl", ""),
        array("update_op", ""),
        array("update_tgl", ""),
        array("kd_instansi_induk", ""),
        array("gelar_gb2", ""),
        array("gelar_gb3", ""),
        array("gelar_gb4", ""),
        array("kp_selanjutnya", ""),
        array("idLokasi", ""),
        array("bapertarum", ""),
        array("kedudukan_pns", ""),
        array("no_sumpah", ""),
    );
    
    protected $related_tables = array(
        "tabel_status_pegawai" => array(
            "fkey" => array("kd_status_pegawai", "kd_status"),
            "columns" => array(
                "kd_status",
                "nama_status",
                "id_status",
            ),
            "referenced" => "LEFT"
        ),
        "riwayat_jabatan" => array(
            "fkey" => "id_identitas",
            "columns" => array(
                "kd_jabatan",
            ),
            "referenced" => "LEFT"
        )
    );
    protected $attribute_types = array();

}
