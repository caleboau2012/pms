<?php

class BackupAndRestoreModel{

    public function backupDB(){
        $path = dirname(__FILE__);
        $hostname = DB_HOST;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $databasename = 'blog';
//        $databasename = DBNAME;

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
    }

    public function restoreDB($sqlDumpFileName, $sqlDumpFileTmpName){
        $dumpFile = $this->uploadDumpFile($sqlDumpFileName, $sqlDumpFileTmpName);

        if($dumpFile){
            $username = DB_USERNAME;
            $password = DB_PASSWORD;
            $databasename = 'blog';

            $cmd = "mysql -u $username -p$password < $dumpFile";
            $ret = shell_exec($cmd);

            return $ret == 0;
        }

        return false;
    }

    private function uploadDumpFile($sqlDumpFileName, $sqlDumpFileTmpName){
//        $target_dir = "/var/www/html/pms/restore/";
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/restore/";
        $target_file = $target_dir . basename($sqlDumpFileName);

        //check file type
        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

        //check if file exists
        if(file_exists($target_file)){
            return $target_file;
        }

        if($file_type == 'sql'){
            if(move_uploaded_file($sqlDumpFileTmpName, $target_file)){
                return $target_file;
            }
        }

        return "";
    }

}