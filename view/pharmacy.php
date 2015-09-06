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
<!--Page header-->
<?php Crave::requireFiles(HEADERS, array('main')) ?>

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
                                    <li class="patients-list_item" data-patient-id="<?php echo $patient['patient_id'] ?>" data-treatment-id="<?php echo $patient['treatment_id'] ?>" data-encounter-id="<?php echo $patient['encounter_id'] ?>" data-name = "<?php echo $patient_name ?>" data-reg = "<?php echo $patient['regNo']; ?>">
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
        <div class="col-sm-6 p-content">
            <h1 class="text-muted text-center" id="empty_active"><br/><br/>&larr; Select patient </h1>
            <div class="col-md-12">
                <div class="active_patient hidden">
                    <div class="active_patient_heading">
                        <h2 id="patient_name"></h2>
                        <p class="small text-primary" id="patient_reg"></p>
                    </div>
                    <div class="col-md-5 patient_prescription">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                PRESCRIPTIONS
                            </div>
                            <div class="panel-body">
                                <h5 class="small text-info text-center">
                                    Click on a prescription to select/de-select it
                                </h5>
                                <ol class="list-group patientPrescriptions">
                                    <li class="list-group-item"></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7  clearing_panel">
                        <form id="addToClear">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="drugName">Drug Name</label>
                                    <input list="drugNames" type="text" class="form-control" id="drugName" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="drugQuantity">Drug Quantity</label>
                                    <input type="number" class="form-control" id="drugQuantity" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="drugUnit">Drug Unit</label>
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
        <div class="col-sm-3">
            <div class="room-overview">
                <div class="room-overview__heading">
                    <h2 class="text-center"><span class="fa fa-history"></span></h2>
                    <h3 class="text-center">Overview</h3>
                </div>
                <p>
                    <span class="fa fa-users text-danger">&nbsp;</span>
                    20 pending patients
                </p>
                <p>
                    <span class="fa fa-dropbox text-danger">&nbsp;</span>
                    200 Drugs Dispensed
                </p>
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
