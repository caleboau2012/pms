<?php
class UserController {
  public function getStaffDetails($userid){
    //call the UserModel
    $user_model = new UserModel();
    $staff_details = $user_model->getUserDetails($userid);

    return $staff_details;
  }
}