<?php
class SystemSetupController{
    private $systemSetupModel;


    public function __construct($name, $pass){
        $this->systemSetupModel = new SystemSetupModel($name, $pass);
    }

    public function setup($regNo, $passcode){
        try{
            if(!$this->systemSetupModel->createDB())
                throw new Exception("Mysql credentials not valid: Couldn't create db");
            if(!$this->systemSetupModel->createDBUser())
                throw new Exception("Mysql credentials not valid: Couldn't create db user");
            $this->systemSetupModel->createAdminUser($regNo, $passcode);
        } catch (Exception $e){
//            var_dump($e->getMessage());
            return array('result' => false, 'message' => $e->getMessage());
        }

        return array('result' => true, 'message' => 'System setup successful');
    }

    public function createAdminUser($username, $password, $confirmPassword){
        if($password == $confirmPassword)
            return $this->systemSetupModel->createAdminUser($username, $password);
        return false;
    }

    public function setupComplete(){
        return $this->systemSetupModel->setupComplete();
    }

}