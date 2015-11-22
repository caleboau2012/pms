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

$patient = (new PatientModel())->getPatientByTreatmentId($_REQUEST['treatment_id']);

$view_bag = $lab->getLabDetails($_REQUEST['labType'], $_REQUEST['treatment_id'], $_REQUEST['encounter_id']);

if ($view_bag['details'][HaematologyTable::status_id] == 7){
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
    <link rel="icon" href="../favicon.ico">

    <title>Haematology</title>

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
            <a class="navbar-brand" href="dashboard.php">
                <?php
                if(is_null(CxSessionHandler::getItem('hospital_name'))){
                    echo "Patient Management System";
                }else{
                    echo ucwords(CxSessionHandler::getItem('hospital_name'));
                }
                ?>
            </a>
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
                        <input type="hidden" name="<?php echo 'data[details]'.'['.HaematologyTable::haematology_id.']'; ?>" value="<?php echo $view_bag['details']['haematology_id'] ?>" />
                        <input type="hidden" name="<?php  echo 'data[details]'.'['.HaematologyTable::lab_attendant_id.']' ?>" value="<?php if(isset($view_bag['details']['lab_attendant_id'])) echo $view_bag['details']['lab_attendant_id'] ?>" />
                        <input type="hidden" name="intent" value="updateLabDetails">
                        <input type="hidden" name="labType" value="haematology">
                        <input type="hidden" id="status" name="status" value="">

                        <div class="row">
                            <div class="page-header">
                                <h2 class="page-header__title">Haematology</h2>
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
                                        <div class="test-label">Laboratory Ref: <span><input type="text" <?php echo $disabled; ?> class="form-inline form-margin" name="<?php echo 'data[details]'.'['.HaematologyTable::laboratory_ref.']'; ?>" value="<?php if (isset($view_bag['details']['laboratory_ref'])) echo $view_bag['details']['laboratory_ref']; ?>"></span> </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php

                            $blood_list = new LabelList();

                            $blood_list->addNode(new LabelNode("PCV", 1, array('unit' => '%', 'column' => BloodTestTable::pcv)));
                            $blood_list->addNode(new LabelNode("Hb", 2, array('unit' => 'G/100ml', 'column' => BloodTestTable::hb)));
                            $blood_list->addNode(new LabelNode("HCHC", 3, array('unit' => '%', 'column' => BloodTestTable::hchc)));
                            $blood_list->addNode(new LabelNode("WBC", 4, array('unit' => '/Cu mm', 'column' => BloodTestTable::wbc)));
                            $blood_list->addNode(new LabelNode("Eosinophilis", 5, array('unit' => '/Cu mm', 'column' => BloodTestTable::eosinophils)));
                            $blood_list->addNode(new LabelNode("Platelets", 6, array('unit' => '/Cu mm', 'column' => BloodTestTable::platelets)));
                            $blood_list->addNode(new LabelNode("Retics", 7 ,  array('unit' => '%', 'column' => BloodTestTable::rectis)));
                            $blood_list->addNode(new LabelNode("Rectis Index", 8,  array('unit' => '%', 'column' => BloodTestTable::rectis_index)));
                            $blood_list->addNode(new LabelNode("E S R", 9, array('unit' => 'MM/hr', 'column' => BloodTestTable::e_s_r)));
                            $blood_list->addNode(new LabelNode("Microfilaria", 10, array('column' => BloodTestTable::microfilaria)));
                            $blood_list->addNode(new LabelNode("Malaria parasites", 11, array('column' => BloodTestTable::malaria_parasites)));
                            ?>
                            <div class="col-sm-6">
                                <h4 class="title">Blood Examination</h4>
                                <?php foreach($blood_list->getList() as $label) {  $attr = $label->getAttribute(); ?>
                                    <label class="test-label"><?php echo $label->getLabel(); ?></label>
                                <?php if (isset($attr['unit'])){ ?>
                                    <div class="input-group">
                                        <?php } else { ?>
                                    <div class="center-block">
                                        <?php } ?>
                                        <input type="text" <?php echo $disabled; ?> class="form-control col-sm-12" name="<?php echo 'data['.BloodTestTable::table_name. ']['.$attr['column'].']' ?>" value="<?php if (isset($view_bag[BloodTestTable::table_name][$attr['column']])) echo $view_bag[BloodTestTable::table_name][$attr['column']]; ?>">
                                        <?php if (isset($attr['unit'])){ ?>
                                            <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>

                            <?php
                            $film_list = new LabelList();

                            $film_list->addNode(new LabelNode("Aniscocytosis", 11, array('column' => FilmAppearanceTable::aniscocytosis)));
                            $film_list->addNode(new LabelNode("Poikilocytosis", 1, array('column' => FilmAppearanceTable::poikilocytosis)));
                            $film_list->addNode(new LabelNode("Polychromasia", 2, array('column' => FilmAppearanceTable::polychromasia)));
                            $film_list->addNode(new LabelNode("Macrocytosis", 3, array('column' => FilmAppearanceTable::macrocytosis)));
                            $film_list->addNode(new LabelNode("Microcytosis", 4, array('column' => FilmAppearanceTable::microcytosis)));
                            $film_list->addNode(new LabelNode("Hypochromia", 5, array('column' => FilmAppearanceTable::hypochromia)));
                            $film_list->addNode(new LabelNode("Sickle Cells", 6, array('column' => FilmAppearanceTable::sickle_cells)));
                            $film_list->addNode(new LabelNode("Target Cells", 7, array('column' => FilmAppearanceTable::target_cells)));
                            $film_list->addNode(new LabelNode("Spherocytes", 8, array('column' => FilmAppearanceTable::spherocytes)));
                            $film_list->addNode(new LabelNode("Nucleated RBC", 9, array('column' => FilmAppearanceTable::nucleated_rbc)));
                            $film_list->addNode(new LabelNode("Sickling Test", 10, array('column' => FilmAppearanceTable::sickling_test)));
                            ?>
                            <div class="col-sm-6">
                                <h4 class="title">Film Appearance</h4>
                                <?php foreach($film_list->getList() as $label) { $attr = $label->getAttribute(); ?>
                                    <label class="test-label"><?php echo $label->getLabel(); ?></label>
                                    <?php if (isset($attr['unit'])){ ?>
                                        <div class="input-group">
                                    <?php } else { ?>
                                        <div class="center-block">
                                    <?php } ?>
                                            <input type="text" <?php echo $disabled; ?> class="form-control col-sm-12" name="<?php echo 'data['.FilmAppearanceTable::table_name.']['.$attr['column'].']'; ?>" value="<?php if (isset($view_bag[FilmAppearanceTable::table_name][$attr['column']])) echo $view_bag[FilmAppearanceTable::table_name][$attr['column']]; ?>">
                                            <?php if (isset($attr['unit'])){ ?>
                                                <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                            <?php } ?>
                                        </div>
                                <?php } ?>
                            </div>

                                <?php
                                $differential_count_label = new LabelList();

                                $differential_count_label->addNode(new LabelNode("Polymorphs / neutrophilis ", 1, array('unit' => '%', 'column' => DifferentialCountTable::polymorphs_neutrophils)));
                                $differential_count_label->addNode(new LabelNode("Lymphocytes", 2, array('unit' => '%', 'column' => DifferentialCountTable::lymphocytes)));
                                $differential_count_label->addNode(new LabelNode("Monocytes", 3, array('unit' => '%', 'column' => DifferentialCountTable::monocytes)));
                                $differential_count_label->addNode(new LabelNode("Eosinophils", 4, array('unit' => '%', 'column' => DifferentialCountTable::eosinophils)));
                                $differential_count_label->addNode(new LabelNode("Basophils", 5, array('unit' => '%', 'column' => DifferentialCountTable::basophils)));
                                $differential_count_label->addNode(new LabelNode("Widal's test", 6, array('unit' => '%', 'column' => DifferentialCountTable::widals_test)));
                                $differential_count_label->addNode(new LabelNode("Blood Group", 7 ,  array('unit' => '', 'column' => DifferentialCountTable::blood_group)));
                                $differential_count_label->addNode(new LabelNode("Rhesus Factor", 8,  array('unit' => '', 'column' => DifferentialCountTable::rhesus_factor)));
                                $differential_count_label->addNode(new LabelNode("Genotype", 9, array('unit' => '', 'column' => DifferentialCountTable::genotype)));
                                $list1 = $differential_count_label->getList();
                                $list2 = $differential_count_label->getList();
                                $list1 = array_splice($list1, 0, 5);
                                $list2 = array_splice($list2, 5, 8);
                                ?>

                                <h4 class="title col-sm-12">Differential Counts</h4>
                                <div class="col-sm-6">
                                    <?php foreach ($list1 as $label) { $attr = $label->getAttribute(); ?>
                                        <label class="test-label"><?php echo $label->getLabel(); ?></label>
                                        <?php if (isset($attr['unit'])) { ?>
                                            <div class="input-group">
                                        <?php } else { ?>
                                            <div class="center-block">
                                        <?php } ?>
                                                <input type="text" <?php echo $disabled; ?> class="form-control col-sm-12" name="<?php echo 'data['.DifferentialCountTable::table_name.']['.$attr['column'].']'; ?>" value="<?php if (isset($view_bag[DifferentialCountTable::table_name][$attr['column']])) echo $view_bag[DifferentialCountTable::table_name][$attr['column']]; ?>">
                                                <?php if (isset($attr['unit'])){ ?>
                                                    <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                                <?php } ?>
                                            </div>
                                    <?php } ?>
                                </div>

                                <div class="col-sm-6">
                                    <?php foreach ($list2 as $label) { $attr = $label->getAttribute(); ?>
                                    <label class="test-label"><?php echo $label->getLabel(); ?></label>
                                    <?php if (isset($attr['unit'])) { ?>
                                    <div class="input-group">
                                        <?php } else { ?>
                                        <div class="center-block">
                                            <?php } ?>
                                            <input type="text" <?php echo $disabled; ?> class="form-control col-sm-12" name="<?php echo 'data['.DifferentialCountTable::table_name.']['.$attr['column']. ']'; ?>" value="<?php if (isset($view_bag[DifferentialCountTable::table_name][$attr['column']])) echo $view_bag[DifferentialCountTable::table_name][$attr['column']]; ?>">
                                            <?php if (isset($attr['unit'])){ ?>
                                                <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                </div>

                                <?php
                                    if ($view_bag['details'][HaematologyTable::status_id] == 5 || $view_bag['details'][HaematologyTable::status_id] == 6){?>
                                <div class="col-sm-6 submit-test">
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