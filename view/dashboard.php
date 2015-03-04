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
<div class="container">
    <div class="row">
        <div id="dashboard">
            <div class="pull-right">
                <img src="../images/profile.png">
        <span><?php echo ucwords(CxSessionHandler::getItem(ProfileTable::surname).' '.CxSessionHandler::getItem(ProfileTable::firstname))?>
        </span>
                <p class="text-right small">
                    <a class="text-right" href="#" id="sign-out">Sign out</a>
                </p>
            </div>
            <div class="clearfix"></div>

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
                                <div class="dashboard-desc">Message</div>
                            </a>
                        </div>
                        <?php
                        if(sizeof(CxSessionHandler::getItem(StaffRoleTable::staff_role_id)) == 0){
                            ?>
                            <div class="alert alert-info">
                                No Role assigned to you yet!
                            </div>
                        <?php
                        }else {
                            foreach (CxSessionHandler::getItem(StaffRoleTable::staff_role_id) as $staff) {
                                ?>
                                <?php
                                if ($staff[StaffRoleTable::staff_role_id] == DOCTOR) {
                                    ?>
                                    <div class="col-xs-3  text-center">
                                        <a href="#" class="dashboard-link">
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
                                }else if ($staff[StaffRoleTable::staff_role_id] == URINE_CONDUCTOR) {
                                    ?>
                                    <div class="col-xs-3 text-center">
                                        <a href="#" class="dashboard-link">
                                            <img src="../images/lab_registration.png">

                                            <div class="dashboard-desc">Urine</div>
                                        </a>
                                    </div>
                                <?php
                                }else if ($staff[StaffRoleTable::staff_role_id] == VISUAL_CONDUCTOR) {
                                    ?>
                                    <div class="col-xs-3 text-center">
                                        <a href="#" class="dashboard-link">
                                            <img src="../images/lab_registration.png">

                                            <div class="dashboard-desc">Visual</div>
                                        </a>
                                    </div>
                                <?php
                                }else if ($staff[StaffRoleTable::staff_role_id] == XRAY_CONDUCTOR) {
                                    ?>
                                    <div class="col-xs-3 text-center">
                                        <a href="#" class="dashboard-link">
                                            <img src="../images/lab_registration.png">

                                            <div class="dashboard-desc">Xray</div>
                                        </a>
                                    </div>
                                <?php
                                }else if ($staff[StaffRoleTable::staff_role_id] == PARASITOLOGY_CONDUCTOR) {
                                    ?>
                                    <div class="col-xs-3 text-center">
                                        <a href="#" class="dashboard-link">
                                            <img src="../images/lab_registration.png">

                                            <div class="dashboard-desc">Parasitology</div>
                                        </a>
                                    </div>
                                <?php
                                }else if ($staff[StaffRoleTable::staff_role_id] == CHEMICAL_PATHOLOGY_CONDUCTOR) {
                                    ?>
                                    <div class="col-xs-3 text-center">
                                        <a href="#" class="dashboard-link">
                                            <img src="../images/lab_registration.png">

                                            <div class="dashboard-desc">Chemical Pathology</div>
                                        </a>
                                    </div>
                                <?php
                                }else if ($staff[StaffRoleTable::staff_role_id] == TREATMENT_RECORD) {
                                    ?>
                                    <div class="col-xs-3 text-center">
                                        <a href="#" class="dashboard-link">
                                            <img src="../images/dash-icons.png">

                                            <div class="dashboard-desc">Treatment Record</div>
                                        </a>
                                    </div>
                                <?php
                                }
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
                                    <a href="staff.php" class="dashboard-link">
                                        <img src="../images/file-edit.png">

                                        <div class="dashboard-desc">Admin Access</div>
                                    </a>
                                </div>
                                <div class="col-xs-3 text-center">
                                    <a href="#" class="dashboard-link">
                                        <img src="../images/reports.png" width="60" height="60">
                                        <div class="dashboard-desc">Report Creation</div>
                                    </a>
                                </div>

                            <?php
                            }else if($staff[StaffRoleTable::staff_role_id] == STAFF_ADDING_OFFICER){
                                $administrator = true;
                                ?>
                                <div class="col-xs-3 text-center">
                                    <a href="#" class="dashboard-link">
                                        <img src="../images/file-edit.png">

                                        <div class="dashboard-desc">Staff Adding Officer</div>
                                    </a>
                                </div>
                            <?php
                            }else if($staff[StaffRoleTable::staff_role_id] == STAFF_CLEARANCE_OFFICER){
                                $administrator = true;
                                ?>
                                <div class="col-xs-3 text-center">
                                    <a href="#" class="dashboard-link">
                                        <img src="../images/file-edit.png">

                                        <div class="dashboard-desc">Staff Clearance Officer</div>
                                    </a>
                                </div>
                            <?php
                            }else if($staff[StaffRoleTable::staff_role_id] == HEALTH_SCHEME){
                                $administrator = true;
                                ?>
                                <div class="col-xs-3 text-center">
                                    <a href="#" class="dashboard-link">
                                        <img src="../images/file-edit.png">

                                        <div class="dashboard-desc">Health Scheme</div>
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
<script src="../js/constants.js"></script>
<script src="../js/index.js"></script>
</body>
</html>
