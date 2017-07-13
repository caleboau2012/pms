<?php
/**
 * Created by PhpStorm.
 * User: olajuwon
 * Date: 2/16/2015
 * Time: 1:10 PM
 */
require_once '../../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'PatientModel'));
Crave::requireFiles(CONTROLLER, array('PatientController', 'UserController'));


if(!isset($_SESSION[UserAuthTable::userid])){
    header("Location: ../../index.php");
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

    <title>Admin Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/bootstrap/jquery.dataTables.css" rel="stylesheet">
    <link href="../../css/bootstrap/datepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/print.css" media="print">
    <link href="../../css/sticky-footer-navbar.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../css/master.css" rel="stylesheet">
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
            <a class="navbar-brand" href="../dashboard.php">
                <?php
                if(is_null(CxSessionHandler::getItem('hospital_name'))){
                    echo "Patient Management System";
                }else{
                    echo ucwords(CxSessionHandler::getItem('hospital_name'));
                }
                ?>
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" class="label-default">Patients</a></li>
                <li><a href="staff.php">Staff</a></li>
                <li><a href="config.php">Config</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <img src="../../images/profile.png">
                        <?php echo ucwords(CxSessionHandler::getItem(ProfileTable::surname).' '.CxSessionHandler::getItem(ProfileTable::firstname))?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a href="../dashboard.php">Dashboard</a></li>
                        <li class="divider"></li>
                        <li role="presentation"><a href="../view-profile.php">View Profile</a></li>
                        <li role="presentation"><a href="#" id="sign-out">Sign out</a></li>
                    </ul>
                </li>
            </ul>
            <!--            <form class="navbar-form navbar-right">-->
            <!--                <input type="text" class="form-control" placeholder="Search...">-->
            <!--            </form>-->
        </div>
    </div>
</nav>

<script id="tmplTable" type="text/html">
    <tr>
        <td>{{sn}}</td>
        <td>{{regNo}}</td>
        <td class="text-capitalize">{{name}}</td>
        <td>{{dob}}</td>
        <td>
            <button class="btn btn-sm btn-default" patientId="{{patient_id}}" onclick="printDetails(this)">Print</button>
        </td>
        <td>
            <button class="btn btn-sm btn-default" patientId="{{patient_id}}" onclick="manage(this)">Manage</button>
        </td>
    </tr>
</script>

<script id="tmplPrint" type="text/html">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h2 class="panel-title">Profile</h2>

            <div>Personal Identification Info</div>
        </div>
        <div class="panel-body">
            <table class="table table-responsive">
                <tr>
                    <td class="form-inline">Name <br/>
                        <span name="name" class="btn btn-default text-capitalize">{{name}}</span>
                    </td>
                    <td class="form-inline">
                        <div>
                            Registration <br/>
                            <span name="regNo" class="btn btn-default">{{regNo}}</span>
                        </div>
                    </td>
                    <td>
                        <div>
                            Occupation <br/>
                            <span name="occupation" class="btn btn-default">{{occupation}}</span>
                        </div>
                    </td>
                    <td>
                        <div>
                            Registration Date <br/>
                            <span name="registration_date" class="btn btn-default">{{registration_date}}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="form-inline">
                        <div class="pull-left">Telephone<br/>
                            <span name="phone" class="btn btn-default">{{phone}}</span>
                        </div>
                    </td>
                    <td>
                        <div class="pull-left">GENDER <br/>
                            <span name="sex" class="btn btn-default">{{sex}}</span>
                        </div>
                    </td>
                    <td>
                        <div class="pull-left">Date of Birth <br/>
                            <span name="birth" class="btn btn-default">{{birth}}</span>
                        </div>
                    </td>
                    <td>
                        <div class="pull-left">Religion
                            <span class="btn btn-default">{{religion}}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Local Address <br/>
                        <span name="addy" class="btn btn-default">{{addy}}</span>
                    </td>
                    <td class="form-inline">
                        <div class="pull-left">Height(m) <br/>
                            <span name="height" class="btn btn-default">{{height}}</span>
                        </div>
                    </td>
                    <td>
                        <div class="pull-left">Weight(Kg) <br/>
                            <span name="weight" class="btn btn-default">{{weight}}</span>
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
                        <span name="nok_name" class="btn btn-default">{{nok_name}}</span>
                    </td>
                    <td class="form-inline">
                        <div class="pull-left">Phone number <br/>
                            <span class="btn btn-default">{{nok_telephone}}</span>
                        </div>
                    </td>
                    <td>
                        <div class="pull-left">Relationship <br/>
                            <span class="btn btn-default">{{nok_relationship}}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Contact address <br/>
                        <span name="nok_address" class="btn btn-default">{{nok_address}}</span>
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
                            <span class="btn btn-default">{{citizenship}}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="form-inline">
                        <div class="pull-left">
                            Allergies: <br>
                            <span class="btn btn-default">{{allergies}}</span>
                        </div>
                    </td>
                    <td class="form-inline">
                        <div class="pull-left">
                            Medical History <br>
                            <span class="btn btn-default">{{medical_history}}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="form-inline">
                        <div class="pull-left">Alcohol Usage <br>
                            <span class="btn btn-default">{{alcohol_usage}}</span>
                        </div>
                        <div class="pull-left">Tobacco Usage <br>
                            <span class="btn btn-default">{{tobacco_usage}}</span>
                        </div>
                    </td>
                    <td class="form-inline">
                        <div class="pull-left">Family History <br>
                            <span class="btn btn-default">{{family_history}}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="form-inline">
                        <div class="pull-left">Surgical History <br>
                            <span class="btn btn-default">{{surgical_history}}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
                <li id="newStaff"><a href="#" data-toggle="modal" data-backdrop="static" data-target="#newPatientModal">Add new Patient</a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="table-responsive">
                <table class="table dataTable table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Registration No</th>
                        <th>Name </th>
                        <th>DOB</th>
                        <th>Print Details</th>
                        <th>Manage Details</th>
                    </tr>
                    </thead>
                    <tbody id="patientsTable">
                    </tbody>
                </table>
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
                                                <input list="regNos" name="<?php echo PatientTable::regNo ?>" class="form-control <?php echo PatientTable::regNo ?>" placeholder='Registration No' aria-describedby="verify">
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
                                            <input name="<?php echo PatientTable::registration_date ;?>" class="date-picker form-control" required/>
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
                                            <input name="<?php echo PatientTable::birth_date ;?>" class="date-picker form-control" required/>
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

<!-- Manage Patient Modal -->
<div class="modal fade" id="managePatientModal" tabindex="-1" role="dialog" aria-labelledby="newPatientModal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="managePatientForm" class="form-group">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Manage Patient</h4>
                    <p>Emergency patients get upgraded, Normal patients get updated</p>
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
                                        <input class="hidden" name="<?php echo PatientTable::patient_id ?>"/>
                                        <input class="form-control" name="<?php echo PatientTable::surname ?>" placeholder="Surname" required/>
                                        <input class="form-control" name="<?php echo PatientTable::firstname ?>" placeholder="Firstname" required/>
                                        <input class="form-control" name="<?php echo PatientTable::middlename ?>" placeholder="Middlename" required/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">
                                            Registration <br/>
                                            <div class="input-group">
                                                <input list="regNos" name="<?php echo PatientTable::regNo ?>" class="form-control <?php echo PatientTable::regNo ?>" placeholder='Registration No' aria-describedby="verify">
                                                <span class="btn btn-info input-group-addon verify">Verify</span>
                                            </div>
                                        </div>
                                        <div class="pull-left">
                                            Occupation <br/>
                                            <input name="<?php echo PatientTable::occupation ;?>" class="form-control" required/>
                                        </div>
                                        <div class="pull-left">
                                            Registration Date <br/>
                                            <input name="<?php echo PatientTable::registration_date ;?>" class="date-picker form-control" required/>
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
                                            <input type="date" name="<?php echo PatientTable::birth_date ;?>" class="form-control" required/>
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
                                            <select name="<?php echo PatientTable::hmo ;?>" required class="form-control" required>
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
                                            <label class="label label-default">Citizenship</label>
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
                                            <textarea id="family_history" name="<?php echo PatientTable::family_history ;?>" class="form-control" required></textarea>
                                        </div>
                                    </td>
                                    <td class="form-inline">
                                        <div class="pull-left">
                                            <label for="surgical_history">Surgical History</label><br>
                                            <textarea id="surgical_history" name="<?php echo PatientTable::surgical_history ;?>" class="form-control" required>
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
                    <button class="btn btn-primary" type="submit">Update Patient</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../../js/bootstrap/jquery-1.10.2.min.js"></script>
<script src="../../js/bootstrap/jquery.dataTables.js"></script>
<script src="../../js/bootstrap/bootstrap.min.js"></script>
<script src="../../js/bootstrap/bootstrap-datepicker.min.js"></script>
<script src="../../js/constants.js"></script>
<script src="../../js/libs/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="../../js/pinger.js"></script>
<script src="../../js/profile.js"></script>
<script src="../../js/admin/patients.js"></script>

<?php include('../footer.php'); ?>

</body>
</html>