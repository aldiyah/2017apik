<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DC_Model
 *
 * @author morpheus
 */
class DC_Model extends AR_model {

    static $attribute_labels = array();
    static $rules = array();
    protected $_use_callback = TRUE;

    static public function get_ci()
    {
        $CI = &get_instance();
        return $CI;
    }
    
    static public function get_lang()
    {
        return self::get_ci()->get_abbr_lang();
    }
    
    static public function get_config($item)
    {
        return self::get_ci()->config->item($item);
    }
    
    static public function get_cache($key, $closure)
    {
        $CI = static::get_ci();
        if (!isset($CI->cache))
        {
            $CI->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'file'));
        }
        $cache = $CI->cache;
        $cache_val = $cache->get($key);
        if ($cache_val === FALSE)
        {
            $cache_val = $closure();
            $cache->save($key, $cache_val, 604800);
        }
        return $cache_val;
    }
    
    static public function get_tool($name)
    {
        $CI = static::get_ci();
        return $CI->get_tool($name);
    }

    static public function get_library($name)
    {
        $CI = static::get_ci();
        if (!isset($CI->$name))
        {
            $CI->load->library($name);
        }
        return $CI->$name;
    }

    public function get_validation_rules()
    {
        require_once 'DC_Validations.php';

        $validator = new DC_Validations($this);
        return $validator->rules();
    }

    protected function _validate()
    {
        require_once 'DC_Validations.php';

        $validator = new DC_Validations($this);
        $validation_on = 'validation_on_' . ($this->is_new_record() ? 'create' : 'update');

        if ($this->_use_callback)
        {
            foreach (array('before_validation', "before_$validation_on") as $callback)
            {
                if (!$this->invoke_callback($callback, false))
                    return false;
            }
        }
        
        // need to store reference b4 validating so that custom validators have access to add errors
        $this->errors = $validator->get_record();
        $validator->validate();

        if ($this->_use_callback)
        {
            foreach (array('after_validation', "after_$validation_on") as $callback)
                $this->invoke_callback($callback, false);
        }

        if (!$this->errors->is_empty())
            return false;

        return true;
    }

    public function get_label($name)
    {
        if (array_key_exists($name, static::$attribute_labels))
        {
            if (is_array(static::$attribute_labels[$name]))
            {
                return static::$attribute_labels[$name][static::get_lang()];
            }
            return static::$attribute_labels[$name];
        }
        return $name;
    }

    public static function delete_all($options=array())
    {
        parent::delete_all($options);
        return static::connection()->affected_rows();
    }

    public static function update_all($options=array())
    {
        parent::update_all($options);
        return static::connection()->affected_rows();
    }

}