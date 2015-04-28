<?php

class BackupAndRestoreModel{

    public function backupDB(){
        $path = dirname(__FILE__);
        $username = 'root';
        $password = 'admin';
        $databasename = 'pms';

        $now = str_replace(":", "", date("Y-m-d H:i:s"));
        $outputFilename = 'backup' . '-' . $now . '.sql';
        $outputFilename = str_replace(" ", "-", $outputFilename);
        $outputFilename = $path . '/' . $outputFilename;

        //Dump the MySQL database
        $cmd = 'mysqldump -u '. $username .' -p'. $password .' '. $databasename .' > '. $outputFilename;
        $ret = shell_exec($cmd);

        if($ret == 0)
            return $outputFilename;
    }

    public function restoreDB($sqlDumpFile){
        $dumpFile = $this->uploadDumpFile($sqlDumpFile);
        if($dumpFile){
            $username = 'root';
            $password = 'admin';
            $databasename = 'pms';

            $cmd = "mysql -u $username -p$password $databasename < $dumpFile";
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