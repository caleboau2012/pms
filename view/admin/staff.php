<?php
/**
 * Created by PhpStorm.
 * User: olajuwon
 * Date: 2/16/2015
 * Time: 1:10 PM
 */
require_once '../../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
if(!isset($_SESSION[UserAuthTable::userid])){
    header("Location: ../index.php");
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
    <link rel="icon" href="../../favicon.ico">

    <title>Admin Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/bootstrap/jquery.dataTables.css" rel="stylesheet">
    <link href="../../css/bootstrap/datepicker.css" rel="stylesheet">
    <link href="../../css/sticky-footer-navbar.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../css/master.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/print.css" media="print">
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
                <li><a href="patients.php">Patients</a></li>
                <li><a href="staff.php" class="label-default">Staff</a></li>
                <li><a href="config.php">Config</a></li>
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

<script id="tmplTable" type="text/html">
    <tr>
        <td>{{sn}}</td>
        <td>{{staffId}}</td>
        <td>{{name}}</td>
        <td><button class="btn btn-sm btn-default" data-status="{{profile-status}}" userid="{{userid}}" onclick="profileModal(this)">Manage</button></td>
        <td><button class="btn btn-sm btn-default" userid="{{userid}}" onclick="rapModal(this)">Manage</button></td>
        <td>
            <div class="switch">
                <input id="cmn-toggle-{{userid}}" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label active_fg="{{active_fg}}" userid="{{userid}}" for="cmn-toggle-{{userid}}"  onclick="return toggleDelete(this)"></label>
            </div>
        </td>
    </tr>
</script>

<script id="tmplPopover" type="text/html">
    <div class='form'>
        <div class="hidden alert alert-danger alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p><strong>Warning!</strong> Invalid Registration Number and Password</p>
        </div>
        <input class='form-control' id='regNo' placeholder='Registration No'><br>
        <div class="input-group">
            <input class="form-control" id='password' placeholder='Password' aria-describedby="generate">
            <span class="btn btn-info input-group-addon" id="generate" onclick="generatePassword()">Generate</span>
        </div>
        <br>
        <button class='form-control btn btn-info' onclick="addNewStaff(this)">Add</button>
    </div>
</script>

<script id="tmplPrint" type="text/html">
    <div style="padding: 10px;">
        <p>
            <b>Username: </b>
            <span class="small"> {{username}}</span>
        </p>
        <p>
            <b>Password: </b>
            <span class="small"> {{password}}</span>
        </p>
    </div>
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
                <li id="newStaff"><a href="#" onclick="newStaff(this)">Add new Staff</a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="table-responsive">
                <table class="table dataTable table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Staff ID</th>
                        <th>Name </th>
                        <th>Profile</th>
                        <th>Roles and Permissions</th>
                        <th>Disable?</th>
                    </tr>
                    </thead>
                    <tbody id="staffTable">
                    <tr>
                        <td>1</td>
                        <td></td>
                        <td></td>
                        <td><button class="btn btn-sm btn-default" userid="1" onclick="profileModal(this)">Manage</button></td>
                        <td><button class="btn btn-sm btn-default" userid="1" onclick="rapModal(this)">Manage</button></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="rapModalTitle">Staff Profile</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title"><h4>Manage profile</h4></div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="hidden text-center" id="form-loading">
                                        <img src="../images/loading.gif">
                                    </div>
                                    <div class="text-danger  text-center hidden " id="form-error"></div>
                                    <div class="text-success text-center hidden" id="form-success"></div>
                                    <form action="#" method="post" role="form"  id="profile-form">
                                        <input type="hidden" id="profile-user-id" name="<?php echo ProfileTable::table_name.'['.ProfileTable::userid.']'?>">
                                        <input type="hidden" name="intent" id="intent" value="updateProfile">
                                        <div class="form-group col-md-4">
                                            <label for="first-name">First Name</label>
                                            <input type="text" class="form-control" id="first-name" name="<?php echo ProfileTable::table_name.'['.ProfileTable::firstname.']'?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="middle-name">Middle Name</label>
                                            <input type="text" class="form-control" id="middle-name"  name="<?php echo ProfileTable::table_name.'['.ProfileTable::middlename.']'?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="surname">Surname</label>
                                            <input type="text" class="form-control" id="surname" name="<?php echo ProfileTable::table_name.'['.ProfileTable::surname.']'?>" required >
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="dob">Date of Birth</label>
                                            <input name="<?php echo ProfileTable::table_name.'['.ProfileTable::birth_date.']'?>" class="date-picker form-control edit-read-only" readonly id="dob" type="text" data-date-format="yyyy-mm-dd"/>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="height">Height</label><span class="text-danger">&nbsp;(metre)</span>
                                            <input type="text" class="form-control" name="<?php echo ProfileTable::table_name.'['.ProfileTable::height.']'?>" id="height">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="weight">Weight</label><span class="text-danger">&nbsp;(kg)</span>
                                            <input type="text" class="form-control" id="weight" name="<?php echo ProfileTable::table_name.'['.ProfileTable::weight.']'?>" >
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="sex">Sex</label>
                                            <select class="form-control" id="sex" name="<?php echo ProfileTable::table_name.'['.ProfileTable::sex.']'?>">
                                                <option id="sex-male" value="MALE">Male</option>
                                                <option id="sex-female" value="FEMALE">Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="telephone">Mobile Number</label>
                                            <input type="text" class="form-control" name="<?php echo ProfileTable::table_name.'['.ProfileTable::telephone.']'?>" id="telephone" value="<?php echo $profile[ProfileTable::telephone]?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="dept">Department</label>
                                            <select class="form-control" id="dept" name="<?php echo ProfileTable::table_name.'['.ProfileTable::department_id.']'?>">
                                                <option id="dept-doctor" value="<?php echo DOCTOR; ?>">Doctor</option>
                                                <option id="dept-pharmacy" value="<?php echo PHARMACIST; ?>">Pharmacy</option>
                                                <option id="dept-mro" value="<?php echo MEDICAL_RECORD; ?>">Medical Records</option>
                                                <option id="dept-urine" value="<?php echo URINE_CONDUCTOR; ?>">Microscopy</option>
                                                <option id="dept-visual" value="<?php echo VISUAL_CONDUCTOR; ?>">Visual</option>
                                                <option id="dept-xray" value="<?php echo XRAY_CONDUCTOR; ?>">Radiology</option>
                                                <option id="dept-parasitology" value="<?php echo PARASITOLOGY_CONDUCTOR; ?>">Parasitology</option>
                                                <option id="dept-pathology" value="<?php echo CHEMICAL_PATHOLOGY_CONDUCTOR; ?>">Chemical Pathology</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="h-address">Home Address</label>
                                            <textarea class="form-control" rows="3" id="h-address" name="<?php echo ProfileTable::table_name.'['.ProfileTable::home_address.']'?>"><?php echo $profile[ProfileTable::home_address]?></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="l-address">Work Address</label>
                                            <textarea class="form-control" rows="3" id="l-address" name="<?php echo ProfileTable::table_name.'['.ProfileTable::work_address.']'?>"><?php echo $profile[ProfileTable::work_address]?></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button type="submit" class="btn btn-lg btn-success">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <h4>Change Password</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form autocomplete="off" class="form-group" id="passwordForm">
                                    <div class="hidden text-center" id="form-loading"><img src="../images/loading.gif"></div>
                                    <div class=" alert alert-danger hidden text-center" id="form-error"></div>
                                    <div class=" alert alert-success hidden text-center" id="form-success"></div>

                                    <input type="hidden" name="intent" value="changePassword">
                                    <input type="hidden" id="password-userid" name="userid">
                                    <input type="hidden" name="status" value="1">
                                    <span class="form-inline">
                                        <label class="sr-only" for="exampleInputAmount">Username</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">New Password &nbsp; &nbsp; &nbsp;</div>
                                            <input type="password" class="form-control " id="passcode" name="passcode" required>
                                        </div>
                                    </span>
                                    <span class="form-inline">
                                        <label class="sr-only" for="passcode">Re-type Password</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">Re-type Password </div>
                                            <input type="password" class="form-control" id="confirm_passcode" name="confirm_passcode" required>
                                        </div>
                                    </span>
                                    <button type="submit" class="btn btn-warning btn-lg">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Roles and Permissions Modal -->
<div class="modal fade" id="rapModal" tabindex="-1" role="dialog" aria-labelledby="rapModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="rapModalTitle">Roles and Permission</h4>
            </div>
            <div class="modal-body">
                <div class="alert hidden alert-danger alert-dismissable" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span id="alertMSG"></span>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h1 id="addNewRoleName" class="panel-title">[Name]</h1>
                    </div>
                    <div class="panel-body">
                        <form class="form" onsubmit="return addNewRole(this)">
                            <div class="pull-left">
                                <div class="">
                                    <label for="role" class="label label-info">Role</label>
                                    <select name="role" id="addNewRoleSelect" class="btn btn-default">
                                    </select>
                                </div>
                            </div>
                            <div class="pull-right">
                                <div class="btn-group" role="group">
                                    <span class="btn btn-sm btn-default">
                                        <input name="permission" type="radio" value="1" checked class="radio radio-inline">
                                        <span>View</span>
                                    </span>
                                    <span class="btn btn-sm btn-default">
                                        <input name="permission" type="radio" value="2" class="radio radio-inline">
                                        <span>View & Edit</span>
                                    </span>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h1 class="panel-title">Edit Existing role(s)</h1>
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive">
                            <thead>
                            <th>Role</th>
                            <th>Permission</th>
                            <th>Delete</th>
                            </thead>
                            <tbody id="existingRolesTable">
                            <tr>
                                <td>[SHING]</td>
                                <td>[SHING]</td>
                                <td><button class="btn btn-sm btn-default">Delete</button></td>
                            </tr>
                            </tbody>
                        </table>
                        <!--   <button class="btn btn-info pull-right" data-dismiss="modal">Save Changes</button>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../../js/bootstrap/jquery-1.10.2.min.js"></script>
<script src="../../js/bootstrap/jquery.dataTables.js"></script>
<script src="../../js/bootstrap/bootstrap.min.js"></script>
<script src="../../js/bootstrap/bootstrap-datepicker.min.js"></script>
<script src="../../js/libs/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="../../js/constants.js"></script>
<script src="../../js/pinger.js"></script>
<script src="../../js/profile.js"></script>
<script src="../../js/index.js"></script>
<script src="../../js/admin/staff.js"></script>

<?php include('../footer.php'); ?>

</body>
</html>