<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'PatientModel', 'ChemicalPathologyModel', 'HaematologyModel', 'MicroscopyModel', 'ParasitologyModel', 'VisualModel', 'RadiologyModel'));
Crave::requireFiles(CONTROLLER, array('LaboratoryController'));

if (!isset($_SESSION[UserAuthTable::userid])) {
    header("Location: ../index.php");
}

$lab = new LaboratoryController();

$view_bag = array();

$view_bag = $lab->getLabDetails($_REQUEST['labType'], $_REQUEST['treatment_id'], $_REQUEST['encounter_id']);
$patient = (new PatientModel())->getPatientByTreatmentId($_REQUEST['treatment_id']);

if ($view_bag[RadiologyTable::table_name][RadiologyTable::status_id] == 7){
    $disabled = 'disabled="disabled"';
}else { $disabled = '';}
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Radiology</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap/jquery-ui.css" rel="stylesheet">
    <link href="../css/bootstrap/jquery.dataTables.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/master.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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

<script id="tmplPatients" type="text/html">
    <div class="panel {{status}} patient">
        <div class="panel-heading" role="tab" id="heading{{patientid}}">
            <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion{{userid}}"
                   href="#collapse{{patientid}}" aria-expanded="false" aria-controls="collapse{{patientid}}">
                    {{regNo}}
                </a>
            </h4>
        </div>
        <div id="collapse{{patientid}}" class="panel-collapse collapse" role="tabpanel"
             aria-labelledby="heading{{patientid}}">
            <div class="panel-body">
                <p>{{name}}</p>

                <p>{{sex}}</p>
                <span class="patientid" hidden>{{patientid}}</span>
                <span class="doctorid" hidden>{{userid}}</span>
            </div>
        </div>
    </div>
</script>

<script id="tmplDoctor" type="text/html">
    <div class="col-sm-4 col-md-3">
        <div class="panel {{online_status}} doctor">
            <div class="panel-heading" userid="{{userid}}">
                <h2 class="panel-title">Dr. {{DoctorName}}</h2>
            </div>
            <div class="panel-body patients">
                <span class="to_doctor" hidden>{{userid}}</span>

                <div class="panel-group drop" id="accordion{{userid}}" role="tablist" aria-multiselectable="true">
                </div>
            </div>
        </div>
    </div>
</script>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 well">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title"><span style="text-transform: uppercase"><?php echo $patient['surname']; ?></span> <?php echo $patient['middlename'].' '. $patient['firstname'];  ?></h2>
                </div>
                <div class="panel-body">
                    <p><?php echo $patient['regNo']; ?></p>
                    <span><?php echo $patient['sex']; ?></span>
                    <span></span>
                </div>
            </div>

            <div class="haematology">
                <div class="add-haematology">
                    <form id="addTestForm" class="form" method="post">
                        <input type="hidden" name="<?php echo 'data[radiology]['.RadiologyTable::radiology_id.']'; ?>"value="<?php echo $view_bag['details']['radiology_id'] ?>">
                        <input type="hidden" name="<?php echo 'data[details]['.RadiologyTable::radiology_id.']'; ?>"value="<?php echo $view_bag['details']['radiology_id'] ?>">
                        <input type="hidden" name="<?php echo 'data[radiology]['.RadiologyTable::lab_attendant_id.']'; ?>" value="<?php if(isset($view_bag['details']['lab_attendant_id'])) echo $view_bag['details']['lab_attendant_id'] ?>">
                        <input type="hidden" name="<?php echo 'data[radiology]['.RadiologyTable::encounter_id.']'; ?>" value="<?php echo $view_bag['radiology']['encounter_id'] ?>">
                        <input type="hidden" name="intent" value="updateLabDetails">
                        <input type="hidden" name="labType" value="radiology">
                        <input type="hidden" id="status" name="status" value="">

                        <div class="row">
                            <div class="page-header">
                                <h2 class="page-header__title">Radiology (X-ray)</h2>
                                <div class="alert hidden alert-danger alert-dismissable" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <span class="alertMSG"></span>
                                </div>
                                <div class="alert hidden alert-success alert-dismissable" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <span class="successMSG"></span>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div>
                                    <div class="test-label"> WARD / CLINIC :
                                        <input type="text" class="form-horizontal" name="<?php echo 'data[radiology]' . '[' . RadiologyTable::ward_clinic_id . ']'; ?>"
                                               value="<?php
                                               if(isset($view_bag['radiology']['ward_clinic_id'])){
                                                   echo $view_bag['radiology']['ward_clinic_id'];
                                               }
                                               ?>"/>
                                    </div>
                                    <fieldset class="barX"><legend class="test-label">X-Ray Details</legend>
                                        <div class="form-group">
                                            <label for="xray-no" class="test-label col-sm-1 text-right">X-ray No:</label>
                                            <div class="col-sm-2">
                                                <input type="text" <?php echo $disabled; ?> id="xray-no" class="form-control" name="<?php echo 'data[xray]' . '[' . XrayNoTable::xray_number . ']';  ?>"
                                                value="<?php
                                                if(isset($view_bag['details']['xray_number'])){
                                                    echo $view_bag['details']['xray_number'];
                                                }
                                                ?>"/>
                                            </div>
                                            <label for="casual-no" class="test-label col-sm-1 text-right">Casual No:</label>
                                            <div class="col-sm-2">
                                                <input type="text" <?php echo $disabled; ?> id="casual-no" class="form-control" name="<?php echo 'data[xray]' . '[' . XrayNoTable::casual_no . ']'; ?>"
                                                value="<?php
                                                if(isset($view_bag['xray_no']['casual_no'])){
                                                    echo $view_bag['xray_no']['casual_no'];
                                                }
                                                ?>"/>
                                            </div>
                                            <label for="gp-no" class="test-label col-sm-1 text-right">G.P No:</label>
                                            <div class="col-sm-2">
                                                <input type="text" <?php echo $disabled; ?> id="gp-no" class="form-control" name="<?php echo 'data[xray]' . '[' . XrayNoTable::gp_no . ']'; ?>"
                                                       value="<?php
                                                       if(isset($view_bag['xray_no']['gp_no'])){
                                                           echo $view_bag['xray_no']['gp_no'];
                                                       }
                                                       ?>"/>
                                            </div>
                                            <label for="ante-natal-no" class="test-label col-sm-1 text-right">Ante-Natal No:</label>
                                            <div class="col-sm-2">
                                                <input type="text" <?php echo $disabled; ?> id="ante-natal-no" class="form-control" name="<?php echo 'data[xray]' . '[' . XrayNoTable::ante_natal_no . ']'; ?>"
                                                       value="<?php
                                                       if(isset($view_bag['xray_no']['ante_natal_no'])){
                                                           echo $view_bag['xray_no']['ante_natal_no'];
                                                       }
                                                       ?>"/>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="barX"><legend class="test-label">Movement</legend>
                                        <?php
                                        $movement_list = new LabelList();

                                        $movement_list->addNode(new LabelNode("W. Case", 1));
                                        $movement_list->addNode(new LabelNode("W.Chair", 2));
                                        $movement_list->addNode(new LabelNode("Trolley", 3));
                                        $movement_list->addNode(new LabelNode("Theatre", 4));
                                        $movement_list->addNode(new LabelNode("Portable", 5));
                                        $movement_list->addNode(new LabelNode("L.M.P.", 6));
                                        ?>

                                        <?php foreach ($movement_list->getList() as $label){?>
                                            <label class="test-label col-sm-1">
                                                <!--<input type="radio" class="form" name="<?php /*RadiologyTable::table_name.'['.RadiologyTable::xray_case_id.']'; */?>">-->
                                                <input class="radi" type="radio" <?php echo $disabled; ?> <?php
                                                if(isset($view_bag['radiology']['xray_case_id'])){
                                                    echo ($view_bag['radiology']['xray_case_id'] == $label->getId()) ?  "checked='checked'" : '';
                                                } ?> name="<?php echo 'data['.RadiologyTable::table_name.'][xray_case_id]'; ?>" value="<?php echo $label->getId(); ?>"/>
                                                <?php echo $label->getLabel(); ?>
                                            </label>
                                        <?php } ?>
                                        <div class="col-sm-3">
                                            <input type="text" <?php echo $disabled; ?> placeholder="L.M.P." class="form-control" name="<?php echo 'data[radiology][' . RadiologyTable::lmp . ']'; ?>" value="<?php if (isset($view_bag['radiology']['lmp'])) { echo $view_bag['radiology']['lmp'];} ?>"/>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <fieldset class="barX"><legend class="test-label">If Examination is Requested</legend>
                                    <label class="test-label">Previous Operation</label>
                                    <div class="center-block">
                                        <input type="text" <?php echo $disabled; ?> class="col-sm-12 form-control" name="<?php echo 'data[details]' . '[' . ExaminationRequestedTable::previous_operation . ']'; ?>"
                                        value="<?php if(isset($view_bag['details']['previous_operation'])) echo $view_bag['details']['previous_operation']; ?>"/>
                                    </div>
                                    <label class="test-label">Any Known Allergies</label>
                                    <div class="center-block">
                                        <input type="text" <?php echo $disabled; ?> class="col-sm-12 form-control" name="<?php echo 'data[details]' . '[' . ExaminationRequestedTable::any_known_allergies . ']'; ?>"
                                               value="<?php if(isset($view_bag['details']['previous_operation'])) echo $view_bag['details']['any_known_allergies']; ?>"/>
                                    </div>
                                    <div class="test-label">Previous X-ray:
                                        <input type="radio" name="<?php echo 'data[details]' . '[' . ExaminationRequestedTable::previous_xray . ']';  echo $disabled;?>" value="1"
                                        <?php if(isset($view_bag['details']['previous_xray']) AND $view_bag['details']['previous_xray'] == 1) {echo 'checked=checked';}?>/> Yes
                                        <input  type="radio" name="<?php echo 'data[details]' . '[' . ExaminationRequestedTable::previous_xray . ']'; ?>" value="0"
                                            <?php if(isset($view_bag['details']['previous_xray']) AND $view_bag['details']['previous_xray'] == 0) {echo 'checked=checked';}?>/> No
                                    </div>
                                    <label class="test-label">Quote X-ray Number</label>
                                    <div class="center-block">
                                        <input type="text" <?php echo $disabled; ?> class="col-sm-12 form-control" name="<?php echo 'data[details]' . '[' . ExaminationRequestedTable::xray_number . ']'; ?>"
                                        value="<?php if(isset($view_bag['details']['xray_number'])) echo $view_bag['details']['xray_number']; ?>"/>
                                    </div>
                                </fieldset>
                                <fieldset class="barX"><legend class="test-label">For Completion By Physician:</legend>
                                    <div class="center-block">
                                        <textarea class="col-sm-12 form-control" <?php echo $disabled; ?> name="<?php echo ExaminationRequestedTable::table_name . "[" . ExaminationRequestedTable::clinical_diagnosis_details . "]"; ?>"><?php if(isset($view_bag['details']['clinical_diagnosis_details'])) echo $view_bag['details']['clinical_diagnosis_details']; ?></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                $dimension_list = new LabelList();

                                $dimension_list->addNode(new LabelNode("17X14", 1));
                                $dimension_list->addNode(new LabelNode("14X4", 2));
                                $dimension_list->addNode(new LabelNode("15X12", 3));
                                $dimension_list->addNode(new LabelNode("12X10", 4));
                                $dimension_list->addNode(new LabelNode("10X8", 5));
                                $dimension_list->addNode(new LabelNode("15X6", 6));
                                $dimension_list->addNode(new LabelNode("8X6", 7));
                                ?>
                                <fieldset class="barX"><legend class="test-label">Dimension</legend>
                                    <div class="center-block">
                                        <table class="table table-striped table-responsive">
                                            <?php foreach ($dimension_list->getList() as $label) { ?>
                                                <tr>
                                                    <td class="test-label">&nbsp;<?php echo $label->getLabel(); ?> </td>
                                                    <td><input type="radio" <?php echo $disabled; ?> <?php
                                                        if(isset($view_bag['radiology']['xray_size_id'])){
                                                            echo ($view_bag['radiology']['xray_size_id'] == $label->getId()) ?  "checked='checked'" : '';
                                                        } ?> name="<?php echo 'data['.RadiologyTable::table_name.'][xray_size_id]'; ?>" value="<?php echo $label->getId(); ?>"/></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <div class="test-label">Checked by:  <input type="text" <?php echo $disabled; ?> class="form-horizontal" name="<?php echo 'data[radiology][' . RadiologyTable::checked_by . ']'; ?>"
                                        value="<?php if(isset($view_bag['radiology']['checked_by'])) echo $view_bag['radiology']['checked_by']; ?>"/>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-6 col-sm-offset-6"></div>
                            <div class="col-sm-6">
                                <fieldset class="barX"><legend class="test-label">Radiographer's Note:</legend>
                                    <div class="center-block">
                                        <textarea class="col-sm-12 form-control" <?php echo $disabled; ?> name="<?php echo 'data[radiology][' . RadiologyTable::radiographers_note . ']'; ?>" ><?php if(isset($view_bag['radiology']['radiographers_note'])) echo $view_bag['radiology']['radiographers_note']; ?></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-6">
                                <fieldset class="barX"><legend class="test-label">Radiologist's Report:</legend>
                                    <div class="center-block">
                                        <textarea class="col-sm-12 form-control" <?php echo $disabled; ?> name="<?php echo 'data[radiology][' . RadiologyTable::radiologists_report . ']'; ?>" ><?php if(isset($view_bag['radiology']['radiologists_report'])) echo $view_bag['radiology']['radiologists_report'];?></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-6">
                                <fieldset class="barX"><legend class="test-label">Signed:</legend>
                                    <label class="test-label">Consultant In Charge of Case</label>
                                    <div class="center-block">
                                        <input type="text" <?php echo $disabled; ?> class="form-control col-sm-12" name="<?php echo 'data[radiology][' . RadiologyTable::consultant_in_charge . ']'; ?>"
                                               value="<?php if(isset($view_bag['radiology']['consultant_in_charge'])) echo $view_bag['radiology']['consultant_in_charge']; ?>"/>
                                    </div>
                                </fieldset>
                            </div>
                            <?php
                            if ($view_bag['radiology'][HaematologyTable::status_id] == 5 || $view_bag['radiology'][HaematologyTable::status_id] == 6){?>
                                <div class="col-sm-6 submit-test">
                                    <input type='submit' id="submit" class='btn btn-primary pull-right pad' value='Submit' name='submit'>
                                    <input type='submit' id="save" class='btn btn-default pull-right pad' value='Save & Continue' name='save'>
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/bootstrap/jquery-1.10.2.min.js"></script>
<script src="../js/bootstrap/jquery-ui.min.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/bootstrap/bootstrap-datepicker.min.js"></script>
<script src="../js/constants.js"></script>
<script src="../js/laboratory.js" type="text/javascript"></script>
<script type="text/javascript">

    $("input[name='data[radiology][lmp]']").attr('disabled', 'disabled');
    $("input[name='data[radiology][xray_case_id]']:last").click(function(){
        $("input[name='data[radiology][lmp]']").attr('disabled', ! this.checked)
    });

</script>
</body>
</html>
