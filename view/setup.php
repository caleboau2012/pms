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
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/master.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">
    <div class="row">
        <div id="setup-container">
            <div class="bg-info text-center" id="setup-heading">
                <h4>PMS Setup</h4>
            </div>
            <div id="setup-nav">
                <div class="col-xs-4 setup-nav-active steps text-center" id="step-one-indicator">
                    Step 1
                </div>
                <div class="col-xs-4  steps text-center" id="step-two-indicator">
                    Step 2
                </div>
                <div class="col-xs-4 steps text-center" id="step-three-indicator">
                    Completed
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="steps_content" id="step-1_content">
                <form class="form-horizontal form-setup" id="step_one_form">
                    <div class="form-group">
                        <label for="root_user" class="col-sm-4 control-label">MySQL Root User</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="root_user">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="root_password" class="col-sm-4 control-label">MySQL Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="root_password" placeholder="Password for root user">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="admin_username" class="col-sm-4 control-label">Admin Username</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="admin_username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="admin_password" class="col-sm-4 control-label">Admin Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="admin_password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirm_admin_password" class="col-sm-4 control-label">Re-type Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="confirm_admin_password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-10">
                            <button type="submit" class="btn btn-primary">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="steps_content hidden" id="step-2_content">
                <form class="form-horizontal form-setup" id="step_one_form">
                    <div class="form-group">
                        <label for="root_user" class="col-sm-4 control-label">Hospital Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="root_user">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="root_password" class="col-sm-4 control-label">Hospital Address</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="root_password" placeholder="Password for root user"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Units</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-10">
                            <button type="submit" class="btn btn-primary">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div> <!-- /container -->
<script src="../js/bootstrap/jquery-1.10.2.min.js"></script>
<script src="../js/constants.js"></script>
<script src="../js/index.js"></script>
<script src="../js/Setup.js"></script>
</body>
</html>
