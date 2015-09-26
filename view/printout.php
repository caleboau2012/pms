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
    <link href="<?php echo HOST?>css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo HOST?>css/master.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo HOST?>css/print.css" media="print">

</head>

<body>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand"><b><?php
                    if(is_null(CxSessionHandler::getItem('hospital_name'))){
                        echo "Patient Management System";
                    }else{
                        echo ucwords(CxSessionHandler::getItem('hospital_name'));
                    }
                    ?></b></a>
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

<br>

<div>
    <div class="text-center">
        Copyright &copy; 2015 ELYON 1.0 | All Rights Reserved
    </div>
</div>

<script src="<?php echo HOST?>js/bootstrap/jquery-1.10.2.min.js"></script>
<script>
    $(document).ready(function(){
        window.print();
//        window.close();
    });
</script>
</body>
</html>
