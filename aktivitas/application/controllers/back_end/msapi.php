<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of msapi
 *
 * @author Rinaldi
 */
class Msapi extends Back_end {

    protected $auto_load_model = FALSE;

    public function __construct() {
        parent::__construct();
    }

    public function like_nip() {
        $keyword = $this->input->post("keyword");
        $data = $this->_call_api('pegawai/nip_auto_complete', array('nip' => $keyword));
        $pegawai = isset($data['response']) ? $data['response'] : FALSE;
        $this->to_json($pegawai);
    }

}
