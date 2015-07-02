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

    <!-- Custom styles for this template -->
    <link href="../../css/master.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/print.css" media="print">
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
        <div class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">
                <li><a href="patients.php">Patients</a></li>
                <li><a href="staff.php">Staff</a></li>
                <li><a href="config.php" class="label-default">Config</a></li>
                <li>
                    <a href="../mails.php">
                        <span class="fa fa-envelope"></span>
                        <sup class="badge notification message_unread"></sup>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <img src="../../images/profile.png">
                        <?php echo ucwords(CxSessionHandler::getItem(ProfileTable::surname).' '.CxSessionHandler::getItem(ProfileTable::firstname))?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a href="../dashboard.php">Dashboard</a></li>
                        <li role="presentation"><a href="#" id="sign-out">Sign out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div id="setup-container">
            <div class="bg-info text-center" id="setup-heading">
                <h4>PMS Setup</h4>
            </div>
            <div id="setup-nav">

                <div class="col-xs-3 pointer setup-nav-active steps text-center" id="step--info">
                    Info
                </div>
                <div class="col-xs-3  pointer steps text-center" id="step--drugs">
                    Drugs
                </div>
                <div class="col-xs-3 pointer  steps text-center" id="step--bills">
                    Bills
                </div>
                <div class="clearfix"></div>
            </div>
            <div id="response"></div>
            <div class="steps_content" id="step--info_content">
                <form class="form-horizontal form-setup" id="step_info_form">
                    <input type="hidden" name="intent" value="addHospitalInfo">

<!--                    <h4 class="text-info text-center">Hospital Info</h4>-->
                    <div class="form-group">
                        <label for="hos_name" class="col-sm-4 control-label">Hospital Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="hos_name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hos_add" class="col-sm-4 control-label">Hospital Address</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="hos_add" required></textarea>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-10">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="steps_content hidden" id="step--drugs_content">
                <form class="form-horizontal form-setup" id="step_drug_units_form">
                    <p class="small text-danger text-center" id="step-2-response"></p>

                    <div class="form-group step-2-form-group">
                        <label for="drug_unit" class="col-sm-4 control-label">Drug Unit</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="drug_unit">
                        </div>
                    </div>
                    <div class="form-group step-2-form-group">
                        <label for="drug_symbol" class="col-sm-4 control-label">Drug Symbol</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="drug_symbol">
                            <a href="#" class="text-primary small" id="add-unit" title="Enter each units used, then click on the add more">Add unit</a>
                            <ol class="text-muted small" id="units-list">
                                <p class="small text-muted text-center units-indicator">No unit added yet</p>
                            </ol>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-10">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="steps_content hidden" id="step--bills_content">
                <h4 class="text-center text-info" style="margin: 0; margin-bottom: 0.5em;">
                    Add the basic hospital bills
                </h4>
                <form class="form-horizontal form-setup" id="step_three_form">
                    <div class="form-group bill-form-group" id="bill-name-input">
                        <label for="bill-name" class="col-sm-4 control-label">Bill Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="bill-name">
                            <p class="small text-danger form-response" id="bill-name-response"></p>

                        </div>
                    </div>
                    <div class="form-group bill-form-group" id="bill-cost-input">
                        <label for="bill-cost" class="col-sm-4 control-label">Bill Cost</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="bill-cost">
                            <p class="small text-danger form-response" id="bill-cost-response"></p>
                            <a href="#" class="text-primary small" id="add-bill">Add Bill</a>
                            <ol class="text-muted small" id="bill-list">
                                <p class="small text-muted text-center units-indicator">No bill added yet</p>
                            </ol>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-10">
                            <button type="submit" class="btn btn-primary disabled" id="add-bill-btn">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div> <!-- /container -->

</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../../js/bootstrap/jquery-1.10.2.min.js"></script>
<script src="../../js/bootstrap/bootstrap.min.js"></script>
<script src="../../js/constants.js"></script>
<script type="text/javascript" src="../../js/pinger.js"></script>
<script type="text/javascript" src="../../js/EditSetup.js"></script>

</body>
</html>