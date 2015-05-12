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
        <div class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">
                <li class="adm-menu active" id="out-patient" data-view-id="1"><a href="#">Out-Patients</a> </li>
                <li class="adm-menu" id="in-patient" data-view-id="2"><a href="#">In-Patients</a> </li>
                <li>
                    <a href="mails.php">
                        <span class="fa fa-envelope"></span>
                        <sup class="badge notification message_unread"></sup>
                    </a>
                </li>
                <li><a href="room-management.php"><span class="fa fa-cog">&nbsp;</span>Manage</a> </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <img src="../images/profile.png">
                        <?php echo ucwords(CxSessionHandler::getItem(ProfileTable::surname).' '.CxSessionHandler::getItem(ProfileTable::firstname))?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a href="dashboard.php">Dashboard</a></li>
                        <li role="presentation"><a href="#" id="sign-out">Sign out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="navbar-offset"></div>

<div class="container-fluid">
    <div class="row">
        <div class="adm-page-content" id="out-patient-view">
            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Pending Request
                    </div>
                    <div class="panel-body pending-list">
                        <img src="../images/loading.gif">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 patient-content">
                <h1 class="text-muted text-center" id="empty_active"><br/><br/>&larr; Select patient </h1>
                <div id="patient-panel" class="panel panel-primary hidden">
                    <div class="panel-heading">
                        <div id="request-heading">

                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-4">
                            <div class="well well-sm">
                                <div class="div-rounded step-1"><span class="fa fa-road"></span> </div>
                                <!--                                <p class="small text-muted text-center">Select ward below</p>-->
                                <ul class="list-group admitted-out-patients_ward">
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
                        <div class="col-sm-4">
                            <div class="well well-sm">
                                <div class="div-rounded step-2"><span class="fa fa-bed"></span></div>
                                <!--  <p class="small text-warning text-center">select bed below</p>-->
                                <div id="bed-list">
                                    <h3 class="text-muted text-center"><br/>&larr;Select ward<br/><br/><br/></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="well well-sm">
                                <div class="div-rounded step-3"><span class="fa fa-check"></span> </div>
                                <p class="small text-warning text-center"><br/></p>
                                <h3 class="text-warning text-center text-capitalize hidden" id="ward_chosen"></h3>
                                <div class="thin-separator hidden"></div>
                                <h3 class="text-warning text-center text-capitalize hidden" id="bed_chosen"></h3>
                                <div id="response" class="text-center center-block">
                                    <span id="loader" class="fa fa-spinner fa-spin hidden"></span>
                                    <div id="response_msg"></div>
                                </div>
                                <button class="btn btn-primary form-control hidden" id="assignPatient">ASSIGN</button>
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="room-overview">
                    <div class="room-overview__heading">
                        <h2 class="text-center"><span class="fa fa-history"></span></h2>
                        <h3 class="text-center">Overview</h3>
                    </div>
                    <p>
                        <span class="fa fa-university text-danger">&nbsp;</span>
                        20 Wards
                    </p>
                    <p>
                        <span class="fa fa-bed text-danger">&nbsp;</span>
                        200 Beds
                    </p>
                    <p>
                        <span class="fa fa-bed text-success">&nbsp;</span>
                        30 Available Beds
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!---
        ----IN-PATIENT
            ----------    View
    -->
    <div class="adm-page-content" id="in-patient-view">
        <div class="row">
            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <form id="in-patient-form">
                            <input id = "patient_query" class="form-control" placeholder="Search for in-patients">
                        </form>
                    </div>
                    <div class="panel-body in-patient-list">
                        <div id="in-patient-result">
                            <h2 class="text-muted text-center">Hit enter to get patient</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <h1 class="text-muted text-center" id="empty_active_in_patient"><br/><br/>&larr; Select patient </h1>
                <div id="active_in_patient" class="in-patient-content hidden">
                    <div id="in-patient-identity">
                        <span class="fa fa-pulse fa-spin"></span>
                    </div>

                    <ul class="nav nav-tabs">
                        <li><a href="#home-tab" data-toggle="tab">Details</a></li>
                        <li class="active"><a href="#switch-tab" data-toggle="tab">Switch Bed</a></li>
                        <li><a href="#vitals-tab" data-toggle="tab"> <span class="fa fa-stethoscope">&nbsp;</span>Add Vitals</a></li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade adm-tab-pane" id="home-tab">
                            <br/>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis dolore enim est eum quae quo.
                        </div>
                        <div class="tab-pane fade adm-tab-pane active in" id="switch-tab">
                            <br/>
                            <div class="panel-body">
                                <div class="col-sm-4">
                                    <div class="well well-sm">
                                        <div class="div-rounded step-1 active"><span class="fa fa-road"></span> </div>
                                        <!--                                <p class="small text-muted text-center">Select ward below</p>-->
                                        <ul class="list-group admitted-patients-in-ward">
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
                                <div class="col-sm-4">
                                    <div class="well well-sm">
                                        <div class="div-rounded step-2"><span class="fa fa-bed"></span></div>
                                        <!--  <p class="small text-warning text-center">select bed below</p>-->
                                        <div id="in-patient-bed-list">
                                            <h3 class="text-muted text-center"><br>←Select ward<br><br><br></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="well well-sm assign-patient-column">
                                        <div class="div-rounded step-3"><span class="fa fa-check"></span> </div>
                                        <p class="small text-warning text-center"><br></p>
                                        <h3 class="text-warning text-center text-capitalize hidden" id="ward_chosen"></h3>
                                        <div class="thin-separator hidden"></div>
                                        <h3 class="text-warning text-center text-capitalize hidden" id="bed_chosen"></h3>
                                        <div id="response" class="text-center center-block">
                                            <span id="switch-loader" class="fa fa-spinner fa-spin hidden fa-2x"></span>
                                            <div id="switch-response_msg"></div>
                                        </div>
                                        <button class="btn btn-primary form-control hidden" id="switchPatient"><span class="fa fa-refresh">&nbsp;</span>Switch</button>
                                        <div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade adm-tab-pane" id="vitals-tab">
                            <!--                                <div class="div-rounded encounter-icon">-->
                            <!--                                    <span class="fa fa-stethoscope"></span>-->
                            <!--                                </div>-->
                            <!-- <h2 class="text-warning text-center">Log Encounter...</h2>-->
                            <form id="log_encounter">
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="temp">Tempertaure</label>
                                        <input type="text" class="form-control" id="temp" name="temp">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="pulse">Pulse</label>
                                        <input type="text" id="pulse" class="form-control" name="pulse">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="respiratory_rate">Respiratoty Rate</label>
                                        <input type="text" class="form-control" id="respiratory_rate" name="respiratory_rate">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="blood_pressure">Blood Pressure</label>
                                        <input type="text" class="form-control" id = "blood_pressure" name="blood_pressure">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="height">Height</label>
                                        <input type="text" class="form-control" id="height" name="height">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="weight">Weight</label>
                                        <input type="text" class="form-control" id="weight" name="weight">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="comment">Comment</label>
                                        <textarea class="form-control" id="comment" name="comment"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="bmi">BMI</label>
                                        <input type="text" class="form-control" id="bmi" name="bmi">
                                    </div>
                                    <div class="col-sm-6">
                                        <br/>
                                        <input type="submit" class="btn btn-primary">
                                    </div>
                                </div>

                            </form>
                            <div class="clearfix"></div>
                            <div id="log_encounter_loading" class="text-center hidden"><span class="fa fa-spinner fa-spin"></span> </div>
                            <div class="text-center" id="log_encounter_response"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="room-overview">
                    <div class="room-overview__heading">
                        <h2 class="text-center"><span class="fa fa-history"></span></h2>
                        <h3 class="text-center">Overview</h3>
                    </div>
                    <p>
                        <span class="fa fa-university text-danger">&nbsp;</span>
                        20 Wards
                    </p>
                    <p>
                        <span class="fa fa-bed text-danger">&nbsp;</span>
                        200 Beds
                    </p>
                    <p>
                        <span class="fa fa-bed text-success">&nbsp;</span>
                        30 Available Beds
                    </p>
                </div>
                <div class="hidden">
                    <br/>
                    <!--Shown when a ptient is selected-->
                    <div class="div-rounded encounter-icon">
                        <span class="fa fa-user-plus"></span>
                    </div>
                    <div class="text-center" id="discharge_patient_content">
                        <button class="btn btn-warning" id="discharge_patient">Discharge</button>
                        <div id="discharge_patient_error" class="text-danger"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!--  -->
<script src='../js/bootstrap/jquery.min.js'></script>
<script src='../js/bootstrap/bootstrap.min.js'></script>
<script src="../js/constants.js"></script>
<script src="../js/admission.js"></script>
<?php include('footer.php'); ?>

</body>
</html>
