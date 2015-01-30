<?php
Class RoleModel extends BaseModel {
    public function add($data) {
        $stmt = PermissionRoleSqlStatement::ADD_STAFF_ROLE;
        $result = $this->conn->execute($stmt, $data, true);

        return $result;
    }

    public function dismiss($permission_role_id) {
        $stmt = PermissionRoleSqlStatement::DELETE_STAFF_ROLE;
        $data = array();
        $data[PermissionRoleTable::permission_role_id] = $permission_role_id;
        $result = $this->conn->execute($stmt, $data, true);

        return $result;
    }

    public function update($data) {
        $stmt = PermissionRoleSqlStatement::UPDATE_ROLE_PERMISSION;
        $result = $this->conn->execute($stmt, $data, true);

        return $result;
    }

    public function getAllRoles() {
        $stmt = PermissionRoleSqlStatement::GET_ALL_ROLES;
        $data = array();
        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
    }

    public function getAllPermissions() {
        $stmt = PermissionRoleSqlStatement::GET_ALL_PERMISSIONS;
        $data = array();
        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
    }

    public function roleExists($role_id) {
        $stmt = PermissionRoleSqlStatement::CHECK_ROLE;
        $data = array();
        $data[StaffRoleTable::staff_role_id] = $role_id;
        $result = $this->conn->fetch($stmt, $data);

        return $result['count'] == 1 ? true : false;
    }

    public function permissionExists($permission_id) {
        $stmt = PermissionRoleSqlStatement::CHECK_PERMISSION;
        $data = array();
        $data[StaffPermissionTable::staff_permission_id] = $permission_id;
        $result = $this->conn->fetch($stmt, $data);

        return $result['count'] == 1 ? true : false;
    }
}