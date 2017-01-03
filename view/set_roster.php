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
$list_of_staff = $userController->getAllRegisteredUsers();
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
    <div class="col-sm-4">
        <div id='external-events' >
            <div class="roster-list">
                <div class="roster-list_heading">
                    <span>ALL STAFF</span>
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
                            <div data-id="<?php echo $staff['userid'] ?>" class="col-xs-2 staff-duty fc-event m-duty" data-dept_id = "<?php echo $staff['department_id']; ?>" data-name = "<?php   echo $staff['firstname'] . " " .$staff['middlename']. " ".$staff['surname']?>" data-duty=8 data-color="#3A87AD">
                                M
                            </div>
                            <div data-id="<?php echo $staff['userid'] ?>" class="col-xs-2 staff-duty fc-event a-duty" data-dept_id = "<?php echo $staff['department_id']; ?>" data-name = "<?php   echo $staff['firstname'] . " " .$staff['middlename']. " ".$staff['surname']?>" data-duty=9  data-color="#4CA618">
                                A
                            </div>
                            <div data-id="<?php echo $staff['userid'] ?>" class="col-xs-2 staff-duty fc-event n-duty" data-dept_id = "<?php echo $staff['department_id']; ?>" data-name = "<?php   echo $staff['firstname'] . " " .$staff['middlename']. " ".$staff['surname']?>" data-duty=10 data-color="#3F3C3C">
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
        <div class="calendar-wrap">
            <div id='roster_loading'>
               <span class="fa fa-pulse fa-spinner"></span>
            </div>
            <div id='calendar'></div>
        </div>
    </div>
    <div  class="clearfix"></div>
</div>

<script src='../js/bootstrap/jquery.min.js'></script>
<script src='../js/bootstrap/bootstrap.min.js'></script>
<script src='../js/libs/fullcalendar/moment.min.js'></script>
<script src='../js/bootstrap/jquery-ui.custom.min.js'></script>
<script src='../js/libs/fullcalendar/fullcalendar.min.js'></script>
<script src="../js/libs/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="../js/constants.js"></script>
<script src="../js/admin/roster.js"></script>
<?php include('footer.php'); ?>

</body>
</html>
