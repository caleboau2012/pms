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
                        <li role="presentation"><a href="#" id="sign-out">Sign out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">
            <div class="p-sidebar">
                <div class="p-panel">
                    <div class=" p-heading">
                        REQUESTS
                    </div>
                    <div class="p_body">
                        <?php
                        if(sizeof($pharmacist_queue) !== 0){
                            ?>
                            <ul class="list-unstyled patients-list">
                                <?php
                                foreach($pharmacist_queue as $patient){
                                    $patient_name = ucwords($patient['surname'].' '.$patient['middlename'].' '. $patient['firstname']);
                                    ?>
                                    <li class="patients-list_item" data-patient-id="<?php echo $patient['patient_id'] ?>" data-treatment-id="<?php echo $patient['treatment_id'] ?>" data-name = "<?php echo $patient_name ?>" data-reg = "<?php echo $patient['regNo']; ?>">
                                        <h4><?php echo $patient_name ?></h4>
                                        <p class="small"><?php echo $patient['regNo'] ?></p>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        <?php
                        }else{
                            ?>
                            <div class="text-muted text-center">
                                <h3>No pending request</h3>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9 p-content">
            <h1 class="text-muted text-center" id="empty_active"><br/><br/>&larr; Select patient </h1>
            <div class="col-md-12">
                <div class="active_patient hidden">
                    <div class="active_patient_heading">
                        <h2 id="patient_name"></h2>
                        <p class="small text-primary" id="patient_reg"></p>
                    </div>
                    <div class="col-md-6 patient_prescription">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                PRESCRIPTIONS
                            </div>
                            <div class="panel-body">
                                <p class="small text-info text-center">
                                    Click on a prescription to select/de-select it
                                </p>
                                <ol class="list-group patientPrescriptions">
                                    <li class="list-group-item"></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6  clearing_panel">
                        <div class="col-md-12">
                            <h4>CLEARING PANEL</h4>
                        </div>
                        <form id="addToClear">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input list="drugNames" type="text" class="form-control" id="drugName" placeholder="Drug name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="drugQuantity" placeholder="Drug quantity" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select id="drugUnit" class="form-control">
                                        <?php
                                        foreach($units as $unit){
                                            ?>
                                            <option value="<?php echo $unit['unit_ref_id']; ?>"><?php  echo $unit['unit']?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
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
                            <div class="clearfix"></div>
                            <ol class="selected_prescription">

                            </ol>

                            <div class="col-md-12">
                                <button class="btn btn-sm btn-warning">ADD TO CLEAR</button>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12" id="clearPrescriptions">

                            </div>
                        </form>
                        <button class="btn btn-sm btn-primary hidden" id="clrPrescription">CLEAR PRESCRIPTION</button>
                        <div class="alert col-md-12" id="response_msg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src='../js/bootstrap/jquery.min.js'></script>
<script src='../js/bootstrap/bootstrap.min.js'></script>
<script src="../js/constants.js"></script>
<script src="../js/pharmacy.js"></script>

<?php include('footer.php'); ?>

</body>
</html>
