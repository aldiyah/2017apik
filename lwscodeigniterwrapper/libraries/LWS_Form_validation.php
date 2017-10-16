<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LWS_Form_validation extends CI_Form_validation {

    function __construct() {
        parent::__construct();
    }

    function _exec($row, $rules, $postdata = NULL, $cycles = 0) {
        return $this->_execute($row, $rules, $postdata = NULL, $cycles = 0);
    }

    function get_error_array() {
        return $this->_error_array;
    }

    public function model_is_unique($str, $field = FALSE) {
        $table_info = explode('.', $field);
        $table = $table_info[0];
        if (!$field) {
            $field = $table_info[1];
        }
        if (count($table_info) > 2) {
            $table = $table_info[0] . '.' . $table_info[1];
            $field = $table_info[2];
        }
        $query = $this->CI->db->limit(1)->get_where($table, array($field => $str));

        return $query->num_rows() === 0;
    }
    
    public function valid_time($str_time){
        return (bool)(preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9])/", $str_time));
    }

}

?>
