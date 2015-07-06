<?php
class UserController {
    private $user;

    public function __construct() {
        $this->user = new UserModel();
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

    public function addUser($regNo, $passcode, $status = INACTIVE){
        if (!Licence::withinUserLimit()) {
            $response_array = array(
                JsonResponse::P_STATUS  =>  JsonResponse::STATUS_ERROR,
                JsonResponse::P_MESSAGE =>  'You have exceeded maximum number of users within your licence'
            );
            return $response_array;
        }

        if (!($regNo && $passcode)){
            return false;
        }

        if ($this->user->userExists($regNo)){
            return false;
        }

        $authData = array(UserAuthTable::regNo => $regNo, UserAuthTable::passcode => $passcode, UserAuthTable::status => $status);
        return $this->user->addAuthInfo($authData);
    }

    public function addProfile($profileInfo){
//        /*$profile = $profileInfo;
//        $profile[UserAuthTable::userid] = $this->getUserId($profileInfo[UserAuthTable::regNo]);
        return $this->user->addProfile($profileInfo);
    }

    public function getUsers($regNo){
        $this->user->getUser($regNo);

    }

    public function getAllUsers(){
        return $this->user->getAllUsers();
    }

    public function updateStatus($userid, $status){
        return $this->user->updateStatus($userid, $status);
    }

    public function searchByName($userid, $name) {
        $name_array = explode(" ", $name);
        $feedback = $this->user->searchByName($userid, $name_array[0]);

        return $feedback;
    }

    public function getDoctorNameById($doctorId){
        return $this->user->getDoctorNameById($doctorId);
    }

}