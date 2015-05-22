<?php
    if (!file_exists("_resource/setup")){
        header("Location: view/setup.php");
    };
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
    <script src="js/constants.js"></script>
    <script src="js/index.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">
    <div style="display:inline;width:80px;height:80px;"><canvas width="80" height="80"></canvas><input type="text" class="input-small knob" value="100" data-min="0" data-max="100" data-step="10" data-width="80" data-height="80" data-thickness=".2" data-fgcolor="#2091CF" style="width: 44px; height: 26px; position: absolute; vertical-align: middle; margin-top: 26px; margin-left: -62px; border: 0px; font-weight: bold; font-style: normal; font-variant: normal; font-stretch: normal; font-size: 16px; line-height: normal; font-family: Arial; text-align: center; color: rgb(32, 145, 207); padding: 0px; -webkit-appearance: none; background: none;"></div>
    <form class="" id="login">
        <div class="panel panel-primary form-signin">
            <div class="panel-heading">
                <h2 class="panel-title">PMS Signin</h2>
            </div>
            <div class="panel-body">
                <div class="hidden text-center" id="form-loading"><img src="images/loading.gif"></div>
                <div class="text-center alert alert-danger hidden" id="form-error"></div>

                <input type="hidden" name="intent" value="login">
                <div class="form-group">
                    <label class="sr-only" for="exampleInputAmount">Username</label>
                    <div class="input-group">
                        <div class="input-group-addon">Username</div>
                        <input type="text" class="form-control" name="regNo" required>
                    </div>
                </div>
                <div>
                    <label class="sr-only" for="exampleInputAmount">Password</label>
                    <div class="input-group">
                        <div class="input-group-addon">Password&nbsp;</div>
                        <input type="password" class="form-control" id="passcode" name="passcode" required>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button type="submit" class="btn btn-primary pull-right">Sign in</button>
                <div class="clearfix"></div>
            </div>
        </div>
    </form>
</div> <!-- /container -->

</body>
</html>
