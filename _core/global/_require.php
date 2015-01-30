<?php
  //PROJECT CONFIG
  define('PROJECT_NAME', 'pms'); //Change project name here, and in global/config.php

  $path_arr = explode(PROJECT_NAME, __DIR__);

  $project_root = $path_arr[0] . PROJECT_NAME;

  require_once $project_root . '/_core/global/config.php';

  require_once $project_root . '/_core/util/Crave.php';

