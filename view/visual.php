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

if ($view_bag[HaematologyTable::status_id] == 7){
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

    <title>Visual Skill Profile</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap/jquery-ui.css" rel="stylesheet">
    <link href="../css/bootstrap/jquery.dataTables.css" rel="stylesheet">
    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">

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
        <br>
        <div class="col-sm-12">
            <button class="btn btn-default pull-right" id="print"><i class="fa fa-print"></i> Print</button>
            <div class="panel panel-default" id="print-head">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        <span style="text-transform: uppercase">
                            <?php echo $patient['surname']; ?>
                        </span>
                        <?php echo $patient['middlename'].' '. $patient['firstname'];  ?>
                    </h2>
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
                        <input type="hidden" name="<?php echo 'data[details]['.VisualSkillsProfileTable::id.']' ?>" value="<?php echo $view_bag[VisualSkillsProfileTable::id] ?>" />
                        <input type="hidden" name="<?php  echo 'data[details]['.VisualSkillsProfileTable::lab_attendant_id.']' ?>" value="<?php if(isset($view_bag[VisualSkillsProfileTable::lab_attendant_id])) echo $view_bag[VisualSkillsProfileTable::lab_attendant_id] ?>" />
                        <input type="hidden" name="intent" value="updateLabDetails">
                        <input type="hidden" name="labType" value="visual">
                        <input type="hidden" id="status" name="status" value="">

                        <div class="row">
                            <div class="page-header">
                                <h2 class="page-header__title">Visual Acuity</h2>
                            </div>

                            <div class="col-sm-12">
                                <table class="table table-striped table-responsive">
                                    <thead>
                                    <tr>
                                        <th colspan="4" class="title text-center">Step One</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="test-label"><span>Distance &raquo;</td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="BE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::distance_be.']'; ?>" value="<?php  if(isset($view_bag[VisualSkillsProfileTable::distance_be])) echo $view_bag[VisualSkillsProfileTable::distance_be]; ?>"></td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="RE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::distance_re.']'; ?>" value="<?php if(isset($view_bag[VisualSkillsProfileTable::distance_re])) echo $view_bag[VisualSkillsProfileTable::distance_re]; ?>"></td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="LE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::distance_le.']'; ?>" value="<?php if(isset($view_bag[VisualSkillsProfileTable::distance_le])) echo $view_bag[VisualSkillsProfileTable::distance_le]; ?>"></td>

                                        </tr>
                                        <tr>
                                            <td class="test-label"><span>Near &raquo;</td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="BE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::near_be.']'; ?>" value="<?php  if(isset($view_bag[VisualSkillsProfileTable::near_be])) echo $view_bag[VisualSkillsProfileTable::near_be]; ?>"></td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="RE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::near_re.']'; ?>" value="<?php if(isset($view_bag[VisualSkillsProfileTable::near_re])) echo $view_bag[VisualSkillsProfileTable::near_be]; ?>"></td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="LE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::near_le.']'; ?>" value="<?php if(isset($view_bag[VisualSkillsProfileTable::near_le])) echo $view_bag[VisualSkillsProfileTable::near_be]; ?>"></td>

                                        </tr>
                                        <tr>
                                            <td class="test-label"><span>Pinhole Acuity &raquo;</td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="BE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::pinhole_acuity_be.']'; ?>" value="<?php  if(isset($view_bag[VisualSkillsProfileTable::pinhole_acuity_be])) echo $view_bag[VisualSkillsProfileTable::pinhole_acuity_be]; ?>"></td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="RE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::pinhole_acuity_re.']'; ?>" value="<?php if(isset($view_bag[VisualSkillsProfileTable::pinhole_acuity_re])) echo $view_bag[VisualSkillsProfileTable::pinhole_acuity_re]; ?>"></td>
                                            <td class="test-label"><input type="text" <?php echo $disabled; ?> class="form-control" placeholder="LE" name="<?php echo 'data[details]['.VisualSkillsProfileTable::pinhole_acuity_le.']'; ?>" value="<?php if(isset($view_bag[VisualSkillsProfileTable::pinhole_acuity_le])) echo $view_bag[VisualSkillsProfileTable::pinhole_acuity_le]; ?>"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-striped table-responsive">
                                    <thead>
                                    <tr>
                                        <th colspan="2" class="title text-center">Step Two</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="test-label"><span>Colour Vision</td>
                                        <td><input class="form-control" type="text" <?php echo $disabled; ?> name="<?php echo 'data[details]['.VisualSkillsProfileTable::colour_vision.']'; ?>" value="<?php  if(isset($view_bag[VisualSkillsProfileTable::colour_vision])) echo $view_bag[VisualSkillsProfileTable::colour_vision]; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td class="test-label"><span>Stereopsis</td>
                                        <td><input class="form-control" type="text" <?php echo $disabled; ?> name="<?php echo 'data[details]['.VisualSkillsProfileTable::stereopsis.']'; ?>" value="<?php  if(isset($view_bag[VisualSkillsProfileTable::stereopsis])) echo $view_bag[VisualSkillsProfileTable::stereopsis]; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td class="test-label"><span>Amplitude of Accommodation</td>
                                        <td><input class="form-control" type="text" <?php echo $disabled; ?> name="<?php echo 'data[details]['.VisualSkillsProfileTable::amplitude_of_accomodation.']'; ?>" value="<?php  if(isset($view_bag[VisualSkillsProfileTable::amplitude_of_accomodation])) echo $view_bag[VisualSkillsProfileTable::amplitude_of_accomodation]; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td class="test-label">Intra-ocular pressure</td>
                                        <td><input class="form-control" type="text" <?php echo $disabled; ?> name="<?php echo 'data[details]['.VisualSkillsProfileTable::intra_ocular_pressure.']';?>" value="<?php if (isset($view_bag[VisualSkillsProfileTable::intra_ocular_pressure])) echo $view_bag[VisualSkillsProfileTable::intra_ocular_pressure]; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td class="test-label">Central Visual Field</td>
                                        <td><input class="form-control" type="text" <?php echo $disabled; ?> name="<?php echo 'data[details]['.VisualSkillsProfileTable::central_visual_field.']';?>" value="<?php if (isset($view_bag[VisualSkillsProfileTable::central_visual_field])) echo $view_bag[VisualSkillsProfileTable::central_visual_field]; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td class="test-label">Others</td>
                                        <td><input class="form-control" type="text" <?php echo $disabled; ?> name="<?php echo 'data[details]['.VisualSkillsProfileTable::others.']';?>" value="<?php if (isset($view_bag[VisualSkillsProfileTable::others])) echo $view_bag[VisualSkillsProfileTable::others]; ?>"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <?php
                            if ($view_bag[VisualSkillsProfileTable::status_id] == 5 || $view_bag[VisualSkillsProfileTable::status_id] == 6){?>
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

<?php include('footer.php'); ?>

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