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
Crave::requireFiles(MODEL, array('BaseModel', 'UserModel', 'PharmacistModel'));
Crave::requireFiles(CONTROLLER, array('UserController', 'PharmacistController'));

$pharmacist = new PharmacistController();
$pharmacist_queue = $pharmacist->getPatientQueue();
$drugs = $pharmacist->getDrugs();
$units = $pharmacist->getUnits();
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
                        <h4>UNCLEARED</h4>
                        <ol class="patientPrescriptions">
                            <!--                            <li class="prescription-item">Prescription name 1</li>-->
                            <!--                            <li class="prescription-item">Prescription name 2</li>-->
                            <!--                            <li class="prescription-item">Prescription name 3</li>-->
                            <!--                            <li class="prescription-item">Prescription name 6</li>-->
                            <!--                            <li class="prescription-item">Prescription name 7</li>-->
                        </ol>
                    </div>
                    <div class="col-md-6 patient_prescription">
                        <h4>CLEARING PANEL</h4>
                        <form id="addToClear">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input list="drugNames" type="text" class="form-control" id="drugName" placeholder="Drug name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="drugQuantity" placeholder="Drug quantity" required>
                                </div>
                                <div class="col-md-6">
                                    <select id="drugUnit" class="form-control">
                                        <option>Ml</option>
                                        <option>Lit.</option>
                                    </select>
                                </div>
                                <datalist id="drugNames">
                                    <?php
                                    foreach($drugs as $drug){
                                        ?>
                                        <option value="<?php echo$drug['drug']; ?>" data-drug-id="<?php echo $drug['drug_ref_id'] ?>"></option>
                                    <?php
                                    }
                                    ?>
                                </datalist>
                            </div>
                            <div class="clearfix"></div>
                            <ol class="selected_prescription">

                            </ol>

                            <div class="col-md-12">
                                <button class="btn btn-sm btn-warning">ADD TO CLEAR</button>
                            </div>
                            <div class="clearfix"></div>
                            <div id="clearPrescriptions">

                            </div>
                        </form>
                        <button class="btn btn-sm btn-primary hidden" id="clrPrescription">CLEAR PRESCRIPTIONS</button>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="patients-list_heading">
                REQUESTS
            </div>
            <?php
            if(sizeof($pharmacist_queue) !== 0){
                ?>
                <ul class="list-unstyled patients-list_body">
                    <?php
                    foreach($pharmacist_queue as $patient){
                        ?>
                        <li class="patients-list_item" data-patient-id="<?php echo $patient['patient_id'] ?>" data-treatment-id="<?php echo $patient['treatment_id'] ?>">
                            <h4><?php echo ucwords($patient['surname'].' '.$patient['middlename'].' '. $patient['firstname']); ?></h4>
                            <p class="small"><?php echo $patient['regNo'] ?></p>
                        </li>
                    <?php
                    }
                    ?>
                    <!--                    <li class="patients-list_item" data-name="Patient Name 1" data-reg="PMS001">-->
                    <!--                        <h4>Patient Name 1</h4>-->
                    <!--                        <p class="small">Patient identification</p>-->
                    <!--                    </li>-->
                    <!--                    <li class="patients-list_item " data-name="Patient Name 2" data-reg="PMS002">-->
                    <!--                        <h4>Patient Name 2</h4>-->
                    <!--                        <p class="small">Patient identification</p>-->
                    <!--                    </li>-->
                    <!--                    <li class="patients-list_item" data-name="Patient Name 3" data-reg="PMS003">-->
                    <!--                        <h4>Patient Name 3</h4>-->
                    <!--                        <p class="small">Patient identification</p>-->
                    <!--                    </li>-->
                    <!--                    <li class="patients-list_item" data-name="Patient Name 4" data-reg="PMS004">-->
                    <!--                        <h4>Patient Name 4</h4>-->
                    <!--                        <p class="small">Patient identification</p>-->
                    <!--                    </li>-->
                </ul>

            <?php
            }else{
                ?>
            <div class="text-muted text-center">
                <h5>No Pending requests</h5>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<script src='../js/bootstrap/jquery.min.js'></script>
<script src='../js/bootstrap/bootstrap.min.js'></script>
<script src="../js/constants.js"></script>
<script src="../js/pharmacy.js"></script>
</body>
</html>
