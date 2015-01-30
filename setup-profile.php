<?php
require_once '_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);

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
    <link href="css/bootstrap/datepicker.css" rel="stylesheet">

    <script src="js/bootstrap/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap/bootstrap-datepicker.min.js"></script>
    <script src="js/profile.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">
    <div class="col-md-3">
        <img src="images/profile-setup.png" alt="Setup Profile" width="300">
    </div>
    <div class="col-md-8 col-md-offset-1">
        <div class="text-muted text-center text-uppercase ">
            <h1>Setup profile below</h1>
            <h3>&darr;</h3>
        </div>

        <div class="hidden text-center" id="form-loading">
            <img src="images/loading.gif">
        </div>
        <div class=" alert alert-danger hidden" id="form-error"></div>

        <form action="#" method="post" class="form-horizontal" id="profile-form">
            <input type="hidden" name="<?php echo ProfileTable::table_name.'['.ProfileTable::userid.']'?>" value="<?php echo CxSessionHandler::getItem(UserAuthTable::userid)?>">
            <input type="hidden" name="intent" value="addProfile">

            <div class="form-group">
                <label for="surname" class="col-sm-2 control-label">Surname</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="surname" name="<?php echo ProfileTable::table_name.'['.ProfileTable::surname.']'?>" placeholder="Type surname here">
                </div>
            </div>
            <div class="form-group">
                <label for="middle-name" class="col-sm-2 control-label">Middle Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="middle-name"  name="<?php echo ProfileTable::table_name.'['.ProfileTable::middlename.']'?>" placeholder="Type middle name here">
                </div>
            </div>
            <div class="form-group">
                <label for="first-name" class="col-sm-2 control-label">First Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="first-name" name="<?php echo ProfileTable::table_name.'['.ProfileTable::firstname.']'?>" placeholder="Tyoe first name here">
                </div>
            </div>
            <div class="form-group">
                <label for="dept" class="col-sm-2 control-label">Department</label>
                <div class="col-sm-10">
                    <select class="form-control" id="dept" name="<?php echo ProfileTable::table_name.'['.ProfileTable::department_id.']'?>">
                        <option value="1">Doctor</option>
                        <option value="2">Pharmacy</option>
                        <option value="3">Medical Records</option>
                        <option value="4">Agent</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="sex" class="col-sm-2 control-label">Sex</label>
                <div class="col-sm-10">
                    <select class="form-control" id="dept" name="<?php echo ProfileTable::table_name.'['.ProfileTable::sex.']'?>">
                        <option value="MALE">Male</option>
                        <option value="FEMALE">Female</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="telephone" class="col-sm-2 control-label">Mobile Number</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="<?php echo ProfileTable::table_name.'['.ProfileTable::telephone.']'?>" id="telephone" placeholder="Your mobile number">
                </div>
            </div>
            <div class="form-group">
                <label for="dob" class="col-sm-2 control-label">Date of Birth</label>
                <div class="col-sm-10">
                    <input name="<?php echo ProfileTable::table_name.'['.ProfileTable::birth_date.']'?>" class="date-picker form-control edit-read-only" readonly id="dob" type="text" placeholder="Date of birth" data-date-format="yyyy-mm-dd"/>
                </div>
            </div>
            <div class="form-group">
                <label for="height" class="col-sm-2 control-label">Height</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="<?php echo ProfileTable::table_name.'['.ProfileTable::height.']'?>" id="height" placeholder="Height in feet">
                </div>
            </div>
            <div class="form-group">
                <label for="weight" class="col-sm-2 control-label">Weight</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="weight" name="<?php echo ProfileTable::table_name.'['.ProfileTable::weight.']'?>" placeholder="Weight of feet">
                </div>
            </div>
            <div class="form-group">
                <label for="l-address" class="col-sm-2 control-label">Work Address</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="3" id="l-address" name="<?php echo ProfileTable::table_name.'['.ProfileTable::work_address.']'?>"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="h-address" class="col-sm-2 control-label">Home Address</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="3" id="h-address" name="<?php echo ProfileTable::table_name.'['.ProfileTable::home_address.']'?>"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                </div>
            </div>
        </form>

    </div>
</div> <!-- /container -->

</body>
</html>
