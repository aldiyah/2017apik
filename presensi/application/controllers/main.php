<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends LWS_Controller {

    public function __construct() {
        parent::__construct();

        $this->grab_another_session();
    }

    public function index() {
        show_404();
    }

    protected function get_user_detail_from_session() {
        return $this->lmanuser->get("user_detail", $this->my_side);
    }

    /**
     * TEMP TPP
     */
    public function sementara_tpp($id = 9999) {
//        $tpp = array("5"=>"15000000", "4"=>"24000000", "3"=>"40000000",5=>"15000000", 4=>"24000000", 3=>"40000000");
        $tpp = array("3" => "15000000", "2" => "24000000", "1" => "40000000");

        if (array_key_exists($id, $tpp)) {
            return $tpp[$id];
        }

//        if(array_key_exists($id, $tpp_alt)){
//            return $tpp_alt[$id];
//        }
    }

}
