<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Lmanuser
 *
 * @author morpheus
 */
class Lmanuser {

    private $_ci_session;
    private $_prefix = 'auth.';

    /**
     * BETA variable to login with frontend and backend side
     * @var type 
     */
    private $_using_backendfrontend = FALSE;
    private $_prefix_backend = "auth.backend.";
    private $_prefix_frontend = "auth.frontend.";
    private $_key = NULL;
    private $_appsalt = '1234';

    const FRONT_END = 'FRONT_END';
    const BACK_END = 'BACK_END';

    function __construct() {
        $CI = &get_instance();
        if (!isset($CI->session)) {
            $CI->load->library('session');
        }
        $this->_ci_session = $CI->session;
        $this->_using_backendfrontend = $CI->config->item('lmanuser.usingbackendfrontend');
        $this->_appsalt = $CI->config->item('appsalt');

        $this->_key = $this->_prefix . 'logged_on';
    }

    function is_valid_password($user_name, $user_pass, $input_password) {
        if (strlen($user_pass) > 0) {
            list($vpwd, $key) = explode("::", $user_pass);
            if (isset($key)) {
                return md5($user_name . $key . $input_password) === $vpwd;
            }
        }
        return FALSE;
    }

    function generate_password($user, $password) {
        $str = trim($password);
        $user = trim($user);
        if ($str != '' && $user != '') {
            $key = $this->generate_key(16);
            $str = md5($user . $key . $str);
            $str .= "::" . $key;
        }
        return $str;
    }

    protected function generate_key($length = 8) {
        $salt = $this->_appsalt;
        $makekey = '';
        mt_srand(10000000 * (double) microtime());
        for ($i = 0; $i < $length; $i++)
            $makekey .= $salt[mt_rand(0, 61)];
        return $makekey;
    }

    function get_const_front_end() {
        return self::FRONT_END;
    }

    function get_const_back_end() {
        return self::BACK_END;
    }

    /**
     * 
     * @param array $user_detail
     * @param string $roles DEFAULT WOULD BE guest
     * @param string $side_end_login DEFAULT WOULD BE FRONT_END
     */
    function login($user_detail, $roles = 'guest', $side_end_login = 'FRONT_END') {

        if ($this->_using_backendfrontend) {
            $prefix = $this->_prefix_frontend;
            if ($side_end_login == self::BACK_END) {
                $prefix = $this->_prefix_backend;
            }
            $this->_login($prefix, $user_detail, $roles);
        } else {
            $this->_login($this->_prefix, $user_detail, $roles);
        }
    }

    public function set_user_detail($key = FALSE, $value = FALSE) {
        if (!$key) {
            return;
        }
        $prefix = $this->_prefix;
        if ($this->_using_backendfrontend) {
            $prefix = $this->_prefix_frontend;
            if ($side_end_login == self::BACK_END) {
                $prefix = $this->_prefix_backend;
            }
        }
        $data = $this->get("user_detail");
        $data[$key] = $value;
        $this->_ci_session->set_userdata($prefix . 'user_detail', $data);
        return;
    }

    private function _get_prefix_key($prefix) {
        return $prefix . 'logged_on';
    }

    private function _get_key_front_end() {
        return $this->_prefix_frontend . 'logged_on';
    }

    private function _get_key_back_end() {
        return $this->_prefix_backend . 'logged_on';
    }

    private function _login($prefix, $user_detail, $roles = 'guest') {
        $data = array();
        $key = $this->_get_prefix_key($prefix);
        $data[$key] = $this->generate_key(32);
        $data[$prefix . 'user_detail'] = (array) $user_detail;
        $data[$prefix . 'roles'] = $roles;

        $this->_ci_session->set_userdata($data);
    }

    function _logout($prefix = FALSE) {
        if (!$prefix) {
            $this->_ci_session->sess_destroy();
        } else {
            $key = $this->_get_prefix_key($prefix);
            $data[$key] = FALSE;
            $data[$prefix . 'user_detail'] = FALSE;
            $data[$prefix . 'roles'] = FALSE;
            $this->_ci_session->unset_userdata($data);
        }
    }

    function get_prefix($side_end_login = 'FRONT_END') {
        $prefix = $this->_prefix;
        if ($this->_using_backendfrontend) {
            $prefix = $this->_prefix_frontend;
            if ($side_end_login == self::BACK_END) {
                $prefix = $this->_prefix_backend;
            }
        }
        return $prefix;
    }

    function logout($side_end_login = 'FRONT_END') {
        $prefix = $this->get_prefix($side_end_login);
        $this->_logout($prefix);
    }

    protected function get_session($item) {
        return $this->_ci_session->userdata($item);
    }

    function get_current_role($side_end_login = FALSE) {
        return $this->get('roles', $side_end_login);
    }

    function get($item, $side_end_login = FALSE) {
        $prefix = $this->_prefix;
        if ($side_end_login) {
            $prefix = $this->get_prefix($side_end_login);
        }
        return $this->get_session($prefix . $item);
    }

    function get_front_end($item) {
        return $this->get($item, self::FRONT_END);
    }
    
    function get_back_end($item){
        return $this->get($item, self::BACK_END);
    }

    function get_back_end_username() {
        $username = FALSE;
        if ($this->is_back_end_authenticated()) {
            $user_detail = $this->get("user_detail", self::BACK_END);
            if ($user_detail && array_key_exists("username", $user_detail)) {
                $username = $user_detail["username"];
            }
            unset($user_detail);
        }
        return $username;
    }

    protected function set_update_property() {
        $this->modified_date = date('Y-m-d');
        $this->modified_by = "";
    }

    function get_by_prefix($prefix, $item) {
        return $this->get_session($prefix . $item);
    }

    function is_authenticated() {
        return $this->get_session($this->_key);
    }

    function is_front_end_authenticated() {
        return $this->get_session($this->_get_key_front_end());
    }

    function is_back_end_authenticated() {
        return $this->get_session($this->_get_key_back_end());
    }

}

?>