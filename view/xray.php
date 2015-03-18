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

    <title>Xray</title>

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
                    <form id="addTestForm" class="form" method="post">
                        <input type="hidden" name="<?php RadiologyTable::table_name.'['.RadiologyTable::radiology_id.']'; ?>">
                        <input type="hidden" name="<?php RadiologyTable::table_name.'['.RadiologyTable::treatment_id.']'; ?>" value="[treatment_id]">

                        <div class="row">
                            <div class="page-header">
                                <a id="back" href="#" class="btn btn-default btn-sm" style="float: left;margin-right: 10px;margin-top: 5px; margin-left: 20px;">← Go Back</a>
                                <h2 class="page-header__title">Radiology (X-ray)</h2>
                            </div>

                            <div class="col-sm-12">
                                <div>
                                    <div class="test-label"> WARD / CLINIC : <input type="text" class="form-horizontal" name="<?php echo RadiologyTable::table_name . "[" . RadiologyTable::ward_clinic_id . "]"; ?>" /></div>
                                    <fieldset class="barX"><legend class="test-label">X-Ray Details</legend>
                                        <div class="form-group">
                                            <label for="xray-no" class="test-label col-sm-1 text-right">X-ray No:</label>
                                            <div class="col-sm-2">
                                                <input type="text" id="xray-no" class="form-control" name="<?php echo XrayNoTable::table_name . "[" . XrayNoTable::xray_number . "]";  ?>">
                                            </div>
                                            <label for="casual-no" class="test-label col-sm-1 text-right">Casual No:</label>
                                            <div class="col-sm-2">
                                                <input type="text" id="casual-no" class="form-control" name="<?php echo XrayNoTable::table_name . "[" . XrayNoTable::casual_no . "]"; ?>">
                                            </div>
                                            <label for="gp-no" class="test-label col-sm-1 text-right">G.P No:</label>
                                            <div class="col-sm-2">
                                                <input type="text" id="gp-no" class="form-control" name="<?php echo XrayNoTable::table_name . "[" . XrayNoTable::gp_no . "]"; ?>">
                                            </div>
                                            <label for="ante-natal-no" class="test-label col-sm-1 text-right">Ante-Natal No:</label>
                                            <div class="col-sm-2">
                                                <input type="text" id="ante-natal-no" class="form-control" name="<?php echo XrayNoTable::table_name . "[" . XrayNoTable::ante_natal_no . "]"; ?>">
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
                                        ?>

                                        <?php foreach ($movement_list->getList() as $label){?>
                                            <label class="test-label col-sm-1"><input type="radio" class="form" name="<?php RadiologyTable::table_name.'['.RadiologyTable::xray_case_id.']'; ?>">
                                                <?php echo $label->getLabel(); ?>
                                            </label>
                                        <?php } ?>
                                        <label class="test-label col-sm-1 text-right">L.M.P:</label>
                                        <div class="col-sm-3">
                                            <input type="text" placeholder="L.M.P." class="form-control" name="<?php echo RadiologyTable::table_name . "[" . RadiologyTable::lmp . "]"; ?>"/>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <fieldset class="barX"><legend class="test-label">If Examination is Requested</legend>
                                    <label class="test-label">Previous Operation</label>
                                    <div class="center-block">
                                        <input type="text" class="col-sm-12 form-control" name="<?php echo ExaminationRequestedTable::table_name . "[" . ExaminationRequestedTable::previous_operation . "]"; ?>"/>
                                    </div>
                                    <label class="test-label">Any Known Allergies</label>
                                    <div class="center-block">
                                        <input type="text" class="col-sm-12 form-control" name="<?php echo ExaminationRequestedTable::table_name . "[" . ExaminationRequestedTable::any_known_allergies . "]"; ?>"/>
                                    </div>
                                    <div class="test-label">Previous X-ray:
                                        <input type="radio" value="1" name="<?php echo ExaminationRequestedTable::table_name . "[" . ExaminationRequestedTable::previous_xray . "]"; ?>"/> Yes
                                        <input  type="radio" name="<?php echo ExaminationRequestedTable::table_name . "[" . ExaminationRequestedTable::previous_xray . "]"; ?>" value="0"/> No
                                    </div>
                                    <label class="test-label">Quote X-ray Number</label>
                                    <div class="center-block">
                                        <input type="text" class="col-sm-12 form-control" name="<?php echo ExaminationRequestedTable::table_name . "[" . ExaminationRequestedTable::xray_number . "]"; ?>"/>
                                    </div>
                                </fieldset>
                                <fieldset class="barX"><legend class="test-label">For Completion By Physician:</legend>
                                    <div class="center-block">
                                        <textarea class="col-sm-12 form-control" name="<?php echo ExaminationRequestedTable::table_name . "[" . ExaminationRequestedTable::clinical_diagnosis_details . "]"; ?>"></textarea>
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
                                                    <td><input type="radio" name="<?php echo RadiologyTable::table_name . "[" . RadiologyTable::xray_size_id . "]"; ?>"/></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <div class="test-label">Checked by:  <input type="text" class="form-horizontal" name="<?php echo RadiologyTable::table_name . "[" . RadiologyTable::checked_by . "]"; ?>"/></div>
                                </fieldset>
                            </div>
                            <div class="col-sm-6 col-sm-offset-6"></div>
                            <div class="col-sm-6">
                                <fieldset class="barX"><legend class="test-label">Radiographer's Note:</legend>
                                    <div class="center-block">
                                        <textarea class="col-sm-12 form-control" name="<?php echo RadiologyTable::table_name . "[" . RadiologyTable::radiographers_note . "]"; ?>" ></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-6">
                                <fieldset class="barX"><legend class="test-label">Radiologist's Report:</legend>
                                    <div class="center-block">
                                        <textarea class="col-sm-12 form-control" name="<?php echo RadiologyTable::table_name . "[" . RadiologyTable::radiologists_report . "]"; ?>" ></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-6">
                                <fieldset class="barX"><legend class="test-label">Signed:</legend>
                                    <label class="test-label">Consultant In Charge of Case</label>
                                    <div class="center-block">
                                        <input type="text" class="form-control col-sm-12" name="<?php echo RadiologyTable::table_name . "[" . RadiologyTable::consultant_in_charge . "]"; ?>" >
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-6 submit-test">
                                <input type='submit' class='btn btn-primary pad' value='Submit' name='submit'>
                                <input type='submit' class='btn btn-default pad' value='Save & Continue' name='save_continue'>
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
