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
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="dashboard.php">Patient Management System</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <div class="dropdown navbar-right navbar-right-text pointer">
            <span class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                <img src="../images/profile.png">
                <span><?php echo ucwords(CxSessionHandler::getItem(ProfileTable::surname).' '.CxSessionHandler::getItem(ProfileTable::firstname))?>
                </span>
                <span class="caret"></span>
             </span>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <li role="presentation"><a href="dashboard.php">Dashboard</a></li>
                    <li role="presentation"><a href="#" id="sign-out">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div id='roster-wrap' class="row">
    <div class="col-md-10 col-md-push-1">
        <div id='roster_loading'>
            <span class="fa fa-pulse fa-spinner"></span>
        </div>
        <div id='calendar'></div>
    </div>
    <div  class="clearfix"></div>
</div>

<?php include('footer.php'); ?>
<script src='../js/bootstrap/jquery.min.js'></script>
<script src='../js/bootstrap/bootstrap.min.js'></script>
<script src='../js/libs/fullcalendar/moment.min.js'></script>
<script src='../js/bootstrap/jquery-ui.custom.min.js'></script>
<script src='../js/libs/fullcalendar/fullcalendar.min.js'></script>
<script src="../js/constants.js"></script>
<script src="../js/roster.js"></script>
</body>
</html>
