<?php

class BackupAndRestoreModel{
    private $path;

    public function __construct(){
        $this->path = dirname(__FILE__);
        $pos = strpos($this->path, 'pms');
        $this->path = substr($this->path, 0, $pos+3) . '/backup';
    }

    public function backupDB(){
        $path = dirname(__FILE__);
        $hostname = DB_HOST;
//        $username = DB_USERNAME;
        $username = 'root';
//        $password = DB_PASSWORD;
        $password = 'admin';
//        $databasename = DBNAME;
        $databasename = 'pms';

        $now = str_replace(":", "", date("Y-m-d H:i:s"));
        $outputFilename = 'backup' . '-' . $now . '.sql';
        $outputFilename = str_replace(" ", "-", $outputFilename);
        $outputFilename = $path . '/' . $outputFilename;

        //Dump the MySQL database
        //$cmd = 'mysqldump -u '. $username .' -p'. $password .' '. $databasename .' > '. $outputFilename;
        $cmd = 'mysqldump -u '. $username .' -p'. $password .' '. $databasename .' > '. $outputFilename;
        $ret = shell_exec($cmd);

        if($ret == 0)
            return $outputFilename;

        return "";
    }

    public function restoreDB($sqlDumpFile){
        if($sqlDumpFile){
            $username = DB_USERNAME;
            $password = DB_PASSWORD;
            $databasename = DBNAME;
            $dumpFile = $this->path . '/' . $sqlDumpFile;

            $cmd = "mysql -u $username -p$password < $dumpFile";
            $ret = shell_exec($cmd);

            return $ret == 0;
        }

        return false;
    }

    public function uploadDumpFile($sqlDumpFileName, $sqlDumpFileTmpName){
        $target_dir = $this->path . '/';
        $target_file = $target_dir . basename($sqlDumpFileName);

        //check file type
        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

        //check if file exists
        if(file_exists($target_file)){
            return true;
        }

        if($file_type == 'sql'){
            if(move_uploaded_file($sqlDumpFileTmpName, $target_file)){
                return true;
            }
        }

        return false;
    }

    public function getFiles(){
        $files = scandir($this->path, SCANDIR_SORT_DESCENDING);
        $result = array();

        foreach($files as $file){
            if(is_file($this->path.'/'.$file)){
                array_push($result, $file);
            }
        }

        return $result;
    }

}