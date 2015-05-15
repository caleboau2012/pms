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
        <div class="col-sm-6 col-sm-offset-3 well restore-shadow">
            <iframe id="upload_frame" name="upload_frame" src="" hidden="hidden"></iframe>
            <div class="col-sm-12">
                <h2>System Restore</h2><hr>
                <form name="form" id="form" action="phase/phase_backup_restore.php?intent=upload" enctype="multipart/form-data" method="post">
                    <h5>Choose File</h5>
                    <div class="input-group">
                        <input id="file" type="file" name="fileToUpload" class="form-control col-sm-12" />
                        <span class="restore-addon"><input type="submit" name="Upload" value="Upload" class="btn btn-default"/></span>
                    </div>
                    <p id="success" class="col-sm-10 text-success text-center">File Upload Successful</p>
                    <button id="restore" class="form-margin btn btn-primary pull-right">Restore</button>
                </form>
            </div>
            <div class="col-sm-12 restore-margin">
                <p class="text-center">. . . or Restore From</p>
            </div>
            <div class="col-sm-12">
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Backup Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="filesToRestore">
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
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