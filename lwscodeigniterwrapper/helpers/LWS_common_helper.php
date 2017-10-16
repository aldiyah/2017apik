<?php

/**
 * @author lahirwisada@gmail.com
 */
/**
 *
 * PATH
 *
 */
if (!function_exists('root')) {

    function root() {
        $root = $root = function_exists("base_url") ? base_url() : "http://" . $_SERVER['HTTP_HOST'];
        return $root;
    }

}

if (!function_exists('assets')) {

    function assets() {
        $_assets = "";
        $_assets .= root() . "_assets/";
        return $_assets;
    }

}

if (!function_exists('js')) {

    function js() {
        $js = "";
        $js .= root() . "_assets/js/";
        return $js;
    }

}

if (!function_exists('img')) {

    function img($path_to = '') {
        $img = "";
        $img .= root() . "_assets/img/" . $path_to;
        return $img;
    }

}

if (!function_exists('css')) {

    function css() {
        $css = "";
        $css .= root() . "_assets/css/";
        return $css;
    }

}

if (!function_exists('backbone_url')) {

    function backbone_url($path = '') {
        $path = 'back_bone/' . $path;
        return base_url($path);
    }

}

if (!function_exists('backend_url')) {

    function backend_url($path = '') {
        $path = 'back_end/' . $path;
        return base_url($path);
    }

}

if (!function_exists('upload_location')) {

    function upload_location($path = '') {
        $upload_location = "";
        $upload_location .= assets() . "uploads/" . $path;
        return $upload_location;
    }

}

if (!function_exists('application_upload_location')) {

    function application_upload_location($path = '') {
        return upload_location() . "application/" . $path;
    }

}

/**
 *
 * URL
 *
 */
if (!function_exists('url_query_string_assoc')) {

    function url_query_string_assoc() {
        $arr_return = FALSE;
        $query_string = $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : FALSE;
        if ($query_string !== FALSE) {
            parse_str($query_string, $arr_return);
        }
        return $arr_return;
    }

}

if (!function_exists('title_to_link')) {

    function title_to_link($str_title = '') {
        if ($str_title != FALSE && $str_title != '') {
            return strtolower(str_replace(' ', '-', preg_replace("/[^A-Za-z0-9 ]/", '-', $str_title)));
        }
        return '';
    }

}

if (!function_exists("string_to_code")) {

    function string_to_code($string = "") {
        if ($string != FALSE && $string != "") {
            return str_replace("-", "_", title_to_link($string));
        }
        return "";
    }

}


/*
 * USE read_crumb:
 *
 * $crumb = array(
 *    array('url' => base_url() . 'backend/' . $this->this_location . 'index', 'title' => $this->header_title),
 *    array('url' => 'javascript:void()', 'title' => $header_title),
 * );
 * <ul>
 * echo read_crumb($crumb);
 *
 */

if (!function_exists('read_crumb')) {

    function read_crumb($crumb = FALSE) {
        $bread_crumb = '';
        if ($crumb != FALSE) {
            $bread_crumb .= '<ul>';
            if (is_array($crumb) && !empty($crumb)) {
                $total_crumb = count($crumb);
                foreach ($crumb as $key => $val) {
                    $bread_crumb .= '<li><a href=\'' . $val['url'] . '\'>' . $val['title'] . '</a>';
                    if ($total_crumb > 1)
                        $bread_crumb .= '<span>�</span></li>';
                    else
                        $bread_crumb .= '</li>';

                    $total_crumb--;
                }
            } else
                $bread_crumb = '<li><a href=\'javascript:void(0);\'>' . $crumb . '</a></li>';

            $bread_crumb .= '</ul>';
        }
        return $bread_crumb;
    }

}

if (!function_exists('have_value')) {

    function have_value($object = NULL, $include_bool = FALSE) {
        if ($object != "" && $object != NULL && !empty($object)) {
            if ($include_bool) {
                return TRUE;
            }

            if ($object) {
                return TRUE;
            }
        }
        return FALSE;
    }

}

/**
 *
 * ARRAY
 *
 */
if (!function_exists('is_arr_key_exists')) {

    function is_arr_key_exists($key_list, $data_array, $strict = FALSE) {
        if (is_array($data_array) && is_array($key_list)) {
            $array_key_found = array();
            foreach ($key_list as $key) {
//                $ada = !array_key_exists($key, $data_array) ? "Tidak Ada" : "Ada";
//                echo $key." exists ".$ada."\n ";
                if (!array_key_exists($key, $data_array) && $strict) {
                    return FALSE;
                }

                if (!$strict && array_key_exists($key, $data_array)) {
                    $array_key_found[] = $key;
                }
            }

            if (!$strict) {
                return count($array_key_found) > 0 && !empty($array_key_found) ? TRUE : FALSE;
            }
        } else {
            return array_key_exists($key_list, $data_array);
        }
        return TRUE;
    }

}

if (!function_exists('default_option_array')) {

    function default_option_array() {
        return array('-1' => '- Silahkan Pilih -');
    }

}

if (!function_exists('array_have_value')) {

    function array_have_value($array) {
        if (is_array($array) && !empty($array)) {
            return TRUE;
        }
        return FALSE;
    }

}

if (!function_exists('array_value_is_ok')) {

    function array_value_is_ok($array_data, $key) {
        if (array_have_value($array_data) && array_key_exists($key, $array_data) && $array_data[$key] != '' && $array_data[$key] != NULL)
            return TRUE;
        else
            return FALSE;
    }

}

/**
 * 
 * @param type $array_data
 * @return int
 */
if (!function_exists('array_count')) {

    function array_count($array_data = FALSE) {
        if (array_have_value($array_data)) {
            return count($array_data);
        }
        return 0;
    }

}

if (!function_exists('shuffle_assoc')) {

    function shuffle_assoc(&$array) {
        $keys = array_keys($array);

        shuffle($keys);

        foreach ($keys as $key) {
            $new[$key] = $array[$key];
        }

        $array = $new;

        return true;
    }

}
/**
 * @return array
 * @param array $src
 * @param array $in
 * @param int|string $pos
 */
if (!function_exists('array_push_before')) {

    function array_push_before($src, $in, $pos) {
        if (is_int($pos))
            $R = array_merge(array_slice($src, 0, $pos), $in, array_slice($src, $pos));
        else {
            foreach ($src as $k => $v) {
                if ($k == $pos)
                    $R = array_merge($R, $in);
                $R[$k] = $v;
            }
        }return $R;
    }

}

/**
 * @return array
 * @param array $src
 * @param array $in
 * @param int|string $pos
 */
if (!function_exists('array_push_after')) {

    function array_push_after($src, $in, $pos) {
        if (is_int($pos))
            $R = array_merge(array_slice($src, 0, $pos + 1), $in, array_slice($src, $pos + 1));
        else {
            foreach ($src as $k => $v) {
                $R[$k] = $v;
                if ($k == $pos)
                    $R = array_merge($R, $in);
            }
        }return $R;
    }

}

/**
 *
 * OPERATION
 *
 */
/**
 * @author Lahir Wisada Santoso <lahirwisada@gmail.com>
 */
if (!function_exists('remove_script')) {

    function remove_script($html = '') {
        return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
    }

}

if (!function_exists('dropdown_tahun')) {

    function dropdown_tahun($namadropdown = 'tahun', $default_value = FALSE, $range_tahun = 10, $attribute = '', $min_year = FALSE, $max_year = FALSE, $desc = FALSE) {
        $default_value = $default_value != FALSE ? $default_value : date('Y');
        $_min_year = $min_year != FALSE && $range_tahun == FALSE ? $min_year : ($min_year == FALSE && $range_tahun != FALSE ? (date('Y') - $range_tahun) : (date('Y') - 10));
        $_max_year = $max_year != FALSE && $range_tahun == FALSE ? $max_year : ($max_year == FALSE && $range_tahun != FALSE ? (date('Y') + $range_tahun) : (date('Y') + 10));
        $arr_year = array();
        if ($desc) {
            while ($_max_year >= $_min_year) {
                $arr_year[$_max_year] = $_max_year;
                $_max_year--;
            }
        } else {
            while ($_min_year <= $_max_year) {
                $arr_year[$_min_year] = $_min_year;
                $_min_year++;
            }
        }
        return form_dropdown($namadropdown, $arr_year, $default_value, $attribute);
    }

}

if (!function_exists('encode_and_json_encode')) {

    function encode_array_and_json_encode($arr_data = array()) {
        if (is_array($arr_data) && !empty($arr_data) && count($arr_data) > 0) {
            $arr_res = array();
            foreach ($_GET as $key => $rec) {
                $arr_res[$key] = '';
                if ($rec != '' && !is_numeric($rec) && !is_array($rec) && !is_object($rec)) {
                    $arr_res[$key] = addslashes(htmlspecialchars($rec));
                }
            }
            return json_encode($arr_res);
        }
        return '{}';
    }

}

if (!function_exists('param_numeric_ok')) {

    function param_numeric_ok($param = FALSE) {
        $result_ok = TRUE;
        if (is_array($param) && !empty($param)) {
            foreach ($param as $row_param) {
                $result_ok = param_numeric_ok($row_param);
            }
        } else {
            if (!is_numeric($param) || $param == 0) {
                $result_ok = FALSE;
            }
        }
        return $result_ok;
    }

}

if (!function_exists('num_to_roman')) {

    function num_to_roman($num) {
        // Make sure that we only use the integer portion of the value
        $n = intval($num);
        $result = '';

        // Declare a lookup array that we will use to traverse the number:
        $lookup = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);

        foreach ($lookup as $roman => $value) {
            // Determine the number of matches
            $matches = intval($n / $value);

            // Store that many characters
            $result .= str_repeat($roman, $matches);

            // Substract that from the number
            $n = $n % $value;
        }

        // The Roman numeral should be built, return it
        return $result;
    }

}

if (!function_exists('beautify_str')) {

    function beautify_str($str = "", $show_blank_space_when_null = FALSE, $default_value = "") {
        if (strlen($str) > 0 && strtolower($str) != "null") {
            return ucwords(str_replace("_", " ", stripslashes($str)));
        }

        if ($show_blank_space_when_null) {
            return " ";
        }
        return $default_value;
    }

}

if (!function_exists('remove_multiple_line_symbol')) {

    function remove_multiple_line_symbol($str_text = "") {
        $str_text = trim(preg_replace("/\s\s+/", "", $str_text));
        $str_text = preg_replace("/(\\r?\\n){2,}/", "", $str_text);
        $str_text = preg_replace("/[\\r\\n]+/", "<br />", $str_text);
        $str_text = preg_replace("/rn+/", "", $str_text);
        $str_text = str_replace("\\n\\n", "", $str_text);
        $str_text = str_replace("\\n", "", $str_text);
        $str_text = nl2br($str_text);
        return $str_text;
    }

}

if (!function_exists('beautify_text')) {

    function beautify_text($str_text = "") {
        if (strlen($str_text) > 0) {
            return beautify_str(stripslashes(remove_multiple_line_symbol($str_text)));
        }
        return "";
    }

}

if (!function_exists('get_some_word')) {

    function get_some_word($str_text = "", $limit = 90, $beautify = TRUE) {

        if (strlen($str_text) > 0) {
            $arr_str_text = explode(" ", $str_text, $limit);
            unset($arr_str_text[$limit - 1]);
            $str_result = implode(" ", $arr_str_text);
            unset($arr_str_text);
            if ($beautify) {
                return beautify_text($str_result);
            }
            return $str_result;
        }
        return "";
    }

}

if (!function_exists('show_sub_description_string')) {

    function show_sub_description_string($str = "", $show_length = 50) {
        if (strlen($str) > $show_length) {
            return stripslashes(substr($str, 0, $show_length)) . " ...";
        }
        return stripslashes(substr($str, 0, $show_length));
    }

}

if (!function_exists('int_todate')) {

    function int_todate($int, $format = 'd-m-Y H:i:s') {
        return date($format, $int);
    }

}

if (!function_exists('get_int_range')) {

    function get_int_range($from_date, $to_date) {
        $from_date = int_todate(intval($from_date), 'Y-m-d H:i:s');
        $to_date = int_todate(intval($to_date), 'Y-m-d H:i:s');
        return array($from_date, $to_date);
    }

}

if (!function_exists('date_to_int')) {

    function date_to_int($date, $format = array('d' => 0, 'm' => 1, 'Y' => 2), $delimiter = '-') {
        $arr_date = explode($delimiter, $date);
        $int_date = mktime(0, 0, 0, $arr_date[$format['m']], $arr_date[$format['d']], $arr_date[$format['Y']]);
        return $int_date;
    }

}

if (!function_exists('array_day')) {

    function array_day($idx_day = FALSE) {
        $arr_day = array('minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jum\'at', 'sabtu');
        if ($idx_day != FALSE && $idx_day >= 0 && $idx_day < 7) {
            return $arr_day[$idx_day];
        } elseif ($idx_day != FALSE && ($idx_day < 0 || $idx_day >= 7)) {
            return FALSE;
        } else {
            return $arr_day;
        }
    }

}

if (!function_exists('array_year_range')) {

    function array_year_range($min_year = FALSE, $max_year = FALSE) {
        if (!$min_year) {
            $min_year = date('Y') - 20;
        }
        if (!$max_year) {
            $max_year = date('Y');
        }

        $array_year = range(date('Y') - 30, $max_year);
        return array_combine($array_year, $array_year);
    }

}

if (!function_exists('array_month')) {

    function array_month($idx_month = FALSE, $get_abbr = FALSE, $from_o = FALSE) {
        $arr_month = array(
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );
        $abbr_month = array(
            '1' => 'jan',
            '2' => 'feb',
            '3' => 'mar',
            '4' => 'apr',
            '5' => 'mei',
            '6' => 'jun',
            '7' => 'jul',
            '8' => 'ags',
            '9' => 'sep',
            '10' => 'okt',
            '11' => 'nov',
            '12' => 'des'
        );

        $idx_month = intval($idx_month);

        if ($from_o) {
            $idx_month + 1;
        }

        if (!$get_abbr) {
            if ($idx_month != FALSE && $idx_month > 0 && $idx_month < 13) {
                return $arr_month[$idx_month];
            } elseif ($idx_month != FALSE && ($idx_month <= 0 || $idx_month > 12)) {
                return FALSE;
            } else {
                return $arr_month;
            }
        }

        if ($idx_month != FALSE && $idx_month > 0 && $idx_month < 13) {
            return $abbr_month[$idx_month];
        } elseif ($idx_month != FALSE && ($idx_month <= 0 || $idx_month > 12)) {
            return FALSE;
        } else {
            return $abbr_month;
        }
    }

}

if (!function_exists('int_month_range')) {

    function int_month_range($idx_month = FALSE, $year = FALSE) {
        if (!$year) {
            $year = date('Y');
        }
        if (!$idx_month) {
            $idx_month = date('m');
        }

        $arr_ret = array();
        $arr_ret[0] = mktime(0, 0, 0, $idx_month, 1);
        $arr_ret[1] = mktime(0, 0, 0, $idx_month, date('t', mktime(0, 0, 0, $idx_month)));
        return $arr_ret;
    }

}

if (!function_exists('string_to_date')) {

    function string_to_date($str_date, $format = 'd-m-Y') {

        if ($str_date != FALSE && $str_date != NULL && $str_date != '')
            return date($format, strtotime($str_date));
        else
            return '';
    }

}

if (!function_exists('pg_date_to_text')) {

    function pg_date_to_text($date, $format = 'd-m-Y', $default_value = "") {
        $date = strtotime($date);
        if ($date != '') {
            $tgl = date('d', $date);
            $mth = array_month(date('m', $date));
            $thn = date('Y', $date);
            return $tgl . " " . $mth . " " . $thn;
        }
        return $default_value;
    }

}

if (!function_exists('remove_space_and_tolower')) {

    function remove_space_and_tolower($string = FALSE) {
        if ($string) {
            return str_replace(" ", "_", strtolower($string));
        }
        return "";
    }

}

if (!function_exists('toArray')) {

// From object to array.
    function toArray($data) {
        if (is_object($data))
            $data = get_object_vars($data);
        return is_array($data) ? array_map(__FUNCTION__, $data) : $data;
    }

}

if (!function_exists('toObject')) {

// From array to object.
    function toObject($data) {
        return is_array($data) ? (object) array_map(__FUNCTION__, $data) : $data;
    }

}

if (!function_exists('toJsonString')) {

    function toJsonString($datas = FALSE, $using_key = TRUE) {

        if (!$datas) {
            return "[]";
        }

        $datas = is_object($datas) ? toArray($datas) : $datas;
        $string_result = "";
        foreach ($datas as $key => $data) {
            if ($using_key) {
                $string_result .= "\"" . $key . "\" : ";
            }
            if (is_array($data)) {
                $string_result .= toJsonString($data, $using_key);
            } elseif (is_numeric($data)) {
                $string_result .= $data;
            } else {
                $string_result .= "\"" . $data . "\"";
            }
            $string_result .= ", ";
        }
        return "[" . $string_result . "]";
    }

}

function rupiahToInt($str) {
    return preg_replace("/([^0-9\\.])/i", "", $str);
}

/**
 *
 * File Operation
 *
 */
if (!function_exists('get_file_name')) {

    function get_file_name($file_path = FALSE) {
        if ($file_path == FALSE)
            return '';

        $file_name = pathinfo($file_path, PATHINFO_BASENAME);
        return $file_name;
    }

}

if (!function_exists('show_list_file')) {

    /**
     * $list_file = 'file1, file2, file3';
     * show_list_file($list_file);
     * @return array();
     */
    function show_list_file($record_file = FALSE) {
        if ($record_file == FALSE)
            return '';

        $files = explode(',', $record_file);
        $total_file = count($files);
        $return = FALSE;
        if ($total_file > 1) {
            foreach ($files as $file) {
                $return[] = array('filename' => get_file_name($file), 'path' => $file);
            }
        } else
            $return[] = array('filename' => get_file_name($files), 'path' => $file);
    }

}

if (!function_exists('remote_file_exists')) {

    function remote_file_exists($url) {
        return (bool) preg_match('~HTTP/1\.\d\s+200\s+OK~', @current(get_headers($url)));
    }

}

if (!function_exists('get_upload_location')) {

    /**
     * BETA version since APPSIDIKA 2016
     * @param type $upload_destination
     * @return type
     */
    function get_upload_location($upload_destination = '') {
        $file_upload_path = real_upload_location();

        $return_upload_path = $upload_destination;
        if (defined('ONCPANEL') && ONCPANEL) {
            $return_upload_path = $file_upload_path;
        }

        $is_file_exists = is_file_exists($upload_destination, TRUE, FALSE, TRUE, $file_upload_path);
        if ($is_file_exists) {
            return $file_upload_path . $return_upload_path;
        }
        return FALSE;
    }

}


if (!function_exists('is_string_not_empty')) {

    function is_string_not_empty($string = "", $min_length = FALSE) {
        if ($string && $string !== "") {
            $lenstr = strlen($string);
            if ($min_length) {
                if ($lenstr >= $min_length) {
                    return $lenstr;
                }
            } else {
                return $lenstr;
            }
        }
        return FALSE;
    }

}


if (!function_exists('is_remote_file_exists')) {

    /**
     * 
     * @param type $path adalah lokasi sub folder dari $real_path contoh : "kategori_file_upload/jenis_file/tanggal/"
     * @param type $return_value
     * @param type $is_remote
     * @param type $create_when_not_exists
     * @param type $real_path adalah lokasi folder yang digunakan untuk menempatkan file upload contoh : "E:/www/SI_APP/_assets/uploads/"
     * @return boolean 
     */
    function is_file_exists($path, $return_value = 'boolean', $is_remote = FALSE, $create_when_not_exists = FALSE, $real_path = FALSE) {
        /**
         * @deprecated since 21-MEI-2016
         */
        /** $root_path = $_SERVER['DOCUMENT_ROOT'] . "/"; */
        if (!$real_path) {

            /**
             * LWS_conf_helper
             */
            $real_path = real_upload_location();
        }

        /**
         * jika aplikasi sudah ditempatkan di CPANEL maka semua file upload akan diarahkan ke path yang telah ditentukan pada konfigurasi
         */
//        if (defined('ONCPANEL') && ONCPANEL) {
//            $CI = &get_instance();
//            $application_upload_location = $CI->config->item('application_upload_location');
//
//            $root_path .= $application_upload_location;
//        }
        $path = substr($path, 0, 1) != "/" ? "/" . $path : $path;

        $file_exists = ($is_remote) ? remote_file_exists($path) : file_exists($real_path . $path);

        /**
         * cek apakah folder ada atau tidak
         * jika folder tidak ada dan variable $create_when_not_exists bernilai TRUE maka buat folder
         */
        if ($file_exists == FALSE || $path == '' || $path == $real_path) {
            if ($create_when_not_exists) {
                if ($real_path) {

                    $path = substr($path, 0, 1) != "/" ? "/" . $path : $path;
                    $return_value = @mkdir($real_path . $path, 0755, true);
                } else {
                    $return_value = @mkdir($path, 0755, true);
                }
            } else {
                return FALSE;
            }
        }

        if ($return_value == 'boolean')
            return TRUE;

        return $return_value;
    }

}

if (!function_exists('check_upload_field')) {

    function check_upload_field($upload_data = FALSE, $field = array()) {
        if ($upload_data == FALSE || empty($field))
            return FALSE;

        $response = FALSE;
        //OR mode
        foreach ($field as $col) {
            if (array_key_exists($col, $upload_data) && $upload_data[$col] && $upload_data[$col]['name'] != '')
                $response = TRUE;
        }
        return $response;
    }

}


if (!function_exists('upload_data')) {

    /**
     * Jika gagal akan memberikan nilai balik Boolena
     * Jika berhasil maka akan memberikan nilai balik Array sbb:
     * array(4) {
      ["uploadfailed"]=> bool(false)
      ["message"]=> string(14) "Upload Success"
      ["file_info"]=> string(157) "D:/www/kominfo/guritaStore/gurita-store/_assets/uploads/application/administrator/counting_beads/thumbnail/counting_beads_counting_beads19-09-2014_233001.jpg"
      ["file_name_uploaded"]=> string(50) "counting_beads_counting_beads19-09-2014_233001.jpg"
      }

     * @param type $data
     * @param type $cfg
     * @param type $rename_prefix
     * @return string|boolean
     */
    function upload_data($data = FALSE, $cfg = array('upload_path' => '_assets/upload/'), $rename_prefix = FALSE, $rename_using_md5 = FALSE) {
        // must be set PHP_INI_PERDIR
//        ini_set("post_max_size", "128M");
//        ini_set("upload_max_filesize", "64M");
        ini_set("memory_limit", "64M");

        $arr_return['uploadfailed'] = FALSE;
        $arr_return['message'] = FALSE;
        $arr_return['file_info'] = FALSE;

        if ($data == FALSE)
            return array('uploadfailed' => TRUE, 'message' => 'Upload Failed.', 'file_info' => FALSE);

        $rename_to = false;

        /**
         * will be set as FALSE when upload failed
         * will be set as file properties when file uploaded in success
         */
        $upload_result = TRUE;

        $CI = &get_instance();
        if (is_array($cfg) && !empty($cfg)) {
            $CI->load->library('upload', $cfg);
        } else {
            $CI->load->library('upload');
        }

        if (!isset($_FILES[$data])) {
            $CI->upload->set_error('upload_no_file_selected');
            $upload_result = FALSE;
        } else {
            // Is the upload path valid?
            if (!$CI->upload->validate_upload_path($data)) {
                // errors will already be set by validate_upload_path() so just return FALSE
                $upload_result = FALSE;
            }
            $upload_result = $CI->upload->do_upload($data);
        }

        $message = $CI->upload->display_errors();
        if ($message != "" || $upload_result == FALSE) {
            $arr_return['uploadfailed'] = TRUE;
            $arr_return['message'] = $message;
            $arr_return['file_info'] = FALSE;
            return $arr_return;
        }
        $uploaded = $CI->upload->data();
        $rename_to = (string) strtolower(str_replace(' ', '_', $uploaded['raw_name'])) . date('d-m-Y_His') . $uploaded['file_ext'];
        if ($rename_prefix != FALSE) {
            $rename_to = $rename_prefix . '_' . $rename_to;
        }

        if ($rename_using_md5) {
            $rename_to = md5($rename_to) . $uploaded['file_ext'];
        }
        rename($uploaded['full_path'], $uploaded['file_path'] . $rename_to);

        $arr_return['message'] = 'Upload Sukses.';
        $arr_return['file_name_uploaded'] = $rename_to;
        $arr_return['file_info'] = $uploaded['file_path'] . $rename_to;
        $arr_return['file_size'] = $uploaded['file_size'];
        unset($CI);
        return $arr_return;
    }

}
/**
 * 
 * IMAGE OPERATION
 *  
 */
if (!function_exists('get_image_properties')) {

    function get_image_properties($path = '') {
        $path = $_SERVER['DOCUMENT_ROOT'] . "/" . $path;
//var_dump($path); exit;
        if (!file_exists($path)) {
            return FALSE;
        }

        $vals = @getimagesize($path);

        $types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');

        $mime = (isset($types[$vals['2']])) ? 'image/' . $types[$vals['2']] : 'image/jpg';

        $v['width'] = $vals['0'];
        $v['height'] = $vals['1'];
        $v['image_type'] = $vals['2'];
        $v['size_str'] = $vals['3'];
        $v['mime_type'] = $mime;

        unset($vals, $mime);

        return $v;
    }

}

if (!function_exists('resize_image')) {

    function resize_image($oldFile, $width, $height, $ext, $path = '_assets/uploads/') {
        $CI = &get_instance();
//call image properties   
        $info = pathinfo($oldFile);
        $name = $info['filename'];
        $new_filename = $name . '_' . $width . 'x' . $height . $ext;

//out($info);

        $tempFile = $path . "temporary_" . $new_filename;

        $newFile = $path . $new_filename;

        $o_size = get_image_properties('/' . $info['dirname'] . '/' . $info['basename'], true);

        $master_dim = ($o_size['width'] - $width < $o_size['height'] - $height ? 'width' : 'height');

        $perc = max((100 * $width) / $o_size['width'], (100 * $height) / $o_size['height']);

        $perc = ceil($perc);

        $w_d = ceil(($perc * $o_size['width']) / 100);
        $h_d = ceil(($perc * $o_size['height']) / 100);

// end math stuff

        /*
         *    Resize image
         */
        $config['image_library'] = 'gd2';
        $config['source_image'] = $oldFile;
        $config['new_image'] = $tempFile;
        $config['maintain_ratio'] = TRUE;
        $config['master_dim'] = $master_dim;
        $config['width'] = $w_d + 1;
        $config['height'] = $h_d + 1;
        $config['quality'] = "100%";
        $CI->load->library('image_lib');

        $CI->image_lib->initialize($config);

        $CI->image_lib->resize();

        $size = get_image_properties($tempFile, true);

        unset($config); // clear $config

        /*
         *    Crop image  in weight, height
         */

        $config['image_library'] = 'gd2';
        $config['source_image'] = $tempFile;
        $config['new_image'] = $newFile;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['y_axis'] = round(($size['height'] - $height) / 2);
        $config['x_axis'] = round(($size['width'] - $width) / 2);
        $config['quality'] = "100%";

        $CI->image_lib->clear();
        $CI->image_lib->initialize($config);
        if (!$CI->image_lib->crop()) {
            $CI->image_lib->display_errors();
        }

        $info = pathinfo($newFile);
        unset($CI);
//out($info);
//echo $_SERVER['DOCUMENT_ROOT']."/".$tempFile; echo "<br>";
        unlink($_SERVER['DOCUMENT_ROOT'] . "/" . $tempFile);
        return $new_filename;
    }

}

if (!function_exists('modify_image')) {

    function modify_image($path, $filename, $ext, $dest_width, $dest_height) {
//call resize image
//return string filename
        return resize_image($path . $filename, $dest_width, $dest_height, $ext, $path);
    }

}

/**
 *
 * DATABASE OPERATION
 *
 */
if (!function_exists('get_total_return')) {

    function get_total_return($record_set) {
        if ($record_set && is_array($record_set) && array_key_exists('total', $record_set[0]))
            return $record_set[0]['total'];
        else
            return '0';
    }

}

if (!function_exists('arrange_keyword')) {

    function arrange_keyword($keyword, $table_name = FALSE, $column_name = FALSE, $lang = 'id', $is_all = FALSE) {
        if ($column_name == FALSE || $table_name == FALSE)
            return FALSE;

        $key = formatting_keyword($keyword);
        if ($key['patent'] != FALSE) {
            foreach ($key['patent'] as $key => $val) {
                _like($val, $table_name, $column_name, $lang, $is_all);
            }
        }
        $arr_string = explode(" ", $key['keyword']);
        $keyword_found = count($arr_string);
        if ($keyword_found > 1) {
            foreach ($arr_string as $key => $val) {
                _like($val, $table_name, $column_name, $lang, $is_all);
            }
        } else
            _like($keyword, $table_name, $column_name, $lang, $is_all);

        unset($arr_string, $keyword_found, $keyword);
        return TRUE;
    }

}

if (!function_exists('_like')) {

    function _like($val, $table_name, $column_name, $lang, $is_all) {
        if (is_array($column_name) && !empty($column_name)) {
            foreach ($column_name as $column)
                set_like($val, $table_name, $column, $lang, TRUE, $is_all);
        } else
            set_like($val, $table_name, $column, $lang, TRUE, $is_all);

        return;
    }

}



if (!function_exists('set_like')) {

    function set_like($keyword, $table_name = FALSE, $column_name = FALSE, $lang = 'id', $first_step = TRUE, $is_all = FALSE) {
        $CI = &get_instance();
        if ($column_name == FALSE || $table_name == FALSE)
            return;

        if ($is_all === TRUE) {
            $CI->db->or_like($table_name . '.' . $column_name . '_id', $keyword);
            $CI->db->or_like($table_name . '.' . $column_name . '_en', $keyword);
        } elseif ($is_all !== TRUE && ($lang == 'en' || $lang == 'id')) {
            $CI->db->or_like($table_name . '.' . $column_name . '_' . $lang, $keyword);
        } else {
            $CI->db->or_like($table_name . '.' . $column_name, $keyword);
        }
        return;
    }

}
if (!function_exists('formatting_keyword')) {

    function formatting_keyword($string) {
        $string = stripslashes($string);
        $pattern = '|\'([^\']+)|';
        preg_match_all($pattern, $string, $keyword_found);
        $key['patent'] = (count($keyword_found[1]) > 0) ? $keyword_found[1] : FALSE;
        if ($key['patent']) {
            foreach ($key['patent'] as $string_to_remove) {
                $string = str_replace($string_to_remove, '', $string);
            }
        }
        $string = trim(str_replace('\'', '', $string));
        $key['keyword'] = $string;
        return $key;
    }

}
/* DISPLAY VARIABLE */

if (!function_exists('rupiah_display')) {

    function rupiah_display($var, $null = TRUE, $fractional = FALSE) {
        $rupiah = _format_number($var, $null, $fractional);
        return $rupiah !== "" && $rupiah !== "N/A" ? "Rp. " . $rupiah : $rupiah;
    }

}

if (!function_exists('_format_number')) {

    function _format_number($var, $null = TRUE, $fractional = FALSE) {
        if ($null === TRUE && $var == 0)
            return "N/A";

        if ($null === FALSE && ($var == 0 || $var == "")) {
            return "";
        }

        if ($fractional) {
            $var = sprintf('%.2f', $var);
        }
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1.$2', $var);
            if ($replaced != $var) {
                $var = $replaced;
            } else {
                break;
            }
        }
        return $var;
    }

}

if (!function_exists('lid_send_mail')) {

    function lid_send_mail($mail_to, $subject = 'Islam United', $mail_content = 'Islam United', $mail_from = FALSE) {

        $CI = & get_instance();
        $CI->load->library('email');

        $CI->config->load('email_config');
        $email_config = $CI->config->item('email');

        $config['protocol'] = $email_config['protocol'];
        $config['mailpath'] = $email_config['mailpath'];
        $config['charset'] = $email_config['charset'];
        $config['wordwrap'] = $email_config['wordwrap'];
        $config['mailtype'] = $email_config['mailtype'];
        $config['smtp_host'] = $email_config['smtp_host'];
        $config['smtp_user'] = $email_config['smtp_user'];
        $config['smtp_pass'] = $email_config['smtp_pass'];
        $config['smtp_port'] = $email_config['smtp_port'];

        $CI->email->initialize($config);

        $CI->email->from($email_config['email_from'], $email_config['email_from_name']);
        $CI->email->to($mail_to);
        $CI->email->subject($subject);

        $CI->email->message($mail_content);

        $CI->email->reply_to($email_config['email_from'], $email_config['email_from_name']);

        if (($CI->email->send()) == TRUE) {
            unset($CI);
            return TRUE;
        } else {
            $debuger = $CI->email->print_debugger();
            unset($CI);
            return $debuger;
        }
        unset($CI);
        return FALSE;
    }

}

if (!function_exists('count_and_rand')) {

    function count_and_rand($array_data = array()) {
        $num = FALSE;
        if (!empty($array_data)) {
            $num_of_arr = count($array_data);
            $num = $num_of_arr != 1 ? rand(0, $num_of_arr - 1) : 0;
        }
        return $num;
    }

}
if (!function_exists('guid')) {

    function guid() {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = chr(123)// "{"
                    . substr($charid, 0, 8) . $hyphen
                    . substr($charid, 8, 4) . $hyphen
                    . substr($charid, 12, 4) . $hyphen
                    . substr($charid, 16, 4) . $hyphen
                    . substr($charid, 20, 12)
                    . chr(125); // "}"
            return $uuid;
        }
    }

}

if (!function_exists('show_date_with_format')) {

    function show_date_with_format($stringdate = "", $format = "d-m-Y", $current_format = "Y-m-d") {
        $return_date = "";
        if ($stringdate != "" && strtolower($stringdate) != "null") {
            $return_date = date($format, strtotime($stringdate));
        }
        return $return_date;
    }

}

if (!function_exists('show_greeting')) {

    function show_greeting($lang = 'id') {
        /* This sets the $time variable to the current hour in the 24 hour clock format */
        date_default_timezone_set('Asia/Jakarta');
        $time = date("H");
        /* Set the $timezone variable to become the current timezone */
        $timezone = date("e");
        /* If the time is less than 1200 hours, show good morning */
        if ($time < "12") {
            echo $lang == 'id' ? "Selamat Pagi" : "Good morning";
        } else
        /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
        if ($time >= "12" && $time < "17") {
            echo $lang == 'id' ? "Selamat Siang" : "Good afternoon";
        } else
        /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
        if ($time >= "17" && $time < "19") {
            echo $lang == 'id' ? "Selamat Sore" : "Good evening";
        } else
        /* Finally, show good night if the time is greater than or equal to 1900 hours */
        if ($time >= "19") {
            echo $lang == 'id' ? "Selamat Malam" : "Good night";
        }
    }

}

if (!function_exists("is_role_match")) {

    /**
     * untuk cek bahwa user yang sekarang sedang aktif adalah seorang pelanggan / user 
     * yang telah terdaftar pada aplikasi gurita store
     * @param string $const_role_pelanggan
     * @param array $current_role
     * @return boolean
     */
    function is_role_match($const_role = FALSE, $current_role = array()) {
        if ($const_role && array_have_value($current_role)) {
            if (in_array($const_role, $current_role)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    if (!function_exists('json_encode')) {

        function json_encode($var) {
            $ci = &get_instance();

            $ci->load->library('my_json');
            $encoded_json = $ci->my_json->encode($var);
            unset($ci);
            return $encoded_json;
        }

    }
}

if (!function_exists("_sort_helper")) {

    function _sort_helper(&$input, &$output, $parent_id, $id_name = 'id', $parent_id_name = 'parent_id') {
        foreach ($input as $key => $item) {
            if ($item->{$parent_id_name} == $parent_id) {
                $output[$item->{$id_name}] = $item;
                unset($input[$key]);

                // Sort nested!!
                _sort_helper($input, $output, $item->{$id_name}, $id_name, $parent_id_name);
            }
        }
    }

}

if (!function_exists("sort_items_into_tree")) {

    function sort_items_into_tree($items, $id_name = 'id', $parent_id_name = 'parent_id') {
        $tree = array();
        _sort_helper($items, $tree, NULL, $id_name, $parent_id_name);
        return $tree;
    }

}


if (!function_exists("build_tree")) {

    function build_tree(array &$elements, $parentId = "", $id_name = 'id', $parent_id_name = 'parent_id') {
        $branch = array();

        foreach ($elements as $key => $element) {
//            echo " a ".$element->nama_modul."<br />";
            if ($element->{$parent_id_name} == $parentId) {
//                echo "child".$element->nama_modul."<br />";
                $children = build_tree($elements, $element->{$id_name}, $id_name, $parent_id_name);
                if ($children) {
                    $element->child = $children;
                }
                $branch[$element->{$id_name}] = $element;
//                unset($elements[$key]);
            }
        }

        return $branch;
    }

}
if (!function_exists("pg_array_parse")) {

    function pg_array_parse($text, &$output, $limit = false, $offset = 1) {
        if (false === $limit) {
            $limit = strlen($text) - 1;
            $output = array();
        }
        if ('{}' != $text)
            do {
                if ('{' != $text{$offset}) {
                    preg_match("/(\\{?\"([^\"\\\\]|\\\\.)*\"|[^,{}]+)+([,}]+)/", $text, $match, 0, $offset);
                    if (count($match) > 0) {
                        $offset += strlen($match[0]);
                        $output[] = ( '"' != $match[1]{0} ? $match[1] : stripcslashes(substr($match[1], 1, -1)) );
                        if ('},' == $match[3])
                            return $offset;
                    }
                } else
                    $offset = pg_array_parse($text, $output[], $limit, $offset + 1);
            }
            while ($limit > $offset);
        return $output;
    }

}
if (!function_exists("to_pg_array")) {

    function to_pg_array($set) {
        settype($set, 'array'); // can be called with a scalar or array
        $result = array();
        foreach ($set as $t) {
            if (is_array($t)) {
                $result[] = to_pg_array($t);
            } else {
                $t = str_replace('"', '\\"', $t); // escape double quote
                if (!is_numeric($t)) // quote only non-numeric values
                    $t = '"' . $t . '"';
                $result[] = $t;
            }
        }
        return '{' . implode(",", $result) . '}'; // format
    }

}

if (!function_exists('remove_non_column_data')) {

    function remove_non_column_data($data = FALSE, $array_key_to_unset = array()) {
        if ($data) {

            foreach ($array_key_to_unset as $key_to_unset) {
                if (array_key_exists($key_to_unset, $data)) {
                    unset($data[$key_to_unset]);
                }
            }
        }
        return $data;
    }

}

if (!function_exists('get_sort_icon')) {

    function get_sort_icon($sort_mode = FALSE, $sort_by = FALSE, $current_sort_by = FALSE) {
        if ($sort_by && $current_sort_by && $sort_by == $current_sort_by) {
            if ($sort_mode == 'asc') {
                return "<span class=\"fa fa-sort-asc\"></span>";
            }
            if ($sort_mode == 'desc') {
                return "<span class=\"fa fa-sort-desc\"></span>";
            }
        }

        return "";
    }

}