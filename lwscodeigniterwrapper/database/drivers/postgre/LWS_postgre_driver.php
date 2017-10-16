<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright		Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @copyright		Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * Postgre Database Adapter Class
 *
 * Note: _DB is an extender class that the app controller
 * creates dynamically based on whether the active record
 * class is being used or not.
 *
 * @package		CodeIgniter
 * @subpackage	Drivers
 * @category	Database
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
class LWS_DB_postgre_driver extends CI_DB_postgre_driver {

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
        return "select * from ";
    }

}

/* End of file postgre_driver.php */
/* Location: ./system/database/drivers/postgre/postgre_driver.php */