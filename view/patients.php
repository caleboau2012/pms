<?php
/**
 * Created by PhpStorm.
 * User: olajuwon
 * Date: 2/16/2015
 * Time: 1:10 PM
 */
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
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
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">
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
            <a class="navbar-brand" href="#">Patient Management System</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" class="label-default">Patients</a></li>
                <li><a href="staff.php">Staff</a></li>
                <li><a href="#">Config</a></li>
                <li class="dropdown navbar-right-text pointer">
                    <span class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                    <img src="../images/profile.png">
                    <span>
                        <?php echo ucwords(CxSessionHandler::getItem(ProfileTable::surname).' '.CxSessionHandler::getItem(ProfileTable::firstname))?>
                        <span class="caret"></span>
                     </span>
                    </span>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a href="dashboard.php">Dashboard</a></li>
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
        <td>{{patientId}}</td>
        <td>{{name}}</td>
        <td>{{dob}}</td>
        <td><button class="btn btn-sm btn-default" patientId="{{patient_id}}" onclick="printDetails(this)">Print</button></td>
    </tr>
</script>

<script id="tmplPrint" type="text/html">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h1 class="panel-title">Patient Details</h1>
            </div>
            <div class="panel-body">
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
            </div>
        </div>
    </div>
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="table-responsive">
                <table class="table dataTable table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient ID</th>
                        <th>Name </th>
                        <th>DOB</th>
                        <th>Print Details</th>
                    </tr>
                    </thead>
                    <tbody id="patientsTable">
                    <tr>
                        <td>1</td>
                        <td>Lorem</td>
                        <td>ipsum</td>
                        <td><button class="btn btn-sm btn-default" userid="1" onclick="rapModal(this)">Manage</button></td>
                    </tr>
                    </tbody>
                </table>
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
<script src="../js/constants.js"></script>
<script src="../js/admin/patients.js"></script>
</body>
</html>