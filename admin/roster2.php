<?php
/**
 * Created by PhpStorm.
 * User: olajuwon
 * Date: 2/16/2015
 * Time: 1:10 PM
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title>Admin Dashboard</title>
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <link href='../css/libs/fullCalendar/fullcalendar.css' rel='stylesheet' />
    <link href='../css/libs/fullCalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
    <link href="../css/master.css" rel="stylesheet">

    <script src='../js/libs/fullCalendar/moment.min.js'></script>
    <script src='../js/bootstrap/jquery.min.js'></script>
    <script src='../js/bootstrap/jquery-ui.custom.min.js'></script>
    <script src='../js/libs/fullCalendar/fullcalendar.min.js'></script>

    <script>

        $(document).ready(function() {


            /* initialize the external events
             -----------------------------------------------------------------*/

            $('#external-events .fc-event').each(function() {

                // store data so the calendar knows to render an event upon drop
                $(this).data('event', {
                    title: $.trim($(this).text()), // use the element's text as the event title
                    stick: true // maintain when user navigates (see docs on the renderEvent method)
                });

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true,      // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                });

            });


            /* initialize the calendar
             -----------------------------------------------------------------*/

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar
                drop: function() {
                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                }
            });


        });

    </script>
    <style>

        body {
            margin-top: 40px;
            /*text-align: center;*/
            /*font-size: 14px;*/
            /*font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;*/
        }

        #wrap {
            /*width: 1100px;*/
            /*margin: 0 auto;*/
        }

        #external-events {
            /*float: left;*/
            /*width: 150px;*/
            /*padding: 0 10px;*/
            /*border: 1px solid #ccc;*/
            /*background: #eee;*/
            /*text-align: left;*/
        }

        #external-events h4 {
            /*font-size: 16px;*/
            /*margin-top: 0;*/
            /*padding-top: 1em;*/
        }

        #external-events .fc-event {
            margin: 10px 0;
            cursor: pointer;
        }

        #external-events p {
            margin: 1.5em 0;
            font-size: 11px;
            color: #666;
        }

        #external-events p input {
            margin: 0;
            vertical-align: middle;
        }

        #calendar {
            /*float: right;*/
           width: 95%;
        }

    </style>
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
            <a class="navbar-brand" href="../dashboard.php">Patient Management System</a>
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

<div id='wrap' class="row">
<div class="col-md-4">

    <div id='external-events' style="padding: 0 2em">
        <div class="roster-list">
            <div class="roster-list_heading">
                <span>ALL STAFFS</span>
                <div class="pull-right pin"></div>
                <div class="clearfix"></div>
            </div>

            <div class="roster-list_names">
                <div class='fc-event staff'>Staff Name</div>
                <div class='fc-event staff'>Staff Name</div>
                <div class='fc-event staff'>Staff Name</div>
                <div class='fc-event staff'>Staff Name</div>
                <div class='fc-event staff'>Staff Name</div>
                <div class='fc-event staff'>Staff Name</div>
                <div class='fc-event staff'>Staff Name</div>
            </div>
<!---->
<!--            <p>-->
<!--                <input type='checkbox' id='drop-remove' />-->
<!--                <label for='drop-remove'>remove after drop</label>-->
<!--            </p>-->
        </div>


    </div>

</div>
    <div class="col-md-8">

    <div id='calendar'></div>
</div>
    <div style='clear:both'></div>

</div>


<!--<script src="../js/admin/roaster.js"></script>-->
<script src="../js/admin/roster.js"></script>
</body>
</html>
