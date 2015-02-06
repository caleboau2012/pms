<?php
class AuthenticationController {
    /*public function verify($data){
        $user_model = new UserModel();
        return $user_model->verify($data);
    }*/

    public function verify($data){
        $verification_result = array();

        $user_model = new UserModel();
        $user_details = $user_model->getByCredentials($data);

        if (is_array($user_details)) {
            if ($user_details[UserAuthTable::online_status] == OFFLINE) {
                $userid = $user_details[UserAuthTable::userid];

                //FLAG USER ONLINE
                if ($user_model->flagUserOnline($userid)) {
                    $user_details[UserAuthTable::online_status] = ONLINE;
                };

                //GET USER ROLE
                $user_roles = $user_model->getUserRoles($userid);
                $user_details[PermissionRoleTable::staff_role_id] = $user_roles;

                //CONSTRUCT VERIFICATION RESPONSE
                $verification_result[P_STATUS] = STATUS_OK;
                $verification_result[P_DATA] = $user_details;
                $verification_result[P_MESSAGE] = 'Login successful!';

                return $verification_result;
            } else {
                $verification_result[P_STATUS] = STATUS_ERROR;
                $verification_result[P_DATA] = array();
                $verification_result[P_MESSAGE] = 'Already Logged In On Another System!';
                return $verification_result;
            }
        } else {
            return false;
        }
    }

    public function changePassword($userid, $passcode, $status, $online_status = OFFLINE){
        //INSTANTIATE A MODEL OBJECT
        $user_model = new UserModel();

        //BUILD DATA ARRAY
        $credentials = array();
        $credentials[UserAuthTable::userid] = $userid;
        $credentials[UserAuthTable::passcode] = $passcode;
        $credentials[UserAuthTable::status] = $status;
        $credentials[UserAuthTable::online_status] = $online_status;

//        die(var_dump($credentials));
        //CALL MODEL METHOD FOR UPDATING PASSWORD
        $feedback = $user_model->changePassword($credentials);

        //CHANGE PROGRESS STATUS TO PROCESSING FOR NEWLY CREATED USERS THAT
        //WHOSE PROGRESS STATUS IS SET TO INACTIVE
//        $current_status = $user_model->getStatus($userid);
//        if($current_status == INACTIVE) {
//            $user_model->updateStatus($userid, PROCESSING);
//        }

        return $feedback;
    }

    public function flagUserOffline($userid) {
        $user_model = new UserModel();
        $user_model->flagUserOffline($userid);
    }

    public function progressStatus($userid) {
        $user_model = new UserModel();
        //GET USER PROGRESS STATUS
        $user_progress_status = $user_model->getStatus($userid);
    }

    /*public function userRoles($userid) {
        $user_model = new UserModel();
        $user_roles = $user_model->getUserRoles($userid);
        $user_role_array = array();
        foreach ($user_roles as $role) {
            array_push($user_role_array, $role[PermissionRoleTable::staff_role_id]);
        }
        return $user_role_array;
    }*/
}