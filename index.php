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

    <title>Elyon</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">

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
    <form class="" id="login">
        <div class="panel panel-primary form-signin">
            <div class="panel-heading">
                <h2 class="panel-title"><span class="fa fa-lock"></span> Login</h2>
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

<?php
include("view/footer.php");
?>

</body>
</html>
