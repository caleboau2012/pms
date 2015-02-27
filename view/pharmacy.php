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
                    <span class="caret"></span>
                </span>
             </span>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <li role="presentation"><a href="dashboard.php">Dashboard</a></li>
                    <li role="presentation"><a href="#" id="sign-out">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
           <h1 class="text-muted text-center" id="empty_active"><br/><br/>Select patient &rarr;</h1>
            <div class="col-md-12">
                <div class="active_patient hidden">
                    <div class="active_patient_heading">
                        <h2 id="patient_name">Patient Name</h2>
                        <p class="small text-primary" id="patient_reg">PMS001</p>
                    </div>
                    <div class="col-md-6 patient_prescription">
                        <h4>CLEARED</h4>
                        <ul>
                            <li>Drug name</li>
                            <li>Drug name</li>
                            <li>Drug name</li>
                            <li>Drug name</li>
                            <li>Drug name</li>
                        </ul>
                    </div>
                    <div class="col-md-6 patient_prescription">
                        <h4>UNCLEARED</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="patients-list_heading">
                Requests
            </div>
            <ul class="list-group patients-list_body">
                <li class="list-group-item patients-list_item" data-name="Patient Name 1" data-reg="PMS001">
                    <h4>Patient Name 1</h4>
                    <p class="small">Patient identification</p>
                </li>
                <li class="list-group-item patients-list_item " data-name="Patient Name 2" data-reg="PMS002">
                    <h4>Patient Name 2</h4>
                    <p class="small">Patient identification</p>
                </li>
                <li class="list-group-item patients-list_item" data-name="Patient Name 3" data-reg="PMS003">
                    <h4>Patient Name 3</h4>
                    <p class="small">Patient identification</p>
                </li>
                <li class="list-group-item patients-list_item" data-name="Patient Name 4" data-reg="PMS004">
                    <h4>Patient Name 4</h4>
                    <p class="small">Patient identification</p>
                </li>
            </ul>
        </div>
    </div>
</div>
<script src='../js/bootstrap/jquery.min.js'></script>
<script src='../js/bootstrap/bootstrap.min.js'></script>
<script src="../js/constants.js"></script>
<script src="../js/pharmacy.js"></script>
</body>
</html>
