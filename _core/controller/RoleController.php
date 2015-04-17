<?php
Class RoleController {
    public function addRole($role_array) {
        $role_model = new RoleModel();

        $legit = $this->validateRoleArray($role_array);
        //die(var_dump($legit[P_STATUS] == STATUS_OK));

        if ($legit[P_STATUS] == STATUS_OK) {
            $response = array();

            $feedback = $role_model->add($role_array);
            if ($feedback) {
                $response[P_STATUS] = STATUS_OK;
            } else {
                $response[P_STATUS] = STATUS_ERROR;
                $response[P_MESSAGE] = "Unable to add role!";
            }

            return $response;
        } else {
            return $legit;
        }
    }

    public function dismissRole($permission_role_id) {
        $role_model = new RoleModel();
        $response = array();

        $feedback = $role_model->dismiss($permission_role_id);

        if ($feedback) {
            $response[P_STATUS] = STATUS_OK;
        } else {
            $response[P_STATUS] = STATUS_ERROR;
            $response[P_MESSAGE] = "Unable to remove role assignment!";
        }

        return $response;
    }

    public function updatePermission($permission_role_id, $staff_permission_id) {
        $role_model = new RoleModel();
        $response = array();

        if ($role_model->permissionExists($staff_permission_id)) {
            # code...
            $role_array = array();
            $role_array[PermissionRoleTable::permission_role_id] = $permission_role_id;
            $role_array[PermissionRoleTable::staff_permission_id] = $staff_permission_id;

            $feedback = $role_model->update($role_array);

            if ($feedback) {
                $response[P_STATUS] = STATUS_OK;
            } else {
                $response[P_STATUS] = STATUS_ERROR;
                $response[P_MESSAGE] = "Unable to update staff permission!";
            }
        } else {
            $response[P_STATUS] = STATUS_ERROR;
            $response[P_MESSAGE] = "Invalid permission!";
        }

        return $response;
    }

    private function validateRoleArray($role_array) {
        $role_model = new RoleModel();
        $response = array();

        $role_exists = $role_model->roleExists($role_array[PermissionRoleTable::staff_role_id]);

        if (!$role_exists) {
            # code...
            $response[P_STATUS] = STATUS_ERROR;
            $response[P_MESSAGE] = "Invalid role!";
            return $response;
        }

        $permission_exists = $role_model->permissionExists($role_array[PermissionRoleTable::staff_permission_id]);

        if (!$permission_exists) {
            # code...
            $response[P_STATUS] = STATUS_ERROR;
            $response[P_MESSAGE] = "Invalid permission!";
            return $response;
        }

        $response[P_STATUS] = STATUS_OK;

        return $response;
    }

    public static function hasRole($userid, $role_id) {
        $role_model = new RoleModel();
        
        $data = array();
        $data[PermissionRoleTable::userid] = $userid;
        $data[PermissionRoleTable::staff_role_id] = $role_id;
        
        $feedback = $role_model->hasRole($data);

        return $feedback;
    }

    public static function hasPermission($userid, $role_id, $permission_id){
        $role_model = new RoleModel();
        return $role_model->hasPermission($userid, $role_id, $permission_id);
    }
}