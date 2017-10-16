<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

define('LWSPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

class LWS {

    private static $classMap = array();
    private static $_aliases = array('system' => BASEPATH, 'lws' => LWSPATH); // alias => path
    private static $_imports = array();
    private static $_configs = array();
    private static $_app;
    private static $enableIncludePath = FALSE;
    private static $_includePaths = array(
        'core'
    );

    public static function autoload($className)
    {
        $is_ci = strpos($className, 'CI_') !== FALSE;
        $is_ext_ci = strpos($className, 'MY_') !== FALSE;
        if ($is_ext_ci || $is_ext_ci)
        {
            return;
        }
        
        if (file_exists(APPPATH . "models/" . strtolower($className) . EXT))
        {
            include_once(APPPATH . "models/" . strtolower($className) . EXT);
        }
        else if (file_exists(APPPATH . "controllers/" . strtolower($className) . EXT))
        {
            include_once(APPPATH . "controllers/" . strtolower($className) . EXT);
        }
//        if ($is_ci)
//        {
//            $core_path = BASEPATH.DIRECTORY_SEPARATOR.'core/'.str_replace('CI_', '', $className).EXT;
//            $lib_path = BASEPATH.DIRECTORY_SEPARATOR.'libraries/'.str_replace('CI_', '', $className).EXT;
//            if (file_exists($core_path))
//            {
//                include($core_path);
//            }
//            else if (file_exists($lib_path))
//            {
//                include($lib_path);
//            }
//        }        
        // use include so that the error PHP file may appear
        if (isset(self::$classMap[$className]))
        {
            include(self::$classMap[$className]);
        }
        else if (isset(self::$_coreClasses[$className]))
        {
            include(LWSPATH . self::$_coreClasses[$className]);
        }
        else
        {
            // include class file relying on include_path
            if (strpos($className, '\\') === false)  // class without namespace
            {
                if (self::$enableIncludePath === false)
                {
                    foreach (self::$_includePaths as $path)
                    {
                        $classFile = LWSPATH . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $className . '.php';
                        if (is_file($classFile))
                        {
                            include($classFile);
                            break;
                        }
                    }
                }
                else
                    include($className . '.php');
            }
            return class_exists($className, false) || interface_exists($className, false);
        }
        return true;
    }

    /**
     * Creates an application of the specified class.
     * @param string $class the application class name
     * @param mixed $config application configuration. This parameter will be passed as the parameter
     * to the constructor of the application class.
     * @return mixed the application instance
     */
    public static function create_application($class, $config=null)
    {
        return new $class($config);
    }

    /**
     * Returns the application singleton, null if the singleton has not been created yet.
     * @return CApplication the application singleton, null if the singleton has not been created yet.
     */
    public static function app()
    {
        return self::$_app;
    }

    public static function config($name, $var, $return_value=FALSE)
    {
        if (isset(self::$_configs[$name]) && $return_value)
        {
            return self::$_configs[$name];
        }

        foreach (array(APPPATH, LWSPATH) as $path)
        {
            $full_path = $path . 'config/' . $name . '.php';
            if (file_exists($full_path))
            {
                require($full_path);
                self::$_configs[$name] = ${$var};

                if ($return_value && isset(${$var}))
                {
                    return ${$var};
                }
                break;
            }
        }
        return FALSE;
    }

    /**
     * Stores the application instance in the class static member.
     * This method helps implement a singleton pattern for CApplication.
     * Repeated invocation of this method or the CApplication constructor
     * will cause the throw of an exception.
     * To retrieve the application instance, use {@link app()}.
     * @param CApplication $app the application instance. If this is null, the existing
     * application singleton will be removed.
     * @throws CException if multiple application instances are registered.
     */
    public static function set_application($app)
    {
        if (self::$_app === null || $app === null)
            self::$_app = $app;
    }

    /**
     * Creates an object and initializes it based on the given configuration.
     *
     * The specified configuration can be either a string or an array.
     * If the former, the string is treated as the object type which can
     * be either the class name or {@link YiiBase::getPathOfAlias class path alias}.
     * If the latter, the 'class' element is treated as the object type,
     * and the rest name-value pairs in the array are used to initialize
     * the corresponding object properties.
     *
     * Any additional parameters passed to this method will be
     * passed to the constructor of the object being created.
     *
     * @param mixed $config the configuration. It can be either a string or an array.
     * @return mixed the created object
     * @throws CException if the configuration does not have a 'class' element.
     */
    public static function create_component($config)
    {
        if (is_string($config))
        {
            $type = $config;
            $config = array();
        }
        else if (isset($config['class']))
        {
            $type = $config['class'];
            unset($config['class']);
        }

        if (!class_exists($type, false))
            $type = DC::import($type, true);

        if (($n = func_num_args()) > 1)
        {
            $args = func_get_args();
            if ($n === 2)
                $object = new $type($args[1]);
            else if ($n === 3)
                $object = new $type($args[1], $args[2]);
            else if ($n === 4)
                $object = new $type($args[1], $args[2], $args[3]);
            else
            {
                unset($args[0]);
                $class = new ReflectionClass($type);
                // Note: ReflectionClass::newInstanceArgs() is available for PHP 5.1.3+
                // $object=$class->newInstanceArgs($args);
                $object = call_user_func_array(array($class, 'newInstance'), $args);
            }
        }
        else
            $object = new $type;

        foreach ($config as $key => $value)
            $object->$key = $value;

        return $object;
    }

    /**
     * Imports a class or a directory.
     *
     * Importing a class is like including the corresponding class file.
     * The main difference is that importing a class is much lighter because it only
     * includes the class file when the class is referenced the first time.
     *
     * Importing a directory is equivalent to adding a directory into the PHP include path.
     * If multiple directories are imported, the directories imported later will take
     * precedence in class file searching (i.e., they are added to the front of the PHP include path).
     *
     * Path aliases are used to import a class or directory. For example,
     * <ul>
     *   <li><code>application.components.GoogleMap</code>: import the <code>GoogleMap</code> class.</li>
     *   <li><code>application.components.*</code>: import the <code>components</code> directory.</li>
     * </ul>
     *
     * The same path alias can be imported multiple times, but only the first time is effective.
     * Importing a directory does not import any of its subdirectories.
     *
     * Starting from version 1.1.5, this method can also be used to import a class in namespace format
     * (available for PHP 5.3 or above only). It is similar to importing a class in path alias format,
     * except that the dot separator is replaced by the backslash separator. For example, importing
     * <code>application\components\GoogleMap</code> is similar to importing <code>application.components.GoogleMap</code>.
     * The difference is that the former class is using qualified name, while the latter unqualified.
     *
     * Note, importing a class in namespace format requires that the namespace is corresponding to
     * a valid path alias if we replace the backslash characters with dot characters.
     * For example, the namespace <code>application\components</code> must correspond to a valid
     * path alias <code>application.components</code>.
     *
     * @param string $alias path alias to be imported
     * @param boolean $forceInclude whether to include the class file immediately. If false, the class file
     * will be included only when the class is being used. This parameter is used only when
     * the path alias refers to a class.
     * @return string the class name or the directory that this alias refers to
     * @throws CException if the alias is invalid
     */
    public static function import($alias, $forceInclude=false)
    {
        if (isset(self::$_imports[$alias]))  // previously imported
            return self::$_imports[$alias];

        if (class_exists($alias, false) || interface_exists($alias, false))
            return self::$_imports[$alias] = $alias;

        if (($pos = strrpos($alias, '.')) === false)  // a simple class name
        {
            if ($forceInclude && self::autoload($alias))
                self::$_imports[$alias] = $alias;
            return $alias;
        }

        $className = (string) substr($alias, $pos + 1);
        $isClass = $className !== '*';

        if ($isClass && (class_exists($className, false) || interface_exists($className, false)))
            return self::$_imports[$alias] = $className;

        if (($path = self::get_alias_path($alias)) !== false)
        {
            if ($isClass)
            {
                if ($forceInclude)
                {
                    if (is_file($path . '.php'))
                    {
                        require($path . '.php');
                        self::$_imports[$alias] = $className;
                    }
                }
                else
                    self::$classMap[$className] = $path . '.php';
                return $className;
            }
        }
        return FALSE;
    }

    /**
     * Translates an alias into a file path.
     * Note, this method does not ensure the existence of the resulting file path.
     * It only checks if the root alias is valid or not.
     * @param string $alias alias (e.g. system.web.CController)
     * @return mixed file path corresponding to the alias, false if the alias is invalid.
     */
    public static function get_alias_path($alias)
    {
        if (isset(self::$_aliases[$alias]))
            return self::$_aliases[$alias];
        else if (($pos = strpos($alias, '.')) !== false)
        {
            $rootAlias = substr($alias, 0, $pos);
            if (isset(self::$_aliases[$rootAlias]))
                return self::$_aliases[$alias] = rtrim(self::$_aliases[$rootAlias] . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, substr($alias, $pos + 1)), '*' . DIRECTORY_SEPARATOR);
        }
        return false;
    }

    /**
     * Create a path alias.
     * Note, this method neither checks the existence of the path nor normalizes the path.
     * @param string $alias alias to the path
     * @param string $path the path corresponding to the alias. If this is null, the corresponding
     * path alias will be removed.
     */
    public static function set_alias_path($alias, $path)
    {
        if (empty($path))
            unset(self::$_aliases[$alias]);
        else
            self::$_aliases[$alias] = rtrim($path, '\\/');
    }

    public static function merge_array($a, $b)
    {
        $args = func_get_args();
        $res = array_shift($args);
        while (!empty($args))
        {
            $next = array_shift($args);
            foreach ($next as $k => $v)
            {
                if (is_integer($k))
                    isset($res[$k]) ? $res[] = $v : $res[$k] = $v;
                else if (is_array($v) && isset($res[$k]) && is_array($res[$k]))
                    $res[$k] = self::merge_array($res[$k], $v);
                else
                    $res[$k] = $v;
            }
        }
        return $res;
    }

    private static $_coreClasses = array(
        /** 'LWS_Html' => '/abc/LWS_Html.php',
        'LWS_Form' => '/abc/LWS_Form.php',
        'LWS_component' => '/abc/LWS_component.php', */
        'LWS_Controller' => '/core/LWS_Controller.php',
        'LWS_Config' => '/core/LWS_Config.php',
        'LWS_Exceptions' => '/core/LWS_Exceptions.php',
        'LWS_Output' => '/core/LWS_Output.php',
        'LWS_Router' => '/core/LWS_Router.php'
    );

}

spl_autoload_register(array('LWS', 'autoload'));