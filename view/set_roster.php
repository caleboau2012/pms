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
        <div class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">
                <li>
                    <a href="mails.php">
                        <span class="fa fa-envelope"></span>
                        <sup class="badge notification message_unread"></sup>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <img src="../images/profile.png">
                        <?php echo ucwords(CxSessionHandler::getItem(ProfileTable::surname).' '.CxSessionHandler::getItem(ProfileTable::firstname))?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a href="dashboard.php">Dashboard</a></li>
                        <li class="divider"></li>
                        <li role="presentation"><a href="view-profile.php">View Profile</a></li>
                        <li role="presentation"><a href="#" id="sign-out">Sign out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id='roster-wrap' class="row">
    <div class="col-sm-4">
        <div id='external-events' >
            <div class="roster-list">
                <div class="roster-list_heading">
                    <span>ALL STAFFS</span>
                    <div class="pull-right pin"></div>
                    <div class="clearfix"></div>
                </div>
                <div id="roster-list_names">
                    <?php
                    foreach($list_of_staff as $staff){
                        ?>
                        <div class='fc-event2 staff' id="<?php echo $staff['userid'] ?>" data-dept_id = "<?php echo $staff['department_id']; ?>" data-name = "<?php   echo $staff['firstname'] . " " .$staff['middlename']. " ".$staff['surname']?>" data-duty = "am">
                            <div class="col-xs-5">
                                <?php echo $staff['firstname'] . " " .$staff['middlename']. " ".$staff['surname'] ?>
                            </div>
                            <div data-id="<?php echo $staff['userid'] ?>" class="col-xs-2 staff-duty fc-event m-duty" data-dept_id = "<?php echo $staff['department_id']; ?>" data-name = "<?php   echo $staff['firstname'] . " " .$staff['middlename']. " ".$staff['surname']?>" data-duty=8 >
                                M
                            </div>
                            <div data-id="<?php echo $staff['userid'] ?>" class="col-xs-2 staff-duty fc-event a-duty" data-dept_id = "<?php echo $staff['department_id']; ?>" data-name = "<?php   echo $staff['firstname'] . " " .$staff['middlename']. " ".$staff['surname']?>" data-duty=9 >
                                A
                            </div>
                            <div data-id="<?php echo $staff['userid'] ?>" class="col-xs-2 staff-duty fc-event n-duty" data-dept_id = "<?php echo $staff['department_id']; ?>" data-name = "<?php   echo $staff['firstname'] . " " .$staff['middlename']. " ".$staff['surname']?>" data-duty=10 >
                                N
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
    <div class="col-sm-8">
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
<script src="../js/admin/roster.js"></script>
<?php include('footer.php'); ?>

</body>
</html>
