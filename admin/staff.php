
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Admin Dashboard</title>

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

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="patients.php">Patients</a></li>
                <li><a href="#" class="label-default">Staff</a></li>
                <li><a href="#">Config</a></li>
                <li><a href="#">Help</a></li>
            </ul>
            <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Search...">
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Add new Staff</a></li>
<!--                <li><a href="#">Analytics</a></li>-->
<!--                <li><a href="#">Export</a></li>-->
            </ul>
<!--            <ul class="nav nav-sidebar">-->
<!--                <li><a href="">Nav item</a></li>-->
<!--                <li><a href="">Nav item again</a></li>-->
<!--                <li><a href="">One more nav</a></li>-->
<!--                <li><a href="">Another nav item</a></li>-->
<!--                <li><a href="">More navigation</a></li>-->
<!--            </ul>-->
<!--            <ul class="nav nav-sidebar">-->
<!--                <li><a href="">Nav item again</a></li>-->
<!--                <li><a href="">One more nav</a></li>-->
<!--                <li><a href="">Another nav item</a></li>-->
<!--            </ul>-->
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Staff ID</th>
                        <th>Name </th>
                        <th>Roles and Permissions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Lorem</td>
                        <td>ipsum</td>
                        <td><button class="btn btn-sm btn-default" onclick="rapModal()">Manage</button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Lorem</td>
                        <td>ipsum</td>
                        <td><button class="btn btn-sm btn-default">Manage</button></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Lorem</td>
                        <td>ipsum</td>
                        <td><button class="btn btn-sm btn-default">Manage</button></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Lorem</td>
                        <td>ipsum</td>
                        <td><button class="btn btn-sm btn-default">Manage</button></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Lorem</td>
                        <td>ipsum</td>
                        <td><button class="btn btn-sm btn-default">Manage</button></td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="rapModal" tabindex="-1" role="dialog" aria-labelledby="rapModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="rapModalTitle">Roles and Permission</h4>
            </div>
            <div class="modal-body">
                <input id="regNo" name="regNo" hidden>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h1 class="panel-title">[Name]</h1>
                    </div>
                    <div class="panel-body">
                        <form class="container">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="role" class="label label-info">Role</label>
                                    <select class="btn btn-default">
                                        <option>Role0</option>
                                        <option>Role1</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-sm-offset-1">
                                    <div>
                                        <span class="tab-pane">
                                            <input type="radio" class="radio radio-inline">
                                            <span>Read_only</span>
                                        </span>
                                        <input type="radio" class="radio radio-inline"><span>Read_write</span>
                                    </div>
                                </div>
                            </div>


                            <button class="btn btn-info">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/bootstrap/jquery-1.10.2.min.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/admin/staff.js"></script>
</body>
</html>