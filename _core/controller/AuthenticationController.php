<?php
class AuthenticationController {
  public function verify($data){
    $user_model = new UserModel();
    return $user_model->verify($data);
  }
}