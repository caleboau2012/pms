<?php
class SystemSetupModel{
    private $pdo;
    private $has_error = false;
    private $path;

    public function __construct($name, $pass){
        $this->path = dirname(__FILE__);
        $pos = strpos($this->path, PROJECT_NAME);
        $this->path = substr($this->path, 0, $pos + strlen(PROJECT_NAME)) . '/_resource/pms.sql';

        try{
            $this->pdo = new PDO('mysql:host=localhost;', $name, $pass);
        } catch(PDOException $e){
            $this->has_error = true;
        }
    }

    public function createDB(){
        $query = file_get_contents($this->path);
        $pds = $this->pdo->prepare($query);
        $check = $pds->execute(array());

        return $check;
    }

    // This method creates a db user using config data
    public function createDBUser(){
        $username = ':username'; $password = ':password';
        $sql = str_replace($username, DB_USERNAME, SystemSetupSqlStatment::CREATE_DB_USER);
        $sql = str_replace($password, DB_PASSWORD, $sql);
        $pds = $this->pdo->prepare($sql);
        $check = $pds->execute(array());
        return $check;
    }

    public function createAdminUser($regNo, $passcode){
        $dbname = DBNAME;
        $host = DB_HOST;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $prepend = "USE $dbname;";
        $params = array(UserAuthTable::regNo => $regNo, UserAuthTable::passcode => $passcode, UserAuthTable::status => 1);
        $sql = UserAuthSqlStatement::ADD;

        try{
            unset($this->pdo);
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->beginTransaction();
            // Add admin user to user_auth table
            $pds = $this->pdo->prepare($sql);
            $pds->execute($params);
            if (!$pds->rowCount()){
                throw new Exception('Could Not Add Admin User');
            }

            // Give admin user admin role
            unset($sql); unset($params);
            $userid = $this->pdo->lastInsertId();
            $sql = PermissionRoleSqlStatement::ADD_STAFF_ROLE;
            $params = array(PermissionRoleTable::userid => $userid,
                            PermissionRoleTable::staff_permission_id => READ_WRITE,
                            PermissionRoleTable::staff_role_id => ADMINISTRATOR);
            $pds = $this->pdo->prepare($sql);
            $check = $pds->execute($params);
            if (!$pds->rowCount()){
                throw new Exception('Could Not Add Admin Role to Admin User');
            }
            $this->pdo->commit();
            return true;
        } catch (PDOException $e){
            $this->pdo->rollBack();
            throw new Exception($e->getMessage());
        }
    }

}