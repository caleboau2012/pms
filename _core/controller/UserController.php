<?php
class UserController {
  public function getStaffDetails($userid){
    //call the UserModel
    $user_model = new UserModel();
    $staff_details = $user_model->getUserDetails($userid);

    //GET USER ROLE
    $user_roles = $user_model->getUserRoles($userid);
    $staff_details[PermissionRoleTable::staff_role_id] = $user_roles;

    return $staff_details;
  }
}