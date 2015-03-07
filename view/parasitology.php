<?php
/**
 * Created by PhpStorm.
 * User: Olaniyi
 * Date: 3/6/15
 * Time: 2:03 PM
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

    <title>Haematology</title>

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
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">{{Patient Name}}</h2>
                </div>
                <div class="panel-body">
                    <p>{{Reg No}}</p>
                    <span>{{Sex}}</span>
                    <span>{{Age}} years</span>
                </div>
            </div>

            <div class="parasitology">
                <div class="add-parasitology">
                    <form id="addTestForm" class="form">
                        <input type="hidden" name="<?php echo ParasitologyRequestTable::table_name.'['.ParasitologyRequestTable::preq_id.']' ?>" value="treatment_id">
                        <input type="hidden" name="<?php echo ParasitologyRequestTable::table_name.'['.ParasitologyRequestTable::treatment_id.']'; ?>" value="treatment_id">

                        <div class="row">
                            <div class="page-header">
                                <a id="back" href="#" class="btn btn-default btn-sm" style="float: left;margin-right: 10px;margin-top: 5px; margin-left: 20px;">← Go Back</a>
                                <h2 class="page-header__title">Parasitology</h2>
                            </div>

                            <div class="col-sm-12">
                                <div class="center-block">
                                    <fieldset>
                                        <h4 class="title">Clinical Diagnosis</h4>
                                        <textarea readonly class="col-sm-12 form-control"></textarea>
                                        <div class="test-label">Requesting Doctor:<span class="pad5 test-label">Date:</span></div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="center-block">
                                    <fieldset>
                                        <h4 class="title">Other Relevant Details</h4>
                                        <label class="test-label">Nature of Specimen</label>
                                        <textarea class="col-sm-12 form-control" placeholder="Nature of Specimen" name="<?php echo ParasitologyRequestTable::table_name.'['.ParasitologyRequestTable::nature_of_specimen.']'; ?>"></textarea>
                                    </fieldset>
                                    <label class="test-label">Investigation Required</label>
                                    <textarea class="col-sm-12 form-control" placeholder="Investigation Required" name="<?php echo ParasitologyRequestTable::table_name.'['.ParasitologyRequestTable::investigation_required.']'; ?>"></textarea>
                                    <div class="test-label">Date of Collection:<span class="pad5 test-label">Date Reported:</span></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="center-block">
                                    <fieldset>
                                        <h4 class="title">Laboratory Report</h4>
                                        <textarea class="col-sm-12 form-control" placeholder="Laboratory Report" name="<?php echo ParasitologyRequestTable::table_name.'['.ParasitologyRequestTable::lab_comment.']'; ?>"></textarea>
                                        <div class="test-label">Laboratory Ref: <span><input type="text" class="form-inline form-margin" name="<?php echo ParasitologyRequestTable::table_name.'['.ParasitologyRequestTable::lab_number.']'; ?>"></span> </div>
                                    </fieldset>
                                </div>
                            </div>

                            <?php
                            $ova_of_parasites = new LabelList();
                            $ova_of_parasites->addNode(new LabelNode("Hook worm" , 1));
                            $ova_of_parasites->addNode(new LabelNode("A. lumbricoides" , 2));
                            $ova_of_parasites->addNode(new LabelNode("T. Trichuris" , 3));
                            $ova_of_parasites->addNode(new LabelNode("E. vemicularis" , 4));
                            $ova_of_parasites->addNode(new LabelNode("S. haematobium" , 5));
                            $ova_of_parasites->addNode(new LabelNode("No cysts. ova" , 6));

                            $trophozoites_cyts_parasites = new LabelList();
                            $trophozoites_cyts_parasites->addNode(new LabelNode("E. coli", 7));
                            $trophozoites_cyts_parasites->addNode(new LabelNode("E. histolytica", 8));
                            $trophozoites_cyts_parasites->addNode(new LabelNode("G. lamblia", 9));

                            $larvae_of_parasites = new LabelList();
                            $larvae_of_parasites->addNode(new LabelNode("Hook worm", 10));
                            $larvae_of_parasites->addNode(new LabelNode("S. stercoralis", 11));

                            $cells_parasites = new LabelList();
                            $cells_parasites->addNode(new LabelNode("RBC's", 12));
                            $cells_parasites->addNode(new LabelNode("WBC's", 13));

                            $occult_blood_parasites = new LabelList();
                            $occult_blood_parasites->addNode(new LabelNode("Positive", 14));
                            $occult_blood_parasites->addNode(new LabelNode("Negative", 15));

                            ?>

                        </div>
                    </form>
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