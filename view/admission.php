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
Crave::requireFiles(MODEL, array('BaseModel', 'AdmissionModel', 'RoleModel', 'BedModel', 'WardModel', 'VitalsModel'));
Crave::requireFiles(CONTROLLER, array('AdmissionController', 'RoleController', 'VitalsController'));

$admission = new AdmissionController();

$wards = $admission->loadWards();
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
        <div id="navbar" class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">
                <li class="adm-menu active" id="out-patient" data-view-id="1"><a href="#">Out-Patients</a> </li>
                <li class="adm-menu" id="in-patient" data-view-id="2"><a href="#">In-Patients</a> </li>
                <li class="dropdown navbar-right-text pointer">
                    <span class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                    <img src="../images/profile.png">
                    <span>
                        <?php echo ucwords(CxSessionHandler::getItem(ProfileTable::surname).' '.CxSessionHandler::getItem(ProfileTable::firstname))?>
                        <span class="caret"></span>
                     </span>
                    </span>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a href="dashboard.php">Dashboard</a></li>
                        <li role="presentation"><a href="#" id="sign-out">Sign out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="adm-page-content" id="out-patient-view">
            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Pending Request
                    </div>
                    <div class="panel-body pending-list">
                        <img src="../images/loading.gif">
                    </div>
                </div>
            </div>
            <div class="col-md-9 patient-content">
                <h1 class="text-muted text-center" id="empty_active"><br/><br/>&larr; Select patient </h1>
                <div id="patient-panel" class="panel panel-primary hidden">
                    <div class="panel-heading">
                        <div id="request-heading">

                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-4">
                            <div class="well well-sm">
                                <div class="div-rounded active" id="step-1">1</div>
                                <p class="small text-warning text-center">select ward below</p>
                                <ul class="list-group">
                                    <?php
                                    foreach($wards as $ward){
                                        ?>
                                        <li class="pointer list-group-item ward" data-ward-id = "<?php echo $ward['ward_ref_id'] ?>">
                                            <?php echo $ward['description'] ?>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="well well-sm">
                                <div class="div-rounded" id="step-2">2</div>
                                <!--                                <p class="small text-warning text-center">select bed below</p>-->
                                <div id="bed-list">
                                    <h3 class="text-muted text-center"><br/>&larr;Select ward<br/><br/><br/></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="well well-sm">
                                <div class="div-rounded" id="step-3">3</div>
                                <p class="small text-warning text-center"><br/></p>
                                <h3 class="text-warning text-center text-capitalize hidden" id="ward_chosen"></h3>
                                <h3 class="text-warning text-center text-capitalize hidden" id="bed_chosen"></h3>
                                <button class="btn btn-primary form-control hidden" id="assignPatient">ASSIGN</button>
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="adm-page-content" id="in-patient-view">
        <h2 class="text-muted">IN-PATIENT</h2>


    </div>
</div>
</div>
<script src='../js/bootstrap/jquery.min.js'></script>
<script src='../js/bootstrap/bootstrap.min.js'></script>
<script src="../js/constants.js"></script>
<script src="../js/admission.js"></script>
</body>
</html>
