<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);

if(!isset($_SESSION[UserAuthTable::userid])){
    header("Location: ../index.php");
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
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/master.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/print.css" media="print">

</head>

<body>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand"><b>Patient Management System</b></a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            {{title}}
            {{body}}
            {{footer}}
        </div>
    </div>
</div> <!-- /container -->

<div class="navbar navbar-fixed-bottom">
    <div class="container-fluid">
        <div class="text-center">
            &copy; 2015. Patient Management System
        </div>
    </div>
</div>

<script src="../js/bootstrap/jquery-1.10.2.min.js"></script>
<script>
    $(document).ready(function(){
        window.print();
//        window.close();
    });
</script>
</body>
</html>
