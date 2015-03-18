<?php
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

    <title>Chemical Pathology</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap/jquery-ui.css" rel="stylesheet">

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
        <div class="col-sm-12 well">
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
                    <form id="addTestForm" class="form">
                        <input type="hidden" name="<?php ChemicalPathologyRequestTable::table_name.'['.ChemicalPathologyRequestTable::cpreq_id.']'; ?>">
                        <input type="hidden" name="<?php ChemicalPathologyRequestTable::table_name.'['.ChemicalPathologyRequestTable::treatment_id.']'; ?>">

                        <div class="row">
                            <div class="page-header">
                                <a id="back" href="#" class="btn btn-default btn-sm" style="float: left;margin-right: 10px;margin-top: 5px; margin-left: 20px;">← Go Back</a>
                                <h2 class="page-header__title">Chemical Pathology</h2>
                            </div>

                            <div class="col-sm-6">
                                <div class="center-block">
                                    <fieldset>
                                        <h4 class="title">Clinical Diagnosis</h4>
                                        <textarea readonly class="col-sm-12 form-control">Test Request Here</textarea>
                                        <div class="test-label">Requesting Doctor: <span class="pad5 test-label">Date:</span></div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="center-block">
                                    <fieldset>
                                        <h4 class="title">Laboratory Report</h4>
                                        <textarea type="text" class="col-sm-12 form-control">

                                        </textarea>
                                        <div class="test-label">Laboratory Ref: <span><input type="text" class="form-inline form-margin" name="[laboratory_ref]"></span></div>
                                    </fieldset>
                                </div>
                            </div>

                            <?php
                            $electrolytes_label_list = new LabelList();
                            $electrolytes_label_list->addNode(new LabelNode("Na (120-140) mmol/L", 1, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                            $electrolytes_label_list->addNode(new LabelNode("K (3-5) mmol/L", 2, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                            $electrolytes_label_list->addNode(new LabelNode("Cl (95-100) mmol/L", 3, array('unit'=>'mmol/L','column'=>ChemicalPathologyDetailsTable::result)));
                            $electrolytes_label_list->addNode(new LabelNode("HCO3 (20-30) mmol/L", 4, array('unit'=>'mmol/L','column'=>ChemicalPathologyDetailsTable::result)));
                            $electrolytes_label_list->addNode(new LabelNode("Ca (2.25-2.75) mmol/L", 5, array('unit'=>'mmol/L','column'=>ChemicalPathologyDetailsTable::result)));
                            $electrolytes_label_list->addNode(new LabelNode("Creatinnie (50-132", 6, array('unit'=>'mmol/L','column'=>ChemicalPathologyDetailsTable::result)));
                            $electrolytes_label_list->addNode(new LabelNode("Urea (2.5-5.8) mmol/L", 7, array('unit'=>'mmol/L','column'=>ChemicalPathologyDetailsTable::result)));
                            $electrolytes_label_list->addNode(new LabelNode("Uric Acid (0.12-0.36) mmol/L", 8, array('unit'=>'mmol/L','column'=>ChemicalPathologyDetailsTable::result)));
                            ?>

                            <div class="col-sm-6">
                                <h4 class="title">ELECTROLYTES</h4>
                                <?php foreach($electrolytes_label_list->getList() as $label) {  $attr = $label->getAttribute(); ?>
                                <label class="test-label"><?php echo $label->getLabel(); ?></label>
                                <?php if (isset($attr['unit'])){ ?>
                                <div class="input-group">
                                    <?php } else { ?>
                                    <div class="center-block">
                                        <?php } ?>
                                        <input type="text" class="form-control col-sm-12" name="<?php echo ChemicalPathologyDetailsTable::table_name. '['.$label->getId().']' ?>">
                                        <?php if (isset($attr['unit'])){ ?>
                                            <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                            </div>

                                <?php
                                $lft_label_list = new LabelList();
                                $lft_label_list->addNode(new LabelNode("Bilirubin (Total)", 15, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $lft_label_list->addNode(new LabelNode("Bilirubin (Conj.)", 16, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $lft_label_list->addNode(new LabelNode("Alk Phos", 17, array('unit'=>'Iu/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $lft_label_list->addNode(new LabelNode("Acid Phos", 18, array('unit'=>'Iu/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $lft_label_list->addNode(new LabelNode("ALT (SGPT)", 19, array('unit'=>'Iu/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $lft_label_list->addNode(new LabelNode("AST (SGOT)", 20, array('unit'=>'Iu/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $lft_label_list->addNode(new LabelNode("Bilirubin (Total)", 15, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                ?>

                                <div class="col-sm-6">
                                    <h4 class="title">LFT</h4>
                                    <?php foreach($lft_label_list->getList() as $label) {  $attr = $label->getAttribute(); ?>
                                    <label class="test-label"><?php echo $label->getLabel(); ?></label>
                                    <?php if (isset($attr['unit'])){ ?>
                                    <div class="input-group">
                                        <?php } else { ?>
                                        <div class="center-block">
                                            <?php } ?>
                                            <input type="text" class="form-control col-sm-12" name="<?php echo ChemicalPathologyDetailsTable::table_name. '['.$label->getId().']' ?>">
                                            <?php if (isset($attr['unit'])){ ?>
                                                <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                </div>

                                <div class="col-sm-6 col-sm-offset-6"></div>

                                <?php
                                $fasting_label_list = new LabelList();
                                $fasting_label_list->addNode(new LabelNode("Total Chol (2.5-5.17)", 9, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $fasting_label_list->addNode(new LabelNode("TG < 2.3", 10, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $fasting_label_list->addNode(new LabelNode("HDL > 1.04", 11, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $fasting_label_list->addNode(new LabelNode("LDL > 3.9", 12, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $fasting_label_list->addNode(new LabelNode("Glucose (Fatsing) 2.8-5.0", 13, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                $fasting_label_list->addNode(new LabelNode("Glucose (2HPP) 3.0-6.0", 14, array('unit'=>'mmol/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                ?>
                                <div class="col-sm-6">
                                    <h4 class="title">FASTING LIPIDS PROFILE</h4>
                                    <?php foreach($fasting_label_list->getList() as $label) { $attr = $label->getAttribute(); ?>
                                    <label class="test-label"><?php echo $label->getLabel(); ?></label>
                                    <?php if (isset($attr['unit'])){ ?>
                                    <div class="input-group">
                                        <?php } else { ?>
                                        <div class="center-block">
                                            <?php } ?>
                                            <input type="text" class="form-control col-sm-12" name="<?php echo ChemicalPathologyDetailsTable::table_name.'['.$label->getId().']'; ?>">
                                            <?php if (isset($attr['unit'])){ ?>
                                                <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                </div>

                                    <?php
                                    $proteins_label_list = new LabelList();
                                    $proteins_label_list->addNode(new LabelNode("Total Protein", 21, array('unit'=>'g/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                    $proteins_label_list->addNode(new LabelNode("Albumin", 22, array('unit'=>'g/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                    $proteins_label_list->addNode(new LabelNode("Globulin", 23, array('unit'=>'g/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                    $proteins_label_list->addNode(new LabelNode("Others", 24, array('unit'=>'g/L', 'column'=>ChemicalPathologyDetailsTable::result)));
                                    ?>

                                    <div class="col-sm-6">
                                        <h4 class="title">PROTEINS</h4>
                                        <?php foreach($proteins_label_list->getList() as $label) { $attr = $label->getAttribute(); ?>
                                        <label class="test-label"><?php echo $label->getLabel(); ?></label>
                                        <?php if (isset($attr['unit'])){ ?>
                                        <div class="input-group">
                                            <?php } else { ?>
                                            <div class="center-block">
                                                <?php } ?>
                                                <input type="text" class="form-control col-sm-12" name="<?php echo ChemicalPathologyDetailsTable::table_name.'['.$label->getId().']'; ?>">
                                                <?php if (isset($attr['unit'])){ ?>
                                                    <span class="input-group-addon"><?php echo $attr['unit']; ?></span>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                        </div>

                                <div class="col-sm-6 submit-test">
                                    <input type='submit' class='btn btn-default pull-right pad' value='Save & Continue' name='save_continue'>
                                    <input type='submit' class='btn btn-primary pull-right pad' value='Submit' name='submit'>
                                </div>
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
<script src="../js/mail.js" type="text/javascript"></script>
</body>
</html>
