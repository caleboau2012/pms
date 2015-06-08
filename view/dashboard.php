<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);

if(!isset($_SESSION[UserAuthTable::userid])){
    header("Location: ../index.php");
}

//var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PMS</title>
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/master.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="dashboard">
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
        <div class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">
                <li>
                    <a href="mails.php">
                        <span class="fa fa-envelope"></span>
                        <sup class="badge notification message_unread"></sup>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <img src="../images/profile.png">
                        <?php echo ucwords(CxSessionHandler::getItem(ProfileTable::surname).' '.CxSessionHandler::getItem(ProfileTable::firstname))?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a href="dashboard.php">Dashboard</a></li>
                        <li role="presentation"><a href="#" id="sign-out">Sign out</a></li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</nav>

<div class="container">
    <div class="row">
        <div id="dashboard">
            <br>
            <div class="dashboard-panels">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Core Functions</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-3 text-center">
                            <a href="get_roster.php" class="dashboard-link">
                                <img src="../images/roster.png" width="60" height="60">
                                <div class="dashboard-desc">Check Roster</div>
                            </a>
                        </div>
                        <div class="col-xs-3 text-center">
                            <a href="mails.php" class="dashboard-link">
                                <img src="../images/messages.png" width="60" height="60">
                                <sup class="badge notification message_unread"></sup>
                                <div class="dashboard-desc">Message</div>
                            </a>

                        </div>
                        <?php
                        foreach (CxSessionHandler::getItem(StaffRoleTable::staff_role_id) as $staff) {
                            ?>
                            <?php
                            if ($staff[StaffRoleTable::staff_role_id] == DOCTOR) {
                                ?>
                                <div class="col-xs-3  text-center">
                                    <a href="treatment/out-patient.php" class="dashboard-link">
                                        <img src="../images/medical_consultants.png" width="60">

                                        <div class="dashboard-desc">Doctor</div>
                                    </a>
                                </div>
                            <?php
                            } else if ($staff[StaffRoleTable::staff_role_id] == PHARMACIST) {
                                ?>
                                <div class="col-xs-3 text-center">
                                    <a href="pharmacy.php" class="dashboard-link">
                                        <img src="../images/pharmacy-icons.png" width="60">

                                        <div class="dashboard-desc">Pharmacist</div>
                                    </a>
                                </div>
                            <?php
                            }else if ($staff[StaffRoleTable::staff_role_id] == MEDICAL_RECORD) {
                                ?>
                                <div class="col-xs-3 text-center">
                                    <a href="arrival.php" class="dashboard-link">
                                        <img src="../images/arrival.png">

                                        <div class="dashboard-desc">Patient Arrival</div>
                                    </a>
                                </div>
                            <?php
                            } else if ($staff[StaffRoleTable::staff_role_id] == LABORATORY_CONDUCTOR){
                                ?>
                                <div class="col-xs-3 text-center">
                                    <a href="laboratory.php" class="dashboard-link">
                                        <img src="../images/laboratory-icon.png" width="60" height="60">

                                        <div class="dashboard-desc">Laboratory</div>
                                    </a>
                                </div>
                            <?php
                            }else if($staff[StaffRoleTable::staff_role_id] == ADMISSION_OFFICER) {
                                ?>
                                <div class="col-xs-3 text-center">
                                    <a href="admission.php" class="dashboard-link">
                                        <img src="../images/arrival.png">

                                        <div class="dashboard-desc">Admission</div>
                                    </a>
                                </div>
                            <?php
                            }else if($staff[StaffRoleTable::staff_role_id] == BILLING_OFFICER) {
                                ?>
                                <div class="col-xs-3 text-center">
                                    <a href="billing.php" class="dashboard-link">
                                        <img src="../images/billing.png" width="60" height="60">

                                        <div class="dashboard-desc">Billing</div>
                                    </a>
                                </div>
                            <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <!--Admininstrative Panel-->
                <?php
                if(sizeof(CxSessionHandler::getItem(StaffRoleTable::staff_role_id)) !== 0){
                $administrator = false;
                ?>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Administrative Functions</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        foreach (CxSessionHandler::getItem(StaffRoleTable::staff_role_id) as $staff) {
                            ?>
                            <?php
                            if ($staff[StaffRoleTable::staff_role_id] == ROASTER_CREATOR) {
                                $administrator = true;
                                ?>
                                <div class="col-xs-3 text-center">
                                    <a href="set_roster.php" class="dashboard-link">
                                        <img src="../images/roster.png" width="60" height="60">
                                        <div class="dashboard-desc">Roster</div>
                                    </a>
                                </div>

                            <?php
                            }else if($staff[StaffRoleTable::staff_role_id] == ADMINISTRATOR){
                                $administrator = true;
                                ?>
                                <div class="col-xs-3  text-center">
                                    <a href="admin/staff.php" class="dashboard-link">
                                        <img src="../images/file-edit.png">

                                        <div class="dashboard-desc">Admin Access</div>
                                    </a>
                                </div>
                                <div class="col-xs-3 text-center">
                                    <a href="report/report.php" class="dashboard-link">
                                        <img src="../images/reports.png" width="60" height="60">
                                        <div class="dashboard-desc">Report Creation</div>
                                    </a>
                                </div>

                            <?php
                            } else if ($staff[StaffRoleTable::staff_role_id] == BACKUP_OFFICER){
                                $administrator = true;
                                ?>
                                <div class="col-xs-3 text-center">
                                    <a href="backups.php" class="dashboard-link">
                                        <img src="../images/backup.png" width="60" height="60">
                                        <div class="dashboard-desc">System Backups</div>
                                    </a>
                                </div>
                            <?php
                            }
                        }
                        if(!$administrator){
                            ?>
                            <div class="alert alert-warning">
                                No Administrative role assigned to you !
                            </div>
                        <?php
                        }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div> <!-- /container -->


<script src="../js/bootstrap/jquery-1.10.2.min.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/constants.js"></script>
<script src="../js/index.js"></script>
<script src="../js/backup_restore.js" type="application/javascript"></script>
<?php include('footer.php'); ?>

</body>
</html>
