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

    <script src="js/bootstrap/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap/bootstrap-datepicker.min.js"></script>
    <script src="js/index.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">
<!--        <form class="form-signin" id="change-password" autocomplete="off">-->
<!--            <div class="alert alert-info">-->
<!--                <p>-->
<!--                    Welcome! you need to change your password-->
<!--                </p>-->
<!--            </div>-->
<!--<!--            <h2 class="form-signin-heading">Change Password</h2>-->-->
<!--            <div class="hidden text-center" id="form-loading"><img src="images/loading.gif"></div>-->
<!--            <div class=" alert alert-danger hidden" id="form-error"></div>-->
<!--            <div class=" alert alert-success hidden" id="form-success"></div>-->
<!---->
<!--            <input type="hidden" name="intent" value="changePassword">-->
<!--            <input type="hidden" name="userid" value="--><?php //echo CxSessionHandler::getItem(UserAuthTable::userid)?><!--">-->
<!--            <input type="hidden" name="status" value="--><?php //echo CxSessionHandler::getItem(UserAuthTable::status)?><!--">-->
<!--            <label for="passcode" class="sr-only">Password</label>-->
<!--            <input type="password" autocomplete="off" id="passcode" class="form-control" placeholder="New Password" required name="passcode">-->
<!--            <label for="confirm_passcode" class="sr-only">Change Password</label>-->
<!--            <input type="password" autocomplete="off" id="confirm_passcode" class="form-control" placeholder="Confirm New Password" required name="confirm_passcode">-->
<!--            <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>-->
<!--        </form>-->

    <form class="form-signin" id="change-password" autocomplete="off">
        <h2 class="form-signin-heading text-center text-muted">PMS Signin</h2>
        <div class="text-center alert alert-warning" id="form-info">
                Welcome! you need to change your password
        </div>

        <div class="hidden text-center" id="form-loading"><img src="images/loading.gif"></div>
        <div class=" alert alert-danger hidden text-center" id="form-error"></div>
        <div class=" alert alert-success hidden text-center" id="form-success"></div>

        <input type="hidden" name="intent" value="changePassword">
        <input type="hidden" name="userid" value="<?php echo CxSessionHandler::getItem(UserAuthTable::userid)?>">
        <input type="hidden" name="status" value="<?php echo CxSessionHandler::getItem(UserAuthTable::status)?>">
        <div class="form-group">
            <label class="sr-only" for="exampleInputAmount">Username</label>
            <div class="input-group">
                <div class="input-group-addon">New Password</div>
                <input type="password" class="form-control" id="passcode" name="passcode" required>
                <div class="input-group-addon"><span class="small pointer" id="show_hide">show</span> </div>
            </div>
        </div>
        <div class="form-group">
            <label class="sr-only" for="passcode">Re-type Password</label>
            <div class="input-group">
                <div class="input-group-addon">Re-type Password</div>
                <input type="password" class="form-control" id="confirm_passcode" name="confirm_passcode" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


</div> <!-- /container -->

</body>
</html>
