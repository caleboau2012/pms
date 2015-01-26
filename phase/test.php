<?php
  require_once '../_core/global/config.php';
  require_once '../_core/global/constants.php';
  require_once '../_core/global/SqlStatement.php';

  require_once '../_core/util/Crave.php';

  Crave::requireFiles(UTIL, array('JsonResponse'));
  var_dump(get_included_files());