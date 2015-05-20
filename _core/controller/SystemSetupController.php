<?php
class SystemSetupController{
    private $systemSetupModel;

    public function __construct($name, $pass){
        $this->systemSetupModel = new SystemSetupModel($name, $pass);
    }

    public function setup($regNo, $passcode){
        try{
            if(!$this->systemSetupModel->createDB())
                throw new Exception('Could not create DB');
            if(!$this->systemSetupModel->createDBUser())
                throw new Exception('Could not create DB user');
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

}