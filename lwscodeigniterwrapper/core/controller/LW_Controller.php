<?php

/**
 * @author Lahir Wisada Santoso <lahirwisada@gmail.com>
 * @since Dark Age
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LW_Controller extends CI_Controller {

    static $_mimes = array();
    var $bottom_js_files = array('all_js.js');
    var $css_files = array('all_css.css');
    protected $_layout = 'default';
    protected $_page_title;
    protected $_name;
    protected $_data_view = array();
    protected $_action;
    protected $_user_agent;
    protected $attention_messages = FALSE;

    /**
     * untuk mengidentifikasi bahwa controller yang dipanggil saat ini adalah merupakan controller backbone
     * 
     * hal ini dilakukan karena pada dasarnya back_bone adalah tulang punggung dari Framework Codeigniter Wrapper ini
     * dan sebaiknya tidak diubah2 templatenya sehingga memudahkan dalam penggunaan berikutnya
     * 
     * Template default yang digunakan untuk controller-controller back_bone adalah avant
     * 
     * @var type bool
     */
    protected $is_run_on_back_bone = FALSE;

    public function __construct() {
        parent::__construct();
        $this->initialize();
    }

    private function initialize() {
        if ($this->input->get('profiler') == 1 && ENVIRONMENT === 'development') {
            $this->output->enable_profiler(TRUE);
        }

        $this->load->library(array(
            "carabiner/carabiner"
        ));

        $carabiner_config = array(
            'script_dir' => '_assets/js/',
            'style_dir' => '_assets/css/',
            'cache_dir' => '_assets/cache/',
            'base_uri' => base_url(),
            'combine' => FALSE,
            'dev' => TRUE,
            'minify_js' => FALSE,
            'minify_css' => FALSE,
        );

        //var_dump($carabiner_config); exit;

        $this->carabiner->config($carabiner_config);

        $full_name = get_class($this);
        $this->_name = strtolower($full_name);
        $this->current_user_agent();
        $this->read_attention_message();
    }

    /**
     * 
     * @param string $message
     */
    protected function set_attention_message($message = FALSE) {
        $this->session->set_flashdata("attention_message", $message);
    }

    protected function read_attention_message() {
        $this->attention_message = $this->session->flashdata("attention_message");
    }

    protected function store_attention_message_to_session($message = FALSE) {
        $this->session->set_userdata("attention_messages", $message);
    }

    protected function get_attention_message_from_session() {
        $this->attention_messages = $this->session->userdata("attention_messages");
        $this->session->unset_userdata("attention_messages");
    }

    protected function current_user_agent() {
        $this->load->library('user_agent');
        $this->_user_agent = new stdClass();
        if ($this->agent->is_browser()) {
            $this->_user_agent->agent = $this->agent->browser() . ' ' . $this->agent->version();
            $this->_user_agent->agent_name = $this->agent->browser();
            $this->_user_agent->agent_version = $this->agent->version();
            $this->_user_agent->is_browser = TRUE;
            $this->_user_agent->is_mobile = FALSE;
            $this->_user_agent->is_robot = FALSE;
        } elseif ($this->agent->is_robot()) {
            $this->_user_agent->agent = $this->agent->robot();
            $this->_user_agent->agent_name = $this->agent->robot();
            $this->_user_agent->agent_version = 'Unidentified version';
            $this->_user_agent->is_browser = FALSE;
            $this->_user_agent->is_mobile = FALSE;
            $this->_user_agent->is_robot = TRUE;
        } elseif ($this->agent->is_mobile()) {
            $this->_user_agent->agent = $this->agent->mobile();
            $this->_user_agent->agent_name = $this->agent->mobile();
            $this->_user_agent->agent_version = 'Unidentified version';
            $this->_user_agent->is_browser = FALSE;
            $this->_user_agent->is_mobile = TRUE;
            $this->_user_agent->is_robot = FALSE;
        } else {
            $this->_user_agent->agent = 'Unidentified User Agent';
            $this->_user_agent->agent_name = 'Unidentified User Agent';
            $this->_user_agent->agent_version = 'Unidentified version';
            $this->_user_agent->is_browser = FALSE;
            $this->_user_agent->is_mobile = FALSE;
            $this->_user_agent->is_robot = FALSE;
        }

        $this->_user_agent->platform = $this->agent->platform();
        $this->set('current_user_agent', $this->_user_agent);
        return;
    }

    public function _remap($method, $params = array()) {
        if (method_exists($this, $method)) {
            $this->_action = $method;
            return call_user_func_array(array($this, $method), $params);
        }
        show_404();
    }

    public function _output($output) {
        $out = $output;
//        var_dump($output == NULL);exit;
        if ($output == NULL) {
            $this->configure_view();
            $out = $this->output->get_output();
        }
        $this->output->_write_cache($out);
        echo $out;
    }

    function load_view($file, $data = array(), $return = FALSE) {
        if (!$return)
            $this->load->view($file, $data, $return);

        return $this->load->view($file, $data, TRUE);
    }

    function add_jsfiles($js_array = array(), $is_config = FALSE) {
        if (!$is_config) {
            $this->bottom_js_files = array_merge($this->bottom_js_files, $js_array);
        } else {
            $this->add_jsfiles(array(
                "all.js",
            ));
        }
        return;
    }

    function add_cssfiles($css_array = array(), $is_config = FALSE) {
        if (!$is_config) {
            $this->css_files = array_merge($this->css_files, $css_array);
        } else {
            $this->add_cssfiles(array(
                "all.css",
            ));
        }
        return;
    }

    public function get_abbr_lang() {
        return $this->config->item('language_abbr');
    }

    function generate_carabiner_groups() {
        //var_dump($this->css_files); exit;

        if (isset($_GET['clear']) == 'assets') {
            $this->carabiner->empty_cache();
        }

        // css inititalization for css on top

        $css_carabiner_arr = $this->carab_init($this->css_files);
        $js_carabiner_arr = $this->carab_init($this->bottom_js_files);

        $this->carabiner->group("main_asset", array('css' => $css_carabiner_arr, 'js' => $js_carabiner_arr));
    }

    public function partial($view, $data = array(), $debug = 0) {
        $check_view = $this->_get_view_path($view);
        if (!$check_view) {
            show_error('Unable to find partial view for ' . $view . '<br />Call lahirwisada@gmail.com', 500);
        }
        $real_data = array_merge($this->_data_view, $data);
        return $this->load->view($view, $real_data, TRUE);
    }

    private function carab_init($files) {
        $file_array = array_unique($files);
        $total = count($file_array);
        $carabiner_arr = array();

        if ($total > 0) {
            foreach ($file_array as $file_item) {
                $my_arr = array($file_item, "", TRUE, TRUE, "main_asset");
                $carabiner_arr[] = $my_arr;
            }
        }
        return $carabiner_arr;
    }

    protected function configure_view($js_more = FALSE, $css_more = FALSE, $page_title = FALSE) {

        if ($js_more != FALSE && is_array($js_more) && !empty($js_more))
            $this->add_jsfiles($js_more);

        if ($css_more != FALSE && is_array($css_more) && !empty($css_more))
            $this->add_cssfiles($css_more);

        $app_name = $this->config->item('appname');
        $pt = $page_title ? $page_title : $app_name;


        $metadesc = FALSE;

        $this->set('is_authenticated', $this->is_authenticated());

        $this->set('uri_string', $this->uri->uri_string);

        $this->set('attention_messages', $this->attention_messages);
        $this->set('page_title', $pt);
        $this->set('meta_description', $metadesc);
        $this->set('app_name', $app_name);
        $this->set('active_modul', $this->_name);

        $this->set_default_js_css();

        $this->generate_carabiner_groups();

        $this->set('css', $this->carabiner->display_string("main_asset", "css", FALSE));
        $this->set('js', $this->carabiner->display_string("main_asset", "js", FALSE));

//        var_dump($this->_data_view);exit;
//        $this->template->render();
        $this->render($this->_action);
    }

    protected function render($view, $path = NULL, $layout = NULL, $return = FALSE) {
        if ($path == NULL) {
            $path = $this->_name;
        }

        $dir = $this->router->fetch_directory();

        if ($this->is_run_on_back_bone) {
            $path .= '/' . $this->_layout;
        }


        $act_view = $this->_get_view_path($dir . $path . '/' . $view);

        if (!$act_view) {
            show_error('Unable to find view for ' . $this->_name . '/' . $view, 500);
        }

        $content = $this->load_view($act_view, $this->_data_view, TRUE);
        $this->render_layout($content, $layout);
    }

    /**
     * @author lahirwisada@gmail.com
     * @uses add default js of controller if any 
     */
    private function set_default_js_css() {
        $view = $this->router->fetch_directory() . $this->_name;

        if ($this->is_run_on_back_bone) {
            $view .= '/' . $this->_layout;
        }

        $js_defa_view = $view . '/js/' . $this->_name;
        $css_defa_view = $view . '/css/' . $this->_name;

        $array_view_paths = $this->load->get_view_paths();
        if (is_array($array_view_paths) && !empty($array_view_paths)) {
            foreach ($array_view_paths as $_view_path => $is_true) {

                if (file_exists($_view_path . $js_defa_view . EXT)) {
                    $this->set('js_default', $this->partial($js_defa_view));
                }
                if (file_exists($_view_path . $css_defa_view . EXT)) {
                    $this->set('css_default', $this->partial($css_defa_view));
                }
            }
        } else {
            if (file_exists(APPPATH . 'views/' . $js_defa_view . EXT)) {
                $this->set('js_default', $this->partial($js_defa_view));
            }
            if (file_exists(APPPATH . 'views/' . $css_defa_view . EXT)) {
                $this->set('css_default', $this->partial($css_defa_view));
            }
        }
    }

    protected function render_layout($content, $layout = NULL) {
        $data_for_layout = array_merge($this->_data_view, array(
            'content_for_layout' => $content,
            'title_for_layout' => $this->_page_title
        ));

        if ($layout === NULL) {
            $layout = $this->_layout;
        }
        $layout_view = $this->_get_view_path('template/' . $layout);

        if (!$layout_view) {
            show_error('Unable to find template for ' . $layout, 500);
        }
        $this->load_view($layout_view, $data_for_layout);
    }

    protected function _get_view_path($view) {
        $act_view = $view . EXT;
        $path_view = APPPATH . '/views/' . $act_view;

        if (!file_exists($path_view)) {
            $path_view = LWSPATH . '/views/' . $act_view;
            if (!file_exists($path_view)) {
                return FALSE;
            }
        }
        return $act_view;
    }

    public function set($key, $value) {
        $this->_data_view[$key] = $value;
    }

    public function get_data_view($key = FALSE) {
        if ($key && array_key_exists($key, $this->_data_view)) {
            return $this->_data_view[$key];
        }
        return FALSE;
    }

    protected function set_header($type) {
        $this->output->set_content_type($type);
    }

    protected function to_json($data) {
        $this->set_header('json');
        $this->output->set_output(json_encode($data));
    }

    protected function to_xml($data, $main_tag = "dataset") {
        $this->set_header('xml');
        $this->output->set_header("Cache-Control: no-cache, must-revalidate");
        $this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        $this->load->library('array2xml');
        $xml = $this->array2xml->get($main_tag, $data);
        $this->output->set_output($xml->saveXML());
    }

}

?>