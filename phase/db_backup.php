<?php

$path = dirname(__FILE__);
$pos = strpos($path, 'pms');
$path = substr($path, 0, $pos+3);
$username = 'root';
$password = 'admin';
$databasename = 'pms';

$now = str_replace(":", "", date("Y-m-d H:i:s"));
$outputFilename = 'backup' . '-' . $now . '.sql';
$outputFilename = str_replace(" ", "-", $outputFilename);
$outputFilename = $path . '/backup/' . $outputFilename;

$cmd = 'mysqldump -u '. $username .' -p'. $password .' --databases '. $databasename .' > '. $outputFilename;
$ret = shell_exec($cmd);

if($ret == 0)
    echo 'successful!';
else
    echo 'unsuccessful!';