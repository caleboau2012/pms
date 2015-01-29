<?php
class UserController {
    private $staff;

    public function __construct() {
        $this->staff = new UserModel();
    }

    public function getStaffDetails($userid){
        $user_model = new UserModel();

        //GET NECESSARY USER DETAILS FROM MODEL
        $staff_details = $user_model->getUserDetails($userid);

        //GET USER EXISTING ROLE(S)
        $user_roles = $user_model->getUserRoles($userid);

        //EXTRACT ROLE ID(S)
        $user_role_ids = array();
        foreach ($user_roles as $role) {
            array_push($user_role_ids, $role[PermissionRoleTable::staff_role_id]);
        }

        //GET ALL STAFF ROLES
        $all_roles = $user_model->getAllRoles();

        //COMPARE USER EXISTING ROLE(S) WITH ALL STAFF ROLES TO EXTRACT
        //UNASSIGNED ROLES
        $available_roles = array();
        foreach ($all_roles as $role) {
            if (!in_array($role[StaffRoleTable::staff_role_id], $user_role_ids)) {
                array_push($available_roles, $role);
            }
        }

        //POPULATE ROLES IN RESPONSE ACCORDING TO AVAILABILITY
        $staff_details[ROLES][EXISTING] = $user_roles;
        $staff_details[ROLES][AVAILABLE] = $available_roles;

        return $staff_details;
    }

    public function addStaff($regNo, $passcode, $status = INACTIVE){
        if (!($regNo && $passcode)){
            return false;
        }

        if ($this->staff->staffExists($regNo)){
            return false;
        }

        $authData = array(UserAuthTable::regNo => $regNo, UserAuthTable::passcode => $passcode, UserAuthTable::status => $status);
        return $this->staff->addAuthInfo($authData);
    }

    public function updateStaff($profileInfo){
        $profile = $profileInfo;
        $profile[UserAuthTable::userid] = $this->getUserId($profileInfo[UserAuthTable::regNo]);
        return $this->staff->addProfile($profile);
    }

    public function getStaff($regNo){
        $this->staff->getStaff($regNo);
    }

    public function getAllStaff(){
        return $this->staff->getAllStaff();
    }

}