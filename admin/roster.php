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

    <!-- Custom styles for this template -->
    <link href="../css/master.css" rel="stylesheet">
    <link href="../css/bootstrap/datepicker.css" rel="stylesheet">

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
                <li><a href="#" class="label-default">Roster</a></li>
            </ul>
            <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Search...">
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">
<div class="row">
<div class="col-sm-3 col-md-2 roster-sidebar">
    <ul class="nav r-nav-sidebar">
        <li class="active nav-link" id="nav-link-1">
            <a href="#">
                Start new week
            </a>
        </li>
        <li class="nav-link" id="nav-link-2"><a href="#">Overview</a></li>
    </ul>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<div class="nav-link-content" id="nav-link-1-content">
    <div class="accordion" id="accordion1">
    <div class="accordion-group col-sm-4 col-md-3" id="acc">
    <div class="accordion-heading">
        <a class="accordion-toggle" href="#all_staffs" data-toggle="collapse" data-parent="#accordion1">
                    <span>
                        ALL STAFF
                        <div class="pull-right pin"></div>
                    </span>
            <div class="clearfix"></div>
        </a>
    </div>

    <div id="all_staffs" class="accordion-body collapse in">
        <div class="accordion-inner">
            <div class="accordion-inner-head">
                <h4 class="text-center text-uppercase">Doctors</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff-all">
                    Adebayo Moses 1
                </li>
                <li class="list-group-item list-group-item-text staff-all">
                    Adebayo Moses
                </li>
            </ul>

            <div class="accordion-inner-head">
                <h4>Pharmacist</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff-all">
                    Adebayo Moses 1
                </li>
                <li class="list-group-item list-group-item-text staff-all">
                    Adebayo Moses
                </li>
                <li class="list-group-item list-group-item-text staff-all">
                    Adebayo Moses
                </li>
                <li class="list-group-item list-group-item-text staff-all">
                    Adebayo Moses
                </li>
            </ul>

            <div class="accordion-inner-head">
                <h4>Medical Record</h4>
            </div>

            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff-all">
                    Adebayo Moses 1
                </li>
                <li class="list-group-item list-group-item-text staff-all">
                    Adebayo Moses
                </li>
                <li class="list-group-item list-group-item-text staff-all">
                    Adebayo Moses
                </li>
            </ul>
        </div>
    </div>
</div>

    <div class="col-md-3 accordion-group roster-date">
        <div class="roster-form ">
            <span class="text-muted">Start Date</span>
            <input type="text" class="date-picker edit-read-only" readonly id="start_date"  placeholder="YYYY-MM-DD">
        </div>
    </div>
    <div class="accordion-group col-md-3 roster-date">
        <div class="roster-form">
            <span class="text-muted">End Date</span>
            <input type="text"  class="date-picker edit-read-only" readonly id="end_date" placeholder="YYYY-MM-DD">
        </div>
    </div>
<!--
        *******LIST OF ROLES*************

-->
    <div class="accordion-group col-sm-4 col-md-3">
        <div class="accordion-heading">
            <a class="accordion-toggle" href="#doctors-list" data-toggle="collapse" data-parent="#accordion1">
                        <span>
                            Doctor
                            <div class="pin pull-right"></div>
                        </span>
                <div class="clearfix"></div>
            </a>
        </div>
        <div class="accordion-body collapse in" id="doctors-list">
            <div class="accordion-inner">
                <p class="text-warning text-center">
                    No staff assigned yet!
                </p>
            </div>
        </div>
    </div>

    <div class="accordion-group col-sm-4 col-md-3">
        <div class="accordion-heading">
            <a class="accordion-toggle" href="#medical-list" data-toggle="collapse" data-parent="#accordion1">
                        <span>
                            Medical Records
                            <div class="pin pull-right"></div>
                        </span>
                <div class="clearfix"></div>
            </a>
        </div>
        <div class="accordion-body collapse in" id="medical-list">
            <div class="accordion-inner">
                <p class="text-warning text-center">
                    No staff assigned yet!
                </p>
            </div>
        </div>
    </div>

    <div class="accordion-group col-sm-4 col-md-3">
        <div class="accordion-heading">
            <a class="accordion-toggle" href="#pharmacy-list" data-toggle="collapse" data-parent="#accordion1">
                        <span>
                            Pharmacy
                            <div class="pin pull-right"></div>
                        </span>
                <div class="clearfix"></div>
            </a>
        </div>
        <div class="accordion-body collapse in" id="pharmacy-list">
            <div class="accordion-inner">
                <p class="text-warning text-center">
                    No staff assigned yet!
                </p>
            </div>
        </div>
    </div>

    <div class="accordion-group col-sm-4 col-md-3">
        <div class="accordion-heading">
            <a class="accordion-toggle" href="#urine-lab-list" data-toggle="collapse" data-parent="#accordion1">
                        <span>
                            Urine Laboratory
                            <div class="pin pull-right"></div>
                        </span>
                <div class="clearfix"></div>
            </a>
        </div>
        <div class="accordion-body collapse in" id="urine-lab-list">
            <div class="accordion-inner">
                <p class="text-warning text-center">
                    No staff assigned yet!
                </p>
            </div>
        </div>
    </div>

    <div class="accordion-group col-sm-4 col-md-3">
        <div class="accordion-heading">
            <a class="accordion-toggle" href="#parasitology-lab-list" data-toggle="collapse" data-parent="#accordion1">
                        <span>
                            Parasitology Laboratory
                            <div class="pin pull-right"></div>
                        </span>
                <div class="clearfix"></div>
            </a>
        </div>
        <div class="accordion-body collapse in" id="parasitology-lab-list">
            <div class="accordion-inner">
                <p class="text-warning text-center">
                    No staff assigned yet!
                </p>
            </div>
        </div>
    </div>

    <div class="accordion-group col-sm-4 col-md-3">
        <div class="accordion-heading">
            <a class="accordion-toggle" href="#chemical-lab-list" data-toggle="collapse" data-parent="#accordion1">
                        <span>
                            Chemical Pathology Lab
                            <div class="pin pull-right"></div>
                        </span>
                <div class="clearfix"></div>
            </a>
        </div>
        <div class="accordion-body collapse in" id="chemical-lab-list">
            <div class="accordion-inner">
                <p class="text-warning text-center">
                    No staff assigned yet!
                </p>
            </div>
        </div>
    </div>

    <div class="accordion-group col-sm-4 col-md-3">
        <div class="accordion-heading">
            <a class="accordion-toggle" href="#visual-lab-list" data-toggle="collapse" data-parent="#accordion1">
                        <span>
                            Visual Laboratory
                            <div class="pin pull-right"></div>
                        </span>
                <div class="clearfix"></div>
            </a>
        </div>
        <div class="accordion-body collapse in" id="visual-lab-list">
            <div class="accordion-inner">
                <p class="text-warning text-center">
                    No staff assigned yet!
                </p>
            </div>
        </div>
    </div>

    <div class="accordion-group col-sm-4 col-md-3">
        <div class="accordion-heading">
            <a class="accordion-toggle" href="#xray-lab-list" data-toggle="collapse" data-parent="#accordion1">
                        <span>
                            Xray Laboratory
                            <div class="pin pull-right"></div>
                        </span>
                <div class="clearfix"></div>
            </a>
        </div>
        <div class="accordion-body collapse in" id="xray-lab-list">
            <div class="accordion-inner">
                <p class="text-warning text-center">
                    No staff assigned yet!
                </p>
            </div>
        </div>
    </div>


</div>
</div>
<div class="nav-link-content hidden" id="nav-link-2-content">
<div class="accordion" id="accordion2">
<div class="accordion-group col-sm-4 col-md-3">
    <div class="accordion-heading" id="week-1">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                            <span>WEEK #1
                                <span class="fa fa-caret-up" id="week-1-title">&nbsp;</span>
                                <div class="pull-right pin"></div>
                            </span>
            <div class="clearfix"></div>
        </a>
    </div>
    <div id="collapseOne" class="accordion-body collapse in">
        <div class="accordion-inner">
            <div class="accordion-inner-head">
                <h4 class="text-center text-uppercase">Doctors</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-1">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-1-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text staff" id="staff-on-2">
                    Adebayo Moses
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-2-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>

            <div class="accordion-inner-head">
                <h4>Pharmacist</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-4">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-4-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text staff" id="staff-on-5">
                    Adebayo Moses
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-5-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text staff" id="staff-on-6">
                    Adebayo Moses
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-6-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text staff" id="staff-on-7">
                    Adebayo Moses
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-7-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>

            <div class="accordion-inner-head">
                <h4>Medical Record</h4>
            </div>

            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-8">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-8-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text staff" id="staff-on-9">
                    Adebayo Moses
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-9-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text staff" id="staff-on-10">
                    Adebayo Moses
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-10-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="accordion-group col-sm-4 col-md-3">
    <div class="accordion-heading" id="week-2">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                            <span>WEEK #2
                                <span class="fa fa-caret-down" id="week-2-title">&nbsp;</span>
                                <div class="pull-right pin"></div>
                            </span>
            <div class="clearfix"></div>
        </a>
    </div>
    <div id="collapseTwo" class="accordion-body collapse">
        <div class="accordion-inner">
            <div class="accordion-inner-head">
                <h4>Doctor</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-11">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-11-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text staff" id="staff-on-12">
                    Adebayo Moses
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-12-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>

            <div class="accordion-inner-head">
                <h4>Pharmacy</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-13">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-13-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="accordion-group col-sm-4 col-md-3">
    <div class="accordion-heading" id="week-3">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
                            <span>WEEK #3
                                <span class="fa fa-caret-down" id="week-2-title">&nbsp;</span>

                                <div class="pull-right pin"></div>
                            </span>
            <div class="clearfix"></div>
        </a>
    </div>
    <div id="collapseThree" class="accordion-body collapse">
        <div class="accordion-inner">
            <div class="accordion-inner-head">
                <h4>Doctor</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-14">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-14-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>

            <div class="accordion-inner-head">
                <h4>Medical Record</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-15">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-15-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>
            <div class="accordion-inner-head">
                <h4>Urine Laboratory</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-16">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-16-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="accordion-group col-sm-4 col-md-3">
    <div class="accordion-heading" id="week-4">
        <a class="accordion-toggle"  data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
                            <span>WEEK #4
                                  <span class="fa fa-caret-down" id="week-4-title">&nbsp;</span>
                                <div class="pull-right pin"></div>
                            </span>
            <div class="clearfix"></div>
        </a>
    </div>
    <div id="collapseFour" class="accordion-body collapse">
        <div class="accordion-inner">
            <div class="accordion-inner-head">
                <h4>Doctor</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-18">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-18-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-19">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-19-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>
            <div class="accordion-inner-head">
                <h4>Medcal Record</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-17">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-17-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="accordion-group col-sm-4 col-md-3">
    <div class="accordion-heading" id="week-5">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFive">
                            <span>WEEK #5
                                <span class="fa fa-caret-down" id="week-5-title">&nbsp;</span>
                                <div class="pull-right pin"></div>
                            </span>
            <div class="clearfix"></div>
        </a>
    </div>
    <div id="collapseFive" class="accordion-body collapse">
        <div class="accordion-inner">
            <div class="accordion-inner-head">
                <h4>Doctor</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-55">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-55-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-56">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-56-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>

            <div class="accordion-inner-head">
                <h4>Medical Record</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-50">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-50-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-52">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-52-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>

            <div class="accordion-inner-head">
                <h4>Pharmacy</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-51">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-51-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-57">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-57-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="accordion-group col-sm-4 col-md-3">
    <div class="accordion-heading" id="week-6">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSix">
                            <span>WEEK #6
                                <span class="fa fa-caret-down" id="week-6-title">&nbsp;</span>
                                <div class="pull-right pin"></div>
                            </span>
            <div class="clearfix"></div>
        </a>
    </div>
    <div id="collapseSix" class="accordion-body collapse">
        <div class="accordion-inner">
            <div class="accordion-inner-head">
                <h4>Doctor</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-60">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-60-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-61">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-61-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-62">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-62-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>

            <div class="accordion-inner-head">
                <h4>Pharmacy</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-63">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-63-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-64">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-64-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-65">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-65-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>

            <div class="accordion-inner-head">
                <h4>Parasitology Laboratory</h4>
            </div>
            <ul class="list-unstyled list-group">
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-66">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-66-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <li class="list-group-item list-group-item-text text-uppercase staff" id="staff-on-67">
                    Adebayo Moses 1
                    <div class="pull-right pointer">
                        <span class="fa fa-remove small hidden" id="staff-on-67-remove">&nbsp;</span>
                    </div>
                    <div class="clearfix"></div>
                </li>
            </ul>
        </div>
    </div>
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
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/bootstrap/bootstrap-datepicker.min.js"></script>
<script src="../js/admin/roaster.js"></script>
</body>
</html>