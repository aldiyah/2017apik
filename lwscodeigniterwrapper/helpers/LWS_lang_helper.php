<?php
/**
 * @author lahirwisada@gmail.com
 */
 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('t')) {

    function t($line, $parent_index = NULL) {
        static $_parent = array();

        $LANG = load_class('Lang', 'core');

        if ($parent_index != NULL && !isset($_parent[$parent_index])) {
            $_parent[$parent_index] = $LANG->load($parent_index);
        }

        return ($t = $LANG->line($line)) ? $t : $line;
    }

}

/*
 * must have session possible uri
 *
 */
if (!function_exists('change_lang'))
{

    function change_lang($lang)
    {
        $CI = &get_instance();
        $_uri = (uri_string() != '') ? uri_string() : '';
        if($_uri == 'content/not_found' || $_uri == '/content/not_found')
		{
            $uri = $CI->session->userdata('posible_uri');
			if($uri==FALSE)
				$uri = $_uri;
		}
        
        unset($CI);
        return base_url() . $lang . '/' . $uri;
    }

}

if (!function_exists('what_current_lang'))
{

    function current_abbr_lang()
    {
        $CI = &get_instance();
        $abbr_lang = $CI->get_abbr_lang();
        unset($CI);
        return $abbr_lang;
    }

}

if (!function_exists('show_array_lang'))
{

    function show_array_lang()
    {
        return array('en', 'id');
    }

}

?>