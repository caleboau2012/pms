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
    <script src="../js/constants.js"></script>
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

<script id="tmplTable" type="text/html">
    <tr>
        <td>{{sn}}</td>
        <td>{{staffId}}</td>
        <td>{{name}}</td>
        <td><button class="btn btn-sm btn-default" userid="{{userid}}" onclick="rapModal(this)">Manage</button></td>
    </tr>
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
                <li id="newStaff"><a href="#" onclick="newStaff(this)">Add new Staff</a></li>
            </ul>
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
                    <tbody id="staffTable">
                    <tr>
                        <td>1</td>
                        <td>Lorem</td>
                        <td>ipsum</td>
                        <td><button class="btn btn-sm btn-default" userid="1" onclick="rapModal(this)">Manage</button></td>
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
                        <h1 id="addNewRoleName" class="panel-title">[Name]</h1>
                    </div>
                    <div class="panel-body">
                        <form class="form">
                            <div class="pull-left">
                                <div class="">
                                    <label for="role" class="label label-info">Role</label>
                                    <select id="addNewRoleSelect" class="btn btn-default">
                                        <option>Doctor</option>
                                        <option>Role1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="pull-right">
                                <div class="">
                                    <div>
                                        <div class="btn-group" role="group">
                                            <span class="btn btn-sm btn-default">
                                                <input name="permission" type="radio" class="radio radio-inline">
                                                <span>Read_Only</span>
                                            </span>
                                            <span class="btn btn-sm btn-default">
                                                <input name="permission" type="radio" class="radio radio-inline">
                                                <span>Read_Write</span>
                                            </span>
                                        </div>
                                        <button class="btn btn-sm btn-primary">Add</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h1 class="panel-title">Edit Existing role(s)</h1>
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive">
                            <thead>
                                <th>Role</th>
                                <th>Permission</th>
                                <th>Delete</th>
                            </thead>
                            <tbody id="existingRolesTable">
                            <tr>
                                <td>[SHING]</td>
                                <td>[SHING]</td>
                                <td><button class="btn btn-sm btn-default">Delete</button></td>
                            </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-info pull-right" data-dismiss="modal">Save Changes</button>
                    </div>
                </div>
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