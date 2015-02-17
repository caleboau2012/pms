<?php
/**
 * Created by PhpStorm.
 * User: olajuwon
 * Date: 2/16/2015
 * Time: 1:10 PM
 */

require_once '_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse'));
Crave::requireFiles(MODEL, array('BaseModel', 'UserModel', 'StaffRosterModel'));
Crave::requireFiles(CONTROLLER, array('UserController', 'StaffRosterController'));

$userController = new UserController();
$list_of_staff = $userController->getAllUsers();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<title>Admin Dashboard</title>
<link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">

<link href='css/libs/fullCalendar/fullcalendar.css' rel='stylesheet' />
<link href='css/libs/fullCalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href="css/master.css" rel="stylesheet">

<script src='js/bootstrap/jquery.min.js'></script>
<script src="js/admin/roster.js"></script>

<script src='js/libs/fullCalendar/moment.min.js'></script>

<script src='js/bootstrap/jquery-ui.custom.min.js'></script>
<script src='js/libs/fullCalendar/fullcalendar.min.js'></script>

<script>
    //        function assignTask(user_id, dept_id, duty, date){
    //            $.post('phase/admin/phase_roster.php',
    //                {
    //                   intent : 'assignTask',
    //                   user_id : user_id,
    //                    dept_id : dept_id
    //                    duty : duty,
    //                    date : date
    //                }, function(response){
    //                    console.log(response)
    //                }
    //            })
    //        }
    $(document).ready(function() {
        function assignTask(user_id, dept_id, duty, date) {

            $.post("phase/admin/phase_roster.php",
                {
                    intent: 'assignTask',
                    user_id: user_id,
                    dept_id : dept_id,
                    duty : duty,
                    duty_date: date
                },
                function(data){
                    console.log(data);
                }
            ).fail(function(data){
                    console.log(data.responseText);
                });
        }

        var staff_events = {};
        staff_events[1] = {
            staff_id:1,
            title:'Hello',
            is_pm:true
        };
        staff_events[2] = {
            staff_id:1,
            title:'Hello',
            is_pm:true
        };
        staff_events[3] = {
            staff_id:1,
            title:'Hello',
            is_pm:true
        };
//            console.log(staff_events);
        $('.staff-duty').bind('click', function(){
                if($(this).html() === "am"){
                    $(this).html("pm");
                    staff_events[$(this).attr('data-id')].is_pm = true;
                }else if($(this).html() === "pm"){
                    $(this).html("am");
                    staff_events[$(this).attr('data-id')].is_pm = false;
                }
//                    console.log(staff_events[$(this).attr('data-id')]);
            }
        );


        /* initialize the external events
         -----------------------------------------------------------------*/

        $('#external-events .fc-event').each(function() {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
//                    title: $.trim($(this).id), // use the element's text as the event title
                staff_id: this.id,
                id:'staff_'+this.id,
                data:staff_events[this.id],
                name: $(this).attr('data-name'),
                stick: true // maintain when user navigates (see docs on the renderEvent method)
//                    console.log('mo');
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
            drop: function(date, allDay) {
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
                var oe = $(this).data('event');
//                    console.log(oe);
                var ce = $.extend({}, oe);
//                    console.log( $(ce).className);
//                    $(ce).className = "night";
//                    console.log( $(ce).className);
                ce.start = date;
                ce.allDay = allDay;
                ce.staff_id = "Added";
//                    $('#calendar').fullCalendar('renderEvent', ce, true);
//                    console.log(date);
//                    console.log(event);
//                    console.log(ui);
            },eventDrop: function(event,delta, revertFunc) {

//                    event.color = "#aaa";

            }, eventReceive: function(event, delta, revertFunc){
                //duty
                duty = $("#" + event.staff_id + " span").html();
//                assignTask(event.staff_id, event.dept_id, duty, event.start.format());
//                                       event.color = "#aaa";
//                    if(event.data.is_pm){
//                        event.duty = 'pm';
//                    }else{
//                        event.duty = 'am';
//                    }
//                    event.className = 'night';
//                    console.log(event.data.is_pm);
//                    console.log($("#" + event.staff_id + " span").html());
                //console.log(delta);
//                    date
//                    console.log(event.start.format());
            },
            eventAfterRender: function(event, element, view){
                //event.color = "#aaa";

                //console.log(view);
//                   $('#calendar').fullCalendar( 'rerenderEvents' );
            },
            eventRender: function(event, element){
                //console.log(event);

//                    $('#calendar').fullCalendar( 'event', event.id).addClass('night');
//                    $(element).html(event.title + "(" + event.data.is_pm + ")");
//                    $(element).html(event.name);
//                    console.log(event.data.is_pm);
//                        if(event.data.is_pm){
//                            element.css('background-color', '#aaa');
//                            element.css('border-color', '#aaa');
//                        }

//                    console.log(event);
//                    console.log(element);
                if($("#" + event.staff_id + " span").html() === 'pm'){
                    element.css('background-color', '#aaa');
                    element.css('border-color', '#aaa');
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
    .night{
        background: #aaa !important;
        border: none;
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

                <div id="roster-list_names">

                    <?php
                    foreach($list_of_staff as $staff){
                        ?>
                        <div class='fc-event staff' id="<?php echo $staff['userid'] ?>" data-dept_id = "<?php echo $staff['department_id']; ?>" data-name = "<?php   echo $staff['firstname'] . " " .$staff['middlename']. " ".$staff['surname']?>" data-duty = "am">
                            <?php echo $staff['firstname'] . " " .$staff['middlename']. " ".$staff['surname'] ?>
                            <span data-id="<?php echo $staff['userid'] ?>" class="pull-right staff-duty">am</span>
                            <span class="clearfix"></span>
                        </div>
                    <?php
                    }
                    ?>
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

<script>

</script>
</body>
</html>
