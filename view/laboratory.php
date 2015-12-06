<?php
/**
 * Created by PhpStorm.
 * User: Olaniyi
 * Date: 3/3/15
 * Time: 3:48 PM
 */

require_once '../_core/global/_require.php';
//require_once '../phase/phase_laboratory.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);

if (!isset($_SESSION[UserAuthTable::userid])) {
    header("Location: ../index.php");
}
//var_dump($_SESSION);
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
    <link href="../css/bootstrap/jquery.dataTables.css" rel="stylesheet">
    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/master.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!--page header-->
<?php Crave::requireFiles(HEADERS, array('main')) ?>

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
        <div id="mainContent" class="col-sm-9 well">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <label class="panel-title">Patients' Test Records</label>
                </div>
                <div id="success" class="alert alert-success">Your Changes are Saved</div>
                <div class="panel-body">
                    <table id="test_table" class="table table-stripped table-responsive dataTable">
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
            <br>
            <label>Select Test</label>
            <select id="type" class="form-control" name="test_id" onchange="Laboratory.onTestChange()">
                <?php
                foreach (CxSessionHandler::getItem(StaffRoleTable::staff_role_id) as $staff){
                    if ($staff[StaffRoleTable::staff_role_id] == HAEMATOLOGY_CONDUCTOR){
                        ?>
                        <option value="haematology">HAEMATOLOGY</option>
                <?php
                    } else if ($staff[StaffRoleTable::staff_role_id] == URINE_CONDUCTOR){
                        ?>
                        <option value="microscopy">MICROSCOPY</option>
                <?php
                    } else if ($staff[StaffRoleTable::staff_role_id] == XRAY_CONDUCTOR){
                        ?>
                        <option value="radiology">XRAY</option>
                <?php
                    } else if ($staff[StaffRoleTable::staff_role_id] == VISUAL_CONDUCTOR){
                        ?>
                        <option value="visual">VISUAL SKILL PROFILE</option>
                <?php
                    } else if ($staff[StaffRoleTable::staff_role_id] == CHEMICAL_PATHOLOGY_CONDUCTOR){
                        ?>
                        <option value="chemical_pathology">CHEMICAL PATHOLOGY</option>
                <?php
                    } else if ($staff[StaffRoleTable::staff_role_id] == PARASITOLOGY_CONDUCTOR){
                        ?>
                        <option value="parasitology">PARASITOLOGY</option>
                <?php
                    }
                }
                ?>
            </select>
        </div>

        <div class="col-sm-3">
            <br/>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <label>Pending Requests</label>
                </div>
                <div id="pending" class="panel-body">
                    <div class="patient-queue__body">
                        <div class="patient-queue__list">
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
<script src="../js/bootstrap/jquery.dataTables.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/bootstrap/jquery-ui.min.js"></script>
<script src="../js/constants.js"></script>
<script src="../js/laboratory.js"></script>
<a href="#" class="l-back-to-top" style="display: none;">Back to top</a>
<script>
    var toTop = $(".l-back-to-top");

    $(window).scroll(function(){
        if($(this).scrollTop() > 200){
            toTop.fadeIn();
        }
        else{
            toTop.fadeOut();
        }
    });

    toTop.click(function(event){
        event.preventDefault();
        $('body,html').animate({scrollTop : 0},800);
    });



</script>
<?php include('footer.php'); ?>
</body>
</html>