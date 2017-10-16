<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if ( ! function_exists('lws_form_multiselect'))
{
	function lws_form_multiselect($name = '', $options = array(), $selected = array(), $extra = '')
	{
		if ( ! strpos($extra, 'multiple'))
		{
			$extra .= ' multiple="multiple"';
		}

		return lws_form_dropdown($name, $options, $selected, $extra);
	}
}

if (!function_exists('lws_form_dropdown')) {

    function lws_form_dropdown($name = '', $options = array(), $selected = array(), $extra = '') {

        if (!is_array($selected)) {
            $selected = array($selected);
        }

        // If no selected state was submitted we will attempt to set it automatically
        if (count($selected) === 0) {
            // If the form name appears in the $_POST array we have a winner!
            if (isset($_POST[$name])) {
                $selected = array($_POST[$name]);
            }
        }

        if ($extra != '') {
            $extra = ' ' . $extra;
        }

        $multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

        $form = '<select name="' . $name . '"' . $extra . $multiple . ">\n";

        if (count($options) > 0) {
            foreach ($options as $key => $val) {
                $key = (string) $key;

                if (is_array($val) && !empty($val)) {
                    $form .= '<optgroup label="' . $key . '">' . "\n";

                    foreach ($val as $optgroup_key => $optgroup_val) {
                        $sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

                        $form .= '<option value="' . $optgroup_key . '"' . $sel . '>' . (string) $optgroup_val . "</option>\n";
                    }

                    $form .= '</optgroup>' . "\n";
                }
                elseif(is_object($val) && !empty($val)){
                    
                    $_val = property_exists($val, 'label') ? $val->label : 'undefined';
                    $_key = property_exists($val, 'value') ? $val->value : $_val;
                    
                    $sel = (in_array($_key, $selected)) ? ' selected="selected"' : '';
                    
                    $_attr = property_exists($val, 'attribute') ? $val->attribute : '';
                    
                    $form .= '<option value="' . $_key . '"' . $sel . ' '.$_attr.' >' . (string) $_val . "</option>\n";
                }
                else {
                    $sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

                    $form .= '<option value="' . $key . '"' . $sel . '>' . (string) $val . "</option>\n";
                }
            }
        }

        $form .= '</select>';

        return $form;
    }

}