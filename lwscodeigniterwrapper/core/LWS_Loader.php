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
 * Loader Class
 *
 * Loads views and files
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @author		ExpressionEngine Dev Team
 * @category	Loader
 * @link		http://codeigniter.com/user_guide/libraries/loader.html
 */
class LWS_Loader extends CI_Loader {

    /**
     * Constructor
     *
     * Sets the path to the view files and gets the initial output buffering level
     */
    public function __construct() {
        parent::__construct();
        $this->_ci_library_paths = array(APPPATH, LWSPATH, BASEPATH);
        $this->_ci_helper_paths = array(APPPATH, LWSPATH, BASEPATH);
        $this->_ci_model_paths = array(APPPATH, LWSPATH);
        $this->_ci_view_paths = array(APPPATH . 'views/' => TRUE, LWSPATH . 'views/' => TRUE);
    }

    public function get_view_paths() {
        return $this->_ci_view_paths;
    }

    /**
     * Load Helper
     *
     * This function loads the specified helper file.
     *
     * @param	mixed
     * @return	void
     */
    public function helper($helpers = array()) {
//        if (!defined('ONWRAPPER')) {
//            parent::helper($helpers);
//        }

        $helper_paths = array_reverse($this->_ci_helper_paths);

        foreach ($this->_ci_prep_filename($helpers, '_helper') as $helper) {

            if (isset($this->_ci_helpers[$helper])) {
                continue;
            }

            $ext_helper = APPPATH . 'helpers/' . config_item('subclass_prefix') . $helper . '.php';

            // Is this a helper extension request?
            if (file_exists($ext_helper)) {
                $base_helper = BASEPATH . 'helpers/' . $helper . '.php';
                $lws_helper = LWSPATH . 'helpers/LWS_' . $helper . '.php';

                if (!file_exists($base_helper)) {
                    show_error('Unable to load the requested file: helpers/' . $helper . '.php');
                }

                if (!file_exists($lws_helper)) {
                    show_error('LWS Unable to load the requested file: helpers/LWS_' . $helper . '.php');
                }

                include_once($ext_helper);
                include_once($lws_helper);
                include_once($base_helper);

                $this->_ci_helpers[$helper] = TRUE;
                log_message('debug', 'Helper loaded: ' . $helper);
                continue;
            }

            // Try to load the helper
            foreach ($helper_paths as $helper_path) {
                $helper_filename = $helper . '.php';
                if ($helper_path == LWSPATH) {
                    $helper_filename = 'LWS_' . $helper . '.php';
                }

                $helper_exists = file_exists($helper_path . 'helpers/' . $helper_filename);
                log_message('debug', 'Check Exists ' . $helper_filename . ': ' . ($helper_exists ? "Yes" : "No"));
                if ($helper_exists) {
                    include_once($helper_path . 'helpers/' . $helper_filename);

                    $this->_ci_helpers[$helper] = TRUE;
                    log_message('debug', 'Helper loaded: ' . $helper);
                    if ($helper_path != LWSPATH) {
                        break;
                    }
                }
            }
        }

        // unable to load the helper
        if (!isset($this->_ci_helpers[$helper]) && !defined('ONWRAPPER')) {
            show_error('Unable to load the requested file: helpers/' . $helper . '.php');
        }
    }

    // --------------------------------------------------------------------

    /**
     * Load class
     *
     * This function loads the requested class.
     * @author mas Feri Harsanto
     * @param	string	the item that is being loaded
     * @param	mixed	any additional parameters
     * @param	string	an optional object name
     * @return	void
     */
    protected function _ci_load_class($class, $params = NULL, $object_name = NULL) {
        parent::_ci_load_class($class, $params, $object_name);
        
//        if(in_array($class, $this->_ci_classes)){
//            log_message('debug', 'Class Library still loaded: on ' . $class);
//            return TRUE;
//        }
        
        $class = str_replace('.php', '', trim($class, '/'));
        $CI = & get_instance();

        $subdir = '';
        if (($last_slash = strrpos($class, '/')) !== FALSE) {
            // Extract the path
            $subdir = substr($class, 0, $last_slash + 1);

            // Get the filename from the path
            $class = substr($class, $last_slash + 1);
        }

        $classvar = strtolower($class);
        if (isset($CI->$classvar)) {
            $class_name = strstr($class, 'LWS_') ? ucfirst($class) : 'LWS_' . ucfirst($class);
            $baseclass = BASEPATH . 'libraries/' . $subdir . ucfirst($class) . '.php';
            $class_path = LWSPATH . 'libraries/' . $subdir . $class_name . '.php';

            if (file_exists($class_path)) {
                include_once($class_path);

                if (file_exists($baseclass))
                    include_once($baseclass);

                if (count($this->_ci_loaded_files) > 0) {
                    foreach ($this->_ci_loaded_files as $index => $file) {
                        if (strstr($file, $class)) {
                            $this->_ci_loaded_files[$index] = $class_path;
                        }
                    }
                }
                $class = strtolower($class);
                $this->_ci_classes[$class] = $class;
                if ($params !== NULL) {
                    $CI->$class = new $class_name($params);
                } else {
                    $CI->$class = new $class_name;
                }
                log_message('debug', 'Class Library loaded: ' . $class_name . ' on ' . $class);
            }
        }
        return TRUE;
    }

    public function file_library($library = '') {
        if ($library == '') {
            return FALSE;
        }

        //var_dump(APPPATH.'libraries/'.$library.EXT);
        //var_dump(file_exists(APPPATH.'libraries/'.$library.EXT)); exit;
        // Is this a helper extension request?			
        if (file_exists(APPPATH . 'libraries/' . $library . EXT)) {
            include_once(APPPATH . 'libraries/' . $library . EXT);
        } elseif (file_exists(LWSPATH . 'libraries/' . $library . EXT)) {
            include_once(LWSPATH . 'libraries/' . $library . EXT);
        } elseif (file_exists(BASEPATH . 'libraries/' . $library . EXT)) {
            include_once(BASEPATH . 'libraries/' . $library . EXT);
        } else {
            show_error('Unable to load the requested file: libraries/' . $library . EXT);
        }
        log_message('debug', 'File Library loaded: ' . $library);
    }

    /**
     * Database Loader
     *
     * @access    public
     * @param    string    the DB credentials
     * @param    bool    whether to return the DB object
     * @param    bool    whether to enable active record (this allows us to override the config setting)
     * @return    object
     */
    function database($params = '', $return = FALSE, $active_record = NULL) {
        // Do we even need to load the database class?
        if (class_exists('CI_DB') AND $return == FALSE AND $active_record == NULL AND isset($CI->db) AND is_object($CI->db)) {
            return FALSE;
        }

        require_once(LWSPATH . 'database/LWS_DB' . EXT);

        // Load the DB class
        $result = DB($params, $active_record);
        $params = $result["param"];
        $DB = FALSE;
        if ($result["extended_driver_found"]) {
            $lws_db_driver = 'LWS_DB_' . $params['dbdriver'] . '_driver';
            $DB = new $lws_db_driver($result["param"]);
            unset($lws_db_driver);
        } else {
            // Instantiate the DB adapter
            $driver = 'CI_DB_' . $params['dbdriver'] . '_driver';
            $DB = new $driver($params);
            unset($driver);
        }

        //initiate DB
        if ($DB->autoinit == TRUE) {
            $DB->initialize();
        }

        if (isset($params['stricton']) && $params['stricton'] == TRUE) {
            $DB->query('SET SESSION sql_mode="STRICT_ALL_TABLES"');
        }

        if ($return === TRUE) {
            return $DB;
        }
        // Grab the super object
        $CI = & get_instance();

        // Initialize the db variable.  Needed to prevent
        // reference errors with some configurations
        $CI->db = '';
        $CI->db = $DB;
    }

}

/* End of file Loader.php */
/* Location: ./system/core/Loader.php */