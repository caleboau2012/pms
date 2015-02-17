<?php
/**
 * Created by PhpStorm.
 * User: olajuwon
 * Date: 2/16/2015
 * Time: 1:10 PM
 */

require_once '_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse'));
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
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <link href='css/libs/fullCalendar/fullcalendar.css' rel='stylesheet' />
    <link href='css/libs/fullCalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
    <link href="css/master.css" rel="stylesheet">

    <script src='js/bootstrap/jquery.min.js'></script>

    <script src='js/libs/fullCalendar/moment.min.js'></script>

    <script src='js/bootstrap/jquery-ui.custom.min.js'></script>
    <script src='js/libs/fullCalendar/fullcalendar.min.js'></script>
    <script src="js/admin/roster.js"></script>

    <style>

        body {
            margin-top: 40px;
            /*text-align: center;*/
            /*font-size: 14px;*/
            /*font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;*/
        }

        #wrap {
            /*width: 1100px;*/
            /*margin: 0 auto;*/
        }

        #external-events {
            /*float: left;*/
            /*width: 150px;*/
            /*padding: 0 10px;*/
            /*border: 1px solid #ccc;*/
            /*background: #eee;*/
            /*text-align: left;*/
        }

        #external-events h4 {
            /*font-size: 16px;*/
            /*margin-top: 0;*/
            /*padding-top: 1em;*/
        }

        #external-events .fc-event {
            /*margin: 10px 0;*/
            cursor: pointer;
        }

        #external-events p {
            margin: 1.5em 0;
            font-size: 11px;
            color: #666;
        }

        #external-events p input {
            margin: 0;
            vertical-align: middle;
        }

        #calendar {
            /*float: right;*/
            width: 95%;
        }
        .night{
            background: #aaa !important;
            border: none;
        }

        #script-warning {
            display: none;
        }
        #loading {
            display: none;
            position: absolute;
            top: 10px;
            right: 10px;
        }

    </style>
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
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" class="label-default">Roster</a></li>
            </ul>
            <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Search...">
            </form>
        </div>
    </div>
</nav>

<div id='wrap' class="row">
    <div class="col-md-4">
        <div id='loading'>loading...</div>

        <div id='external-events' style="padding: 0 2em">
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
                            <div class="col-md-5">
                                <?php echo $staff['firstname'] . " " .$staff['middlename']. " ".$staff['surname'] ?>
                            </div>
                            <div data-id="<?php echo $staff['userid'] ?>" class="col-md-2 staff-duty fc-event m-duty" data-dept_id = "<?php echo $staff['department_id']; ?>" data-name = "<?php   echo $staff['firstname'] . " " .$staff['middlename']. " ".$staff['surname']?>" data-duty=8 >
                               M
                            </div>
                            <div data-id="<?php echo $staff['userid'] ?>" class="col-md-2 staff-duty fc-event a-duty" data-dept_id = "<?php echo $staff['department_id']; ?>" data-name = "<?php   echo $staff['firstname'] . " " .$staff['middlename']. " ".$staff['surname']?>" data-duty=9 >
                               A
                            </div>
                            <div data-id="<?php echo $staff['userid'] ?>" class="col-md-2 staff-duty fc-event n-duty" data-dept_id = "<?php echo $staff['department_id']; ?>" data-name = "<?php   echo $staff['firstname'] . " " .$staff['middlename']. " ".$staff['surname']?>" data-duty=10 >
                                N
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <!---->
                <!--            <p>-->
                <!--                <input type='checkbox' id='drop-remove' />-->
                <!--                <label for='drop-remove'>remove after drop</label>-->
                <!--            </p>-->
            </div>


        </div>

    </div>
    <div class="col-md-8">
        <div id='script-warning'>
            <code>php/get-events.php</code> must be running.
        </div>
        <div class="text-success text-center hidden" id="rosterResponse"></div>
        <div id='calendar'></div>
    </div>
    <div style='clear:both'></div>

</div>


<!--<script src="../js/admin/roaster.js"></script>-->

<script>

</script>
</body>
</html>
