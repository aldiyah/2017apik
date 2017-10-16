<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends LWS_Model {

    protected $user_detail;

    function __construct($table_name = '') {
        parent::__construct($table_name);
        $this->user_detail = $this->lmanuser->get("user_detail", $this->my_side);
    }

    public function set_user_detail($user_detail) {
        $this->user_detail = $user_detail;
    }

    protected function set_insert_property() {
        parent::set_insert_property();
        $this->{$this->created_by_column_name} = $this->user_detail['username'];
    }

    protected function set_update_property() {
        parent::set_update_property($this->user_detail['username']);
    }

}

class MY_Presensi extends MY_Model {

    protected $user_detail;
    protected $presensi;

    function __construct($table_name = '') {
        parent::__construct($table_name);
        $this->presensi = $this->load->database('presensi', TRUE);
        $this->schema_name = 'sc_presensi';
        $this->table_name = $this->schema_name . '.' . $table_name;
//        $this->load->database('presensi');
    }

}
