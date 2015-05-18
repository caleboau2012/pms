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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title>Admin Dashboard</title>
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">

<!--    <link href='../css/libs/fullCalendar/fullcalendar.css' rel='stylesheet' />-->
<!--    <link href='../css/libs/fullCalendar/fullcalendar.print.css' rel='stylesheet' media='print' />-->
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

<div class="container-fluid">
    <div class="row">
        <!--   Bill management -->
        <div>
            <div class="col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <form id="search-patient-form">
                            <input id = "patient_query" class="form-control" placeholder="Search...">
                        </form>
                    </div>
                    <div class="panel-body in-patient-list">
                        <div id="unbilled-patient">
                            <h2 class="text-muted text-center">No Unbilled Patient</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="well in-patient-content">
                    <br>
                    <div class="div-rounded encounter-icon">
                        <span class="fa fa-money"></span>
                    </div>
                    <!-- <h2 class="text-warning text-center">Log Encounter...</h2>-->
                    <form id="bill" class="bill table-responsive">
                        <table class="table table-stripped">
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><input class="form-control" name="item[{{0}}]" value="{{Constant Item 0}}" disabled></td>
                                <td><input class="form-control" name="amount[{{0}}]"></td>
                            </tr>
                            <tr>
                                <td><input class="form-control" name="item[{{1}}]" value="{{Constant Item 1}}" disabled></td>
                                <td><input class="form-control" name="amount[{{1}}]"></td>
                            </tr>
                            <tr>
                                <td><input class="form-control" name="item[{{2}}]"></td>
                                <td><input class="form-control" name="amount[{{2}}]"></td>
                            </tr>
                            <tr><td colspan="2"><button type="button" class="btn btn-primary btn-sm pull-right">Add More <span class="fa fa-angle-down"></span></button></td></tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Total</th>
                                <th>{{total amount}}</th>
                            </tr>
                            </tfoot>
                        </table>
<!--                        <div class="form-group">-->
<!--                            <div class="col-sm-6">-->
<!--                                <p class="text-center">Item 1</p>-->
<!--                            </div>-->
<!--                            <div class="col-sm-6">-->
<!--                                <input type="text" id="pulse" class="form-control" name="pulse">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            <div class="col-sm-6">-->
<!--                                <label for="respiratory_rate">Respiratoty Rate</label>-->
<!--                                <input type="text" class="form-control" id="respiratory_rate" name="respiratory_rate">-->
<!--                            </div>-->
<!--                            <div class="col-sm-6">-->
<!--                                <label for="blood_pressure">Blood Pressure</label>-->
<!--                                <input type="text" class="form-control" id = "blood_pressure" name="blood_pressure">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            <div class="col-sm-6">-->
<!--                                <label for="height">Height</label>-->
<!--                                <input type="text" class="form-control" id="height" name="height">-->
<!--                            </div>-->
<!--                            <div class="col-sm-6">-->
<!--                                <label for="weight">Weight</label>-->
<!--                                <input type="text" class="form-control" id="weight" name="weight">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            <div class="col-sm-12">-->
<!--                                <label for="comment">Comment</label>-->
<!--                                <textarea class="form-control" id="comment" name="comment"></textarea>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            <div class="col-sm-6">-->
<!--                                <label for="bmi">BMI</label>-->
<!--                                <input type="text" class="form-control" id="bmi" name="bmi">-->
<!--                            </div>-->
<!--                            <div class="col-sm-6">-->
<!--                                <br/>-->
<!--                                <input type="submit" class="btn btn-primary">-->
<!--                            </div>-->
<!--                        </div>-->

                    </form>
                    <div class="clearfix"></div>
                    <div id="log_encounter_loading" class="text-center hidden"><span class="fa fa-spinner fa-spin"></span> </div>
                    <div class="text-center" id="log_encounter_response"></div>
                </div>
            </div>
            <div class="col-sm-3">
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
                    <div>
                        <br/><br/>
                        <div class="text-center" id="discharge_patient_content">
                            <button class="btn btn-success" id="discharge_patient">Print</button>
                            <div id="discharge_patient_error" class="text-danger"></div>
                        </div>

                    </div>
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
<script src="../js/billing.js"></script>
<?php include('footer.php'); ?>

</body>
</html>
