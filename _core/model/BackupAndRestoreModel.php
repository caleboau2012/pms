<?php

class BackupAndRestoreModel{

    public function backupDB(){
        $path = dirname(__FILE__);
        $host = DB_HOST;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $databasename = DBNAME;

        $now = str_replace(":", "", date("Y-m-d H:i:s"));
        $outputFilename = 'backup' . '-' . $now . '.sql';
        $outputFilename = str_replace(" ", "-", $outputFilename);
        $outputFilename = $path . '/' . $outputFilename;

        //Dump the MySQL database
//        $cmd = 'mysqldump --allow-keywords --opt -u$username' .!empty($password) ? ' -p'.$password : null .' '. $databasename .' > '. $outputFilename;
//        $cmd = 'C:\wamp\bin\mysql\mysql5.6.17\bin\mysqldump.exe --allow-keywords --opt -h '. $host . '-u '. $username .' -p'. $password .' '. $databasename .' > '. $outputFilename;
        $cmd = 'mysqldump -u '. $username .' -p'. $password .' '. $databasename .' > '. $outputFilename;
        $ret = shell_exec($cmd);

        if($ret == 0)
            return $outputFilename;
    }

    public function restoreDB($sqlDumpFile){
        $dumpFile = $this->uploadDumpFile($sqlDumpFile);
        if($dumpFile){
            $username = DB_USERNAME;
            $password = DB_PASSWORD;
            $databasename = DBNAME;

            $cmd = "mysql -u $username -p$password --databases $databasename < $dumpFile";
            $ret = shell_exec($cmd);

            return $ret == 0;
        }

        return false;
    }

    private function uploadDumpFile($sqlDumpFile){
        $target_dir = "../../uploads/";
        $target_file = $target_dir . basename($sqlDumpFile);

        //check file type
        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

        //check if file exists
        if(file_exists($target_file)){
            return $target_file;
        }

        if($file_type == 'sql'){
            if(move_uploaded_file($sqlDumpFile, $target_dir)){
                return $target_file;
            }
        }

        return "";
    }

}