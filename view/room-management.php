<?php
/**
 * Created by PhpStorm.
 * User: olajuwon
 * Date: 2/16/2015
 * Time: 1:10 PM
 */
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'RoleModel', 'BedModel', 'WardModel', 'VitalsModel'));
Crave::requireFiles(CONTROLLER, array('WardController', 'RoleController', 'VitalsController'));

$ward = new WardController();

$wards = $ward->loadWards();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title>Admin Dashboard</title>
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">

    <link href='../css/libs/fullCalendar/fullcalendar.css' rel='stylesheet' />
    <link href='../css/libs/fullCalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
    <link href="../css/master.css" rel="stylesheet">
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
            <a class="navbar-brand" href="dashboard.php">
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
                <li class="adm-menu active" id="ward" data-view-id="1"><a href="#">Wards</a> </li>
                <li>
                    <a href="admission.php"><span class="fa fa-bed">&nbsp;</span>Admission</a>
                </li>
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
                        <li class="divider"></li>
                        <li role="presentation"><a href="view-profile.php">View Profile</a></li>
                        <li role="presentation"><a href="#" id="sign-out">Sign out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!--   Room management -->
        <div class="room-page-content" id="ward-view">
            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="pull-left">Wards</h4>
                        <button class="btn btn-sm btn-default pull-right" id="new-ward-action"><span class="fa fa-plus">&nbsp;</span>Add Ward</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <div id="new-ward-response"></div>
                        <ul class="list-group ward-list-items">
                            <?php
                            if($wards){
                                foreach($wards as $ward){
                                    ?>
                                    <li class="list-group-item ward-item ward text-primary" data-ward-id = "<?php echo $ward['ward_ref_id'] ?>" data-ward-name = "<?php echo $ward['description']?>">
                                        <div class="pull-left ward-list-name">
                                            <?php echo $ward['description'] ?>
                                        </div>
                                        <p class='text-muted pull-right pointer ward-list-delete invisible' data-ward-name = "<?php echo $ward['description'] ?>" data-ward-id="<?php echo $ward['ward_ref_id']?>">
                                            <span class='fa fa-remove fa-2x text-danger'>&nbsp;</span>
                                        </p>
                                        <div class="clearfix"></div>
                                    </li>
                                <?php
                                }
                            }else{
                                ?>
                                <h3 class="text-info text-center">No ward yet</h3>
                            <?php
                            }

                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="room-bed-list">
                    <div class="bed-list__default-text">
                        <h2 class="text-center text-muted">
                            Select ward from the left pane
                        </h2>
                    </div>
                </div>
            </div>

            <div class="col-sm-3 hidden">
                <div class="room-overview">
                    <div class="room-overview__heading">
                        <h2 class="text-center"><span class="fa fa-history"></span></h2>
                        <h3 class="text-center">Overview</h3>
                    </div>
                    <p>
                        <span class="fa fa-university text-danger">&nbsp;</span>
                        20 Wards
                    </p>
                    <p>
                        <span class="fa fa-bed text-danger">&nbsp;</span>
                        200 Beds
                    </p>
                    <p>
                        <span class="fa fa-bed text-success">&nbsp;</span>
                        30 Available Beds
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  MODAL FORM-->
<div class="modal fade" id="room-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="fa fa-2x text-danger" aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--  -->
<script src='../js/bootstrap/jquery.min.js'></script>
<script src='../js/bootstrap/bootstrap.min.js'></script>
<script src="../js/constants.js"></script>
<script src="../js/room-mgt.js"></script>
<?php include('footer.php'); ?>

</body>
</html>
