<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends LWS_Model {

    protected $user_detail;
    protected $related_tables = array(
//        "master_aktifitas" => array(
//            "table_name" => "",
//            "table_alias" => "",
//            "reference_to" => "",
//            "fkey" => "aktifitas_id",
//            "columns" => array(
//                "aktifitas_kode",
//                "aktifitas_nama"
//            ),
//            "referenced" => "LEFT",
//            "conditions" => "",
//        )
    );

    function __construct($table_name = '') {
        parent::__construct($table_name);
        $this->__initiate();
    }

    private function __initiate() {
        $this->using_insert_and_update_properties = FALSE;
    }

}
