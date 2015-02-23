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
    <script src="js/index.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">

    <!--    <form class="form-signin" id="login">-->
    <!--        <h2 class="form-signin-heading text-center text-muted">PMS Signin</h2>-->
    <!--        <div class="hidden text-center" id="form-loading"><img src="images/loading.gif"></div>-->
    <!--        <div class=" center-block alert alert-danger hidden" id="form-error"></div>-->
    <!--        <label for="inputEmail" class="sr-only">Email address</label>-->
    <!--        <input type="hidden" name="intent" value="login">-->
    <!--        <input type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus name="regNo">-->
    <!--        <label for="inputPassword" class="sr-only">Password</label>-->
    <!--        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="passcode">-->
    <!--        <div class="checkbox text-muted text-right">-->
    <!--            <label>-->
    <!--                <input type="checkbox" value="remember-me"> Remember me-->
    <!--            </label>-->
    <!--        </div>-->
    <!--        <button class="btn btn-sm btn-primary btn-block" type="submit">Sign in</button>-->
    <!--        </form>-->
    <!--<br/>-->
    <form class="form-signin" id="login">
        <h2 class="form-signin-heading text-center text-muted">PMS Sign In</h2>

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
        <div class="form-group">
            <label class="sr-only" for="exampleInputAmount">Password</label>
            <div class="input-group">
                <div class="input-group-addon">Password</div>
                <input type="password" class="form-control" id="passcode" name="passcode" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Sign in</button>


    </form>



</div> <!-- /container -->

</body>
</html>
