<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* custom setting */

$config['appname'] = 'FrameWork';
$config['copyright'] = 'Copyright &copy; 2015,.';


$config['hashed'] = 'VFUUl2rWS6I5EdSFU2JJyQ==';

$config['appkey'] = '1029384756';

$config['appsalt'] = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

$config['lmanuser.usingbackendfrontend'] = FALSE;
$config['user_id_column_name'] = "id_user";
$config['profil_id_column_name'] = "id_profil";

/**
 * ini digunakan ketika terdapat tabel selain profil yang digunakan
 */
$config['another_profil_tablename'] = FALSE;
$config['another_profil_properties'] = FALSE;
//$config['another_profil_properties']['foreign_key'] = "id_profil";
//$config['another_profil_properties']['columns'] = array();
//$config['another_profil_properties']['related_tables'] = array();

$config['backend_login_uri'] = 'back_end/member/login';

$config['application_upload_location'] = '_assets/uploads/';
$config['application_upload_images_doctor_location'] = '_assets/uploads/images/doctor/';

$config['application_active_layout'] = 'default';

/**
 * ini digunakan untuk memberikan nama schema
 * ketika menggunakan basis data postgres
 * default value = FALSE ketika basis data tidak menggunakan schema
 */
$config['application_db_schema_name'] = FALSE;

/** ini digunakan ketika aplikasi telah diupload ke hosting */
$config['application_path_location'] = '/home/ikatifau/public_html/';

$config['front_end_css_files'] = array("bootstrap/bootstrap.css", "bootstrap/bootstrap-theme.css");

$config['paging_using_template_name'] = TRUE;


$config["pdf_paper_size"] = 'A5';
$config["pdf_paper_orientation"] = 'L';


/**
 * core/LW_Model.php
 * 
 * menjelaskan kolom
 */
$config['using_insert_and_update_properties'] = TRUE;

$config['created_date'] = 'created_date';
$config['modified_date'] = 'modified_date';
$config['created_by'] = 'created_by';
$config['modified_by'] = 'modified_by';
$config['record_active'] = 'record_active';

/**
 * Mendefinisikan nama-nama tabel back_bone yang digunakan
 */

$config['backbone_modul'] = 'backbone_modul';
$config['backbone_modul_role'] = 'backbone_modul_role';
$config['backbone_profil'] = 'backbone_profil';
$config['backbone_role'] = 'backbone_role';
$config['backbone_user'] = 'backbone_user';
$config['backbone_user_role'] = 'backbone_user_role';

/**
 * Mendefinisikan nama - nama kolom pada tabel backbone_user
 */

$config['backbone_user.username'] = "username";
$config['backbone_user.password'] = "password";
$config['backbone_user.pk_column'] = "id_user";

/**
 * Mendefinisikan parameter dan jumlah data yang akan ditampilkan pada tabel data
 */

$config['default_limit_row'] = 32;
$config['limit_key_param'] = 'limit';
$config['offset_key_param'] = 'offset';
$config['keyword_key_param'] = 'keyword';

/**
 * set record-active value
 * value:
 * 1: ketika menggunakan nama kolom yang memiliki arti positif (cth: record_active)
 * 0: ketika menggunakan nama kolom yang memiliki arti negatif (cth: is_deleted)
 */
$config['record_active_positive_value'] = 1;