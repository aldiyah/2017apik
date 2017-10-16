<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */

/**
 * 
 * Code Wrapper injecting some attributes and reading post/get data automatically
 * 
 * LWS_Model Model Wrapper
 * @package LWS
 * @author Lahir Wisada <lahirwisada@gmail.com>
 */
class LWS_Model extends CI_Model {

    private $on_development = TRUE;
    public $errors = NULL;
    protected $table_name = '';
    protected $schema_name = '';

    /**
     *
     * @var ARRAY 
     * @example protected $attribute_labels = array(
     *   "id_diklat" => array("id_diklat", "Id Diklat"),
     *   "created_date" => array("created_date", "created_date"),
     *   "created_by" => array("created_by", "created_by"),
     *   "modified_date" => array("modified_date", "modified_date"),
     *   "modified_by" => array("modified_by", "modified_by"),
     *   "record_active" => array("record_active", "record_active"),
     * );
     */
    protected $attribute_labels = array();

    /**
     * 
     * will be STRING, DATE, NUMERIC
     * if not set then MIX
     * @author Lahir Wisada <lahirwisada@gmail.com>
     */
    protected $attribute_types = array();
    protected $model_properties = array();
    protected $attributes = array();
    public $primary_key = 'id';
    public $skip_validation = FALSE;
    protected $rules = array();
    public $model_has_post_data = FALSE;
    protected $is_update = FALSE;
    protected $is_insert = FALSE;
    protected $inserted_id = FALSE;
    private $escape_string = TRUE;
    public $related_data = FALSE;

    /**
     * Digunakan untuk melakukan join ke tabel2 relasinya
     * asumsi entity adalah entitas dari tabel kecamatan
     * 
     * @author Lahir Wisada <lahirwisada@gmail.com>
     * @var array 
     * @example protected $related_tables = array(
     *   "ref_kabupaten_kota" => array(
     *       "fkey" => "id_kabupaten_kota",
     *       "columns" => array(
     *           "nama_kabupaten",
     *           "kode_kabupaten",
     *           "is_ibukota",
     *       ),
     *       "referenced" => "LEFT"
     *   ),
     *   "ref_jenis_diklat" => array(
     *       "fkey" => "id_jenis_diklat",
     *       "columns" => array(
     *           "jenis_diklat",
     *       ),
     *       "referenced" => "INNER"
     *   ),
     *   "ref_provinsi" => array(
     *       "fkey" => "id_provinsi",
     *       "reference_to" => "ref_kabupaten_kota",
     *       "columns" => array(
     *           "nama_provinsi",
     *           "kode_provinsi",
     *       ),
     *       "referenced" => "LEFT"
     *   ),
     *   "table_name_1" => array(
     *       "fkey" => "foreign_key_id_1",
     *       "reference_to" => "reference_to_another_table",    // if not reference to current table ($this->table_name)
     *       "columns" => array(
     *           "column1",
     *           array("column2", "alias_column2"),
     *       ),
     *       "referenced" => "LEFT"
     *   ),
     *   "table_name_2" => array(
     *       "fkey" => array("foreign_key_id_2", "ID"),          // array index 0 explain name of foreign key on table_name_2
     *                                                           // array index 1 explain name of primary key on table origin       
     *       "reference_to" => "reference_to_another_table_x",   // if not reference to current table ($this->table_name)
     *       "columns" => array(
     *           "column1a",
     *           array("column2", "alias_column2_a"),
     *       ),
     *       "referenced" => "LEFT"
     *   ),
     * );
     */
    protected $related_tables = array();

    /**
     * untuk mendapatkan nilai limit dari variabel yang di POST
     * @var type string
     */
    protected $limit_key_param = 'limit';
    protected $current_limit_value = 5;

    /**
     * untuk mendapatkan nilai offset dari variabel yang di POST
     * @var type string
     */
    protected $offset_key_param = 'offset';
    protected $current_offset_value = 1;

    /**
     * untuk mendapatkan nilai keyword dari variabel yang di POST
     * @var type string
     */
    protected $keyword_key_param = 'keyword';
    protected $using_insert_and_update_properties = TRUE;
    protected $using_backend_front_end = FALSE;
    protected $created_date_column_name = 'created_date';
    protected $modified_date_column_name = 'modified_date';
    protected $created_by_column_name = 'created_by';
    protected $modified_by_column_name = 'modified_by';
    protected $record_active_column_name = 'record_active';
    protected $record_active_positive_value = 1;
    protected $_continuously_attribute_label = array();
    protected $_continuously_rules = array();
    protected $backbone_user_username = 'username';
    protected $backbone_user_password = 'password';
    protected $backbone_user_pk_column = 'id_user';
    public $sort_by = '';
    public $sort_mode = 'desc';

    function __construct($table_name = '') {
// Call the Model constructor
        parent::__construct();

        $this->__set_default_table_name($table_name);


        $this->errors = new model_error();



        $using_backend_front_end = $this->config->item("lmanuser.usingbackendfrontend");
        if ($using_backend_front_end) {
            $this->using_backend_front_end = $using_backend_front_end;
        }

        /**
         * please don't disturb this code
         */
        $this->__configure_limit_offset_param();
        $this->__configure_insert_and_update_properties();

        $this->__set_continuously_attribute_label();
        $this->__set_continuously_rules();

        if ($this->sort_by == '') {
            $this->sort_by = $this->modified_date_column_name;
        } /**
         * end here
         */
        $this->__set_backbone_user_columns();
    }

    private function __set_backbone_user_columns() {
        $username_column = $this->config->item('backbone_user.username');
        $password_column = $this->config->item('backbone_user.password');

        $pk_column = $this->config->item('backbone_user.pk_column');

        if ($username_column) {
            $this->backbone_user_username = $username_column;
        }

        if ($password_column) {
            $this->backbone_user_password = $password_column;
        }

        if ($pk_column) {
            $this->backbone_user_pk_column = $pk_column;
        }
    }

    /**
     * Set default table name
     * 
     * Untuk pertama kalinya aplikasi akan mencari nama tabel pada -
     * file konfigurasi config/application.php
     * 
     * ketika ditemukan nama tabel pada file konfigurasi tersebut -
     * maka aplikasi akan menggunakan nama tabel yang terdapat pada -
     * file kofigurasi tersebut
     * 
     * jika tidak ditemukan nama tabel pada file konfigurasi tersebut,
     * maka aplikasi akan menggunakan nama tabel yang telah didefinisikan pada -
     * constructor
     * 
     * @author Lahir Wisada <lahirwisada@gmail.com>
     * @return void Aplikasi akan menset nama tabel kepada variabel $this->table_name
     */
    private function __set_default_table_name($table_name) {

        $cfg_schema_name = $this->config->item("application_db_schema_name");

        $cfg_table_name = $this->config->item($table_name);

        $table_name = $cfg_table_name ? $cfg_table_name : $table_name;

        if ($table_name != '') {
            $this->table_name = $cfg_schema_name ? $cfg_schema_name . '.' . $table_name : $table_name;
            $this->schema_name = $cfg_schema_name;
        }
    }

    /**
     * please don't disturb this code
     */
    private function __set_continuously_attribute_label() {
        $this->_continuously_attribute_label = array(
            $this->created_date_column_name => array($this->created_date_column_name, $this->created_date_column_name),
            $this->created_by_column_name => array($this->created_by_column_name, $this->created_by_column_name),
            $this->modified_date_column_name => array($this->modified_date_column_name, $this->modified_date_column_name),
            $this->modified_by_column_name => array($this->modified_by_column_name, $this->modified_by_column_name),
            $this->record_active_column_name => array($this->record_active_column_name, $this->record_active_column_name),
        );
    }

    /**
     * please don't disturb this code
     */
    private function __set_continuously_rules() {
        $this->_continuously_rules = array(
            array($this->created_date_column_name, ""),
            array($this->created_by_column_name, ""),
            array($this->modified_date_column_name, ""),
            array($this->modified_by_column_name, ""),
            array($this->record_active_column_name, ""),
        );
    }

    /**
     * please don't disturb this code
     */
    private function __configure_limit_offset_param() {
        $config_items = array("limit_key_param", "offset_key_param", "keyword_key_param",
            "using_insert_and_update_properties");

        foreach ($config_items as $config_item) {
            $config_item_value = $this->config->item($config_item);
            if ($config_item_value) {
                $this->{$config_item} = $config_item_value;
            }
        }
    }

    /**
     * please don't disturb this code
     */
    private function __configure_insert_and_update_properties() {

        $config_items = array("created_date", "modified_date", "created_by",
            "modified_by", "record_active");

        foreach ($config_items as $config_item) {
            $config_item_value = $this->config->item($config_item);
            if ($config_item_value) {
                $var_string_name = $config_item . "_column_name";
                $this->{$var_string_name} = $config_item_value;
            }
        }

        $record_active_positive_value = $this->config->item('record_active_positive_value');
        $this->record_active_positive_value = $record_active_positive_value !== FALSE ? $record_active_positive_value : 1;
    }

    public function get_backbone_table_name($backbone_tablename) {
        $_config_backbone_tablename = $this->config->item($backbone_tablename);
        if ($_config_backbone_tablename) {
            return $_config_backbone_tablename;
        }

        return $backbone_tablename;
    }

    /**
     * replace blank to NULL
     * @param type $array_blank_post
     * @return type
     */
    protected function __replace_blank_post_with_null($array_null_post = array()) {
        if (!empty($array_null_post)) {
            foreach ($array_null_post as $null_post) {
                if ($this->{$null_post} == "") {
                    $this->{$null_post} = "NULL";
                } else {
                    $this->{$null_post} = "'" . $this->{$null_post} . "'";
                }
            }
        }
        return;
    }

    public function get_record_active_column_name() {
        return $this->record_active_column_name;
    }

    public function get_created_date_column_name() {
        return $this->created_date_column_name;
    }

    public function get_created_by_column_name() {
        return $this->created_by_column_name;
    }

    public function get_modified_date_column_name() {
        return $this->modified_date_column_name;
    }

    public function get_modified_by_column_name() {
        return $this->modified_by_column_name;
    }

    /**
     * 
     * Menambahkan nama schema di depan nama tabel
     * contoh output:
     *          1. Jika parameter pertama tidak kosong (tidak FALSE) maka : [nama_schema].[nama_tabel]
     *             contoh output real : schema_name.table_name
     *          2. Jika parameter pertama kosong maka : [nama_schema]
     *             contoh output real : schema_name
     * 
     * @author Lahir Wisada <lahirwisada@gmail.com>
     * 
     * @param string $table_name nama tabel yang akan diimbuhkan dengan nama schema depannya
     * @param boolean $reload_schema default FALSE, ini digunakan untuk memanggil ulang nama schema-
     *                               yang terdapat pada config/application.php tetapi tidak di tetapkan-
     *                               pada $this->schema_name, hanya digunakan sekali waktu pada saat fungsi ini dipanggil
     * @return string
     */
    protected function get_schema_name($table_name = FALSE, $reload_schema = FALSE) {

        $schema_name = $this->schema_name;

        if ($reload_schema) {
            $schema_name = $this->config->item("application_db_schema_name");
        }

        if (!$table_name) {
            return $schema_name;
        }

        return $schema_name ? $schema_name . '.' . $table_name : $table_name;
    }

    public function get_table_name() {
        return $this->table_name;
    }

    protected function before_get_data_post() {
        
    }

    protected function after_get_data_post() {
        
    }

    public function escape_string($string_to_be_escape = "") {
        if (is_string($string_to_be_escape)) {
            return $this->db->escape_str(trim($string_to_be_escape));
        }
        if (is_array($string_to_be_escape)) {
            foreach ($string_to_be_escape as $key => $value) {
                $string_to_be_escape[$key] = $this->escape_string($value);
            }
            return $string_to_be_escape;
        }
        if (is_object($string_to_be_escape)) {
            $tmp_arr_obj = (array) $string_to_be_escape;
            $tmp_arr_obj = $this->escape_string($tmp_arr_obj);
            $string_to_be_escape = (object) $tmp_arr_obj;
            return $string_to_be_escape;
        }
        return $string_to_be_escape;
    }

    public function get_primarykeys_from_rs($rs = FALSE) {
        $primary_keys = FALSE;
        if ($rs) {
            $primary_keys = array();
            foreach ($rs as $record) {
                if (isset($record->{$this->primary_key})) {
                    $primary_keys[] = $record->{$this->primary_key};
                }
            }
        }
        return $primary_keys;
    }

    public function before_show_detail($id = FALSE, $record_active = TRUE) {
        return;
    }

    public function after_show_detail($record_found = FALSE) {
        return $record_found;
    }

    public function get_active_value($positive = TRUE) {
        if ($positive) {
            return $this->record_active_positive_value;
        }

        return $this->record_active_positive_value == 1 ? 0 : 1;
    }

    public function show_detail($id = FALSE, $record_active = TRUE, $fields = NULL) {
        if ($id) {
            $this->before_show_detail($id, $record_active);
            $where = $this->table_name . "." . $this->primary_key . " = '" . $id . "'";
            if ($record_active && $this->using_insert_and_update_properties) {
                $where .= " and " . $this->table_name . "." . $this->record_active_column_name . " <> '" . $this->get_active_value(FALSE) . "'";
            }

            $record_found = $this->get_detail($where, $fields);
            $updated_record = $this->after_show_detail($record_found);
            unset($record_found);
            return $updated_record;
        }
        return FALSE;
    }

    public function get_detail($where = NULL, $fields = NULL, $order_by = NULL, $table_name = NULL) {
        if ($this->table_name != NULL) {
            $table_name = $table_name == NULL ? $this->table_name : $table_name;
            if ($fields !== FALSE) {
                $this->db->select(($fields != NULL ? $fields : $this->table_name . ".*"), FALSE)
                        ->from($table_name);
            } else {
                $this->db->from($table_name);
            }
            if ($where != NULL) {
                $this->db->where($where);
            }
            if ($order_by != NULL) {
                $this->db->order_by($order_by);
            }

            $this->get_select_referenced_table();

            $q = $this->db->get();
            if ($q && $q->num_rows() > 0) {
                return $q->row();
            }
        }
        return FALSE;
    }

    protected function set_insert_property() {
        /*
          $this->CREATED_TIME = date('d/m/Y');
          $this->CREATED_BY = $_SESSION['webdbPemakai'];
          $this->CREATED_IP = $_SERVER['REMOTE_ADDR'];
         * 
         */
        $this->{$this->created_date_column_name} = date('Y-m-d');
        $this->{$this->created_by_column_name} = "";
        $this->{$this->record_active_column_name} = $this->get_active_value(TRUE);
    }

    protected function set_update_property($username = FALSE) {
        /*
          $this->UPDATED_TIME = date('d/m/Y');
          $this->UPDATED_BY = $_SESSION['webdbPemakai'];
          $this->UPDATED_IP = $_SERVER['REMOTE_ADDR'];
         * 
         */
        $this->{$this->modified_date_column_name} = date('Y-m-d');
        $this->{$this->modified_by_column_name} = ($username ? $username : "");
    }

    protected function get_back_end_username() {
        $created_by = $this->lmanuser->get_back_end_username();
        if (!$created_by) {
            $created_by = "Admin";
        }
        return $created_by;
    }

    protected function unset_attributes_data() {
        $this->attributes = array();
    }

    /**
     * 
     * @param object $object_clob 
     */
    public function read_clob($object_clob) {
        if ($object_clob &&
                is_object($object_clob) &&
                is_a($object_clob, 'OCI-Lob')) {
            return $object_clob->read($object_clob->size());
        }
        return "";
    }

    public function get_data_post($strict_check_post = TRUE, $array_form_name_data_post = array()) {
        $this->model_has_post_data = FALSE;
        $this->before_get_data_post();
        $post_data_ok = FALSE;
        $form_name_to_be_collected = $this->get_attributes_label_key();
        if (!$strict_check_post && count($array_form_name_data_post) > 0) {
            $form_name_to_be_collected = $array_form_name_data_post;
        }

        if ($this->check_post_data($strict_check_post, $form_name_to_be_collected) && (count($_POST) > 0 || !empty($_POST))) {
            $post_data_ok = TRUE;
        }

        if ($post_data_ok) {
            foreach ($form_name_to_be_collected as $field) {
                $this->{$field} = $this->escape_string($this->input->post($field));
            }

            $this->after_get_data_post();
            $this->model_has_post_data = TRUE;
        }

        unset($form_name_to_be_collected, $array_form_name_data_post);
        return $this->model_has_post_data;
    }

    /**
     * must return TRUE
     * if return FALSE then save() can not run
     */
    protected function before_save($primary_key_value = FALSE) {
        return TRUE;
    }

    protected function before_update() {
        return TRUE;
    }

    protected function after_update() {
        return;
    }

    protected function after_save() {
        return;
    }

    private function reset_save_status() {
        $this->is_update = FALSE;
        $this->is_insert = FALSE;
        $this->inserted_id = FALSE;
    }

    public function remove_children($table_name, $id_value = FALSE, $field_name = FALSE) {
        if ($id_value && $field_name) {
            $field_name = strtoupper($field_name);
            $this->db->set($field_name, NULL);
            $this->db->where($field_name . " = '" . $id_value . "'");
            $this->db->update($this->table_name);
        }
        return;
    }

    public function set_non_active($id_value = FALSE, $flag_del_name = 'record_active', $using_where = FALSE) {

        if ($flag_del_name == 'record_active') {
            $flag_del_name = $this->record_active_column_name;
        }

        $active_value = $this->get_active_value(FALSE);
//        $data[$flag_del_name] = "'" . $this->get_active_value(FALSE) . "'";
        $data[$flag_del_name] = $this->get_active_value(FALSE);
        if (array_key_exists($flag_del_name, $this->attribute_types)) {
            if (strtolower($this->attribute_types[$flag_del_name]) == 'bit') {
                $data[$flag_del_name] = ($active_value) ? TRUE : FALSE;
            }
        }

        if ($id_value) {
            $this->db->where($this->primary_key, $id_value);
            $this->db->update($this->table_name, $data);
        } elseif ($using_where) {
            $this->db->update($this->table_name, $data);
        }

        unset($data);
        return;
    }

    public function remove_by_foreign_key($id_value = FALSE, $foreign_key_name = FALSE, $using_where = FALSE) {
        if ($id_value && $foreign_key_name) {
            $this->db->delete($this->table_name, array($foreign_key_name => $id_value));
            return TRUE;
        }
        return FALSE;
    }

    protected function before_remove() {
        return TRUE;
    }

    public function remove($id_value = FALSE, $using_where = FALSE) {
        if ($id_value && $this->before_remove()) {
            $this->db->delete($this->table_name, array($this->primary_key => $id_value));
        }
        return;
    }

    public function set_escape_string($val = TRUE) {
        $this->escape_string = $val;
    }

    public function set_escape_string_to_true() {
        $this->set_escape_string();
    }

    public function set_escape_string_to_false() {
        $this->set_escape_string(FALSE);
    }

    private function attribute_type_test() {
        if (!empty($this->attribute_types)) {
            if (in_array("DATE", $this->attribute_types) && $this->db->dbdriver == "oracle") {
                $this->escape_string = FALSE;
                foreach ($this->attribute_types as $key => $value) {
                    if ($value == "DATE") {
                        $oracle_date = convert_to_oracle_date($this->{$key});
                        if ($this->{$key} != "" && $oracle_date != "") {
                            $this->{$key} = "to_date('" . $oracle_date . "','YYYY-MM-DD')";
                        } else {
                            unset($this->attributes[$key]);
                        }
                    }
                }
            }
        }
    }

    protected function check_is_update($primary_key_value = FALSE) {
        if (!$primary_key_value) {
            $this->is_insert = TRUE;
        } else {
            $this->is_update = TRUE;
        }
        return;
    }

    /**
     * support for blob insertion but not tested yet
     * if insert will return inserted_id
     * @author Lahir Wisada <lahirwisada@gmail.com>
     */
    public function save($primary_key_value = FALSE) {
        $ret = FALSE;

        $this->check_is_update($primary_key_value);

        if ($this->using_insert_and_update_properties) {
            if (!$primary_key_value) {
                $this->set_insert_property();
            }
            $this->set_update_property();
        }

        $before_save = $this->before_save($primary_key_value);
        if (!$before_save) {
            return FALSE;
        }
        
        $this->attribute_type_test();

        if (!$primary_key_value) {

            $data = $this->before_data_insert($this->attributes);

            if (!empty($this->attribute_types)) {
                if (in_array('CLOB', $this->attribute_types)) {
                    $arr_value_blob = array();
                    $arr_text_blob = array();
                    foreach ($this->attribute_types as $key => $value) {
                        if ($value == "CLOB") {
                            $arr_value_blob[] = array("name" => ":" . $key, "value" => $data[$key]);
                            $data[$key] = ":" . $key;
                            $arr_text_blob[] = $key . " = " . ":" . $key;
                        }
                    }

                    $inserted_id = $this->data_insert($data);
                    $arr_value_blob[] = array("name" => ":" . $this->primary_key, "value" => $inserted_id);
                    $set_for_update = implode(", ", $arr_text_blob);
                    $sql = "UPDATE " . $this->table_name . " SET " . $set_for_update
                            . " WHERE " . $this->primary_key . " = :" . $this->primary_key;

                    $this->db->query($sql, $arr_value_blob, TRUE);
                    $ret = $inserted_id;
                } elseif (!in_array('CLOB', $this->attribute_types)) {
                    foreach ($data as $key => $val) {
                        if (in_array($key, array_keys($this->attribute_types)) &&
                                $this->attribute_types[$key] == 'DATE') {
                            $this->db->set($key, $val, FALSE);
                        } else {
                            $this->db->set($key, $val);
                        }
                    }
                    if ($this->db->dbdriver == 'postgre') {
                        $ret = $this->data_insert($data);
                    } else {
                        $ret = $this->data_insert($data, TRUE);
                    }
                }
            } else {
                $ret = $this->data_insert($data);
            }
        } else {
            $before_update_ok = $this->before_update();
            if ($before_update_ok) {
                $data = $this->before_data_update($this->attributes);
                $this->inserted_id = $primary_key_value;
                $ret = $this->data_update($data, $this->primary_key . " = '" . $primary_key_value . "'");
            }
            $this->after_update();
        }
        $after_save_response = $this->after_save($ret);
        if ($after_save_response != NULL) {
            $ret = $after_save_response;
            unset($after_save_response);
        }
        $this->reset_save_status();
        return $ret;
    }

    public function select_next_id() {
        $table_name = $this->table_name;
        $primary_key = $this->primary_key;
        if ($this->db->dbprefix != '') {
            $table_name = $this->db->dbprefix . $table_name;
            $primary_key = $table_name . "." . $primary_key;
        }
        if ($this->db->dbdriver == 'postgre') {
            $sql = "select max(" . $primary_key . ") as next_id from " . $table_name;
        } elseif ($this->db->dbdriver == 'sqlsrv') {
            $sql = "select ident_current('" . $table_name . "') as next_id ";
        } else {
            $sql = "select nvl(max(" . $primary_key . "),0) + 1 as next_id from " . $table_name;
        }

        $res = $this->db->query($sql)->row();
        if (property_exists($res, 'NEXT_ID')) {
            return $res->NEXT_ID;
        } elseif (property_exists($res, 'next_id')) {
            return $res->next_id;
        }
        return NULL;
    }

    public function select_inserted_id() {
        if (!empty($this->attributes)) {
            $this->db->where($this->attributes);
            $detail = $this->get_detail();
            if ($detail && isset($detail->{$this->primary_key})) {
                $inserted_id = $detail->{$this->primary_key};
                unset($detail);
                return $inserted_id;
            }
        }
        return FALSE;
    }

    protected function before_data_insert($data = FALSE) {
        return $data;
    }

    protected function before_data_update($data = FALSE) {
        return $data;
    }

    public function data_insert($data = FALSE, $using_ar_set = FALSE) {

        if ($this->table_name != NULL && $data) {
            if ($this->db->dbdriver == 'mysql') {
                $this->db->insert($this->table_name, $data);
                return $this->db->insert_id();
            } else {
                if ($this->on_development && !in_array($this->db->dbdriver, array('postgre', 'sqlsrv'))) {
                    $data[$this->primary_key] = $this->select_next_id();
                }
                if ($using_ar_set) {
                    if (!in_array($this->db->dbdriver, array('postgre', 'sqlsrv'))) {
                        $this->db->set($this->primary_key, $this->select_next_id());
                    }
                    $this->db->insert($this->table_name);
                } else {
                    $this->db->insert($this->table_name, $data);
                    if ($this->db->dbdriver == 'postgre') {
                        $data[$this->primary_key] = $this->select_next_id();
                    }
                }
                $this->inserted_id = $data[$this->primary_key];
                return $this->inserted_id;
            }
        }
        return FALSE;
    }

    public function get_where($where = NULL, $fields = NULL, $order_by = NULL, $return_as_query = FALSE, $tbl_from = FALSE) {
        $rs = FALSE;
        $before_get_where_response = $this->before__get_where();
        if ($this->table_name != NULL && $before_get_where_response !== FALSE) {
            $select_from = $this->table_name;
            if ($tbl_from) {
                $select_from = $tbl_from;
            }

            if ($fields && $fields != NULL) {
                $this->db->select($fields != NULL ? $fields : "*", FALSE)
                        ->from($select_from);
            } else {
                $this->db->from($select_from);
            }

            if ($where != NULL) {
                $this->db->where($where);
            }

            if (!$this->force_no_order()) {
                if ($order_by != NULL) {
                    $this->db->order_by($order_by);
                } else {
                    if ($this->sort_by && $this->sort_mode && count($this->db->ar_orderby) <= 0) {

                        $this->sort_by = $this->is_table_name_in_string($this->sort_by, TRUE);

                        $preg_found = preg_match_all("|" . $this->get_schema_name() . "|", $this->table_name, $matches);

                        if ($preg_found && count(current($matches)) == 1) {
                            $this->db->order_by($this->sort_by, $this->sort_mode);
                        }
                    }
                }
            }

            if ($return_as_query) {
                /* SELECT */ //$this->db->_compile_select();
                /* INSERT */ //$this->db->_insert();
                /* UPDATE */ //$this->db->_update();
                return $this->db->_compile_select();
            }
            $q = $this->db->get();
            if ($q && $q->num_rows() > 0) {
                $rs = $q->result();
//                unset($q);
            }

            $this->lws_free_result($q);
//            $q->free_result();
        }
        return $rs;
    }

    public function data_update($data, $where) {
        if ($this->table_name != NULL) {
            if ($this->escape_string) {
                return $this->db->update($this->table_name, $data, $where);
            } else {
                foreach ($data as $key => $val) {
                    $escape = TRUE;
                    if ($val != "") {
                        if (array_key_exists($key, $this->attribute_types) &&
                                $this->attribute_types[$key] != "STRING") {
                            $escape = FALSE;
                        }
                        $this->db->set($key, $val, $escape);
                    }
                }
                return $this->db->update($this->table_name, NULL, $where);
            }
        }
        return FALSE;
    }

    protected function check_attributes_label() {
        return is_array($this->attribute_labels) && !empty($this->attribute_labels);
    }

    public function get_attributes_label_key() {
        if ($this->check_attributes_label())
            return array_keys($this->attribute_labels);

        return array();
    }

    public function get_attributes() {
        return $this->attributes;
    }

    public function get_attributes_as_object() {
        return (object) $this->get_attributes();
    }

    public function check_post_data($strict = TRUE, $array_form_name_data_post = array()) {
        if ($strict) {
            return is_arr_key_exists($this->get_attributes_label_key(), $_POST, $strict);
        }

        return is_arr_key_exists($array_form_name_data_post, $_POST, $strict);
    }

    public function check_model_data_value($predefine = FALSE, $mix_data_value = FALSE) {
        $ret = FALSE;
        if (!empty($this->attributes) || $predefine) {
            foreach ($this->get_attributes_label_key() as $field) {
                if ($mix_data_value !== FALSE && is_object($mix_data_value)) {
                    $this->attributes[$field] = $mix_data_value->{$field};
                } elseif ($mix_data_value !== FALSE && is_array($mix_data_value)) {
                    $this->attributes[$field] = $mix_data_value[$field];
                } elseif (!array_key_exists($field, $this->attributes) && $mix_data_value === FALSE) {
                    $this->attributes[$field] = NULL;
                }
            }
            $ret = TRUE;
        }

        return $ret;
    }

    public function get_model_data_value($predefine = FALSE, $as_object = TRUE) {
        if ($this->check_model_data_value($predefine))
            return $as_object ? toObject($this->attributes) : $this->attributes;

        return FALSE;
    }

    public function model_data_value_to_array() {
        if ($this->check_model_data_value())
            return $this->attributes;
    }

    public function set_model_data_value($key, $value = FALSE, $add_default_value = FALSE) {
        if ($value) {
            if ($value == '' && $add_default_value !== FALSE)
                $value = $add_default_value;

            $this->attributes[$key] = $value;
        }
        return;
    }

    public function set_attribute_from_array($attribute_name, $obj_array = array()) {
        if (array_value_is_ok($obj_array, $attribute_name)) {
            $this->{$attribute_name} = $obj_array[$attribute_name];
        }
    }

    function __get($key) {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }

        if (property_exists($this, $key)) {
            return $this->$key;
        }
        $CI = & get_instance();
        return isset($CI->$key) ? $CI->$key : FALSE;
    }

    public function __set($name, $value) {
        if (method_exists($this, "set_$name")) {
            $name = "set_$name";
            return $this->$name($value);
        }

        if ($name == 'id')
            $this->attributes[$this->primary_key] = $value;
        else {
            if (!in_array($name, $this->model_properties)) {
                $this->attributes[$name] = $value;
            } else {
                $this->$name = $value;
            }
        }
        return;
    }

    public function is_table_name_in_string($string = FALSE, $set_if_not_found = FALSE) {
        if ($string && strpos($string, $this->table_name)) {
            return TRUE;
        }

        if ($set_if_not_found) {
            if (strpos($string, $this->table_name) === FALSE) {
                return $this->table_name . "." . $string;
            }
            return $string;
        }
        return FALSE;
    }

    public function is_valid($posted_data = FALSE) {
        $this->skip_validation = FALSE;
        if ($posted_data) {
            return $this->_run_validation_by_posted_data($posted_data);
        }
        return $this->_run_validation($this->attributes);
    }

    /*
     * must return TRUE
     * if return FALSE then is_valid() return FALSE to
     */

    protected function before_run_validation() {
        return TRUE;
    }

    protected function after_run_validation($is_valid) {
        return;
    }

    private function __is_skip_validation() {
        if ($this->skip_validation) {
            return TRUE;
        }
        $this->load->library("form_validation");
        return FALSE;
    }

    private function _run_validation_by_posted_data($posted_data = FALSE) {
        if ($this->__is_skip_validation()) {
            return TRUE;
        }

        if (!empty($this->rules) && $posted_data && array_have_value($posted_data)) {
            if (array_have_value($this->rules)) {
                $existing_rules = $this->rules;
                foreach ($posted_data as $rule) {
//                    var_dump($rule);exit;
                    if (count($rule) == 0)
                        continue;

                    $this->form_validation->set_rules(
                            $rule[0], $this->attribute_labels[$rule[0]][1], $rule[1]);
//                    $attr = $rule[0];
//                    $rule_param = explode("|", $rule[1]);
//                    $this->_validate($attr, $rule_param);
                }
                $ret_before_run_validation = $this->before_run_validation();
                if (!$ret_before_run_validation) {
                    return FALSE;
                }

                if (!$this->form_validation->run()) {
                    $this->errors->list = $this->form_validation->get_error_array();
                    $this->errors->error_found = TRUE;
                }
                $this->after_run_validation(!$this->errors->error_found);
            }
//            var_dump($this->errors->list);exit;

            return !$this->errors->error_found;
        }
        return TRUE;
    }

    private function _run_validation() {
        if ($this->__is_skip_validation()) {
            return TRUE;
        }

        if (!empty($this->rules)) {
            if (is_array($this->rules) && count($this->rules) > 0) {

                foreach ($this->rules as $rule) {
//                    var_dump($rule);exit;
                    if (count($rule) == 0)
                        continue;

                    $this->form_validation->set_rules(
                            $rule[0], $this->attribute_labels[$rule[0]][1], $rule[1]);
//                    $attr = $rule[0];
//                    $rule_param = explode("|", $rule[1]);
//                    $this->_validate($attr, $rule_param);
                }
                $ret_before_run_validation = $this->before_run_validation();
                if (!$ret_before_run_validation) {
                    return FALSE;
                }

                if (!$this->form_validation->run()) {
                    $this->errors->list = $this->form_validation->get_error_array();
                    $this->errors->error_found = TRUE;
                }
                $this->after_run_validation(!$this->errors->error_found);
            }
//            var_dump($this->errors->list);exit;

            return !$this->errors->error_found;
        }
        return TRUE;
    }

    /**
     * 
     * @param string $name
     * @return string
     */
    public function get_label($name) {
        if (array_key_exists($name, $this->attribute_labels)) {
            return $this->attribute_labels[$name];
        }
        return $name;
    }

    public function get_label_assoc() {
        return $this->attribute_labels;
    }

    protected function _validate($attribute, $rules) {
        $var = $this->check_model_data_value() ? $this->data_value->{$attribute} : NULL;
        $this->form_validation->_exec(array(
            'field' => $attribute,
            'is_array' => FALSE,
            'label' => $this->get_label($attribute)
                ), $rules, $var);

        $error = $this->form_validation->error($attribute);
        if ($error != '') {
            $this->errors->add($attribute, $error);
        }
    }

    protected function execute_query($sql_query, $row_start = 1, $row_end = 10) {
        $sql = "select * from (" . $sql_query . ") where r > " . $row_start . " and r <= " . $row_end;
        $query = $this->db->query($sql);
        /* reset after execute query */
        $this->db->_reset_select();
        $rs = $query->result();
        $this->lws_free_result($query);
//        unset($query);
        return $rs;
    }

    protected function lws_free_result($query = FALSE) {

//        var_dump($this->db->result_id, $this->db->dbdriver == 'mysql', $this->db->dbdriver, $this->db->username);exit;

        if ($this->db->dbdriver == 'mysql') {
            if ($query && is_a($query, 'CI_DB_mysql_result') && property_exists($query, 'result_id')) {
                mysql_free_result($query->result_id);
                $query->result_id = FALSE;
            }
        }

//        var_dump($query, $this->db->result_id);exit;
        return;
    }

    protected function parse_procedure_parameters($parameters = array()) {
        $result_parameters = "";
//        var_dump($parameters , is_array($parameters) , count($parameters) > 0);exit;
        if ($parameters && is_array($parameters) && count($parameters) > 0) {
            return $this->db->configure_procedure_parameters($parameters);
        }
        return $result_parameters;
    }

    protected function call_procedure($procedure_query = FALSE, $get_detail = FALSE) {
        if ($procedure_query) {
            $procedure_executor = $this->db->get_procedure_executor();

            $sql_query = $procedure_executor . " " . $procedure_query;

            return $this->execute_procedure($sql_query, $get_detail);
        }
        return FALSE;
    }

    protected function execute_procedure($sql_query, $get_detail = FALSE) {
        if (!$this->db) {
            return FALSE;
        }
        $query = $this->db->query($sql_query);
        $rs = FALSE;
        if ($query && $get_detail) {
            return $query->row();
        } elseif ($query && !$get_detail) {
            $rs = $query->result();
        }
        $this->lws_free_result($query);
//        $query->free_result();
        return $rs;
    }

    /**
     * combobox(array(
     * "key"=>"column_id_pk",
     * "value"=>"column_desc",
     * "cb_using_default_value"=>TRUE,
     * "cb_default_value"=>0,
     * "record_active_only" => TRUE,
     * "order_by"=>"",
     * "order_direction"=>"asc",
     * "table_name"=>"table_name", 
     * "where_no_quote"=>FALSE))
     */
    public function combobox() {
        $args = & func_get_args();

        if (!is_array($args) && count($args) < 1) {
            return array();
        }

        extract(current($args));

        $key = isset($key) ? $key : FALSE;
        $value = isset($value) ? $value : FALSE;
        $where = isset($where) ? $where : "";
        $custom_select = isset($custom_select) ? $custom_select : FALSE;

        if (!$key || !$value) {
            return array();
        }

        $t_name = $this->table_name;
        if ($this->table_name == '' && !isset($table_name))
            return FALSE;
        elseif ($this->table_name == '' && isset($table_name) && $table_name != "")
            $t_name = $table_name;

        if (!$custom_select) {
            $this->db->select($this->table_name . "." . $key . ", " . $this->table_name . "." . $value);
        } else {
            $this->db->select($custom_select, FALSE);
        }
        if ($where != "") {
            if (isset($where_no_quote) && $where_no_quote) {
                $this->db->where($where, NULL, FALSE);
            } else {
                $this->db->where($where);
            }
        }

        $record_active_only = isset($record_active_only) ? $record_active_only : TRUE;
        if ($record_active_only) {
            $this->db->where($t_name . "." . $this->record_active_column_name . " != '" . $this->get_active_value(FALSE) . "'");
        }

        $order_by = isset($order_by) ? $order_by : "";
        $order_direction = isset($order_direction) ? $order_direction : "asc";
        if ($order_by != "") {
            $this->db->order_by($order_by, $order_direction);
        }
        $q = $this->db->get($t_name);
        $result = $q->result();
        $this->lws_free_result($q);
//        $q->free_result();
        $options = array();
        if ($result) {
            foreach ($result as $row) {
                $options[$row->{$key}] = $row->{$value};
            }
        }
        $cb_using_default_value = isset($cb_using_default_value) ? $cb_using_default_value : TRUE;
        $cb_default_value = isset($cb_default_value) ? $cb_default_value : 0;
        if ($cb_using_default_value) {
            $options = array($cb_default_value => '-- Silahkan Pilih --') + $options;
        }
        return $options;
    }

    public function get_limit_key_param() {
        return $this->limit_key_param;
    }

    public function change_limit_param($limit_param) {
        $this->limit_key_param = $limit_param;
    }

    public function change_offset_param($offset_param) {
        $this->offset_key_param = $offset_param;
    }

    public function get_offset_key_param() {
        return $this->offset_key_param;
    }

    public function get_current_limit_value() {
        return $this->current_limit_value;
    }

    public function get_current_offset_value() {
        return $this->current_offset_value;
    }

    public function get_keyword_key_param() {
        return $this->keyword_key_param;
    }

    public function get_limitoffset() {
        $default_limit_row = $this->config->item('default_limit_row');
        $limit = array_key_exists($this->limit_key_param, $_REQUEST) ? $_REQUEST[$this->limit_key_param] : $default_limit_row;
        $this->current_limit_value = $limit;
        $offset = $this->get_next_offset(TRUE);
        return array(
            $limit,
            $offset
        );
    }

    /**
     * Mungkin digunakan diseluruh model, maka harus dipindahkan ke core
     * @return string
     */
    public function get_keyword() {
        $keyword = '';
        if (array_key_exists($this->keyword_key_param, $_REQUEST)) {
            $keyword = addslashes(trim($_REQUEST[$this->keyword_key_param]));
        }
        return $keyword;
    }

    protected function get_referenced_tables($_referenced_table = FALSE) {
        $__related_tables = FALSE;
        if (array_have_value($this->related_tables)) {
            $__related_tables = $this->related_tables;
        } elseif ($_referenced_table && array_have_value($_referenced_table)) {
            $__related_tables = $_referenced_table;
        }

        $related_tables = array();
        if ($__related_tables) {
            foreach ($__related_tables as $related_table_name => $att) {
                if ($att["referenced"] && array_have_value($att["columns"])) {
                    $related_tables[$related_table_name] = $att;
                }
            }
        }
        if (array_have_value($related_tables)) {
            return $related_tables;
        }
        return FALSE;
    }

    private function __get_reference_to_table_name_or_alias($reference_to_table) {
        if (array_key_exists($reference_to_table, $this->related_tables)) {
            if (array_key_exists("table_alias", $this->related_tables[$reference_to_table])) {
                return $this->related_tables[$reference_to_table]["table_alias"];
            }
        }
        return $this->get_schema_name($reference_to_table);
    }

    /**
     * Evaluate if column is configured using alias column name
     * - column configured using alias column name will be like this 
     *   "columns" => array(
     *       "column1",
     *       array("column2", "alias_column_2")
     *   )
     * 
     * @author Lahir Wisada <lahirwisada@gmail.com>
     * @see this->related_tables
     * 
     * @param mix $column can be string or can be array
     * @param string $table_alias
     * @return mix if success then return string otherwise return FALSE
     */
    private function __get_select_column_referenced_table($column, $table_alias) {
        if (is_array($column)) {
            if (count($column) > 1) {
                return $table_alias . "." . current($column) . " as " . end($column);
            }
        } else {
            return $table_alias . "." . $column;
        }
        return FALSE;
    }

    /**
     * read and produce an array of foreign_key origin and reference key name
     * 
     * e.g:
     * "fkey" => "foreign_key"
     * or
     * "fkey" => array("this_foreign_key", "origin_foreign_key")
     * 
     * @param mix $fkey string/array
     * @return array
     */
    private function __get_foreign_key_of_referenced_table($fkey) {
        $foreign_key = array("fk_col_name" => $fkey, "fk_original_col_name" => $fkey);
        if (is_array($fkey)) {
            $foreign_key = array("fk_col_name" => current($fkey), "fk_original_col_name" => end($fkey));
        }

        return $foreign_key;
    }

    /**
     * Arange referenced table ($this->related_table) into Codeigniter Active Record
     * 
     * @author Lahir Wisada <lahirwisada@gmail.com>
     * 
     * @param string $table_name
     * @param array $referenced_table_properties
     */
    protected function select_referenced_table($table_name = FALSE, $referenced_table_properties = FALSE) {
        if ($table_name && $referenced_table_properties && is_array($referenced_table_properties) && array_have_value($referenced_table_properties)) {

            $join_table = $this->get_schema_name($table_name);
            if (array_key_exists("table_name", $referenced_table_properties)) {
                $join_table = $this->get_schema_name($referenced_table_properties["table_name"]);
            }

            $table_alias = $join_table;
            if (array_key_exists("table_alias", $referenced_table_properties)) {
                $table_alias = $referenced_table_properties["table_alias"];
                $join_table = $join_table . " as " . $table_alias;
            }

            if (array_key_exists("columns", $referenced_table_properties)) {
                foreach ($referenced_table_properties["columns"] as $key => $column) {
                    $_sel_col = $this->__get_select_column_referenced_table($column, $table_alias);
                    if ($_sel_col) {
                        $referenced_table_properties["columns"][$key] = $_sel_col;
                    }
                    unset($_sel_col);
                }

                $this->db->select(implode(",", $referenced_table_properties["columns"]), FALSE);
            }

            $additional_condition = "";

            if (array_key_exists("conditions", $referenced_table_properties)) {
                foreach ($referenced_table_properties["conditions"] as $key => $condition) {
                    $referenced_table_properties["conditions"][$key] = $table_alias . "." . $condition;
                }
                $additional_condition = " AND " . implode(" AND ", $referenced_table_properties["conditions"]);
            }

            $fkey = $this->__get_foreign_key_of_referenced_table($referenced_table_properties["fkey"]);
            extract($fkey);
            if (array_key_exists("reference_to", $referenced_table_properties)) {
                $this->db->join($join_table, $table_alias . "." . $fk_col_name . " = " . $this->__get_reference_to_table_name_or_alias($referenced_table_properties["reference_to"]) . "." . $fk_original_col_name . " " . $additional_condition, $referenced_table_properties["referenced"]);
            } else {
                $this->db->join($join_table, $table_alias . "." . $fk_original_col_name . " = " . $this->table_name . "." . $fk_col_name . " " . $additional_condition, $referenced_table_properties["referenced"]);
            }
        }
    }

    protected function get_fields() {
        if (array_have_value($this->attribute_labels)) {
            $fields_name = array();
            foreach ($this->attribute_labels as $key => $fields_name_and_label) {
                $fields_name[] = $this->table_name . "." . $fields_name_and_label[0];
            }
            if (array_have_value($fields_name)) {
                return implode(", ", $fields_name);
            }
        }
    }

    protected function select_field() {
        $selected_field = $this->get_fields();
        if (strlen($selected_field) > 0) {
            $this->db->select($selected_field);
        }
    }

    /**
     * 
     * @param array $_referenced_table masukkan parameter jika menginginkan select referenced table secara kustom 
     *                                 (tidak mengambil referenced table dari entity)
     */
    protected function get_select_referenced_table($_referenced_table = FALSE) {
        $referenced_table = FALSE;
        if (array_have_value($this->related_tables)) {
            $referenced_table = $this->get_referenced_tables();
        } elseif ($_referenced_table && is_array($_referenced_table) && array_have_value($_referenced_table)) {
            $referenced_table = $this->get_referenced_tables($_referenced_table);
        }

        if ($referenced_table) {
            foreach ($referenced_table as $referenced_table_name => $referenced_table_properties) {
                $this->select_referenced_table($referenced_table_name, $referenced_table_properties);
            }
        }
    }

    public function __arrange_keyword_where_for_postgres($searchable_field, $keyword) {
        if (array_key_exists($searchable_field, $this->attribute_types)) {
            if ($this->attribute_types[$searchable_field] == "DATE") {
                return "to_char(" . $searchable_field . ", 'DD-MM-YYYY') ILIKE '%" . $keyword . "%'";
            }
            if ($this->attribute_types[$searchable_field] == "NUMERIC") {
                return $searchable_field . "::text ILIKE '%" . $keyword . "%'";
            }
        }
        return $searchable_field . " ILIKE '%" . $keyword . "%'";
    }

    private function __get_keyword_where_for_postgres($searchable_fields = array(), $return_keyword_to = FALSE) {
        $keyword = $this->get_keyword();
        $arr_where = array();
        $where = "";

        if (array_have_value($searchable_fields) && $keyword != '') {
            $key_current = current(array_keys($searchable_fields));
            $key_end = count(array_keys($searchable_fields));

            $arr_keyword = array_fill($key_current, $key_end, $keyword);

            $arr_where = array_map(array($this, '__arrange_keyword_where_for_postgres'), $searchable_fields, $arr_keyword);
            unset($arr_keyword, $key_current, $key_end);
        }

        if (array_have_value($arr_where)) {
            $where = implode(" OR ", $arr_where);
        }
        unset($arr_where);
        if ($return_keyword_to) {
            return (object) array(
                        "where" => $where,
                        "keyword" => $keyword,
            );
        }
        return $where;
    }

    protected function get_keyword_where($searchable_fields = array(), $return_keyword_to = FALSE) {

        if ($this->db->dbdriver == 'postgre') {
            return $this->__get_keyword_where_for_postgres($searchable_fields, $return_keyword_to);
        }

        $keyword = $this->get_keyword();
        $arr_where = array();
        $where = "";


        if (array_have_value($searchable_fields) && $keyword != '') {
            foreach ($searchable_fields as $field) {
                $arr_where[] = $field . " LIKE '%" . $keyword . "%'";
            }
        }
        if (array_have_value($arr_where)) {
            $where = implode(" OR ", $arr_where);
        }
        unset($arr_where);
        if ($return_keyword_to) {
            return (object) array(
                        "where" => $where,
                        "keyword" => $keyword,
            );
        }
        return $where;
    }

    protected function set_where_record_active($record_active = 1, $record_active_exists = TRUE) {
        if ($record_active_exists) {
            switch ($record_active) {
                case 1: {
                        $this->db->where('(' . $this->table_name . '.' . $this->record_active_column_name . ' IS NULL OR ' . $this->table_name . '.' . $this->record_active_column_name . ' = \'' . $this->get_active_value() . '\')');
                        break;
                    }
                case 0: {
                        $this->db->where('(' . $this->table_name . '.' . $this->record_active_column_name . ' = \'' . $this->get_active_value(FALSE) . '\')');
                        break;
                    }
                default:
                    /* show all */
                    break;
            }
        }
    }

    public function before_count_all() {
        return;
    }

    public function count_all($where = "", $table_name = FALSE) {
        if ($where != "") {
            $this->db->where($where);
        }

        $select_from = $this->table_name;
        if ($table_name) {
            $select_from = $table_name;
        }

        $this->db->from($select_from);
        $this->get_select_referenced_table();
        $this->before_count_all();
        return $this->db->count_all_results();
    }

    private function __configure_get_all_condition($searchable_fields = array(), $record_active = 1, $record_active_exists = TRUE) {
        $where = $this->get_keyword_where($searchable_fields);
        $this->get_select_referenced_table();
        $this->select_field();
        if ($this->using_insert_and_update_properties) {
            $this->set_where_record_active($record_active, $record_active_exists);
        }
        return $where;
    }

    protected function before__get_all() {
        return;
    }

    protected function before__get_where() {
        return;
    }

    protected function auto_order__get_all() {
        return TRUE;
    }

    protected function after__get_all($records) {
        return $records;
    }

    private function __get_all($where = "", $force_limit = FALSE, $force_offset = FALSE, $order_by = NULL) {
        list($limit, $offset) = $this->get_limitoffset();

        if ($force_limit) {
            $limit = $force_limit;
        }

        if ($force_offset !== FALSE) {
            $offset = $force_offset;
        }
        $this->db->limit($limit, $offset);
        $this->before__get_all();
        $records = $this->get_where($where, NULL, $order_by, FALSE, FALSE);
        return $this->after__get_all($records);
    }

    /**
     * array 1 condition = array(array("column_1 = 'value'", "and", "("), .., array("column_5 = 'value'", "or"), .., array("column_5 = 'value'", ")", "and"))
     * array 2 condition = array("column_1 = 'value'", "column_2 = 'value'")
     * @param mixed $condition
     * @return string where
     */
    protected function collect_condition($conditions) {
        $final_condition = array();
        $where = $conditions;
        if (is_array($conditions)) {
            $temp_array = array();
            foreach ($conditions as $condition) {
                if (is_array($condition)) {
                    foreach ($condition as $item) {
                        $temp_array[] = $item;
                    }
                } else {
                    $final_condition[] = $condition;
                }
            }
            if (count($temp_array) > 0) {
                $final_condition[] = implode(" ", $temp_array);
            }
            $where = implode(" and ", $final_condition);
            unset($final_condition, $temp_array);
        }
        return $where;
    }

    public function force_no_order($no_order = FALSE) {
        return $no_order;
    }

    /**
     * hanya field data yang bertipe string
     * jika force_limit diisi maka offset akan otomatis menjadi 0
     * @param array of String $searchable_fields array("nama", "alamat")
     * @param integer $record_active if 1 then active, if 0 then inactive if -1 then all
     * @param bool record_active_exists TRUE when record_active field exist on table (default TRUE)
     */
    public function get_all($searchable_fields = array(), $conditions = FALSE, $show_detailed = FALSE, $show_all = TRUE, $record_active = 1, $record_active_exists = TRUE, $force_limit = FALSE, $force_offset = FALSE, $order_by = NULL) {
        $temp_where = array();

        if ($conditions) {
            $temp_where[] = $this->collect_condition($conditions) . " ";
        }

        $general_condition = $this->__configure_get_all_condition($searchable_fields, $record_active, $record_active_exists);

        if ($general_condition != "") {
            $temp_where[] = "(" . $general_condition . ")";
        }
        $where = implode(" and ", $temp_where);

        unset($temp_where, $general_condition, $conditions);

        if (!$show_all) {
            $record_set = $this->__get_all($where, $force_limit, $force_offset, $order_by);
        } else {
            $record_set = $this->get_where($where, NULL, $order_by, FALSE, FALSE);
        }

        if (!$show_detailed) {
            return $record_set;
        }
        $record_found = $this->count_all($where);

        return (object) array(
                    "record_set" => $record_set,
                    "record_found" => $record_found,
                    "keyword" => $this->get_keyword()
        );
    }

    public function show_last_query($with_exit = TRUE) {
        echo $this->db->last_query();
        if ($with_exit) {
            exit;
        }
    }

    public function get_next_offset($keep_zero = FALSE) {
        $default_offset_value = 1;
        if ($keep_zero) {
            $default_offset_value = 0;
        }
        $offset = array_key_exists($this->offset_key_param, $_REQUEST) && $_REQUEST[$this->offset_key_param] != "" ? $_REQUEST[$this->offset_key_param] : $default_offset_value;
        $this->current_offset_value = $offset;
        $default_limit_row = $this->config->item('default_limit_row');
        $next_record_number_list = (($default_limit_row * $offset) - $default_limit_row) + $default_offset_value;
        if ($next_record_number_list < 0) {
            $next_record_number_list = $default_offset_value;
        }
        return $next_record_number_list;
    }

    public function get_next_record_number_list() {
        return $this->get_next_offset(FALSE);
    }

}

class model_error {

    public $list = array();
    public $error_found = FALSE;

    /**
     * Add an error message.
     *
     * @param string $attribute Name of an attribute on the model
     * @param string $msg The error message
     */
    public function add($attribute, $msg) {
        if (!isset($this->list[$attribute]))
            $this->list[$attribute] = array($msg);
        else
            $this->list[$attribute] = $msg;
    }

    /**
     * Retrieve error messages for an attribute.
     *
     * @param string $attribute Name of an attribute on the model
     * @return array or null if there is no error.
     */
    public function show_error($attribute, $using_span = TRUE) {
        if (!array_key_exists($attribute, $this->list))
            return null;

        $ret = $this->list[$attribute];
        if ($using_span)
            $ret = '<span class="ticket ticket-important">' . $ret . '</span>';

        return $ret;
    }

    /**
     * Returns true if the specified attribute had any error messages.
     *
     * @param string $attribute Name of an attribute on the model
     * @return boolean
     */
    public function is_invalid($attribute) {
        return isset($this->list[$attribute]);
    }

    /**
     * Returns the error message(s) for the specified attribute or null if none.
     *
     * @param string $attribute Name of an attribute on the model
     * @return string/array	Array of strings if several error occured on this attribute.
     */
    public function on($attribute) {
        $errors = $this->$attribute;

        return $errors && count($errors) == 1 ? $errors[0] : $errors;
    }

    /**
     * Returns the internal errors object.
     *
     * <code>
     * $model->errors->get_raw_errors();
     *
     * # array(
     * #  "name" => array("can't be blank"),
     * #  "state" => array("is the wrong length (should be 2 chars)",
     * # )
     * </code>
     */
    public function get_raw_errors() {
        return $this->list;
    }

    public function get_html_errors($glue = ", ", $divclass = "") {
        $html_errors = implode($glue, $this->get_imploded_raw_errors());
        $_divclass = $divclass != "" ? "class=\"" . $divclass . "\"" : "";
        return "<div id=\"model_error\" " . $_divclass . ">" . $html_errors . "</div>";
    }

    public function get_imploded_raw_errors() {
        $arr_return = array();
        foreach ($this->list as $key => $val) {
            if (is_array($val)) {
                $arr_return[$key] = implode('\n', $val);
            } else {
                $arr_return[$key] = $val;
            }
        }
        return $arr_return;
    }

    /**
     * Returns all the error messages as an array.
     *
     * <code>
     * $model->errors->full_messages();
     *
     * # array(
     * #  "Name can't be blank",
     * #  "State is the wrong length (should be 2 chars)"
     * # )
     * </code>
     *
     * @return array
     */
    /* public function full_messages() {
      $full_messages = array();

      $this->to_array(function($attribute, $message) use (&$full_messages) {
      $full_messages[] = $message;
      });

      return $full_messages;
      } */

    /**
     * Returns all the error messages as an array, including error key.
     *
     * <code>
     * $model->errors->errors();
     *
     * # array(
     * #  "name" => array("Name can't be blank"),
     * #  "state" => array("State is the wrong length (should be 2 chars)")
     * # )
     * </code>
     *
     * @param array $closure Closure to fetch the errors in some other format (optional)
     *                       This closure has the signature function($attribute, $message)
     *                       and is called for each available error message.
     * @return array
     */
    public function to_array($closure = null) {
        $errors = array();

        if ($this->list) {
            foreach ($this->list as $attribute => $messages) {
                foreach ($messages as $msg) {
                    if (is_null($msg))
                        continue;

                    $errors[$attribute][] = $msg;

                    if ($closure)
                        $closure($attribute, $msg);
                }
            }
        }
        return $errors;
    }

    /**
     * Convert all error messages to a String.
     * This function is called implicitely if the object is casted to a string:
     *
     * <code>
     * echo $error;
     *
     * # "Name can't be blank\nState is the wrong length (should be 2 chars)"
     * </code>
     * @return string
     */
    /* public function __toString() {
      return implode("\n", $this->full_messages());
      } */

    /**
     * Returns true if there are no error messages.
     * @return boolean
     */
    public function is_empty() {
        return empty($this->list);
    }

    /**
     * Clears out all error messages.
     */
    public function clear() {
        $this->list = array();
    }

    /**
     * Returns the number of error messages there are.
     * @return int
     */
    public function size() {
        if ($this->is_empty())
            return 0;

        $count = 0;

        foreach ($this->list as $attribute => $error)
            $count += count($error);

        return $count;
    }

}

?>