<?php if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
} include_once "entity/backbone_user_role.php";

class model_backbone_user_role extends backbone_user_role {
    
    public $backbone_user_role_tablename = "backbone_user_role";

    public function __construct() {
        parent::__construct();
        
        $this->backbone_user_role_tablename = $this->get_backbone_table_name("backbone_user_role");
    }

    public function save($id_user = FALSE, $id_role = FALSE) {
        if ($id_user && $id_role) {
            $this->id_user = $id_user;
            $this->id_role = $id_role;
        }
        if (!$this->is_record_exists()) {
            return parent::save();
        }
        return FALSE;
    }
    
    protected function is_record_exists() {
        $record_found = $this->get_detail($this->table_name . ".id_user = '" . $this->id_user . "' and " . $this->table_name . ".id_role = '" . $this->id_role . "'");
        $exists = FALSE;
        if ($record_found) {
            $exists = TRUE;
        }
        unset($record_found);
        return $exists;
    }
    
    /**
     * 
     * @param type $id_user
     * @param type $data_post post by ck_role
     * @return boolean
     */
    public function save_roles($id_user=FALSE, $data_post = FALSE){
        if(!$id_user){
            return FALSE;
        }
        
        $created_date = date('Y-m-d H:i:s');
        $created_by = $this->get_back_end_username();
        
        
        
        $this->db->delete($this->get_schema_name($this->backbone_user_role_tablename, TRUE), array("id_user" => $id_user));
        foreach($data_post as $id_role){
            $this->db->insert($this->get_schema_name($this->backbone_user_role_tablename, TRUE), array(
                "id_user"=>$id_user,
                "id_role"=>$id_role,
                "created_date"=>$created_date,
                "created_by"=>$created_by
            ));
        }
        return TRUE;
    }
    
    public function get_roles_by_user($id_user = 1) {
        if (!$id_user) {
            return FALSE;
        }

//        $this->model->load("ref_modul");
        $rs_roles = $this->model_backbone_role->get_all();
        $roles = FALSE;
        if($rs_roles){
            $roles = $rs_roles->record_set;
        }
        unset($rs_roles);
        $this->db->where($this->backbone_user_role_tablename.".id_user = '" . $id_user . "'");
        $roles_by_user = $this->get_all();
        if ($roles) {
            foreach ($roles as $key => $role) {
                $roles[$key]->selected = 0;
                if ($roles_by_user) {
                    foreach ($roles_by_user as $object_role_by_user) {
                        if ($object_role_by_user->id_role == $role->id_role) {
                            $roles[$key]->selected = 1;
                        }
                    }
                }
            }
        }
        unset($roles_by_user);
        
        
        return $roles;
    }
}
?>