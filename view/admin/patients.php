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
if(!isset($_SESSION[UserAuthTable::userid])){
    header("Location: ../index.php");
}
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
    <link rel="stylesheet" href="../../css/print.css" media="print">

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
            <a class="navbar-brand" href="../dashboard.php">Patient Management System</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" class="label-default">Patients</a></li>
                <li><a href="staff.php">Staff</a></li>
                <li><a href="config.php">Config</a></li>
                <li class="dropdown navbar-right-text pointer">
                    <span class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                    <img src="../../images/profile.png">
                    <span>
                        <?php echo ucwords(CxSessionHandler::getItem(ProfileTable::surname).' '.CxSessionHandler::getItem(ProfileTable::firstname))?>
                        <span class="caret"></span>
                     </span>
                    </span>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a href="../dashboard.php">Dashboard</a></li>
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
        <td>{{name}}</td>
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
    <div class="row">
        <div class="pull-left" style="margin: 10px;">
            <label for="name" class="label label-primary">Name</label>
            <span name="name" class="btn btn-default">{{name}}</span>
        </div>
        <div class="pull-right" style="margin: 10px;">
            <label for="regNo" class="label label-primary">Registration No</label>
            <span name="regNo" class="btn btn-default">{{regNo}}</span>
        </div>
    </div>
    <div class="row">
        <div class="pull-left" style="margin: 10px;">
            <label for="addy" class="label label-info">Address</label>
            <span name="addy" class="btn btn-default">{{addy}}</span>
        </div>
        <div class="pull-left" style="margin: 10px;">
            <label for="phone" class="label label-info">Telephone</label>
            <span name="phone" class="btn btn-default">{{phone}}</span>
        </div>
        <div class="pull-right" style="margin: 10px;">
            <label for="sex" class="label label-info">Gender</label>
            <span name="sex" class="btn btn-default">{{sex}}</span>
        </div>
    </div>
    <div class="row">
        <div class="pull-left" style="margin: 10px;">
            <label for="height" class="label label-info">Height</label>
            <span name="height" class="btn btn-default">{{height}}</span>
        </div>
        <div class="pull-left" style="margin: 10px;">
            <label for="weight" class="label label-info">Weight</label>
            <span name="weight" class="btn btn-default">{{weight}}</span>
        </div>
        <div class="pull-right" style="margin: 10px;">
            <label for="birth" class="label label-info">Birth Date</label>
            <span name="birth" class="btn btn-default">{{birth}}</span>
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
                                            Registration <br/>
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
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">Height(m) <br/>
                                            <input name="<?php echo PatientTable::height ;?>" class="form-control" required/>
                                        </div>
                                        <div class="pull-left">Weight(Kg) <br/>
                                            <input name="<?php echo PatientTable::weight ;?>" class="form-control" required/>
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
                            <h2 class="panel-title">Demographic</h2>
                            <div>Family Background Info</div>
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
                                        <div class="pull-left">Religion
                                            <select name="<?php echo PatientTable::religion ;?>" class="form-control">
                                                <option value="" selected="selected">Select One...</option>
                                                <option value="ISLAM">ISLAM</option>
                                                <option value="CHRISTAINITY">CHRISTAINITY</option>
                                                <option value="OTHERS">OTHERS</option>
                                            </select>
                                        </div>
                                        <div class="pull-left">
                                            position in family:
                                            <select name="<?php echo PatientTable::family_position ;?>" required class="form-control">
                                                <option value="">Choose position...</option>
                                                <option value="1">1st</option>
                                                <option value="2">2nd</option>
                                                <option value="3">3rd</option>
                                                <option value="4">4th</option>
                                                <option value="5">5th</option>
                                                <option value="6">6th</option>
                                                <option value="7">7th</option>
                                                <option value="8">8th</option>
                                                <option value="9">9th</option>
                                                <option value="10">10th</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">
                                            Mother is
                                            <select name="<?php echo PatientTable::mother_status ;?>" required class="form-control">
                                                <option value="" >Select One...</option>
                                                <option value="ALIVE">Alive</option>
                                                <option value="DEAD">Deceased</option>
                                            </select>
                                        </div>
                                        <div class="pull-left">
                                            father is
                                            <select name="<?php echo PatientTable::father_status ;?>" required class="form-control">
                                                <option value="">Select One...</option>
                                                <option value="ALIVE">Alive</option>
                                                <option value="DEAD">Deceased</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">Marital Status
                                            <select name="<?php echo PatientTable::marital_status ;?>" required class="form-control">
                                                <option value="">Choose martial status...</option>
                                                <option value="SINGLE">SINGLE</option>
                                                <option value="MARRIED">MARRIED</option>
                                                <option value="DIVORCED">DIVORCED</option>
                                                <option value="SEPERATED">SEPERATED</option>
                                                <option value="WIDOWED">WIDOWED</option>
                                            </select>
                                        </div>
                                        <div class="pull-left">No of children
                                            <select name="<?php echo PatientTable::no_of_children ;?>" class="form-control">
                                                <option value="0">None</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
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
    <div class="modal-dialog">
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
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">Height(m) <br/>
                                            <input name="<?php echo PatientTable::height ;?>" class="form-control" required/>
                                        </div>
                                        <div class="pull-left">Weight(Kg) <br/>
                                            <input name="<?php echo PatientTable::weight ;?>" class="form-control" required/>
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
                            <h2 class="panel-title">Demographic</h2>
                            <div>Family Background Info</div>
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
                                        <div class="pull-left">Religion
                                            <select name="<?php echo PatientTable::religion ;?>" class="form-control">
                                                <option value="" selected="selected">Select One...</option>
                                                <option value="ISLAM">ISLAM</option>
                                                <option value="CHRISTAINITY">CHRISTAINITY</option>
                                                <option value="OTHERS">OTHERS</option>
                                            </select>
                                        </div>
                                        <div class="pull-left">
                                            position in family:
                                            <select name="<?php echo PatientTable::family_position ;?>" required class="form-control">
                                                <option value="">Choose position...</option>
                                                <option value="1">1st</option>
                                                <option value="2">2nd</option>
                                                <option value="3">3rd</option>
                                                <option value="4">4th</option>
                                                <option value="5">5th</option>
                                                <option value="6">6th</option>
                                                <option value="7">7th</option>
                                                <option value="8">8th</option>
                                                <option value="9">9th</option>
                                                <option value="10">10th</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">
                                            Mother is
                                            <select name="<?php echo PatientTable::mother_status ;?>" required class="form-control">
                                                <option value="" >Select One...</option>
                                                <option value="ALIVE">Alive</option>
                                                <option value="DEAD">Deceased</option>
                                            </select>
                                        </div>
                                        <div class="pull-left">
                                            father is
                                            <select name="<?php echo PatientTable::father_status ;?>" required class="form-control">
                                                <option value="">Select One...</option>
                                                <option value="ALIVE">Alive</option>
                                                <option value="DEAD">Deceased</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">Marital Status
                                            <select name="<?php echo PatientTable::marital_status ;?>" required class="form-control">
                                                <option value="">Choose martial status...</option>
                                                <option value="SINGLE">SINGLE</option>
                                                <option value="MARRIED">MARRIED</option>
                                                <option value="DIVORCED">DIVORCED</option>
                                                <option value="SEPERATED">SEPERATED</option>
                                                <option value="WIDOWED">WIDOWED</option>
                                            </select>
                                        </div>
                                        <div class="pull-left">No of children
                                            <select name="<?php echo PatientTable::no_of_children ;?>" class="form-control">
                                                <option value="0">None</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
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
<script src="../../js/constants.js"></script>
<script type="text/javascript" src="../../js/pinger.js"></script>
<script src="../../js/admin/patients.js"></script>
</body>
</html>