<?php
/**
 * Created by PhpStorm.
 * User: olajuwon
 * Date: 2/16/2015
 * Time: 1:10 PM
 */
require_once '../_core/global/_require.php';
Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'UserModel', 'StaffRosterModel'));
Crave::requireFiles(CONTROLLER, array('UserController', 'StaffRosterController'));

if(!isset($_SESSION[UserAuthTable::userid])){
    header("Location: ../index.php");
}

$userController = new UserController();
$list_of_staff = $userController->getAllUsers();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title>Admin Dashboard</title>
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href='../css/libs/fullCalendar/fullcalendar.css' rel='stylesheet' />
    <link href='../css/libs/fullCalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
    <link href="../css/master.css" rel="stylesheet">
</head>
<body>
<!--page header-->
<?php Crave::requireFiles(HEADERS, array('main')) ?>

<div id='roster-wrap' class="row">
    <div class="col-md-10 col-md-push-1">
        <div id='roster_loading'>
            <span class="fa fa-pulse fa-spinner"></span>
        </div>
        <div id='calendar'></div>
    </div>
    <div  class="clearfix"></div>
</div>

<script src='../js/bootstrap/jquery.min.js'></script>
<script src='../js/bootstrap/bootstrap.min.js'></script>
<script src='../js/libs/fullcalendar/moment.min.js'></script>
<script src='../js/bootstrap/jquery-ui.custom.min.js'></script>
<script src='../js/libs/fullcalendar/fullcalendar.min.js'></script>
<script src="../js/constants.js"></script>
<script src="../js/roster.js"></script>
<?php include('footer.php'); ?>

</body>
</html>
