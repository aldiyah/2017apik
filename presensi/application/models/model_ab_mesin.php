<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * model_ab_mesin.php
 * Nov 12, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_ab_mesin extends Adms_model {

    public function __construct() {
        parent::__construct();
    }

    public function all() {
        $query = $this->dbo->get('iclock');
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }

}
