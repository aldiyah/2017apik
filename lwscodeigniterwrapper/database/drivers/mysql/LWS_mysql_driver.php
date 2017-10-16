<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LWS_DB_mysql_driver extends CI_DB_mysql_driver {

    function escape_str($str, $like = FALSE) {
        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = $this->escape_str($val, $like);
            }

            return $str;
        }

//        if (function_exists('mysql_real_escape_string') AND is_resource($this->conn_id)) {
//            $str = mysql_real_escape_string($str, $this->conn_id);
//        } elseif (function_exists('mysql_escape_string')) {
//            $str = mysql_escape_string($str);
//        } else {
        $str = addslashes($str);
//        }
        // escape LIKE condition wildcards
        if ($like === TRUE) {
            $str = str_replace(array('%', '_'), array('\\%', '\\_'), $str);
        }

        return $str;
    }

    public function get_procedure_parameters_values($param_value = array()) {
        if (is_array($param_value) && count($param_value) > 0) {
            return "'" . $param_value["value"] . "'";
        }

        return "'" . $param_value . "'";
    }

    public function configure_procedure_parameters($parameters = array()) {
        $result_param = array();
        foreach ($parameters as $param_name => $param_value) {
            if (is_array($param_value) && array_key_exists("type", $param_value) && array_key_exists("value", $param_value)) {
                $_param_value = $this->get_procedure_parameters_values($param_value);
                $result_param[] = $_param_value;
                unset($_param_value);
            } else {
                $result_param[] = "'" . $param_value . "'";
            }
        }

        $str_result_param = implode(", ", $result_param);
        return "(" . $str_result_param . ")";
    }
    
    public function get_procedure_executor(){
        return "call ";
    }

}
