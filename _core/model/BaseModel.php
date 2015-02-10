<?php


abstract class  BaseModel {
    /**
     * @var
     */
    protected $conn;

    public function __construct($conn_params=array()){
        $db_host = (isset($conn_params['HOST'])) ? $conn_params['HOST'] : DB_HOST;
        $db_name = (isset($conn_params['DBNAME'])) ? $conn_params['DBNAME'] : DBNAME;
        $db_username = (isset($conn_params['USERNAME'])) ? $conn_params['USERNAME'] : DB_USERNAME;
        $db_password = (isset($conn_params['PWD'])) ? $conn_params['PWD'] : DB_PASSWORD;

        $this->conn = new SqlClient($db_host, $db_name, $db_username, $db_password);

    }
}