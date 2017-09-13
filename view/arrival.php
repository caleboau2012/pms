<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'PatientModel'));
Crave::requireFiles(CONTROLLER, array('PatientController', 'UserController'));


if(!isset($_SESSION[UserAuthTable::userid])){
    header("Location: ../index.php");
}
$patientController = new PatientController();
$hmos = $patientController->getAllHMO();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Patient Arrival</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap/jquery-ui.css" rel="stylesheet">
    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
    <link href="../css/bootstrap/datepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/print.css" media="print">


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
            <a class="navbar-brand" href="dashboard.php">
                <?php
                if(is_null(CxSessionHandler::getItem('hospital_name'))){
                    echo "Patient Management System";
                }else{
                    echo ucwords(CxSessionHandler::getItem('hospital_name'));
                }
                ?>
            </a>
            <span id="search-loader" class="hidden fa fa-spin fa-spinner text-warning"></span>

        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right nav-pills">
                <li><a href="#" data-toggle="modal" data-target="#newPatientModal">New Patient</a></li>
                <li><a href="#" onclick="emergency()"><span class="text-danger">Emergency</span></a></li>
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
            <form id="search-form" class="patient-arrival navbar-form">
                <div class="search text-center">
                    <input id="search_query" type="text" class="form-control" name="search" placeholder="Search Returning Patients...">
                    <span id="search-empty-text" class="hidden help-block text-danger" style="line-height: 5px;">No patient found</span>
                </div>
            </form>
        </div>
    </div>
</nav>

<script id="tmplPatients" type="text/html">
    <div class="panel {{status}} patient">
        <div class="panel-heading" role="tab" id="heading{{patientid}}">
            <h4 class="panel-title">
                <button type="button" class="close remove-patient"><span class="fa fa-close"></span></button>
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion{{userid}}"
                   href="#collapse{{patientid}}" aria-expanded="false" aria-controls="collapse{{patientid}}">
                    {{regNo}}
                </a>
            </h4>
        </div>
        <div id="collapse{{patientid}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{patientid}}">
            <div class="panel-body">
                <p>{{name}}</p>
                <p>{{sex}}</p>
                <p class="hidden">{{regNo}}</p>
                <span class="patientid hidden">{{patientid}}</span>
                <span class="doctorid hidden">{{userid}}</span>
                <button class="btn btn-success btn-block" onclick="openVitalsModal(this)">Vitals</button>
            </div>
        </div>
    </div>
</script>

<script id="tmplDoctor" type="text/html">
    <div class="col-sm-6 col-md-4">
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

<div class="container-fluid page">
    <div class="row">
        <div class="col-sm-4 col-md-3">
            <div class="panel panel-default doctor general">
                <div class="panel-heading">
                    <h2 class="panel-title">General Queue</h2>
                </div>
                <div class="panel-body patients">
                    <span class="to_doctor" hidden></span>
                    <div class="panel-group drop" id="accordion0" role="tablist" aria-multiselectable="true">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8 col-md-9">
            <div id="masonry" class="row">
            </div>
        </div>
    </div>
</div>

<!-- New Patient Modal -->
<div class="modal fade" id="newPatientModal" tabindex="-1" role="dialog" aria-labelledby="newPatientModal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="newPatientForm" name="newPatientForm" class="form-group">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">New Patient</h4>
                </div>
                <div class="modal-body">
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
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2 class="panel-title">Profile</h2>

                            <div>Personal Identification Info</div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="form-inline">Name <br/>
                                        <input class="form-control" name="<?php echo PatientTable::surname ?>" placeholder="Surname" required/>
                                        <input class="form-control" name="<?php echo PatientTable::firstname ?>" placeholder="Firstname" required/>
                                        <input class="form-control" name="<?php echo PatientTable::middlename ?>" placeholder="Middlename" required/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">
                                            Registration No.<br/>
                                            <div class="input-group">
                                                <input id="regNo" list="regNos" name="<?php echo PatientTable::regNo ?>" class="form-control <?php echo PatientTable::regNo ?>" placeholder='Registration No' aria-describedby="verify">
                                                <span class="btn btn-info input-group-addon verify">Verify</span>
                                                <datalist id="regNos"></datalist>
                                            </div>
                                        </div>
                                        <div class="pull-left">
                                            Occupation <br/>
                                            <input name="<?php echo PatientTable::occupation ;?>" class="form-control" required/>
                                        </div>
                                        <div class="pull-left">
                                            Registration Date <br/>
                                            <input name="<?php echo PatientTable::registration_date ;?>" class="date-picker form-control" required placeholder="yyyy-mm-dd"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Local Address <br/>
                                        <input name="<?php echo PatientTable::home_address ;?>" class="form-control" required/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">Telephone<br/>
                                            <input class="form-control" name="<?php echo  PatientTable::telephone ;?>" required/>
                                        </div>
                                        <div class="pull-left">GENDER <br/>
                                            <select class="form-control" name="<?php echo PatientTable::sex ;?>" required>
                                                <option value="">Choose one...</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="pull-left">Date of Birth <br/>
                                            <input name="<?php echo PatientTable::birth_date ;?>" class="date-picker form-control" required placeholder="yyyy-mm-dd"/>
                                        </div>
                                        <div class="pull-left">Religion <br>
                                            <select name="<?php echo PatientTable::religion ;?>" class="form-control">
                                                <option value="" selected="selected">Select One...</option>
                                                <option value="ISLAM">ISLAM</option>
                                                <option value="CHRISTAINITY">CHRISTAINITY</option>
                                                <option value="OTHERS">OTHERS</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">Marital Status <br/>
                                            <select name="<?php echo PatientTable::marital_status ;?>" required class="form-control">
                                                <option value="">Choose martial status...</option>
                                                <option value="SINGLE">SINGLE</option>
                                                <option value="MARRIED">MARRIED</option>
                                                <option value="DIVORCED">DIVORCED</option>
                                                <option value="SEPERATED">SEPERATED</option>
                                                <option value="WIDOWED">WIDOWED</option>
                                            </select>
                                        </div>
                                        <div class="pull-left">Height(m) <br/>
                                            <input name="<?php echo PatientTable::height ;?>" class="form-control" required/>
                                        </div>
                                        <div class="pull-left">Weight(Kg) <br/>
                                            <input name="<?php echo PatientTable::weight ;?>" class="form-control" required/>
                                        </div>
                                        <div class="pull-left">HMO<br/>
                                            <select name="<?php echo PatientTable::hmo ;?>" required class="form-control">
                                                <?php
                                                foreach ($hmos as $hmo){
                                                    echo "<option value='". $hmo['id'] ."'>". $hmo['name'] ."</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h2 class="panel-title">Next of Kin</h2>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="form-inline">Name <br/>
                                        <input name="<?php echo PatientTable::nok_surname ;?>" placeholder="Surname" class="form-control" required/>
                                        <input name="<?php echo PatientTable::nok_firstname ;?>" class="form-control" placeholder="First Name" required/>
                                        <input name="<?php echo PatientTable::nok_middlename ;?>" class="form-control" placeholder="Middle Name" required/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Contact address <br/>
                                        <input name="<?php echo PatientTable::nok_address ;?>" class="form-control" required/></td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">Phone number <br/>
                                            <input name="<?php echo PatientTable::nok_telephone ;?>" class="form-control"/>
                                        </div>
                                        <div class="pull-left">Relationship <br/>
                                            <select name="<?php echo PatientTable::nok_relationship ;?>" class="form-control" required>
                                                <option value="">Choose relation...</option>
                                                <option value="1">Father</option>
                                                <option value="2">Mother</option>
                                                <option value="3">Son</option>
                                                <option value="4">Daughter</option>
                                                <option value="5">Brother</option>
                                                <option value="6">Sister</option>
                                                <option value="7">Husband</option>
                                                <option value="8">Wife</option>
                                                <option value="9">Other</option>
                                            </select></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">Medical / Social History</h2>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">
                                            Citizenship:
                                            <label class="label label-success">Nigerian</label>
                                            <input checked id="naija" type="checkbox" class="naija form-control checkbox">
                                        </div>
                                        <div class="pull-left non-naija" style="display: none;">
                                            <label class="label label-default">Others? Please specify:</label>
                                            <input name="<?php echo PatientTable::citizenship ;?>" class="form-control"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">
                                            <label for="allergies">Allergies</label><br>
                                            <textarea id="allergies" name="<?php echo PatientTable::allergies ;?>" class="form-control"></textarea>
                                        </div>
                                    </td>
                                    <td class="form-inline">
                                        <div class="pull-left">
                                            <label for="med_history">Medical History</label><br>
                                            <textarea id="med_history" name="<?php echo PatientTable::medical_history ;?>" class="form-control"></textarea>
                                        </div>
                                    </td>
                                    <td class="form-inline">
                                        <div class="pull-left">
                                            <label for="alcohol_usage">Alcohol Usage</label><br>
                                            <textarea id="alcohol_usage" name="<?php echo PatientTable::alcohol_usage ;?>" class="form-control"></textarea>
                                        </div>
                                    </td>
                                    <td class="form-inline">
                                        <div class="pull-left">
                                            <label for="tobacco_usage">Tobacco Usage</label><br>
                                            <textarea id="tobacco_usage" name="<?php echo PatientTable::tobacco_usage ;?>" class="form-control"></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">
                                            <label for="family_history">Family History</label><br>
                                            <textarea id="family_history" name="<?php echo PatientTable::family_history ;?>" class="form-control"></textarea>
                                        </div>
                                    </td>
                                    <td class="form-inline">
                                        <div class="pull-left">
                                            <label for="surgical_history">Surgical History</label><br>
                                            <textarea id="surgical_history" name="<?php echo PatientTable::surgical_history ;?>" class="form-control">
                                            </textarea>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span id="loader" class="fa fa-spinner fa-spin hidden"></span>
                    <button class="btn btn-primary" type="submit">Add Patient</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Vitals Modal -->
<div class="modal fade" id="vitalsModal" tabindex="-1" role="dialog" aria-labelledby="vitalsModal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add Vitals of Patient</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h2 class="panel-title" id="patientName"></h2>
                        <p id="patientRegNo"></p>
                    </div>
                    <div class="panel-body">
                        <div class="div-rounded encounter-icon">
                            <span class="fa fa-stethoscope"></span>
                        </div>
                        <form name="vitalsForm">
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
                            <div class="form-group">
                                <input class="hidden" name="<?php echo PatientTable::patient_id;?>">
                                <div class="col-sm-6">
                                    <label for="temp">Temperature</label>
                                    <input type="text" class="form-control" name="temp">
                                </div>
                                <div class="col-sm-6">
                                    <label for="pulse">Pulse</label>
                                    <input type="text" class="form-control" name="pulse">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="respiratory_rate">Respiratoty Rate</label>
                                    <input type="text" class="form-control" name="respiratory_rate">
                                </div>
                                <div class="col-sm-6">
                                    <label for="blood_pressure">Blood Pressure</label>
                                    <input type="text" class="form-control" name="blood_pressure">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="height">Height</label>
                                    <input type="text" class="form-control" name="height">
                                </div>
                                <div class="col-sm-6">
                                    <label for="weight">Weight</label>
                                    <input type="text" class="form-control" name="weight">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="height">Var</label>
                                    <input type="text" class="form-control" name="var">
                                </div>
                                <div class="col-sm-6">
                                    <label for="weight">Val</label>
                                    <input type="text" class="form-control" name="val">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="bmi">BMI</label>
                                    <input type="text" class="form-control" id="bmi" name="bmi">
                                </div>
                                <div class="col-sm-6">
                                    <br>
                                    <input type="submit" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                        <div id="loading" class="text-center hidden"><span class="fa fa-spinner fa-spin"></span> </div>
                        <div class="text-center hidden" id="response"><p class="text-danger">undefined</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/bootstrap/jquery-1.10.2.min.js"></script>
<script src="../js/bootstrap/jquery.dataTables.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/bootstrap/bootstrap-datepicker.min.js"></script>
<script src="../js/constants.js"></script>
<script src="../js/bootstrap/jquery-ui.min.js"></script>
<script src="../js/libs/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="../js/constants.js"></script>
<script src="../js/libs/masonry.js"></script>
<script src="../js/arrival.js"></script>



<?php include('footer.php'); ?>
</body>
</html>