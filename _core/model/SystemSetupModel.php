<?php
class SystemSetupModel{
    private $sqlClient;

    public function __construct(){
        //$this->sqlClient = new SqlClient();
    }

    public function createDB($username, $password, $sqlDumpFile){
        $cmd = "MYSQL -u $username -p$password < $sqlDumpFile";
        $ret = shell_exec($cmd);
        return $ret == 0;
    }

    public function createDBUser($username, $password){
        $cmd = "MYSQL -u root -padmin -e \"CREATE USER '$username'@'localhost' IDENTIFIED by '$password'; GRANT ALL ON pms.* TO '$username'@'localhost';\";";
        $ret = shell_exec($cmd);
        return $ret == 0;
    }

    public function createAdminUser($regNo, $passcode){
        $data = array(UserAuthTable::regNo => $regNo, UserAuthTable::passcode => $passcode, UserAuthTable::status => 1);

        return true;
    }



}