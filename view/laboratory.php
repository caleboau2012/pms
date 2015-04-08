<?php
/**
 * Created by PhpStorm.
 * User: Olaniyi
 * Date: 3/3/15
 * Time: 3:48 PM
 */

require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);

if (!isset($_SESSION[UserAuthTable::userid])) {
    header("Location: ../index.php");
}
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

    <title>Laboratory</title>

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
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="dashboard.php">Patient Management System</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right nav-pills">
                <div class="dropdown navbar-right navbar-right-text pointer">
                    <span class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                    <img src="../images/profile.png">
                    <span>
                        <?php echo ucwords(CxSessionHandler::getItem(ProfileTable::surname) . ' ' . CxSessionHandler::getItem(ProfileTable::firstname)) ?>
                    </span>
                    <span class="caret"></span>
                </span>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a href="#" id="sign-out">Sign out</a></li>
                    </ul>
                </div>
            </ul>
            <form class="treatment navbar-form">
                <div class="search form-inline">
                    <input type="text" class="form-control" name="search" placeholder="Search Returning Patients...">
                </div>
            </form>
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
        <div class="col-sm-9 well">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <label class="panel-title">Patients' Test Records</label>
                </div>
                <div class="panel-body">
                    <table id="test_table" class="table table-stripped table--bordered dataTable">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Identification No.</th>
                            <th>Test Type</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Created Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Identification No.</th>
                            <th>Test Type</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Created Date</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <label>Select Test</label>
            <select id="type" class="form-control" name="test_id" onchange="Laboratory.onTestChange()">
                <option value="haematology">HAEMATOLOGY</option>
                <option value="radiology">RADIOLOGY</option>
                <option value="xray">XRAY</option>
                <option value="visual">VISUAL SKILL PROFILE</option>
                <option value="chemical_pathology">CHEMICAL PATHOLOGY</option>
                <option value="parasitology">PARASITOLOGY</option>
            </select>
        </div>

        <div class="col-sm-3">
            <br/>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <label>Pending Requests</label>
                </div>
                <div id="pending" class="panel-body">
                    <div class="patient-queue__body">
                        <div class="patient-queue__list">

                        </div>
                    </div>
                </div>
            </div>
        </div>

<!--Haematology Modal starts here-->
        <div id="haematology" class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <div>
                            <h2>{{Patient Name}}</h2>
                        </div>
                        <div>
                            <p>{{Reg No}}</p>
                            <span>{{Sex}}</span>
                            <span>{{Age}} years</span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form id="addTestForm" class="form">
                            <input type="hidden" name="<?php HaematologyTable::table_name.'['.HaematologyTable::haematology_id.']'; ?>"  />
                            <input type="hidden" name="<?php  HaematologyTable::table_name.'['.HaematologyTable::lab_attendant_id.']' ?>" value="<?php echo $_SESSION['userid']; ?>" />
                            <input type="hidden" name="<?php HaematologyTable::table_name.'['.HaematologyTable::treatment_id.']'; ?>" >

                            <div class="row">
                                <div class="page-header">
                                    <h2 class="page-header__title pad">Haematology</h2>
                                </div>

                                <div class="col-sm-6">
                                    <div class="center-block">
                                        <fieldset>
                                            <h4 class="title">Clinical Diagnosis and Relevant Details</h4>
                                            <textarea readonly class="col-sm-12 form-control" >
                                                <?php
                                                if(isset($_SESSION[HaematologyTable::clinical_diagnosis_details])){
                                                    echo $_SESSION[HaematologyTable::clinical_diagnosis_details];
                                                }
                                                ?>
                                            </textarea>
                                            <div class="test-label">Doctor: {{Doctor's Name}}<span class="pad5 test-label">Date:</span></div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="center-block">
                                        <fieldset>
                                            <h4 class="title">Laboratory Report</h4>
                                            <textarea name="<?php echo 'details'.'['.HaematologyTable::table_name.'['.HaematologyTable::laboratory_report.']'.']'; ?>" class="col-sm-12 form-control">

                                            </textarea>
                                            <div class="test-label">Laboratory Ref: <span><input type="text" class="form-inline form-margin" name="<?php echo 'details'.'['.HaematologyTable::table_name.'['.HaematologyTable::laboratory_ref.']'.']'; ?>"></span> </div>
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
                                            <input type="text" class="form-control col-sm-12" name="<?php echo BloodTestTable::table_name. '['.$attr['column'].']' ?>">
                                            <?php if (isset($attr['unit'])){ ?>
                                                <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <?php
                                    $film_list = new LabelList();

                                    $film_list->addNode(new LabelNode("Aniscocytosis", 10, array('column' => FilmAppearanceTable::aniscocytosis)));
                                    $film_list->addNode(new LabelNode("Poikilocytosis", 1, array('column' => FilmAppearanceTable::poikilocytosis)));
                                    $film_list->addNode(new LabelNode("Polychromasia", 2, array('column' => FilmAppearanceTable::polychromasia)));
                                    $film_list->addNode(new LabelNode("Macrocytosis", 3, array('column' => FilmAppearanceTable::macrocytosis)));
                                    $film_list->addNode(new LabelNode("Hypochromia", 4, array('column' => FilmAppearanceTable::hypochromia)));
                                    $film_list->addNode(new LabelNode("Sickle Cells", 5, array('column' => FilmAppearanceTable::sickle_cells)));
                                    $film_list->addNode(new LabelNode("Target Cells", 6, array('column' => FilmAppearanceTable::target_cells)));
                                    $film_list->addNode(new LabelNode("Spherocytes", 7, array('column' => FilmAppearanceTable::spherocytes)));
                                    $film_list->addNode(new LabelNode("Nucleated RBC", 8, array('column' => FilmAppearanceTable::nucleated_rbc)));
                                    $film_list->addNode(new LabelNode("Sickling Test", 9, array('column' => FilmAppearanceTable::sickling_test)));
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
                                                <input type="text" class="form-control col-sm-12" name="<?php echo FilmAppearanceTable::table_name.'['.$attr['column'].']'; ?>">
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
                                                    <input type="text" class="form-control col-sm-12" name="<?php echo DifferentialCountTable::table_name.'['.$attr['column'].']'; ?>">
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
                                                        <input type="text" class="form-control col-sm-12" name="<?php echo 'data'.'['.DifferentialCountTable::table_name.'['.$attr['column'].']]'; ?>">
                                                        <?php if (isset($attr['unit'])){ ?>
                                                            <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                                        <?php } ?>
                                                    </div>
                                                    <?php } ?>
                                                </div>

                                                <div class="col-sm-6 submit-test">
                                                    <input type='submit' id="submit" class='btn btn-primary pull-right pad' value='Submit' name='submit'>
                                                    <input type='submit' id="save" class='btn btn-default pull-right pad' value='Save & Continue' name='save_continue'>
                                                </div>
                                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<!--haematology modal ends here-->


<!--Chemical Pathology modal starts here-->
        <div id="chemical_pathology" class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">{{Patient Name}}</h2>
                        </div>
                        <div class="panel-body">
                            <p>{{Reg No}}</p>
                            <span>{{Sex}}</span>
                            <span>{{Age}} years</span>
                        </div>
                    </div>

                    <div class="haematology">
                        <div class="add-haematology">

                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--Chemical Pathology modal ends here-->

    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/bootstrap/jquery-1.10.2.min.js"></script>
<script src="../js/bootstrap/jquery.dataTables.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/bootstrap/jquery-ui.min.js"></script>
<script src="../js/constants.js"></script>
<script src="../js/laboratory.js"></script>
</body>
</html>