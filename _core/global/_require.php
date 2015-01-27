<?php
  //PROJECT CONFIG
  $project_name = 'pms'; //Change project name here, and in global/config.php

  $path_arr = explode($project_name, __DIR__);
  $project_root = $path_arr[0] . $project_name;

  require_once $project_root . '/_core/global/config.php';

  require_once $project_root . '/_core/util/Crave.php';