<?php


class SqlClient {
    private $username;
    private $password;
    private $host;
    private $dbname;
    private $pdo;
    private $has_error = false;

    public function __construct($host, $dbname, $username, $password){
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;

        //initializing PDO
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        } catch (PDOException $e) {
            $this->has_error = true;
        }
    }

    public function hasError(){
        return $this->has_error;
    }

    /**
     * @return mixed
     */
    public function getDbname()
    {
        return $this->dbname;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    public function execute($sql, $params, $zero_allowed=false){
        //handles INSERT, UPDATE and DELETE
//        var_dump($params);
        $pds = $this->pdo->prepare($sql);
        $check = $pds->execute($params);
        if (!$check){
            return false;
        }

        return ($zero_allowed) ? $pds->rowCount() > 0 : $pds->rowCount() >= 0;
    }

    public function fetch($sql, $params){
        $pds = $this->pdo->prepare($sql);
        $pds->execute($params);
        return $pds->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($sql, $params){
        $pds = $this->pdo->prepare($sql);
        $pds->execute($params);
        return $pds->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLastInsertedId(){
        return $this->pdo->lastInsertId();
    }

    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    public function commit() {
        return $this->pdo->commit();
    }

    public function rollBack() {
        return $this->pdo->rollBack();
    }

    public function checkParams($stmt, $data){
        $pattern = '/:(\w*)/';
        preg_match_all($pattern, $stmt, $matches);
        $vars = array_unique($matches[0]);

        if(sizeof($vars) != sizeof($data))
            return false;

        foreach($vars as $key){
            echo substr($key, 1) . "<br>";
            if(!array_key_exists(substr($key, 1), $data)){
                return false;
            }
        }

        return true;
    }
}