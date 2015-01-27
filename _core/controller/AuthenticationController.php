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
      if ($user_credentials[UserAuthTable::online_status] == OFFLINE) {
        $userid = $user_credentials[UserAuthTable::userid];
        $user_model->flagUserOnline($userid);

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
}