<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/backbone_modul_role.php";

class model_backbone_modul_role extends backbone_modul_role {

    public function __construct() {
        parent::__construct();
    }

    private function collect_access_rule($modul_name = FALSE, $id_user = 'unknown', $current_role = array('unknown')) {
        $access_rules = array();

//        if($modul_name == 'user'){
//            $modul_name = 'member';
//        }

        $parameter_id_user_column_name = "i_" . $this->backbone_user_pk_column;

        $parameters = $this->parse_procedure_parameters(
                array(
                    "i_modul_name" => array("type" => "nvarchar", "value" => $modul_name),
                    $parameter_id_user_column_name => array("type" => "integer", "value" => $id_user),
                )
        );

//        var_dump($parameters);exit;


        $procedure_name = "fnSelectModulAccessRuleByModulNameAndRoleName";
        if ($this->db->dbdriver == "postgre") {
            $procedure_name = $this->get_schema_name("fnSelectModulAccessRuleByModulNameAndRoleName", TRUE);
        }
        $records_set = $this->call_procedure($procedure_name . $parameters . ";");
//        var_dump($this->db->last_query());exit;
//        $records_set = $this->execute_procedure("call fnSelectModulAccessRuleByModulNameAndRoleName('" . $modul_name . "','" . $id_user . "');");
//        var_dump($records_set, $id_user);exit;
        if ($records_set) {
            foreach ($records_set as $record_set) {
                $username_column = $this->backbone_user_username;
                $username = array($record_set->{$username_column});
                $nama_role = array($record_set->nama_role);
                $modul = array($record_set->nama_modul);

                $actions = array();

                /**
                  $actions[] = 'get_combobox_fasilitas_petak_by_id_petak';
                  $actions[] = 'get_json_gambar_petak_by_id';
                  if ($record_set->nama_modul == 'standar_harga_petak') {
                  $actions[] = 'get_standar_harga_petak_by_id';
                  }

                  if ($record_set->is_read == 1) {
                  $actions[] = 'index';
                  if ($record_set->nama_modul == 'rekap_pembayaran') {
                  $actions[] = 'payment_in_arrears';
                  $actions[] = 'print_receipt';
                  } elseif ($record_set->nama_modul == 'kontrak') {
                  $actions[] = 'print_register_paper';
                  $actions[] = 'get_by_keyword';
                  } elseif ($record_set->nama_modul == 'master_petak') {
                  $actions[] = 'daftar_gambar';
                  }
                  $access_rules[] = array(
                  'allow',
                  'users'   => $username,
                  'roles'   => $nama_role,
                  'modul'   => $modul,
                  'actions' => $actions,
                  );
                  }
                 */
                $allow_to = array();
                $allow_to['read'] = $record_set->is_read == 1 ? 'allow' : 'deny';
                $allow_to['insert'] = $record_set->is_write == 1 ? 'allow' : 'deny';
                $allow_to['update'] = $record_set->is_update == 1 ? 'allow' : 'deny';
                $allow_to['delete'] = $record_set->is_delete == 1 ? 'allow' : 'deny';
                $modul_action_configuration = $this->config->item("modul_action_configuration");

                foreach ($allow_to as $action => $permission) {
                    $actions = array($action);

                    if ($modul_action_configuration &&
                            array_key_exists($record_set->nama_modul, $modul_action_configuration) &&
                            array_key_exists($action, $modul_action_configuration[$record_set->nama_modul])) {
                        foreach ($modul_action_configuration[$record_set->nama_modul][$action] as $cfg_action) {
                            $actions[] = $cfg_action;
                        }
                    }

                    if ($action == 'read') {
                        $actions[] = "index";
                        $actions[] = "get_like";
                    }

                    if ($action == 'insert' || $action == 'update') {
                        $actions[] = 'detail';
                        if ($record_set->nama_modul == 'member') {
                            $actions[] = 'reset_password';
                            $actions[] = 'role';
                        }
                    }

                    if ($action == 'delete') {
                        /**
                          if (in_array($record_set->nama_modul, array('penghuni', 'kontrak'))) {
                          $actions[] = 'deletekontrak';
                          } elseif ($record_set->nama_modul == 'master_petak') {
                          $actions[] = 'hapus_gambar';
                          }
                         * 
                         */
                    }

                    if ($record_set->nama_modul == 'member') {
                        $actions[] = 'logout';
                        $actions[] = 'profil';
                    }

                    if ($action == 'delete' && $record_set->nama_modul == 'member' && $record_set->is_delete == 1) {
                        $actions[] = 'update_status_active';
                    }

                    $access_rules[] = array(
                        $permission,
                        'users' => $username,
                        'actions' => $actions,
                        'modul' => $modul,
                        'roles' => $nama_role
                    );
                }
            }
        } else {

            $_access_rules = array(
                "default_all" => array(
                    'allow',
                    'users' => array('@')
                ),
                "default_all_login" => array(
                    'allow',
                    'actions' => array("login", "logout"),
                    'users' => array('*'),
                    'page_side' => array('FRONT_END', 'BACK_END')
                )
            );

            if ($this->using_backend_front_end) {
                $_access_rules["default_front_end"] = array(
                    'allow',
                    'users' => array('*'),
                    'page_side' => array('FRONT_END')
                );
            }

            if ($id_user == 'unknown' || $id_user == '0') {
                $access_rules = $_access_rules;
            }
            $current_role = is_array($current_role) ? $current_role : array('unkown');
            log_message('error', 'Hak Akses modul/kontroller \'' . $modul_name . '\' untuk role \'' . implode(", ", $current_role) . '\' belum di set.');
        }
        $this->db->close();
        return $access_rules;
    }

    public function get_access_rule($modul_name = FALSE, $current_role = FALSE, $user_detail = FALSE) {
        $access_rules = array(
            array(
                'allow',
                'users' => array('@')
            )
        );

//var_dump($user_detail);exit;
        $id_user = $user_detail ? $user_detail["id_user"] : '0';
//        var_dump($user_detail, $current_role);exit;
        if ($modul_name) {


//            if (is_array($current_role) && count($current_role) > 0) {
//                foreach ($current_role as $crole) {
//                    $access_rules = array_merge($this->collect_access_rule($modul_name, $crole));
//                }
//            } else {
            $access_rules = $this->collect_access_rule($modul_name, $id_user, $current_role);
//                $is_free = $this->result_id;
//                    while (!$is_free) {
//                        sleep(10);
//                        $is_free = $this->lws_free_result();
//                    }
//            }
        } else {
            log_message('error', 'Modul/Kontroller ' . $modul_name . ' tidak dikenali, model_ref_modul_role.php -> get_access_rule().');
        }
        return $access_rules;
    }

    public function get_access_by_role($id_role = 1) {
        if (!$id_role) {
            return FALSE;
        }

//        $this->model->load("ref_modul");
        $modules = $this->model_backbone_modul->get_all();
        $this->db->where($this->table_name . ".id_role = '" . $id_role . "'");
        $access_modul_by_role = $this->get_all();

        if ($modules) {
            foreach ($modules as $key => $modul) {
                $modules[$key]->access = (object) array(
                            "is_delete" => 0,
                            "is_read" => 0,
                            "is_update" => 0,
                            "is_write" => 0,
                );
                if ($access_modul_by_role) {
                    foreach ($access_modul_by_role as $object_module_by_role) {
                        if ($object_module_by_role->id_modul == $modul->id_modul) {
                            $modules[$key]->access = (object) array(
                                        "is_delete" => $object_module_by_role->is_delete,
                                        "is_read" => $object_module_by_role->is_read,
                                        "is_update" => $object_module_by_role->is_update,
                                        "is_write" => $object_module_by_role->is_write
                            );
                        }
                    }
                }
            }
        }
        unset($access_modul_by_role);
        return $modules;
    }

    public function get_all() {
        return parent::get_all(array(), FALSE, FALSE, TRUE, 1, TRUE);
    }

    private function collect_permission($id_role) {
        $permission = $this->input->post();
        $id_moduls = $permission && array_key_exists('id_modul', $permission) ? $permission['id_modul'] : FALSE;
        unset($permission['id_modul'], $permission['nama_role']);

        $collected = array();

        $created_date = date('Y-m-d H:i:s');
        $created_by = $this->get_back_end_username();

        if (!empty($permission)) {
            foreach ($permission as $check_name => $permission_value) {
                $arr_name = explode("_", $check_name);
                if (is_array($arr_name) && count($arr_name) > 0) {
                    unset($arr_name[0]);
                }
                $idx_modul_name = implode("_", $arr_name);
                $id_modul = $id_moduls[$idx_modul_name];

                $data = array(
                    'id_role' => $id_role,
                    'id_modul' => $id_modul,
                    $this->created_date_column_name => $created_date,
                    $this->created_by_column_name => $created_by,
                    $this->modified_date_column_name => $created_date,
                    $this->modified_by_column_name => $created_by
                );
                $collected[] = array_merge($data, $permission_value);
            }
        }

        return $collected;
    }

    public function save_permission($id_role = FALSE) {

        if (!$id_role) {
            return FALSE;
        }

        $permission_datas = $this->collect_permission($id_role);
        $this->db->delete($this->table_name, array("id_role" => $id_role));
        foreach ($permission_datas as $permission_data) {
            $this->db->insert($this->table_name, $permission_data);
        }
        return TRUE;
    }

}

?>