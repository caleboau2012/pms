<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'UserModel'));
Crave::requireFiles(CONTROLLER, array('AuthenticationController', 'UserController'));

if(!isset($_SESSION[UserAuthTable::userid])){
    header("Location: index.php");
}

$userController = new UserController();
$profile = $userController->getUserProfile($_SESSION[UserAuthTable::userid]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ELYON 1.0</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/master.css" rel="stylesheet">
    <link href="../css/bootstrap/datepicker.css" rel="stylesheet">

    <script src="../js/bootstrap/jquery-1.10.2.min.js"></script>
    <script src="../js/bootstrap/bootstrap.min.js"></script>
    <script src="../js/bootstrap/bootstrap-datepicker.min.js"></script>
    <script src="../js/constants.js"></script>
    <script src="../js/profile.js"></script>
    <script src="../js/index.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<!--Page header-->
<?php Crave::requireFiles(HEADERS, array('main')) ?>

<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title"><h4>Your profile</h4></div>
            </div>
            <div class="panel-body">
                <div class="hidden text-center" id="form-loading">
                    <img src="../images/loading.gif">
                </div>
                <div class="text-danger  text-center hidden " id="form-error"></div>
                <div class="text-success text-center hidden" id="form-success"></div>
                <form action="#" method="post" role="form"  id="profile-form">
                    <input type="hidden" name="<?php echo ProfileTable::table_name.'['.ProfileTable::userid.']'?>" value="<?php echo CxSessionHandler::getItem(UserAuthTable::userid)?>">
                    <input type="hidden" name="intent" value="updateProfile">
                    <div class="form-group-lg col-md-4">
                        <label for="first-name">First Name</label>
                        <input type="text" class="form-control" id="first-name" name="<?php echo ProfileTable::table_name.'['.ProfileTable::firstname.']'?>" required value="<?php echo $profile[ProfileTable::firstname]?>">
                    </div>
                    <div class="form-group-lg col-md-4">
                        <label for="middle-name">Middle Name</label>
                        <input type="text" class="form-control" id="middle-name"  name="<?php echo ProfileTable::table_name.'['.ProfileTable::middlename.']'?>" required value="<?php echo $profile[ProfileTable::middlename]?>">
                    </div>
                    <div class="form-group-lg col-md-4">
                        <label for="surname">Surname</label>
                        <input type="text" class="form-control" id="surname" name="<?php echo ProfileTable::table_name.'['.ProfileTable::surname.']'?>" required value="<?php echo $profile[ProfileTable::surname]?>">
                    </div>

                    <div class="form-group-lg col-md-4">
                        <label for="dob">Date of Birth</label>
                        <input name="<?php echo ProfileTable::table_name.'['.ProfileTable::birth_date.']'?>" class="date-picker form-control edit-read-only" readonly id="dob" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $profile[ProfileTable::birth_date]?>"/>
                    </div>
                    <div class="form-group-lg col-md-4">
                        <label for="height">Height</label><span class="text-danger">&nbsp;(metre)</span>
                        <input type="text" class="form-control" name="<?php echo ProfileTable::table_name.'['.ProfileTable::height.']'?>" id="height" value="<?php echo $profile[ProfileTable::height]?>">
                    </div>
                    <div class="form-group-lg col-md-4">
                        <label for="weight">Weight</label><span class="text-danger">&nbsp;(kg)</span>
                        <input type="text" class="form-control" id="weight" name="<?php echo ProfileTable::table_name.'['.ProfileTable::weight.']'?>" value="<?php echo $profile[ProfileTable::weight]?>">
                    </div>
                    <div class="form-group-lg col-md-3">
                        <label for="sex">Sex</label>
                        <select class="form-control" id="dept" name="<?php echo ProfileTable::table_name.'['.ProfileTable::sex.']'?>">
                            <option <?php echo ($profile[ProfileTable::sex] == "MALE")?"selected":""?> value="MALE">Male</option>
                            <option <?php echo ($profile[ProfileTable::sex] == "FEMALE")?"selected":""?> value="FEMALE">Female</option>
                        </select>
                    </div>
                    <div class="form-group-lg col-md-3">
                        <label for="telephone">Mobile Number</label>
                        <input type="text" class="form-control" name="<?php echo ProfileTable::table_name.'['.ProfileTable::telephone.']'?>" id="telephone" value="<?php echo $profile[ProfileTable::telephone]?>">
                    </div>
                    <div class="form-group-lg col-md-6">
                        <label for="dept">Department</label>
                        <select class="form-control" id="dept" name="<?php echo ProfileTable::table_name.'['.ProfileTable::department_id.']'?>">
                            <option <?php echo ($profile[ProfileTable::department_id] == 1)?"selected":""?> value="<?php echo DOCTOR; ?>">Doctor</option>
                            <option <?php echo ($profile[ProfileTable::department_id] == 2)?"selected":""?> value="<?php echo PHARMACIST; ?>">Pharmacy</option>
                            <option <?php echo ($profile[ProfileTable::department_id] == 3)?"selected":""?> value="<?php echo MEDICAL_RECORD; ?>">Medical Records</option>
                            <option <?php echo ($profile[ProfileTable::department_id] == 7)?"selected":""?> value="<?php echo URINE_CONDUCTOR; ?>">Microscopy</option>
                            <option <?php echo ($profile[ProfileTable::department_id] == 5)?"selected":""?> value="<?php echo VISUAL_CONDUCTOR; ?>">Visual</option>
                            <option <?php echo ($profile[ProfileTable::department_id] == 6)?"selected":""?> value="<?php echo XRAY_CONDUCTOR; ?>">XRAY</option>
                            <option <?php echo ($profile[ProfileTable::department_id] == 4)?"selected":""?> value="<?php echo PARASITOLOGY_CONDUCTOR; ?>">Parasitology</option>
                            <option <?php echo ($profile[ProfileTable::department_id] == 8)?"selected":""?> value="<?php echo CHEMICAL_PATHOLOGY_CONDUCTOR; ?>">Chemical Pathology</option>
                        </select>
                    </div>
                    <div class="form-group-lg col-md-6">
                        <label for="h-address">Home Address</label>
                        <textarea class="form-control" rows="3" id="h-address" name="<?php echo ProfileTable::table_name.'['.ProfileTable::home_address.']'?>"><?php echo $profile[ProfileTable::home_address]?></textarea>
                    </div>
                    <div class="form-group-lg col-md-6">
                        <label for="l-address">Work Address</label>
                        <textarea class="form-control" rows="3" id="l-address" name="<?php echo ProfileTable::table_name.'['.ProfileTable::work_address.']'?>"><?php echo $profile[ProfileTable::work_address]?></textarea>
                    </div>
                    <div class="form-group-lg col-md-6">
                        <button type="submit" class="btn btn-lg btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>Change Password</h4>
                </div>
            </div>
            <div class="panel-body">
                <form autocomplete="off" class="form-group-lg" id="passwordForm">
                    <div class="hidden text-center" id="form-loading"><img src="../images/loading.gif"></div>
                    <div class=" alert alert-danger hidden text-center" id="form-error"></div>
                    <div class=" alert alert-success hidden text-center" id="form-success"></div>

                    <input type="hidden" name="intent" value="changePassword">
                    <input type="hidden" name="userid" value="<?php echo CxSessionHandler::getItem(UserAuthTable::userid)?>">
                    <input type="hidden" name="status" value="<?php echo CxSessionHandler::getItem(UserAuthTable::status)?>">
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
</div> <!-- /container -->

</body>
</html>
