<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>System Restore</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap/jquery-ui.css" rel="stylesheet">
    <link href="css/bootstrap/jquery.dataTables.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/master.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="container">
    <div class="row">
        <div id="top-margin" class="col-sm-6 col-sm-offset-3 well restore-shadow">
            <h2>System Restore</h2><hr>

            <h5>Choose File</h5>
            <input type="file" name="fileToUpload" class="form-control"/>
            <button type="submit" id="restore" class="form-margin btn btn-primary pull-right">Restore</button>
        </div>
    </div>
</div>

<script src="js/bootstrap/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap/jquery-ui.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/constants.js"></script>
<script src="js/backup_restore.js"></script>
</body>
</html>