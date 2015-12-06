<?php
require_once '../_core/global/_require.php';
Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);

if(!CxSessionHandler::getItem(UserAuthTable::userid)){
    header("Location: ../index.php");
} else {
    $name = CxSessionHandler::getItem(ProfileTable::surname) . " " . CxSessionHandler::getItem(ProfileTable::middlename) . " " . CxSessionHandler::getItem(ProfileTable::firstname);
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
    <link rel="icon" href="../favicon.ico">

    <title>Backups</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/master.css" rel="stylesheet">
    <link href="../css/bootstrap/datepicker.css" rel="stylesheet">
    <link href="../css/bootstrap/jquery-ui.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!--page header-->
<?php Crave::requireFiles(HEADERS, array('main')) ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 well">
            <h2 class="backup-title">Backup Files</h2>
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th>S/N</th>
                    <th>Backup Date</th>
                    <th>Download</th>
                </tr>
                </thead>
                <tbody id="backup">
                <tr>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>




<script src="../js/bootstrap/jquery-1.10.2.min.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/constants.js"></script>
<script src="../js/backup_restore.js" type="application/javascript"></script>
<?php include('footer.php'); ?>
</body>
</html>
