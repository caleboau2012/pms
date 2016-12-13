<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
//
//if(!isset($_SESSION[UserAuthTable::userid])){
//    header("Location: index.php");
//}
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
    <script src="../js/bootstrap/bootstrap-datepicker.min.js"></script>
    <script src="../js/constants.js"></script>
    <script src="../js/profile.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-muted text-center text-uppercase ">
                <h1 class="text-primary">Setup Staff profile </h1>
            </div>
            <div class="form-profile">
                <div class="hidden text-center" id="form-loading">
                    <img src="../images/loading.gif">
                </div>
                        <div class="text-danger  text-center hidden " id="form-error"></div>
                        <div class="text-success text-center hidden" id="form-success"></div>
                <form action="#" method="post" role="form"  id="profile-form">
                    <input type="hidden" name="<?php echo ProfileTable::table_name.'['.ProfileTable::userid.']'?>" value="<?php echo CxSessionHandler::getItem(UserAuthTable::userid)?>">
                    <input type="hidden" name="intent" value="addProfile">
                    <div class="form-group-lg col-md-4">
                        <label for="first-name">First Name</label>
                        <input type="text" class="form-control" id="first-name" name="<?php echo ProfileTable::table_name.'['.ProfileTable::firstname.']'?>" required >
                    </div>
                    <div class="form-group-lg col-md-4">
                        <label for="middle-name">Middle Name</label>
                        <input type="text" class="form-control" id="middle-name"  name="<?php echo ProfileTable::table_name.'['.ProfileTable::middlename.']'?>" required >
                    </div>
                    <div class="form-group-lg col-md-4">
                        <label for="surname">Surname</label>
                        <input type="text" class="form-control" id="surname" name="<?php echo ProfileTable::table_name.'['.ProfileTable::surname.']'?>" required >
                    </div>

                    <div class="form-group-lg col-md-4">
                        <label for="dob">Date of Birth</label>
                        <input name="<?php echo ProfileTable::table_name.'['.ProfileTable::birth_date.']'?>" class="date-picker form-control edit-read-only" readonly id="dob" type="text" data-date-format="yyyy-mm-dd"/>
                    </div>
                    <div class="form-group-lg col-md-4">
                        <label for="height">Height</label><span class="text-danger">&nbsp;(metre)</span>
                        <input type="text" class="form-control" name="<?php echo ProfileTable::table_name.'['.ProfileTable::height.']'?>" id="height">
                    </div>
                    <div class="form-group-lg col-md-4">
                        <label for="weight">Weight</label><span class="text-danger">&nbsp;(kg)</span>
                        <input type="text" class="form-control" id="weight" name="<?php echo ProfileTable::table_name.'['.ProfileTable::weight.']'?>" >
                    </div>
                    <div class="form-group-lg col-md-3">
                        <label for="sex">Sex</label>
                        <select class="form-control" id="dept" name="<?php echo ProfileTable::table_name.'['.ProfileTable::sex.']'?>">
                            <option value="MALE">Male</option>
                            <option value="FEMALE">Female</option>
                        </select>
                    </div>
                    <div class="form-group-lg col-md-3">
                        <label for="telephone">Mobile Number</label>
                        <input type="text" class="form-control" name="<?php echo ProfileTable::table_name.'['.ProfileTable::telephone.']'?>" id="telephone" >
                    </div>
                    <div class="form-group-lg col-md-6">
                        <label for="dept">Department</label>
                        <select class="form-control" id="dept" name="<?php echo ProfileTable::table_name.'['.ProfileTable::department_id.']'?>">
                            <option value="<?php echo DOCTOR; ?>">Doctor</option>
                            <option value="<?php echo PHARMACIST; ?>">Pharmacy</option>
                            <option value="<?php echo MEDICAL_RECORD; ?>">Medical Records</option>
                            <option value="<?php echo URINE_CONDUCTOR; ?>">Urine</option>
                            <option value="<?php echo VISUAL_CONDUCTOR; ?>">Visual</option>
                            <option value="<?php echo XRAY_CONDUCTOR; ?>">Radiology</option>
                            <option value="<?php echo PARASITOLOGY_CONDUCTOR; ?>">Parasitology</option>
                            <option value="<?php echo CHEMICAL_PATHOLOGY_CONDUCTOR; ?>">Chemical Pathology</option>
                        </select>
                    </div>
                    <div class="form-group-lg col-md-6">
                        <label for="h-address">Home Address</label>
                        <textarea class="form-control" rows="3" id="h-address" name="<?php echo ProfileTable::table_name.'['.ProfileTable::home_address.']'?>"></textarea>
                    </div>
                    <div class="form-group-lg col-md-6">
                        <label for="l-address">Work Address</label>
                        <textarea class="form-control" rows="3" id="l-address" name="<?php echo ProfileTable::table_name.'['.ProfileTable::work_address.']'?>"></textarea>
                    </div>
                    <div class="form-group-lg col-md-6">
                      <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div> <!-- /container -->

</body>
</html>
