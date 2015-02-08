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
    <link href="../css/bootstrap/jquery.dataTables.css" rel="stylesheet">

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
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Patient Management System</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right nav-pills">
                <li><a href="#" data-toggle="modal" data-target="#newPatientModal">New Patient</a></li>
                <li><a href="#">Emergency</a></li>
            </ul>
            <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Search Returning Patients...">
            </form>
        </div>
    </div>
</nav>

<script id="tmplTable" type="text/html">
    <tr>
        <td>{{sn}}</td>
        <td>{{patientId}}</td>
        <td>{{name}}</td>
        <td>{{dob}}</td>
        <td>
            <button class="btn btn-sm btn-default" patientId="{{patient_id}}" onclick="printDetails(this)">Print
            </button>
        </td>
    </tr>
</script>

<script id="tmplPrint" type="text/html">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h1 class="panel-title">Patient Details</h1>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="pull-left" style="margin: 10px;">
                        <label for="name" class="label label-primary">Name</label>
                        <span name="name" class="btn btn-default">{{name}}</span>
                    </div>
                    <div class="pull-right" style="margin: 10px;">
                        <label for="regNo" class="label label-primary">Registration No</label>
                        <span name="regNo" class="btn btn-default">{{regNo}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="pull-left" style="margin: 10px;">
                        <label for="addy" class="label label-info">Address</label>
                        <span name="addy" class="btn btn-default">{{addy}}</span>
                    </div>
                    <div class="pull-left" style="margin: 10px;">
                        <label for="phone" class="label label-info">Telephone</label>
                        <span name="phone" class="btn btn-default">{{phone}}</span>
                    </div>
                    <div class="pull-right" style="margin: 10px;">
                        <label for="sex" class="label label-info">Gender</label>
                        <span name="sex" class="btn btn-default">{{sex}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="pull-left" style="margin: 10px;">
                        <label for="height" class="label label-info">Height</label>
                        <span name="height" class="btn btn-default">{{height}}</span>
                    </div>
                    <div class="pull-left" style="margin: 10px;">
                        <label for="weight" class="label label-info">Weight</label>
                        <span name="weight" class="btn btn-default">{{weight}}</span>
                    </div>
                    <div class="pull-right" style="margin: 10px;">
                        <label for="birth" class="label label-info">Birth Date</label>
                        <span name="birth" class="btn btn-default">{{birth}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="table-responsive">
                <table class="table dataTable table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient ID</th>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>Print Details</th>
                    </tr>
                    </thead>
                    <tbody id="patientsTable">
                    <tr>
                        <td>1</td>
                        <td>Lorem</td>
                        <td>ipsum</td>
                        <td>
                            <button class="btn btn-sm btn-default" userid="1" onclick="rapModal(this)">Manage</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newPatientModal" tabindex="-1" role="dialog" aria-labelledby="newPatientModal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">New Patient</h4>
            </div>
            <div class="modal-body">
                <div class="alert hidden alert-danger alert-dismissable" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <span id="alertMSG"></span>
                </div>
                <form class="form-group">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2 class="panel-title">Profile</h2>

                            <div>Personal Identification Info</div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="form-inline">Name <br/>
                                        <input class="form-control" name="surname" placeholder="Surname" required/>
                                        <input class="form-control" name="firstname" placeholder="Firstname" required/>
                                        <input class="form-control" name="middlename" placeholder="Middlename"
                                               required/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Local Address <br/>
                                        <input name="local_address" class="form-control" required/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">Telephone<br/>
                                            <input class="form-control" name="telephone" required/>
                                        </div>
                                        <div class="pull-left">GENDER <br/>
                                            <select class="form-control" name="sex" required>
                                                <option value="">Choose one...</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                        <div class="pull-left">Date of Birth <br/>
                                            <input type="date" name="birth_date" class="form-control" required/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">Height(m) <br/>
                                            <input name="height" class="form-control" required/>
                                        </div>
                                        <div class="pull-left">Weight(Kg) <br/>
                                            <input name="weight" class="form-control" required/>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h2 class="panel-title">Next of Kin</h2>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="form-inline">Name <br/>
                                        <input name="next_of_kin[surname]" placeholder="Surname" class="form-control"
                                               required/>
                                        <input name="next_of_kin[firstname]" class="form-control"
                                               placeholder="othernames" required/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Contact address <br/>
                                        <input name="next_of_kin[address]" class="form-control"/></td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">Phone number <br/>
                                            <input value="" name="next_of_kin[telephone]" class="form-control"/>
                                        </div>
                                        <div class="pull-left">Relationship <br/>
                                            <select name="next_of_kin[relationship]" class="form-control" required>
                                                <option value="">Choose relation...</option>
                                                <option value="Mother">Mother</option>
                                                <option value="Father">Father</option>
                                                <option value="Step-mother">Step-mother</option>
                                                <option value="Step-father">Step-father</option>
                                                <option value="Child">Child</option>
                                                <option value="Brother">Brother</option>
                                                <option value="Sister">Sister</option>
                                            </select></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">Demographic</h2>
                            <div>Family Background Info</div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">
                                            Citizenship:
                                            <label class="label label-success">Nigerian</label>
                                            <input value="Nigeria" type="checkbox" name="citizenship" class="form-control checkbox">
                                        </div>
                                        <div class="pull-left">
                                            <label class="label label-default">Others? Please specify:</label>
                                            <input name="citizenship" class="form-control"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">Religion
                                            <select name="religion" class="form-control">
                                                <option value="" selected="selected">Select One...</option>
                                                <option value="ISLAM">ISLAM</option>
                                                <option value="CHRISTAINITY">CHRISTAINITY</option>
                                                <option value="OTHERS">OTHERS</option>
                                            </select>
                                        </div>
                                        <div class="pull-left">
                                            position in family:
                                            <select name="position_in_family" required class="form-control">
                                                <option value="">Choose position...</option>
                                                <option value="1">1st</option>
                                                <option value="2">2nd</option>
                                                <option value="3">3rd</option>
                                                <option value="4">4th</option>
                                                <option value="5">5th</option>
                                                <option value="6">6th</option>
                                                <option value="7">7th</option>
                                                <option value="8">8th</option>
                                                <option value="9">9th</option>
                                                <option value="10">10th</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">
                                            Mother is
                                            <select name="is_mother_alive" required class="form-control">
                                                <option value="" >Select One...</option>
                                                <option value="ALIVE">Alive</option>
                                                <option value="DEAD">Deceased</option>
                                            </select>
                                        </div>
                                        <div class="pull-left">
                                            father is
                                            <select name="is_father_alive" required class="form-control">
                                                <option value="">Select One...</option>
                                                <option value="ALIVE">Alive</option>
                                                <option value="DEAD">Deceased</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-inline">
                                        <div class="pull-left">Marital Status
                                            <select name="marital_status" required class="form-control">
                                                <option value="">Choose martial status...</option>
                                                <option value="SINGLE">SINGLE</option>
                                                <option value="MARRIED">MARRIED</option>
                                                <option value="DIVORCED">DIVORCED</option>
                                                <option value="SEPERATED">SEPERATED</option>
                                                <option value="WIDOWED">WIDOWED</option>
                                            </select>
                                        </div>
                                        <div class="pull-left">No of children
                                            <select name="no_of_children" class="form-control">
                                                <option value="0">None</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Add Patient</button>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/bootstrap/jquery-1.10.2.min.js"></script>
<script src="../js/bootstrap/jquery.dataTables.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/constants.js"></script>
<script src="../js/arrival/arrival.js"></script>
</body>
</html>