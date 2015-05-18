<?php
class SystemSetupController{
    private $systemSetupModel;

    public function __construct(){
        $this->systemSetupModel = new SystemSetupModel();
    }

    public function createDB($sqlDumpFile){
        return $this->systemSetupModel->createDB($sqlDumpFile);
    }

    public function createDBUser($username, $password){
        return $this->systemSetupModel->createDBUser($username, $password);
    }

    public function createAdminUser($username, $password, $confirmPassword){
        if($password == $confirmPassword)
            return $this->systemSetupModel->createAdminUser($username, $password);
        return false;
    }

}