<?php

//if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 50300)
//	die('PHP ActiveRecord requires PHP 5.3 or higher');

define('PHP_ACTIVERECORD_VERSION_ID', '1.0');

if (!defined('PHP_ACTIVERECORD_AUTOLOAD_PREPEND'))
    define('PHP_ACTIVERECORD_AUTOLOAD_PREPEND', true);

if (!function_exists('get_called_class'))
{

    function get_called_class($bt = false, $l = 1)
    {
        if (!$bt)
            $bt = debug_backtrace();
        if (!isset($bt[$l]))
            throw new Exception("Cannot find called class -> stack level too deep.");
        if (!isset($bt[$l]['type']))
        {
            throw new Exception('type not set');
        }
        else
        {
            switch ($bt[$l]['type'])
            {
                case '::':
                    $lines = file($bt[$l]['file']);
                    $i = 0;
                    $callerLine = '';
                    do
                    {
                        $i++;
                        $callerLine = $lines[$bt[$l]['line'] - $i] . $callerLine;
                    }
                    while (stripos($callerLine, $bt[$l]['function']) === false);
                    preg_match('/([a-zA-Z0-9\_]+)::' . $bt[$l]['function'] . '/', $callerLine, $matches);
                    if (!isset($matches[1]))
                    {
                        // must be an edge case.
                        throw new Exception("Could not find caller class: originating method call is obscured.");
                    }
                    switch ($matches[1])
                    {
                        case 'self':
                        case 'parent':
                            return get_called_class($bt, $l + 1);
                        default:
                            return $matches[1];
                    }
                // won't get here.
                case '->': switch ($bt[$l]['function'])
                    {
                        case '__get':
                            // edge case -> get class of calling object
                            if (!is_object($bt[$l]['object']))
                                throw new Exception("Edge case fail. __get called on non object.");
                            return get_class($bt[$l]['object']);
                        default: return $bt[$l]['class'];
                    }

                default: throw new Exception("Unknown backtrace method type");
            }
        }
    }
}

require 'lib/Singleton.php';
require 'lib/Config.php';
require 'lib/Utils.php';
require 'lib/DateTime.php';
require 'lib/AR_model.php';
require 'lib/DC_Model.php';
require 'lib/DC_Form_Model.php';
require 'lib/Table.php';
require 'lib/ConnectionManager.php';
require 'lib/Connection.php';
require 'lib/DC_Connection.php';
require 'lib/SQLBuilder.php';
require 'lib/Reflections.php';
require 'lib/Inflector.php';
require 'lib/CallBack.php';
require 'lib/Exceptions.php';
require 'lib/Cache.php';

if (!defined('PHP_ACTIVERECORD_AUTOLOAD_DISABLE'))
{
    if (!is_php('5.3'))
    {
        spl_autoload_register('activerecord_autoload', TRUE);
    }
    else
    {
        spl_autoload_register('activerecord_autoload', FALSE, PHP_ACTIVERECORD_AUTOLOAD_PREPEND);
    }
}

if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

function activerecord_autoload($class_name)
{
    $path = Config::instance()->get_model_directory();
    $root = realpath(isset($path) ? $path : '.');

    if (($namespaces = get_namespaces($class_name)))
    {
        $class_name = array_pop($namespaces);
        $directories = array();

        foreach ($namespaces as $directory)
            $directories[] = $directory;

        $root .= DS . implode($directories, DS);
    }

    $file_name = strtolower("{$class_name}.php");
    $file = $root . DS . $file_name;

    if (file_exists($file))
    {
        require $file;
    }
    else
    {
        $modules_path = APPPATH . 'modules';
        if (is_dir($modules_path))
        {
            $modules = scandir(realpath($modules_path));
            foreach ($modules as $module)
            {
                $full_path = $modules_path . DS . $module . DS . 'models' . DS . $file_name;
                if ($module != '.' && $module != '..' && file_exists($full_path))
                {
                    require $full_path;
                }
            }
        }
    }
}

?>
