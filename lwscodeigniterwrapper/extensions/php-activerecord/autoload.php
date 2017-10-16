<?php

if (!defined('BASEPATH'))
    die('No direct script access allowed');
/*
 *
 * Class name: PHPActiveRecord
 * Initializes PHPActiveRecord and registers the autoloader
 *
 */

// Set a path to the spark root that we can reference
$spark_path = dirname(__FILE__) . DIRECTORY_SEPARATOR;
// Include the CodeIgniter database config file
// Is the config file in the environment folder?
if (!defined('ENVIRONMENT') OR !file_exists($file_path = APPPATH . 'config/' . ENVIRONMENT . '/database.php')) {
    foreach (array(DCPATH, APPPATH) as $path) {
        $config_path = $path . 'config/database.php';
        $memcache_path = $path . 'config/memcached.php';
        if (file_exists($config_path)) {
            require($config_path);
        }
        if (file_exists($memcache_path)) {
            $cache_config_loaded = TRUE;
            require($memcache_path);
        }
    }
}

if (!isset($db) || !isset($active_group)) {
    show_error('PHPActiveRecord: The configuration file database.php does not exist.');
}

// Include the ActiveRecord bootstrapper
require_once $spark_path . 'ActiveRecord.php';

// PHPActiveRecord allows multiple connections.
$connections = array();
if ($db && $active_group) {
    foreach ($db as $conn_name => $conn) {
        // Build the DSN string for each connection
        if (is_array($conn) &&
                array_key_exists('dbdriver', $conn) &&
                array_key_exists('username', $conn) &&
                array_key_exists('password', $conn) &&
                array_key_exists('hostname', $conn) &&
                array_key_exists('database', $conn) &&
                array_key_exists('char_set', $conn)
        )
            $connections[$conn_name] = $conn['dbdriver'] .
                    '://' . $conn['username'] .
                    ':' . $conn['password'] .
                    '@' . $conn['hostname'] .
                    '/' . $conn['database'] .
                    '?charset=' . $conn['char_set'];
    }

    $memcache_connection = FALSE;
    if ($cache_config_loaded) {
        $memcache_connection = "memcached://" . $config['default']['hostname'] . ":" . $config['default']['port'];
    }

    // Initialize PHPActiveRecord
    $config = Config::instance();
    $config->set_model_directory(APPPATH . 'models/');
    $config->set_connections($connections);
    $config->set_default_connection($active_group);

    if ($memcache_connection) {
        $config->set_cache($memcache_connection, array("expire" => 604800));
    }
//    $config->set_cache(NULL);
//  Support for PHP >= 5.3.0    
//    Config::initialize(function ($cfg) use ($connections, $active_group,
//            $memcache_connection, $memcache_expired)
//            {
//                $cfg->set_model_directory(APPPATH . 'models/');
//                $cfg->set_connections($connections);
//
//                // This connection is the default for all models
//                $cfg->set_default_connection($active_group);
//                if ($memcache_connection != '')
//                {
//                    $cfg->set_cache($memcache_connection, $memcache_expired ? array('expire' => $memcache_expired) : array());
//                }
//
//                // To enable logging and profiling, install the Log library 
//                // from pear, create phpar.log inside of your application/logs 
//                // directory, then uncomment the following block:
//
//                /*
//                  $log_file = $_SERVER['DOCUMENT_ROOT'].'/application/logs/phpar.log';
//
//                  if (file_exists($log_file) and is_writable($log_file)) {
//                  include 'Log.php';
//                  $logger = Log::singleton('file', $log_file ,'ident',array('mode' => 0664, 'timeFormat' =>  '%Y-%m-%d %H:%M:%S'));
//                  $cfg->set_logging(true);
//                  $cfg->set_logger($logger);
//                  } else {
//                  log_message('warning', 'Cannot initialize logger. Log file does not exist or is not writeable');
//                  }
//                 */
//            });
}
/* End of file PHPActiveRecord.php */
/* Location: ./sparks/php-activerecord/<version>/libraries/PHPActiveRecord.php */
