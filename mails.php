<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">

    <title>Admin Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/master.css" rel="stylesheet">
    <link href="css/bootstrap/datepicker.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="dashboard.php">Patient Management System</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" class="label-default">Roster</a></li>
            </ul>
            <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Search...">
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 roster-sidebar">
            <a href="#myModal" class="btn btn-primary btn-compose" data-toggle="modal">Compose</a>

            <ul class="list-group nav nav-tabs">
                    <a href="#inbox" class="list-group-item" data-toggle="tab">
                         Inbox <span class="badge">0</span>
                    </a>
                    <a href="#sentmails" class="list-group-item" data-toggle="tab">
                       Sent Mails <span class="badge">0</span>
                    </a>
                    <a href="#draft" class="list-group-item" data-toggle="tab">
                        Draft <span class="badge">0</span>
                    </a>
                    <a href="#trash" class="list-group-item" data-toggle="tab">
                         Trash <span class="badge">0</span>
                    </a>
            </ul>
        </div>
        <div class="col-sm-9 col-md-10 pull-right put-margin-top">
        <div class="tab-content">
            <div id="inbox" class="tab-pane fade in active">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Sender</th>
                            <th>Subject</th>
                            <th>Date Sent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>S/N</th>
                            <th>Sender</th>
                            <th>Subject</th>
                            <th>Date Sent</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div id="sentmails" class="tab-pane fade">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Recipient</th>
                        <th>Subject</th>
                        <th>Date Sent</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>S/N</th>
                        <th>Recipient</th>
                        <th>Subject</th>
                        <th>Date Sent</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div id="draft" class="tab-pane fade">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Subject</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>S/N</th>
                        <th>Subject</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div id="trash" class="tab-pane fade">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Subject</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>S/N</th>
                        <th>Date Sent</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">New Message</h4>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group ">
                            <input type="text" class="form-control" name="recipient" placeholder="Recipient">
                        </div>
                        <div class="form-group">
                            <input type="text" name="subject" class="form-control" placeholder="Subject">
                        </div>
                        <div class="form-group">
                            <textarea rows="12" name="message" class="form-control" placeholder="Message"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="Send" value="Send">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>





<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/bootstrap/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/bootstrap/bootstrap-datepicker.min.js"></script>
<script src="js/admin/roaster.js"></script>
</body>
</html>
