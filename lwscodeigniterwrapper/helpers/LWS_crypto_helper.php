<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



if (!function_exists('generate_crypt')) {

    function generate_crypt($string_something, $separator = "::", $prefix = "abcd", $basic_crypt = FALSE, $generate_key = 18) {
        $str = trim($string_something);
        $prefix = trim($prefix);
        if ($str != '' && $prefix != '') {
            $key = generate_key($generate_key, $basic_crypt);
            $str = md5($prefix . $key . $str);
            $str .= $separator . $key;
        }
        return $str;
    }

}
if (!function_exists('generate_key')) {

    function generate_key($length = 8, $basic_crypt = FALSE) {
        $salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $makekey = '';

        if (!$basic_crypt) {
            mt_srand(10000000 * (double) microtime());
        }

        for ($i = 0; $i < $length; $i++)
            $makekey .= $salt[mt_rand(0, 61)];
        return $makekey;
    }

}
