/**
 * Created by olajuwon on 2/10/2015.
 */
(function ($){

    Roster = {
        CONSTANTS: {
          MORNING_DUTY : '#3A87AD',
          AFTERNOON_DUTY : '#4CA618',
          NIGHT_DUTY : '#3F3C3C'
        },
        init: function(){
            /* initialize the external events
             -----------------------------------------------------------------*/
            $('#external-events .fc-event').each(function() {
                // store data so the calendar knows to render an event upon drop
                $(this).data('event', {
//                title: $.trim($(this).text()), // use the element's text as the event title
                    title: $(this).attr('data-name'), // use the element's text as the event title
                    staff_id: $(this).attr('data-id'),
                    duty: $(this).attr('data-duty'),
                    dept_id : $(this).attr('data-dept_id'),
                    color : $(this).attr('data-color'),
                    name: $(this).attr('data-name'),
                    stick: true // maintain when user navigates (see docs on the renderEvent method)
                });

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true,      // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                });

            });

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek'
                },
                eventLimit: true, // allow "more" link when too many events
                //defaultDate: '2015-02-12',
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar
                events:{
                    url: host + 'phase/admin/phase_roster.php?intent=getAllRoster',
                    error: function(err) {
                        alert('Currently unable to display roster correctly');
                    }
                },
                loading: function(bool) {
                    $('#roster_loading').toggle(bool);
                },
                eventDrop: function(event, delta, revertFunc){
                    Roster.updateRoster(event.roster_id, event.start.format())
                },
                eventClick: function(event, element){
                    var info = event.title + " schedule on " + event.start.format() + " for " + Roster.getDuty(event.color) + " duty";
                    if(confirm("Are you sure you want to delete " + info)){
                       Roster.deleteRoster(event.roster_id);
                       $('#calendar').fullCalendar('removeEvents', event._id);
                   }
                },
                eventReceive: function(event, delta, revertFunc){
                    Roster.sendRoster(event);
                },
                eventRender: function(event, element){
                    //AFTERNOON
                    if(event.duty === '9'){
                        element.css('background-color', '#4CA618');
                        element.css('border-color', '#4CA618');
                    }else if(event.duty === '10'){
                        //NIGHT
                        element.css('background-color', '#3F3C3C');
                        element.css('border-color', '#3F3C3C');
                    }
                }
            });
            var response = '<div id="rosterResponse"></div>';
            $('.fc-toolbar').append(response);
        },
        getDuty : function(colorCode){
           var  duty = '';
            switch (colorCode){
                case  Roster.CONSTANTS.MORNING_DUTY:
                    duty = 'Morning';
                    break;
                case  Roster.CONSTANTS.AFTERNOON_DUTY:
                    duty = 'Afternoon';
                    break;
                case Roster.CONSTANTS.NIGHT_DUTY:
                    duty = 'Night';
                    break;
                default :
                    duty = 'Unknown';
                    break
            }
            return duty;
        },
        sendRoster: function(event){
            var user_id = event.staff_id,   dept_id = event.dept_id,
                duty    = event.duty,       date = event.start.format();
            $.post(host + "phase/admin/phase_roster.php",
                {
                    intent: 'assignTask',
                    user_id: user_id,
                    dept_id : dept_id,
                    duty : duty,
                    duty_date: date
                },
                function(data){
                    var res = JSON.parse(data);
                    if(res.status == 1){
                        $('#rosterResponse').html('Roster schedule saved');
                        setTimeout(function(){
                            $('#rosterResponse').empty();
                        }, 2000);
                    }else if(res.status == 2){
                        if(res.message == -10){
                            $('#calendar').fullCalendar('removeEvents', event._id);
                            $('#rosterResponse').addClass("text-danger").html('Staff already schedule for this duty');
                            setTimeout(function(){
                                $('#rosterResponse').empty().removeClass("text-danger");
                            }, 2000);
                        }else{
                            $('#calendar').fullCalendar('removeEvents', event._id);
                            $('#rosterResponse').addClass("text-danger").html('Unable to complete request');
                            setTimeout(function(){
                                $('#rosterResponse').empty().removeClass("text-danger");
                            }, 2000);
                        }
                    }

                }
            ).fail(function(data){
                alert('Currently unable to process request');
                    // console.log(data.responseText);
                });
        },
        updateRoster: function(roster_id, date){
            $.post(host + "phase/admin/phase_roster.php",
                {
                    intent: 'updateTask',
                    roster_id: roster_id,
                    duty_date: date
                },
                function(data){
                    $('#rosterResponse').html('Roster schedule updated');
                    setTimeout(function(){
                        $('#rosterResponse').empty();
                    }, 2000);
                }
            ).fail(function(data){
                alert('Currently unable to process request')
                });
        },
        deleteRoster: function(roster_id){
            $.post(host + "phase/admin/phase_roster.php",
                {
                    intent: 'deleteTask',
                    roster_id: roster_id
                },
                function(data){
                    $('#rosterResponse').html('Roster schedule deleted');
                    setTimeout(function(){
                        $('#rosterResponse').empty();
                    }, 2000);
                }
            ).fail(function(data){
                alert('Currently unable to process request')
                });
        }
    };
    $(function(){
        Roster.init();
    })
})(jQuery);

