/**
 * Created by olajuwon on 2/10/2015.
 */
(function ($){

    Roster = {
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
                    right: 'month,agendaWeek,agendaDay'
                },
                eventLimit: true, // allow "more" link when too many events
                defaultDate: '2015-02-12',
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar
                events:{
                    url: 'roster/get-events.php',
                    error: function(){
                        $('#script-warning').show();
                    }
                },
                loading: function(bool) {
                    $('#loading').toggle(bool);
                },
                drop: function(date, allDay) {
                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                },
                eventReceive: function(event, delta, revertFunc){
                    //duty
//                duty = $("#" + event.staff_id + " span").html();

                    Roster.sendRoster(event.staff_id, event.dept_id, event.duty, event.start.format());
                },
                eventAfterRender: function(event, element, view){
                    //event.color = "#aaa";

                    //console.log(view);
//                   $('#calendar').fullCalendar( 'rerenderEvents' );
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

        },
        allStaffs: function(){
            $.get('phase/admin/phase_roster.php?intent=getUsers', function(data){
                //console.log(data);
                var response = JSON.parse(data);
                if(response.status == 1){
                    var staffs = Object.keys(response.data);
                    staffs.forEach(function(record){
                        html = "<div class='fc-event staff'>" +
                        response.data[record]['firstname'] +" " + response.data[record]['middlename'] +" " + response.data[record]['surname'] +
                        "<span class='hidden'>" + response.data[record]['userid'] + "</span>" +
                        "</div>";
                        //$('#roster-list_names').append(html);
                    });
                }else{
                    console.log('fail');
                }

            }).fail(function(data){
                console.log('fail');
            })
        },
        sendRoster: function(user_id, dept_id, duty, date){
            $.post("phase/admin/phase_roster.php",
                {
                    intent: 'assignTask',
                    user_id: user_id,
                    dept_id : dept_id,
                    duty : duty,
                    duty_date: date
                },
                function(data){
                    $('#rosterResponse').html('All changes saved').removeClass('hidden');
                    setTimeout(function(){
                        $('#rosterResponse').addClass('hidden').empty();
                    }, 2000);
                }
            ).fail(function(data){
                    console.log(data.responseText);
                });
        }
    };

    $(function(){
        Roster.init();
    })
})(jQuery);

