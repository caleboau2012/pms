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