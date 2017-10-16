<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends LWS_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->_layout = "backend";
    }

    public function access_rules($_rules = array()) {
        /**
         * Basic rules
         * untuk selanjutnya lihat LWmember_Controller.php
         * 
         * akan konek ke basis data, cek : model_ref_modul_role.php->get_access_rule();
         */
        return array(
            array(
                'allow',
                'actions' => array(
                    "index",
                    "terbilang",
                    "captcha",
                    "login",
                    "logout"
                ),
                'users' => array('*')
            ),
            array(
                'allow',
                'users' => array('@')
            )
        );
    }

    public function index() {
    }

}

?>