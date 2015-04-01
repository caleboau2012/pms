<?php
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

    <title>Treatment</title>

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
    <div class="panel {{status}} patient pointer">
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
                <p>{{Age}} year(s)</p>
                <p>{{sex}}</p>
                <span class="patientid" hidden>{{patientid}}</span>
                <span class="doctorid" hidden>{{userid}}</span>
                <span class="patientName" hidden>{{name}}</span>
                <span class="patientSex" hidden>{{sex}}</span>
                <span class="patientRegNo" hidden>{{regNo}}</span>
                <span class="patientAge">{{Age}} year(s)</span>
            </div>
        </div>
    </div>
</script>

<script id="tmplTreatmentHistory" type="text/html">
    <li class="list-group-item">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion{{userid}}"
           href="#collapse{{treatmentid}}" aria-expanded="false" aria-controls="collapse{{treatmentid}}">
            <b>Diagnosis:</b> {{diagnosis}}
        </a>
        <div id="collapse{{treatmentid}}" class="panel-collapse collapse" role="tabpanel"
             aria-labelledby="heading{{treatmentid}}">
            <div class="panel-body">
                <p><b>Comments:</b> {{comments}}</p>
                <p><b>Consultation Details:</b> {{consultation}}</p>
                <span class="treatmentid" hidden>{{treatmentid}}</span>
                <span class="doctorid" hidden>{{doctorid}}</span>
                <p><b>Syptoms:</b> {{symptoms}}</p>
            </div>
        </div>
    </li>
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
        <div class="col-sm-9">
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title patient-name">Please Select a Patient from the Queue <span class="fa fa-long-arrow-right"></span> </h2>
                </div>
                <div class="panel-body">
                    <p class="patient-RegNo"></p>
                    <span class="patient-Sex"></span>
                    <span class="patient-ID hidden"></span>
                    <span class="treatment-ID hidden"></span>
                    <span class="patient-Age"></span>
                </div>
            </div>

            <div class="well">
                <ul class="treatment-nav nav nav-tabs nav-justified">
                    <li class="at active" onclick="switchTabs('add-treatment', 'at')"><a href="#">Add Treatment</a></li>
                    <li class="rt" onclick="switchTabs('request-test', 'rt')"><a href="#">Request Test</a></li>
                    <li class="th" onclick="switchTabs('treatment-history', 'th')"><a href="#">Treatment History</a></li>
                    <li class="lh" onclick="switchTabs('lab-history', 'lh')"><a href="#">Lab History</a></li>
                </ul>
                <div class="add-treatment">
                    <form name="addTreatmentForm" class="form">
                        <div class="row">
                            <br/>
                            <div class="col-sm-12">
                                <div class="center-block">
                                    <label>Consultation Details:</label>
                                    <textarea type="text" class="form-control" name="consultation"></textarea>
                                </div>
                            </div>
                            <br/>
                            <div class="col-sm-6">
                                <div class="center-block"><label>Comments:</label>
                                    <textarea class="form-control" name="comment"></textarea>
                                </div>
                                <br/>

                                <div class="center-block"><label>Prescriptions:</label>
                                    <input type="text" id="prescriptionInput" class="form-control" placeholder="">

                                    <p>
                                        <small>Type and press the Enter key to add to prescription list</small>
                                    </p>
                                </div>
                                <br/>

                                <div class="center-block prescription">
                                    <ol id="prescriptionList" class="list-group"><span class="empty-box-message">No prescriptions added</span>
                                    </ol>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="center-block">
                                    <label>Symptoms:</label>
                                    <textarea type="text" class="form-control" name="symptoms"></textarea>
                                </div>
                                <br/>

                                <div class="center-block"><label>Diagnosis:</label>
                                    <input type="text" class="form-control" name="diagnosis">
                                </div>
                                <br/>
                                <button id="treatmentSubmit" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="request-test hidden">
                    <form name="requestTestForm" class="form">
                        <div class="row">
                            <br/>
                            <div class="col-sm-5 col-md-3 form-inline">
                                <label>Test Type</label>
                                <select class="form-control" name="test_id">
                                    <option value="radiology">RADIOLOGY</option>
                                    <option value="haematology">HAEMATOLOGY</option>
                                    <option value="microscopy">MICROSCOPY</option>
                                    <option value="visual">VISUAL SKILL PROFILE</option>
                                    <option value="chemical">CHEMICAL PATHOLOGY</option>
                                    <option value="parasitology">PARASITOLOGY</option>
                                </select>
                                <br/>
                                <br/>
                                <button type="submit" class="btn btn-primary">Request Test</button>
                            </div>

                            <div class="col-sm-7 col-md-9">
                                <label>Description</label>
                                <textarea id="description" class="form-control" type="text"
                                          name="description"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="treatment-history hidden">
                    <br/>
                    <ul class="list-group history">
                    </ul>
<!--                    <button class="btn btn-info">Load More</button>-->
                </div>
                <div class="lab-history hidden">
                    <div class="table">
                        <br/>
                        <div class="center-block form-inline">
                            <label>Select a test: </label>
                            <select id="type" class="form-control" name="test_id">
                                <option value="5">RADIOLOGY</option>
                                <option value="2">HAEMATOLOGY</option>
                                <option value="3">MICROSCOPY</option>
                                <option value="4">VISUAL SKILL PROFILE</option>
                                <option value="15">CHEMICAL PATHOLOGY</option>
                                <option value="16">PARASITOLOGY</option>
                            </select>
                        </div>
                        <br/>
                        <table class="table table-stripped table--bordered dataTable">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Diagnosis</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="odd">
                                <td>No data available in table</td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Diagnosis</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <br/>
            <div class="panel panel-primary doctor">
                <div class="panel-heading">
                    <p style="display: none;" id="doctorid"><?php echo ucwords(CxSessionHandler::getItem(ProfileTable::userid)); ?></p>
                    <h2 class="panel-title">Patient Queue</h2>
                </div>
                <div class="panel-body patients">
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
<script src="../js/libs/masonry.js"></script>
<script src="../js/treatment.js"></script>
</body>
</html>