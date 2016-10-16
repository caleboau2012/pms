/**
 * Created by olajuwon on 2/10/2015.
 */
(function ($){
    var Roster = {
        init: function(){
            $('#dashboard-calendar').fullCalendar('removeEvents').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'basicWeek, basicDay'
                },
                defaultView: 'basicWeek',
                height: 125,
                eventLimit: true, // allow "more" link when too many events
                editable: false,
                droppable: false, // this allows things to be dropped onto the calendar
                events:{
                    url: host + 'phase/admin/phase_roster.php?intent=getStaffRoster'
                },
                loading: function(bool) {
                    $('#roster_loading').toggle(bool);
                    if(!bool){
                        Roster.clearDuplicates();
                    }
                }
            });
            //*Legend */
            //var content = '<div class="text-center" id="roster-legend">' +
            //                '<span class="m-duty small">Morning</span>' +
            //                '<span class="a-duty small">Afternoon</span>' +
            //                '<span class="n-duty small">Night&nbsp;&nbsp;&nbsp;</span><br/>' +
            //              '</div>';
            //$('.fc-toolbar').append(content)
            //console.log((new Date()).toUTCString());
        },
        clearDuplicates: function(){
            console.log($(".fc-event-container"));
            $(".fc-event-container").each(function(i){
                $(this).remove();
            });
        }
    };
    $(function(){
        Roster.init();
    })
})(jQuery);

