<?php

if (!defined('LWSPATH'))
    exit('No direct script access allowed');

include_once "controller/LWmember_Controller.php";

class LWS_Controller extends LWmember_Controller {

    protected $arr_query_url;
    protected $my_location;
    protected $default_limit_paging;

    public function __construct() {
        parent::__construct();
        $this->init_lws_controller();
    }

    private function init_lws_controller() {
        $this->arr_query_url = $this->get_arr_query_url();
        $this->default_limit_paging = $this->config->item('default_limit_row');
        $this->get_user_info();
        $this->load->model("model_user");
    }

    private function get_user_info() {
        $is_authenticated = $this->is_authenticated();
        $this->set('is_authenticated', $is_authenticated);
        $detail_user = FALSE;
        if ($is_authenticated) {
            $user_detail = $this->lmanuser->get("user_detail", $this->my_side);
            if ($user_detail) {
                $_cfg_username = $this->config->item('backbone_user.username');
                $uname = $_cfg_username ? $_cfg_username : 'username';
                unset($_cfg_username);
                $this->set('currentusername', $user_detail[$uname]);
                $this->set('current_user_profil_name', $user_detail['nama_profil']);
                $this->set('current_user_roles', implode(", ", $user_detail['roles']));
            }
            $detail_user = $user_detail;
            unset($user_detail);
        }
        return $detail_user;
    }

    protected function get_current_location() {
        return $this->my_location . $this->_name . "/" . $this->_action;
    }

    protected function get_current_uri_with_url_query() {
        $current_location = $this->get_current_location();
        $slash = '/';
        if (substr($current_location, -1) == '/') {
            $slash = '';
        }

        if (!$this->arr_query_url) {
            return $current_location;
        }
        return $current_location . $slash ."?". http_build_query($this->arr_query_url);
    }

    protected function get_paging($paging_url, $total_data, $limit = FALSE, $area_name = FALSE) {
        $lang = $this->get_abbr_lang();
        $this->config->load("paging");

        if (!$limit) {
            $limit = $this->default_limit_paging;
        }

        $paging_cfg = $this->config->item("backend_paging");
        if ($this->is_front_end) {
            $paging_cfg = $this->config->item("frontend_paging");
        }
        
        if($this->config->item('paging_using_template_name')){
            $name = $this->_layout."_paging";
            $paging_cfg = $this->config->item($name);
            unset($name);
        }

        $arr_query_url = $this->arr_query_url;

        if ($area_name != FALSE) {
            $key_name = 'currpage_' . $area_name;
            if ($arr_query_url !== FALSE && array_key_exists($key_name, $arr_query_url)) {
                unset($arr_query_url[$key_name]);
                if (count($arr_query_url) == 0) {
                    $arr_query_url = FALSE;
                }
            }
            $paging_cfg['query_string_segment'] = 'currpage_' . $area_name;
        }

        $slash = '/';
        if (substr($paging_url, -1) == '/') {
            $slash = '';
        }

        $pre_url_query = $slash . '?p';
        if ($arr_query_url !== FALSE) {
            $pre_url_query = $slash . '?' . http_build_query($arr_query_url);
        }

        $paging_cfg["base_url"] = base_url() . $paging_url . $pre_url_query;
        unset($arr_query_url, $slash, $pre_url_query, $paging_url);

        $paging_cfg["total_rows"] = $total_data; //$contents["total_found"];
        $paging_cfg["per_page"] = $limit;

        $this->load->library('pagination');
        $this->pagination->initialize($paging_cfg);
        
        return $this->pagination->create_links();
    }

    protected function get_arr_query_url() {
        $url_associative = url_query_string_assoc();
        if ($url_associative !== FALSE && is_array($url_associative)) {
            if (array_key_exists('p', $url_associative))
                unset($url_associative['p']);
            if (array_key_exists('page', $url_associative))
                unset($url_associative['page']);
            if (array_key_exists('page', $url_associative))
                unset($url_associative['page']);
            if (array_key_exists('currpage', $url_associative))
                unset($url_associative['currpage']);
        }
        return $url_associative;
    }
    
    protected function init_backend_menu(){
        $this->load->model('model_backbone_modul');
        $this->model_backbone_modul->set_user_detail($this->get_user_info());
        $menu_item = $this->model_backbone_modul->get_backend_menu();
        $this->set("menu_item", $menu_item);
    }

}
?>