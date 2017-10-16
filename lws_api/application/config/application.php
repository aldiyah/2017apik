<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* custom setting */

$config['appname'] = 'Aplikasi Kinerja';
$config['copyright'] = 'Copyright CV. Mitra Indokomp Sejahtera &copy; 2017.';


$config['hashed'] = 'VFUUl2rWS6I5EdSFU2JJyQ==';

$config['appkey'] = '1029384756';

$config['appsalt'] = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

$config['resource_api_link'] = 'http://localhost:43500/BkppRestFulServices-Api/';

$config['lmanuser.usingbackendfrontend'] = FALSE;

/**
 * tabel profil lain yang digunakan selain backbone_profil
 */
$config['another_profil_tablename'] = "sc_akrifwz.master_pegawai";


$config['another_profil_properties']['partial_form_view'] = "back_bone/member/atlant/tr_pegawai_profil";
$config['another_profil_properties']['form_config'] = array(
    "using_select2" => TRUE,
    "input_name" => "id_pegawai",
    "input_type" => "select",
    "additional_js" => array(
        "back_bone/member/atlant/js/tr_pegawai_profil_js",
    ),
    "add_cssfiles" => array("plugins/select2/select2.min.css"),
    "add_jsfiles" => array(
        "plugins/select2/select2.full.min.js",
        "atlant/plugins/summernote/summernote.js",
    ),
);
$config['another_profil_properties']['foreign_key'] = "id_profil";
$config['another_profil_properties']['foreign_key_to_another_profile'] = "pegawai_id";

$config['another_profil_properties']['columns'] = array(
    "pegawai_id",
    "pegawai_nip",
    "pegawai_nama"
);
//$config['another_profil_properties']['related_tables'] = array(
//    "sc_akrifwz.master_jabatan" => array(
//        "fkey" => "jabatan_id",
//        "reference_to" => "sc_akrifwz.master_pegawai",
//        "columns" => array(
//            "keljab_id",
//            "jabatan_nama"
//        ),
//        "referenced" => "LEFT"
//    ),
//);
$config['backend_login_uri'] = 'back_bone/login';

$config['application_upload_location'] = '_assets/uploads/';

$config['application_active_layout'] = 'atlant';

/**
 * ini digunakan untuk memberikan nama schema
 * ketika menggunakan basis data postgres
 */
$config['application_db_schema_name'] = '';

/** ini digunakan ketika aplikasi telah diupload ke hosting */
$config['application_path_location'] = '/home/ikatifau/public_html/';

$config['front_end_css_files'] = array("bootstrap/bootstrap.css", "bootstrap/bootstrap-theme.css");

$config['paging_using_template_name'] = TRUE;


$config["pdf_paper_size"] = 'A5';
$config["pdf_paper_orientation"] = 'L';


/**
 * core/LW_Model.php
 * 
 */
$config['using_insert_and_update_properties'] = TRUE;

$config['created_date'] = 'created_date';
$config['modified_date'] = 'modified_date';
$config['created_by'] = 'created_by';
$config['modified_by'] = 'modified_by';
$config['record_active'] = 'record_active';

$config['default_limit_row'] = 20;
$config['limit_key_param'] = 'limit';
$config['offset_key_param'] = 'offset';
$config['keyword_key_param'] = 'keyword';

/**
 * modul configuration
 * array("nama_modul"=>array("nama_aksi"=>array("nama_aksi_dikontroller")))
 */
$config['modul_action_configuration'] = array(
    "home" => array(
        "insert" => array(),
        "update" => array(),
        "delete" => array(),
        "read" => array("index", "lihataktifitas"),
    ),
    "msaktifitas" => array(
        "insert" => array("detail"),
        "update" => array("detail"),
        "delete" => array("delete"),
        "read" => array("index"),
    ),
    "usaktifitas" => array(
        "insert" => array("detail"),
        "update" => array("detail"),
        "delete" => array("delete"),
        "read" => array("index"),
    ),
    "msusulan" => array(
        "insert" => array(),
        "update" => array("validasi"),
        "delete" => array("delete"),
        "read" => array("index")
    ),
    "aktifitasharian" => array(
        "insert" => array("detail"),
        "update" => array("detail"),
        "delete" => array("delete"),
        "read" => array("index", "get_waktu", "rkbulanan")
    ),
    "aktifitasbawahan" => array(
        "insert" => array(""),
        "update" => array(""),
        "delete" => array(""),
        "read" => array("index", "lihataktifitas")
    ),
    "validasiaktifitas" => array(
        "insert" => array(""),
        "update" => array("validasi", "reject"),
        "delete" => array(""),
        "read" => array("index")
    ),
    "msapi" => array(
        "insert" => array(),
        "update" => array(),
        "delete" => array(),
        "read" => array("like_nip", "lihataktifitas"),
    ),
    "tpaktifitas" => array(
        "insert" => array("pilihaktifitas", "tambahaktifitas", "getaktifitas"),
        "update" => array(),
        "delete" => array("delete"),
        "read" => array(),
    ),
    "setkegiatan" => array(
        "insert" => array("pilihpegawai", "tambahpegawai", "getkegiatan", "pilihkegiatan", "tambahkegiatan"),
        "update" => array("detail"),
        "delete" => array("delete"),
        "read" => array("index"),
    ),
    "setaktifitas" => array(
        "insert" => array("getaktifitas", "pilihaktifitas", "tambahaktifitas", "pilihkegiatan", "tambahkegiatan"),
        "update" => array("detail"),
        "delete" => array("delete"),
        "read" => array("index"),
    ),
    "inputaktifitas" => array(
        "insert" => array("laporan"),
        "update" => array(""),
        "delete" => array(""),
        "read" => array("index"),
    ),
    "trpenilaian" => array(
        "insert" => array("aktifitas", "perilaku", "capaian"),
        "update" => array(""),
        "delete" => array(""),
        "read" => array("index"),
    )
);

/**
 * konstanta id role dengan nama role pegawai negeri sipil
 * digunakan untuk memberikan role secara otomatis pada PNS ketika menambahkan PNS pada referensi data PNS
 * karena ketika menambahkan PNS aplikasi membuatkan username dan password secara otomatis
 */
//$config['id_role_pegawai_negeri_sipil'] = 13;
