<?php

include_once "LW_Controller.php";

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Lahir Wisada Santoso <lahirwisada@gmail.com>
 * @since Feudal Age
 */
class LWmember_Controller extends LW_Controller {

    /**
     * Menyatakan Aplikasi menggunakan sisi back_end dan front_end
     * @var bool 
     */
    protected $using_backend_front_end = FALSE;

    /**
     * Menyatakan saat ini aplikasi berada di sisi Front end.
     * secara default aplikasi dianggap berada di sisi Front End.
     * @var bool 
     */
    protected $is_front_end = TRUE;
    private $_uri_before_login = '/';
    protected $current_role;
    protected $my_side = FALSE;
    protected $user_detail = FALSE;
    private $user_id_column_name;
    private $profil_id_column_name;
    private $backend_login_uri = FALSE;
    private $front_end_css_files = FALSE;

    public function __construct() {
        parent::__construct();
        $this->initialize();
    }

    private function initialize() {
        $this->using_backend_front_end = $this->config->item("lmanuser.usingbackendfrontend");
        if ($this->using_backend_front_end) {
            $this->backend_login_uri = $this->config->item("backend_login_uri");
        }

        $this->front_end_css_files = $this->config->item('front_end_css_files');

        $this->set_uri_before_login();
        $this->current_role = $this->get_current_role();
        $this->my_side = $this->my_side();
//        var_dump($this->is_front_end, $this->my_side, $this->_name);exit;
        $this->get_user_detail();

        $this->user_id_column_name = $this->config->item("user_id_column_name");
        $this->profil_id_column_name = $this->config->item("profil_id_column_name");
    }

    private function uri_string_not_login() {
        return uri_string() != 'login' && uri_string() != '/' && preg_match('/login|error|assets|refresh_captcha|register|logout/', uri_string()) == 0;
    }

    private function set_uri_before_login() {
        if ($this->uri_string_not_login()) {
            $url_query = '';
            if ($_SERVER['QUERY_STRING']) {
                $url_query = '?' . $_SERVER['QUERY_STRING'];
            }

            $uri_string = uri_string();
            if ($uri_string == "") {
                $uri_string = "/";
            }

            $this->_uri_before_login = $uri_string . $url_query;
            unset($url_query, $uri_string);
        }
        return;
    }

    private function get_current_access_rules() {
        $this->load->model('model_backbone_modul_role');

        /**
         * $_name adalah module name / nama kontroller yang diakses
         * $current_role adalah role pengguna yang saat ini sedang mengakses aplikasi
         */
        return $this->model_backbone_modul_role->get_access_rule($this->_name, $this->current_role, $this->user_detail);
    }

    protected function go_to_session_location() {
        $current_location = $this->session->userdata('current_location');
        if ($current_location) {
            redirect($current_location);
        }
        redirect("/");
    }

    protected function get_session_current_location() {
        $curr_location = $this->session->userdata('current_location');
        return $curr_location;
    }

    protected function set_session_current_location($location = FALSE) {
        if ($location != FALSE && $this->uri_string_not_login()) {
            $this->session->set_userdata(array('current_location' => $location));
        }
        return;
    }

    protected function unset_session_current_location() {
        $this->session->unset_userdata(array('current_location' => ""));
        return;
    }

    /**
     * Listed all rules for this controller
     * 
     * array(
     *  array(
      'allow',  // or 'deny'
      // optional, list of action IDs (case insensitive) that this rule applies to
      // if not specified, rule applies to all actions
      'actions'=>array('edit', 'delete'),
      // Use * to represent all users, ? guest users, and @ authenticated users
      'users'=>array('thomas', 'kevin'),
      // optional, list of roles (case sensitive!) that this rule applies to.
      'roles'=>array('admin', 'editor'),
      // optional, modul : controller name
      'modul' => 'master',
     * 
      //optional, page_side : is back_end or front_end that this rule applies to.
      'page_side' => array('back_end', 'front_end')
      ))
     * @return type 
     */
    public function access_rules($_rules = array()) {
        /**
         * Basic rules
         */
        $rules = array(
            array(
                'allow',
                'users' => array('*'),
                'page_side' => array('FRONT_END')
            ),
            array(
                'allow',
                'actions' => array("login", "logout", "favicon.ico"),
                'users' => array('*')
            ),
            array(
                'allow',
                'actions' => array("login", "logout"),
                'users' => array('*'),
                'page_side' => array('FRONT_END', 'BACK_END')
            )
        );

        /**
         * cek access rule (hak akses) dari database
         */
        $rules_found = $this->get_current_access_rules();

        if ($rules_found) {
            $rules = $rules_found;
        }
        unset($rules_found);

        if ($_rules && !empty($_rules)) {
            $rules = array_merge($rules, $_rules);
        }

//        var_dump($rules);exit;

        return $rules;
    }

    protected function is_back_end_authenticated() {
        return $this->lmanuser->is_back_end_authenticated();
    }

    protected function is_front_end_authenticated() {
        return $this->lmanuser->is_front_end_authenticated();
    }

    protected function get_current_role() {
        return $this->lmanuser->get_current_role($this->my_side());
    }

    protected function is_authenticated() {
        $is_auth = $this->lmanuser->is_authenticated();
        if ($this->using_backend_front_end) {
            $is_auth = $this->is_back_end_authenticated();
            if ($this->is_front_end) {
                $is_auth = $this->is_front_end_authenticated();
            }
        }
        return $is_auth;
    }

    private function get_current_page_site_for_access_rule() {
        if ($this->my_side) {
            return $this->my_side;
        }

        if ($this->is_front_end) {
            return Lmanuser::FRONT_END;
        }
        return Lmanuser::BACK_END;
    }

    protected function can_access() {
        $is_auth = $this->is_authenticated();

        if (!$is_auth) {
            $this->set_session_current_location($this->_uri_before_login, FALSE);
        }

        $user_role = $this->get_current_role();
        $current_page_side = $this->get_current_page_site_for_access_rule();

        foreach ($this->access_rules() as $rule) {

            if (is_array($rule)) {
                if (isset($rule[0]) && isset($rule['users'])) {
                    $is_match_modul = TRUE;
                    if (isset($rule['modul'])) {
                        $is_match_modul = $this->_name == $rule['modul'];
                        if (is_array($rule['modul'])) {
                            $is_match_modul = in_array($this->_name, $rule['modul']);
                        }
                    }
                    $is_match_page_side = TRUE;
                    if (isset($rule['page_side']) && is_array($rule['page_side'])) {
                        $is_match_page_side = in_array($current_page_side, $rule['page_side']);
                    } elseif (isset($rule['page_side']) && !is_array($rule['page_side'])) {
                        $is_match_page_side = $current_page_side == $rule['page_side'];
                    }
                    $is_allow = $rule[0] == 'allow';
                    $is_match_action = TRUE;
                    if (isset($rule['actions']) && is_array($rule['actions'])) {
                        $is_match_action = $is_match_modul && in_array($this->_action, $rule['actions']);
                    }
                    $is_have_roles = isset($rule['roles']) && is_array($rule['roles']);
                    $is_match_user = FALSE;
                    if (is_array($rule['users'])) {
                        if ($is_match_modul && $is_match_page_side && $is_match_action) {
                            if (in_array('@', $rule['users']) && $is_auth) {
                                $is_match_user = TRUE;
                                if ($is_have_roles) {
                                    if (is_array($user_role)) {
                                        $is_match_user = count(array_intersect($user_role, $rule['roles'])) > 0 ? TRUE : FALSE;
                                    } else {
                                        $is_match_user = $is_have_roles && $user_role ? in_array($user_role, $rule['roles']) : TRUE;
                                    }
                                }
                            } else if (in_array('*', $rule['users']) || in_array('?', $rule['users'])) {
                                $is_match_user = TRUE;
                            } else if (isset($this->user_detail['username']) && in_array($this->user_detail['username'], $rule['users'])) {
                                $is_match_user = TRUE;
                            }
                        }
                    }

                    if ($is_match_user) {
                        return $is_allow;
                    }
                }
            }
        }
        return FALSE;
    }

    public function _remap($method, $params = array()) {
        if (method_exists($this, $method)) {
            $this->_action = $method;
            if ($this->can_access()) {
                return call_user_func_array(array($this, $method), $params);
            }

            if ($this->using_backend_front_end && !$this->is_front_end) {
                redirect($this->backend_login_uri);
                return;
            }
            redirect("/");
            //return show_error('The requested URL was Forbidden.', 403, 'Forbidden Access');
        }
        show_404();
    }

    /**
     * @todo Sesuaikan dengan session yang ada di lmanuser
     * @param type $key
     * @return type
     */
    protected function get_session_manajemen($key = FALSE) {
        return $this->session->userdata('manajemen.' . $key);
    }

    protected function get_user_detail($item = FALSE) {
        if ($this->is_authenticated() && !$this->user_detail) {
            $this->user_detail = $this->lmanuser->get("user_detail", $this->my_side);
        }
        $response = $this->user_detail;

        if ($item && array_key_exists($item, $response)) {
            $response = $response[$item];
        } elseif ($item && !array_key_exists($item, $response)) {
            $response = FALSE;
        }

        return $response;
    }

    /**
     * todo: bikin konstanta id_user
     * @return boolean
     */
    protected function my_id() {
        if ($this->is_authenticated()) {
            if ($this->user_detail) {
                return array_key_exists($this->user_id_column_name, $this->user_detail) ? $this->user_detail[$this->user_id_column_name] : FALSE;
            }
        }
        return FALSE;
    }

    protected function my_profil_id() {
        if ($this->is_authenticated()) {
            if ($this->user_detail) {
                return array_key_exists($this->profil_id_column_name, $this->user_detail) ? $this->user_detail[$this->profil_id_column_name] : FALSE;
            }
        }
        return FALSE;
    }

    protected function my_side() {
        if ($this->using_backend_front_end && $this->is_front_end) {
            return Lmanuser::FRONT_END;
        } elseif ($this->using_backend_front_end && !$this->is_front_end) {
            return Lmanuser::BACK_END;
        }
        return FALSE;
    }

    public function reset_password() {

        $user_detail = $this->model_user->get_user_detail_username($this->input->post('uname'), FALSE);
        if ($user_detail) {
//            $this->model_user->set_attribute_from_array("username", $user_detail);
//            $this->model_user->password = '12345';
            $this->load->model('model_ref_user');
//            $this->model_user->apply_password();
            $this->model_ref_user->password = $this->lmanuser->generate_password(is_array($user_detail) ? $user_detail["username"] : $user_detail->username, "12345");
            $this->model_ref_user->save(is_array($user_detail) ? $user_detail["id_user"] : $user_detail->id_user);
        }
        echo '1';
        exit;
    }

    public function profil() {
        $user_detail = $this->get_user_detail_from_session();
        $roles = implode(", ", $user_detail["roles"]);
        $this->model_user->set_attribute_from_array("username", $user_detail);
        $this->model_user->set_profile_rules();

        $this->get_attention_message_from_session();

        if ($this->model_user->get_data_post()) {
            if ($this->model_user->is_valid()) {
                $this->load->model('model_tr_profil');
                $this->model_tr_profil->set_userdata_from_model_user($this->model_user->attributes, $user_detail["id_user"]);
                $this->model_tr_profil->save($user_detail["id_profil"]);

                if ($this->model_user->is_update_password()) {
                    $this->load->model('model_ref_user');
                    $this->model_user->apply_password();
                    $this->model_ref_user->password = $this->model_user->password;
                    $this->model_ref_user->save($user_detail["id_user"]);
                }

                $this->relogin($this->model_user->username);
                $user_detail = $this->lmanuser->get("user_detail", $this->my_side);
                $this->attention_messages = "Perubahan Telah disimpan.";
            } else {
                $this->attention_messages = $this->model_user->errors->get_html_errors("<br />", "line-wrap");
            }
        }

        $this->set("user_detail", $user_detail);
        $this->set("roles", $roles);
        $this->set("error_found", $this->model_user->errors->error_found);
        if ($this->is_front_end && $this->front_end_css_files) {
            $this->add_cssfiles($this->front_end_css_files);
        }
        $this->model_user->reset();
    }

    protected function relogin($username) {
        $user_detail = $this->model_user->get_user_detail_username($username);
        $this->lmanuser->logout($this->my_side);
        $this->lmanuser->login($user_detail, $user_detail->roles, $this->my_side);
        return;
    }

    protected function after_login_success() {
        
    }

    protected function set_login_layout() {
        if (!strpos($this->_layout, '_login')) {
            $this->_layout .= "_login";
        }
    }

    public function login() {
        if ($this->is_authenticated()) {
            $this->go_to_session_location();
        }

        $this->set_login_layout();

        $login_success = FALSE;
        $this->attention_messages = "";
        $this->model_user->set_login_rules();
        if ($this->model_user->get_data_post()) {
            if ($this->model_user->login($this->my_side)) {
                $login_success = TRUE;
            } else {
                $this->attention_messages = $this->model_user->errors->get_html_errors("<br />", "line-wrap");
                if (trim($this->attention_messages) == "<div id=\"model_error\" class=\"line-wrap\"></div>") {
                    $this->attention_messages = "<div id=\"model_error\" class=\"line-wrap\">Username atau password tidak ditemukan.</div>";
                }
            }
        }

        /*
         * akan diexecute ketika 
         */
        if ($login_success) {
            $this->after_login_success();
            $this->go_to_session_location();
        }


        if ($this->is_front_end && $this->front_end_css_files) {
            $this->add_cssfiles($this->front_end_css_files);
        } else {
            if ($login_success) {
                redirect("/");
            }
        }
        $this->set('login_success', $login_success);
        $this->set('model_user_attributes', $this->model_user->get_attributes());
    }
    
    protected function after_grab_another_session($data=FALSE){
        return $data;
    }
    
    protected function grab_another_session(){
        
        if(array_key_exists("auth.logged_on", $_SESSION)){
            $data["auth.logged_on"] = $_SESSION["auth.logged_on"];
            $data["auth.user_detail"] = $_SESSION["auth.user_detail"];
            $data["auth.roles"] = $_SESSION["auth.roles"];
            
            $data["auth.backend.logged_on"] = $_SESSION["auth.logged_on"];
            $data["auth.backend.user_detail"] = $_SESSION["auth.user_detail"];
            $data["auth.backend.roles"] = $_SESSION["auth.roles"];
            
            $response_data = $this->after_grab_another_session($data);
            if(is_array($response_data)){
                $data = array_merge($data, $response_data);
            }
            
            $this->session->set_userdata($data);
            unset($data);
        }
    }

    public function logout() {
        $this->lmanuser->logout($this->my_side);
        redirect("../");
    }

}

?>