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
                    <table class="table table-stripped table--bordered dataTable">
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
                        <tr class="odd">
                            <td>No data available</td>
                        </tr>
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
            <select id="type" class="form-control" name="test_id">
                <option value="5">RADIOLOGY</option>
                <option value="2">HAEMATOLOGY</option>
                <option value="3">XRAY</option>
                <option value="4">VISUAL SKILL PROFILE</option>
                <option value="15">CHEMICAL PATHOLOGY</option>
                <option value="16">PARASITOLOGY</option>
            </select>
        </div>

        <div class="col-sm-3">
            <br/>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <label>Pending Test</label>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-success">Patient's name</li>
                    </ul>
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
<script src="../js/bootstrap/jquery-ui.min.js"></script>
<script src="../js/constants.js"></script>
</body>
</html>