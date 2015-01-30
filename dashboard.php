<?php
require_once '_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);

var_dump($_SESSION);
if(!isset($_SESSION[UserAuthTable::userid])){
    header("Location: index.php");
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

    <title>PMS</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/master.css" rel="stylesheet">

    <script src="js/bootstrap/jquery-1.10.2.min.js"></script>
    <script src="js/login.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<div class="container">
    <div class="row">
        <div id="dashboard">
            <div class="pull-right">
                <img src="images/profile.png">
                <span><?php echo ucwords(CxSessionHandler::getItem(ProfileTable::surname).' '.CxSessionHandler::getItem(ProfileTable::firstname))?></span>
            </div>
            <div class="clearfix"></div>

            <!--        USER ROLES -->
            <div class="dashboard-items col-md-12">
                <?php
                foreach(CxSessionHandler::getItem(StaffRoleTable::staff_role_id) as $staff){
                    ?>
                    <?php
                    if($staff[StaffRoleTable::staff_role_id] == ADMINISTRATOR){
                        ?>
                        <div class="col-md-3 col-sm-offset-1 text-center">
                            <a href="admin/staff.php">
                                <img src="images/file-edit.png">
                                <div class="dashboard-desc">Admin Access</div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-offset-1 text-center">
                            <a href="admin/staff.php">
                                <img src="images/reports.png" width="60" height="60">
                                <div class="dashboard-desc">Report Creation</div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-offset-1 text-center">
                            <a href="admin/staff.php">
                                <img src="images/student_access_code.png" width="60" height="60" alt="Student Access Code">
                                <div class="dashboard-desc">Patient Access code</div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-offset-1 text-center">
                            <a href="admin/staff.php">
                                <img src="images/file-edit.png" >
                                <div class="dashboard-desc">Health Scheme</div>
                            </a>
                        </div>
                    <?php
                    }else if($staff[StaffRoleTable::staff_role_id] == DOCTOR){
                        ?>
                        <div class="col-md-3 col-sm-offset-1 text-center">
                            <a href="admin/staff.php">
                                <img src="images/dash-icons.png">
                                <div class="dashboard-desc">Doctor Access</div>
                            </a>
                        </div>
                    <?php
                    }else if($staff[StaffRoleTable::staff_role_id] == PHARMACIST){
                        ?>
                        <div class="col-md-3 col-sm-offset-1 text-center">
                            <a href="admin/staff.php">
                                <img src="images/dash-icons.png">
                                <div class="dashboard-desc">Pharmacist Access</div>
                            </a>
                        </div>
                    <?php
                    }?>

                <?php
                }
                ?>
            </div>
            <div class="clearfix"></div>
        </div>

    </div>

</div> <!-- /container -->

</body>
</html>
