<?php
/**
 * Created by PhpStorm.
 * User: Olaniyi
 * Date: 6/4/15
 * Time: 3:37 PM
 */

require_once '../../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title>Report Generator</title>
    <link href="../../css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/libs/morris.css" rel="stylesheet">
    <link href="../../css/master.css" rel="stylesheet">
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
        <div class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">
                <li>
                    <a href="index.php">Tables</a>
                </li>
                <li class="active">
                    <a>Graphs</a>
                </li>
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
                        <li class="divider"></li>
                        <li role="presentation"><a href="../view-profile.php">View Profile</a></li>
                        <li role="presentation"><a href="#" id="sign-out">Sign out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!--<script id="tmplPatients" type="text/html">-->
<!--    <div class="panel {{status}} patient pointer">-->
<!--        <div class="panel-heading" role="tab" id="heading{{id}}">-->
<!--            <h4 class="panel-title">-->
<!--                <a class="collapsed" data-toggle="collapse" data-parent="#accordion{{id}}"-->
<!--                   href="#collapse{{id}}" aria-expanded="false" aria-controls="collapse{{id}}">-->
<!--                    {{regNo}}-->
<!--                </a>-->
<!--            </h4>-->
<!--        </div>-->
<!--        <div id="collapse{{id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{patientid}}">-->
<!--            <div class="panel-body">-->
<!--                <p>{{name}}</p>-->
<!--                <p class="name hidden">{{name}}</p>-->
<!--                <p class="regNo hidden">{{regNo}}</p>-->
<!--                <span class="treatment_id hidden">{{treatment_id}}</span>-->
<!--                <span class="treatment_status hidden">{{treatment_status}}</span>-->
<!--                <span class="bill_status hidden">{{bill_status}}</span>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</script>-->

<div class="container-fluid">
    <div class="row">
        <div id="reportContent" class="col-sm-12 well">
            <div class="col-sm-4 center-block">
                <label class="label label-primary">
                    Select a report to view
                </label>
                <select id="view" class="form-control">
                    <option value="allPatients">All Patients</option>
                    <option value="newPatients">New Patients</option>
                    <option value="currentPatients">Current Patients</option>
                    <option value="inPatients">Inpatients</option>
                    <option value="consultationReport">Consultation</option>
                    <option value="patientDiagnosis">Patients and Diagnosis</option>
                </select>
            </div>
            <div class="col-sm-2 hidden center-block">
                <label class="label label-primary">
                    Select Gender
                </label>
                <select id="gender" class="form-control" disabled="disabled">
                    <option value="1">All</option>
                    <option value="2">Male</option>
                    <option value="3">Female</option>
                </select>
            </div>
            <div class="col-sm-3 center-block">
                <label class="label label-primary">
                    Start Date
                </label>
                <input type="date" name="start_date" id="start_date" class="form-control"/>
            </div>
            <div class="col-sm-3 center-block">
                <label class="label label-primary">
                    End Date
                </label>
                <input type="date" name="end_date" id="end_date" class="form-control"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 text-center">
            <div class="well">
                <div class="alert hidden alert-danger alert-dismissable" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <span class="alertMSG"></span>
                </div>
                <div class="graph" id="doughnut">

                </div>
            </div>
        </div>
        <div class="col-sm-6 text-center">
            <div class="well">
                <div class="alert hidden alert-danger alert-dismissable" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <span class="alertMSG"></span>
                </div>
                <div class="graph" id="bar">

                </div>
            </div>
        </div>
    </div>
</div>

<script src='../../js/bootstrap/jquery.min.js'></script>
<script src='../../js/bootstrap/bootstrap.min.js'></script>
<script src="../../js/libs/morrisCharts/raphael-min.js"></script>
<script src="../../js/libs/morrisCharts/morris.min.js"></script>
<script src="../../js/constants.js"></script>
<script src="../../js/reports/graphs.js" type="application/javascript"></script>
<?php include('../footer.php'); ?>
</body>
</html>