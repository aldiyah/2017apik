<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/backbone_modul.php";

class model_backbone_modul extends backbone_modul {

    private $user_detail = FALSE;
    protected $rules = array(
        array("nama_modul", "required|min_length[3]|max_length[300]|alpha_dash"),
        array("deskripsi_modul", "required|min_length[3]|max_length[300]"),
        array("turunan_dari", "max_length[20]|alpha_dash"),
        array("show_on_menu", "numeric")
    );

    public function __construct() {
        parent::__construct();
    }

    protected function after_get_data_post() {

        if (!is_numeric($this->no_urut)) {
            $this->no_urut = '99';
        }
    }

    protected function before__get_where() {
        return TRUE;
    }

    public function set_user_detail($user_detail) {
        $this->user_detail = $user_detail;
    }

    public function get_backend_menu() {

        /**
         * @todo tambahkan kolom untuk membedakan bahwa modul tersebut berada di back_end dan front_end
         * @todo tambahkan pengecekan terhadap hak akses user yang sedang login (yg aktif saat ini)
         */
        if ($this->user_detail) {
            $this->db->join($this->schema_name . ".backbone_modul_role", $this->schema_name . ".backbone_modul_role.id_modul = " . $this->schema_name . ".backbone_modul.id_modul");
            $this->db->join($this->schema_name . ".backbone_role", $this->schema_name . ".backbone_role.id_role = " . $this->schema_name . ".backbone_modul_role.id_role");
            $this->db->join($this->schema_name . ".backbone_user_role", $this->schema_name . ".backbone_user_role.id_role = " . $this->schema_name . ".backbone_role.id_role");
            $this->db->join($this->schema_name . ".backbone_user", $this->schema_name . ".backbone_user.id_user = " . $this->schema_name . ".backbone_user_role.id_user");

            $this->db->where($this->schema_name . ".backbone_user.username = '" . $this->user_detail['username'] . "'");
        }

        $rs_modules = $this->get_all(array(), "show_on_menu = '1'", FALSE, TRUE, 1, TRUE, FALSE, FALSE, 'no_urut');

        $menu_set = array();
        if ($rs_modules) {
            $menu_set = build_tree($rs_modules, NULL, "nama_modul", "turunan_dari");
        }
        unset($modules, $rs_modules);
        return $menu_set;
    }

    public function all($force_limit = FALSE, $force_offset = FALSE) {
        return parent::get_all(array(
                    "nama_modul",
                    "deskripsi_modul",
                        ), FALSE, TRUE, FALSE, 1, TRUE, $force_limit, $force_offset);
    }

//    protected function get_all($keyword = '', $state_active = 1, $limit = FALSE, $offset = FALSE) {
//        return parent::get_all(array('nama_modul', 'deskripsi_modul'), FALSE, FALSE, TRUE, $state_active, TRUE, $limit, $offset);
//    }
}

?>