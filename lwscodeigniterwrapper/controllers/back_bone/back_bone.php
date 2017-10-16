<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Back_bone extends Main {

    protected $backbone_controller_location = "back_bone/";
    protected $is_run_on_back_bone = TRUE;

    public function __construct() {
        $this->is_front_end = FALSE;
        parent::__construct();
        
        $this->_layout = $this->config->item('application_active_layout');
        $this->init_back_bone();
    }
    
//    public function access_rules() {
//        return parent::access_rules(array(
////            array(
////                'allow',
////                'users' => array('*')
////            ),
//            array(
//                'allow',
//                'actions' => array("login", "logout"),
//                'users' => array('*')
//            ),
//            array(
//                'allow',
//                'actions' => array("back_end"),
//                'roles' => array("administrator"),
//                'users' => array('@')
//            )
//        ));
//    }

    public function can_access() {
        return TRUE;
    }

    private function init_back_bone() {
        $this->my_location = "back_bone/";
        $this->init_backend_menu();
        $this->backbone_controller_location = $this->my_location . $this->_name;
        $this->set("controller_location", $this->backbone_controller_location);
    }

}
