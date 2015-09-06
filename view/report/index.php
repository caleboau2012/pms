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
    <link href="../../css/master.css" rel="stylesheet">
    <link href="../../css/bootstrap/jquery.dataTables.css" rel="stylesheet">
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
                <li class="active">
                    <a>Tables</a>
                </li>
                <li>
                    <a href="graphs.php">Graphs</a>
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

<script id="tmplPatients" type="text/html">
    <div class="panel {{status}} patient pointer">
        <div class="panel-heading" role="tab" id="heading{{id}}">
            <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion{{id}}"
                   href="#collapse{{id}}" aria-expanded="false" aria-controls="collapse{{id}}">
                    {{regNo}}
                </a>
            </h4>
        </div>
        <div id="collapse{{id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{patientid}}">
            <div class="panel-body">
                <p>{{name}}</p>
                <p class="name hidden">{{name}}</p>
                <p class="regNo hidden">{{regNo}}</p>
                <span class="treatment_id hidden">{{treatment_id}}</span>
                <span class="treatment_status hidden">{{treatment_status}}</span>
                <span class="bill_status hidden">{{bill_status}}</span>
            </div>
        </div>
    </div>
</script>

<div class="container-fluid">
    <div class="row">

            <div class="col-sm-3">
                <div class="r-sidebar">
                    <div class="r-panel">
                        <div class="r-heading">REPORTS</div>
                        <div class="r_body">
                            <div class="r-margin">
                                <label>
                                    Select a report to view
                                </label>
                                <select id="view" onchange="Report.switcher()" class="form-control">
                                    <option opt="yes" value="newPatient">New Patients</option>
                                    <option opt="yes" value="currentPatients">Current Patients</option>
                                    <option opt="no" value="patientsAge">Patients with their Age</option>
                                    <option opt="day" value="patientVisits">Patients Visits / Encounter</option>
                                    <option opt="no" value="inPatients">Inpatients</option>
                                    <option opt="no" value="consultationReport">Consultation</option>
                                    <option opt="no" value="patientDiagnosis">Patient with Diagnosis</option>
                                </select>
                            </div>
                            <div id="range">
                                <div class="r-margin">
                                    <div class="gender"><label>
                                        Select Gender
                                    </label>
                                    <select id="gender" class="form-control">
                                        <option>All</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select></div>
                                </div>
                                <div class="r-margin">
                                    <label>
                                        Start Date
                                    </label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"/>
                                </div>
                                <div class="r-margin">
                                    <label>
                                        End Date
                                    </label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"/>
                                </div>
                            </div>
                            <div id="day" class="r-margin">
                                <label>
                                    Select Day
                                </label>
                                <input type="date" name="day" id="day" class="form-control"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">

                <iframe id="report_iframe" style="width: 100%;" seamless="seamless" frameborder="0">
                    <h1>iFrames are not supported in this browser.</h1>
                </iframe>

            </div>
    </div>
</div>

<script src='../../js/bootstrap/jquery.min.js'></script>
<script src='../../js/bootstrap/bootstrap.min.js'></script>
<script src="../../js/constants.js"></script>
<script src="../../js/set-iframe-height.js"></script>
<script src="../../js/bootstrap/jquery.dataTables.min.js"></script>
<script src="../../js/bootstrap/dataTables.tableTools.min.js"></script>
<script src="../../js/reports/report.js" type="application/javascript"></script>
<?php include('../footer.php'); ?>
</body>
</html>
