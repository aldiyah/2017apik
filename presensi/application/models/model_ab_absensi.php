<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * model_ab_absensi.php
 * Nov 12, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_ab_absensi extends Adms_model {

    public function __construct() {
        parent::__construct();
    }

    public function all() {
        $this->dbo->limit(10);
        $query = $this->dbo->get('checkinout');
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }

    public function get_absensi($pegawai_nip, $last_time) {
        $this->dbo->select("date(c.checktime) as ctime");
        $this->dbo->select_min("c.checktime", "mintime");
        $this->dbo->select_max("c.checktime", "maxtime");
        if ($last_time) {
            $this->dbo->where("c.checktime >", $last_time);
        }
//        $this->dbo->where("u.badgenumber", $pegawai_nip);
        $this->dbo->where("p.usernip", $pegawai_nip);
        $this->dbo->from("checkinout c");
//        $this->dbo->join("userinfo u", "u.userid = c.userid", "left");
        $this->dbo->join("pegawai_info p", "p.userid = c.userid", "left");
        $this->dbo->group_by("date(c.checktime)");
        $this->dbo->group_by("c.userid");
        $this->dbo->order_by("ctime");
        $query = $this->dbo->get();
//        print_r($this->dbo->last_query());
//        var_dump($query->result());
//        exit();
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }

}
