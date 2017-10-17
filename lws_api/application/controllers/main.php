<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Main
 *
 * @author nurfadillah
 */
class Main extends LWS_Controller {

    protected $token = NULL;
    protected $status_code = [
        "200" => [
            "code" => 200,
            "status" => "OK",
            "message" => "Success",
            "response" => "",
        ],
        "400" => [
            "code" => 400,
            "status" => "Bad Request",
            "message" => "Parameters not valid",
            "response" => "",
        ],
    ];
    protected $response = [];

    function can_access() {
        $skip_checking = $this->input->get("skiptoken");
        if ($skip_checking) {
            return TRUE;
        }
        return $this->valid_token();
    }

    public function __construct() {
        parent::__construct();

        $this->response = $this->status_code["400"];
    }

    private function __set_token() {
        $this->token = $this->__configure_token();
    }

    private function __configure_token() {
        return md5(date('d') . md5("api_bkpp") . date("Y"));
    }

    /**
     * 
     * @param string $status_code
     * @return string
     */
    protected function get_token($status_code = FALSE) {
        if (is_null($this->token) || $this->token != $this->__configure_token()) {
            $this->__set_token();
        }

        return $this->token;
    }

    /**
     * Show sample token
     * @return objectJson e.g.: {apitoken: "fasdf43r34vdvasdfasd"}
     */
    public function get_sample_token() {
        $this->response = ["apitoken" => $this->__configure_token()];
    }

    /**
     * Check token is valid
     * @return boolean
     */
    protected function valid_token() {
        $received_token = $this->input->post("apitoken");
        return $received_token === $this->get_token();
    }
    
    public function index(){
        $this->to_json($this->response);
    }
    
    public function _output($output) {
        $output_type = $this->input->post('output');
        if(!$output_type || !in_array($output_type, ["json", "xml"])){
            $output_type = 'json';
        }
        
//        if($output_type == 'xml'){
//            $this->to_xml($this->response);
//        }else{
        $this->to_json($this->response);
        $out = $this->output->get_output();
        header("Content-type:application/json");
        echo $out;
//    }
    }

}
