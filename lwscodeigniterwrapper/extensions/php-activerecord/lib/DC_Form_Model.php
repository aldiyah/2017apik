<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DC_Form_Model
 *
 * @author morpheus
 */
class DC_Form_Model extends DC_Model {

    protected $_use_callback = FALSE;

    function __construct(array $attributes = array(), $guard_attributes = true, $instantiating_via_find = false, $new_record = true)
    {
        if (!$instantiating_via_find)
        {
            $attributes = count(static::$attribute_labels) > 0 ? static::$attribute_labels : (count(static::$rules) > 0 ? static::$rules : FALSE);
            if ($attributes)
            {
                foreach ($attributes as $index => $field)
                {
                    $r_index = is_array($field) ? $field[0] : $index;
                    $this->attributes[$r_index] = NULL;
                    $this->flag_dirty($r_index);
                }
            }
        }
    }

    function assign_attribute($name, $value)
    {
        $this->attributes[$name] = $value;
        $this->flag_dirty($name);
        return $value;
    }

    function set_attributes(array $attributes)
    {
        if ($attributes)
        {
            foreach ($attributes as $index => $value)
            {
                $this->$index = $value;
//                $this->flag_dirty($index, $value);
            }
        }
    }

}