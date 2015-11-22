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

if ($view_bag['details'][UrineTable::status_id] == 7){
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

    <title>Microscopy</title>

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
            <a class="navbar-brand" href="dashboard.php"><?php
                if(is_null(CxSessionHandler::getItem('hospital_name'))){
                    echo "Patient Management System";
                }else{
                    echo ucwords(CxSessionHandler::getItem('hospital_name'));
                }
                ?></a>
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
            <button class="btn btn-default pull-right" id="print"><i class="fa fa-print"></i> Print</button>
            <div class="panel panel-default" id="print-head">
                <div class="panel-heading">
                    <h2 class="panel-title"><span style="text-transform: uppercase"><?php echo $patient['surname']; ?></span> <?php echo $patient['middlename'].' '. $patient['firstname'];  ?></h2>
                </div>
                <div class="panel-body">
                    <p><?php echo $patient['regNo']; ?></p>
                    <span><?php echo $patient['sex']; ?></span>
                    <span></span>
                </div>
            </div>

            <div class="haematology" id="print-body">
                <div class="add-haematology">
                    <form id="addTestForm" class="form" method="POST">
                        <input type="hidden" name="<?php echo 'data[details]'.'['.UrineTable::urine_d.']'; ?>" value="<?php echo $view_bag['details']['urine_id'] ?>" />
                        <input type="hidden" name="<?php  echo 'data[details]'.'['.UrineTable::lab_attendant_id.']' ?>" value="<?php if(isset($view_bag['details']['lab_attendant_id'])) echo $view_bag['details']['lab_attendant_id'] ?>" />
                        <input type="hidden" name="<?php echo 'data['.UrineTable::treatment_id.']' ?>" value="<?php if(isset($view_bag['details']['treatment_id'])) echo $view_bag['details']['treatment_id'] ?>">
                        <input type="hidden" name="intent" value="updateLabDetails">
                        <input type="hidden" name="labType" value="microscopy">
                        <input type="hidden" id="status" name="status" value="">

                        <div class="row">
                            <div class="page-header">
                                <h2 class="page-header__title">Microscopy</h2>
                            </div>

                            <div class="col-sm-6">
                                <div class="center-block">
                                    <fieldset>
                                        <h4 class="title">Clinical Diagnosis and Relevant Details</h4>
                                        <textarea disabled="disabled" class="col-sm-12 form-control"><?php
                                            if(isset($view_bag['details']['clinical_diagnosis_details'])){
                                                echo $view_bag['details']['clinical_diagnosis_details'];
                                            }
                                            ?>
                                        </textarea>
                                        <div class="test-label">Doctor: {{Doctor's Name}}<span class="pad5 test-label">Date: <?php if(isset($view_bag['details']['created_date'])) echo $view_bag['details']['created_date'];?></span></div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="center-block">
                                    <fieldset>
                                        <h4 class="title">Laboratory Report</h4>
                                        <textarea <?php echo $disabled; ?> name="<?php echo 'data[details]'.'['.HaematologyTable::laboratory_report.']'; ?>" class="col-sm-12 form-control"><?php
                                            if(isset($view_bag['details']['laboratory_report'])){
                                                echo $view_bag['details']['laboratory_report'];
                                            }
                                            ?>
                                        </textarea>
                                        <div class="test-label">Laboratory Ref: <span><input type="text" <?php echo $disabled; ?> class="form-inline form-margin" name="<?php echo 'data[details]'.'['.UrineTable::laboratory_ref.']'; ?>" value="<?php if (isset($view_bag['details']['laboratory_ref'])) echo $view_bag['details']['laboratory_ref']; ?>"></span> </div>
                                        <div class="test-label">Investigation Required: <span><input type="text" <?php echo $disabled; ?> class="form-inline form-margin" name="<?php echo 'data[details]'.'['.UrineTable::investigation_required.']'; ?>" value="<?php if (isset($view_bag['details']['investigation_required'])) echo $view_bag['details']['investigation_required']; ?>"></span> </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            $urinalysis_label_list = new LabelList();

                            $urinalysis_label_list->addNode(new LabelNode("Appearance", 1, array('column'=>UrinalysisTable::appearance)));
                            $urinalysis_label_list->addNode(new LabelNode("pH", 2, array('column'=>UrinalysisTable::ph)));
                            $urinalysis_label_list->addNode(new LabelNode("glucose", 3, array('column'=>UrinalysisTable::glucose)));
                            $urinalysis_label_list->addNode(new LabelNode("protein", 4, array('column'=>UrinalysisTable::protein)));
                            $urinalysis_label_list->addNode(new LabelNode("Bilirubin", 5, array('column'=>UrinalysisTable::bilirubin)));
                            $urinalysis_label_list->addNode(new LabelNode("Urobilinogen", 6, array('column'=>UrinalysisTable::urobillinogen)));

                            $microscopy_label_list = new LabelList();

                            $microscopy_label_list->addNode(new LabelNode("Pus Cells", 1, array('column'=>MicroscopyTable::pus_cells)));
                            $microscopy_label_list->addNode(new LabelNode("Red Cells", 2, array('column'=>MicroscopyTable::red_cells)));
                            $microscopy_label_list->addNode(new LabelNode("Epithelial Cells", 3, array('column'=>MicroscopyTable::epithelial_cells)));
                            $microscopy_label_list->addNode(new LabelNode("Casts", 4, array('column'=>MicroscopyTable::casts)));
                            $microscopy_label_list->addNode(new LabelNode("Crystals", 5, array('column'=>MicroscopyTable::crystals)));
                            $microscopy_label_list->addNode(new LabelNode("Others", 6, array('column'=>MicroscopyTable::others)));

                            $anibiotics_label_list = new LabelList();

                            $anibiotics_label_list->addNode(new LabelNode("Ampiciline", 1));
                            $anibiotics_label_list->addNode(new LabelNode("Mechicillin/Clox", 2));
                            $anibiotics_label_list->addNode(new LabelNode("Erythromycin", 3));
                            $anibiotics_label_list->addNode(new LabelNode("Tetrecyclin", 4));
                            $anibiotics_label_list->addNode(new LabelNode("Septrin", 5));
                            $anibiotics_label_list->addNode(new LabelNode("Streptomycin", 6));
                            $anibiotics_label_list->addNode(new LabelNode("Nitofurantoin", 7));
                            $anibiotics_label_list->addNode(new LabelNode("Cefotaxime", 8));
                            $anibiotics_label_list->addNode(new LabelNode("Tarivid", 9));
                            $anibiotics_label_list->addNode(new LabelNode("Ciprfloxacin", 10));

                            ?>

                            <div class="col-sm-6">
                                <h4 class="title">URINALYSIS</h4>
                                <?php foreach($urinalysis_label_list->getList() as $label) {  $attr = $label->getAttribute(); ?>
                                <label class="test-label"><?php echo $label->getLabel(); ?></label>
                            <?php if (isset($attr['unit'])){ ?>
                                <div class="input-group">
                                    <?php } else { ?>
                                    <div class="center-block">
                                        <?php } ?>

                                        <input type="text" class="form-control col-sm-12" <?php echo $disabled; ?> name="<?php echo 'data['.UrinalysisTable::table_name. ']['.$attr['column'].']' ?>" value="<?php if (isset($view_bag[UrinalysisTable::table_name][$attr['column']])) echo $view_bag[UrinalysisTable::table_name][$attr['column']]; ?>">
                                        <?php if (isset($attr['unit'])){ ?>
                                            <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div>

                                <div class="col-sm-6">
                                    <h4 class="title">MICROSCOPY</h4>
                                    <?php foreach($microscopy_label_list->getList() as $label) { $attr = $label->getAttribute(); ?>
                                    <label class="test-label"><?php echo $label->getLabel(); ?></label>
                                <?php if (isset($attr['unit'])){ ?>
                                    <div class="input-group">
                                        <?php } else { ?>
                                        <div class="center-block">
                                            <?php } ?>
                                            <input type="text" class="form-control col-sm-12" <?php echo $disabled; ?> name="<?php echo 'data['.MicroscopyTable::table_name.']['.$attr['column'].']'; ?>" value="<?php if (isset($view_bag[MicroscopyTable::table_name][$attr['column']])) echo $view_bag[MicroscopyTable::table_name][$attr['column']]; ?>">
                                            <?php if (isset($attr['unit'])){ ?>
                                                <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="center-block">
                                            <fieldset>
                                                <h4 class="title">Culture</h4>
                                                <textarea <?php echo $disabled; ?> class="col-sm-12 form-control" name="<?php echo 'data[details]['.UrineTable::culture_value.']' ?>" ><?php if (isset($view_bag['details'][UrineTable::culture_value])) echo $view_bag['details'][UrineTable::culture_value]; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <table class="table table-striped table-responsive">
                                            <thead>
                                            <tr>
                                                <th class="title">Antibiotics</th>
                                                <th colspan="2" class="title">Isolates</th>
                                            </tr>
                                            <tr>
                                                <th colspan="1">&nbsp;</th>
                                                <th colspan="1">No</th>
                                                <th colspan="1">Yes</th>
                                            </tr>
                                            </thead>
                                            <?php foreach ($anibiotics_label_list->getList() as $label) { ?>
                                                <tr>
                                                    <td class="test-label"><?php echo $label->getLabel(); ?></td>

                                                    <td class="text-center"><input type="radio" <?php echo $disabled; ?> name="<?php echo 'data['.UrineSensitivityTable::table_name.']['.$label->getId().']' ?>" <?php if (isset($view_bag[UrineSensitivityTable::table_name][$label->getId()])) {	if ($view_bag[UrineSensitivityTable::table_name][$label->getId()] == '0'){ echo "checked='checked'";	}}?> value='0'  /></td>
                                                    <td class="text-center"><input type="radio" <?php echo $disabled; ?> name="<?php echo 'data['.UrineSensitivityTable::table_name.']['.$label->getId().']' ?>" <?php if (isset($view_bag[UrineSensitivityTable::table_name][$label->getId()])) {	if ($view_bag[UrineSensitivityTable::table_name][$label->getId()] == '1'){ echo "checked='checked'";	}}?> value='1' /></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <?php
                                    if ($view_bag['details'][UrineTable::status_id] == 5 || $view_bag['details'][UrineTable::status_id] == 6){?>
                                        <div class="col-sm-12 submit-test">
                                            <input type='submit' id="submit" class='btn btn-primary pull-right pad' value='Submit' name='submit'>
                                            <input type='submit' id="save" class='btn btn-default pull-right pad' value='Save & Continue' name='save_continue'>
                                        </div>
                                    <?php } ?>
                                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div id="print-footer" class="row hidden">
    <div class="text-center">
        <p><?php
            if(is_null(CxSessionHandler::getItem('hospital_name'))){
                echo "Patient Management System";
            }else{
                echo ucwords(CxSessionHandler::getItem('hospital_name'));
            }
            ?>
        </p>
        <p>
            <?php
            if(is_null(CxSessionHandler::getItem('hospital_address'))){
            }else{
                echo ucwords(CxSessionHandler::getItem('hospital_address'));
            }
            ?>
        </p>
        <p></p>
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
</body>
</html>