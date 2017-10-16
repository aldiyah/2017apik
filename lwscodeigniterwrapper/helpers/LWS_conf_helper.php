<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('img_upload_location')) {

    function img_upload_location($path = "") {
        $upload_location = "";
        $upload_location .= upload_location("img/") . $path;
        return $upload_location;
    }

}

if (!function_exists('real_upload_location')) {

    function real_upload_location($path = "") {
        $upload_location = "";
        $upload_location .= APPPATH . "../_assets/uploads/" . $path;
        return $upload_location;
    }

}

if (!function_exists('real_application_upload_location')) {

    function real_application_upload_location($path = "", $real = FALSE) {
        $CI = &get_instance();
        $application_upload_location = $CI->config->item('application_upload_location');

        if ($real) {
            $dir_name = dirname(__FILE__);
            if (defined('__DIR__')) {
                $dir_name = __DIR__;
            }
            if (defined('ONCPANEL') && ONCPANEL) {
                $application_path = $CI->config->item('application_path_location');
                unset($CI);
                return $application_path . $application_upload_location;
            } else {
//            echo realpath($dir_name . "/../../" . $application_upload_location);
//            exit;
                unset($CI);
                return realpath($dir_name . "/../../" . $application_upload_location);
            }
        }
        return APPPATH . "../" . $application_upload_location . "/" . $path;
    }

}

if (!function_exists('real_img_upload_location')) {

    function real_img_upload_location($path = "") {
        $upload_location = "";
        $upload_location .= real_upload_location("img/") . $path;
        return $upload_location;
    }

}

if (!function_exists('load_partial')) {

    function load_partial($view, $data = array(), $debug = 0) {
        $CI = &get_instance();
        return $CI->partial($view, $data, $debug);
    }

}

if (!function_exists('IsSslPage')) {

    function IsSslPage() {
        $CI = & get_instance();
        $class = $CI->router->fetch_class();

        $ssl = array();

        if (in_array($class, $ssl)) {
            return true;
        }

        return false;
    }

}

if (!function_exists('iti_base_url')) {

    function iti_base_url() {
        $CI = & get_instance();

        if (IsSslPage())
            return str_replace('http://', 'https://', $CI->config->slash_item('base_url'));
        else
            return str_replace('https://', 'http://', $CI->config->slash_item('base_url'));

        return $CI->config->slash_item('base_url');
    }

}

if (!function_exists('is_menu_active')) {

    function is_menu_active($active_menu, $class_name = 'active', $using_attr_class = FALSE) {
        $CI = &get_instance();
        $uri = $CI->uri->uri_string();
        unset($CI);
        if (preg_match("|/" . $active_menu . "|", $uri))
            if ($using_attr_class)
                return "class='" . $class_name . "'";
            else
                return $class_name;
        else
            return "";
    }

}

if (!function_exists('modules')) {

    function modules() {
        $CI = & get_instance();

        if (IsSslPage())
            return str_replace('http://', 'https://', $CI->config->slash_item('base_url') . 'application/views/');
        else
            return str_replace('https://', 'http://', $CI->config->slash_item('base_url') . 'application/views/');


        return $CI->config->slash_item('base_url') . 'application/views/';
    }

}

if (!function_exists('show_array_lang')) {

    function show_array_lang() {
        return array('en', 'id');
    }

}

if (!function_exists('graph_key_data')) {

    function graph_key_data($by_time, $key_data, $total_key_data) {
        $key_head = '';
        if (!empty($by_time) && $key_data != FALSE) {
            $key_view_count = 0;
            foreach ($key_data as $key => $val) {
                $string = '';
                if ($key == $key_view_count) {
                    if ($by_time == 'hour') {
                        $string = date('H', $val);
                    } elseif ($by_time == 'day')
                        $string = date('D', $val);
                    else //month
                        $string = date('D,M', $val);

                    $key_view_count+=$total_key_data;
                }
                $key_head.= '<th scope="col">' . $string . '</th>';
            }
        }
        return $key_head;
    }

}

if (!function_exists('clean_string_url')) {

    function clean_string_url($str) {
        return preg_replace("/[^0-9a-zA-Z\-_]/", "-", $str);
    }

}
?>