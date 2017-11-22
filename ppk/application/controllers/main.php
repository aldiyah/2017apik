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

}
