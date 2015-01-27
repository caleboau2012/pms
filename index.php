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

    <script src="js/bootstrap/jquery-1.10.0.min.js"></script>
    <script src="js/login.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">

    <form class="form-signin" id="login">
        <h2 class="form-signin-heading">Please sign in</h2>
        <div class=" alert alert-danger hidden" id="form-error"></div>

        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="hidden" name="intent" value="login">
        <input type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus name="regNo">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="passcode">
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>

</div> <!-- /container -->

</body>
</html>
