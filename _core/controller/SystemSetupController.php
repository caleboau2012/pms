<?php
class SystemSetupController{
    private $systemSetupModel;

    public function __construct($name, $pass){
        $this->systemSetupModel = new SystemSetupModel($name, $pass);
    }

    public function setup($username, $password, $confirmPassword){
        try{
            if(!$this->systemSetupModel->createDB())
                throw new Exception('Could not create DB');
            if(!$this->systemSetupModel->createDBUser())
                throw new Exception('Could not create DB user');
            return true;
            if(!$this->createAdminUser($username, $password, $confirmPassword))
                throw new Exception('Could not create an Admin User');
        } catch (Exception $e){
            return array('result' => false, 'message' => $e->getMessage());
        }

        return array('result' => true, 'message' => 'System setup successful');
    }

    private function createAdminUser($username, $password, $confirmPassword){
        if($password == $confirmPassword)
            return $this->systemSetupModel->createAdminUser($username, $password);
        return false;
    }

}