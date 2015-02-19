/**
 * Created by olajuwon on 2/10/2015.
 */
(function ($){

    Roster = {
        init: function(){
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek'
                },
                eventLimit: true, // allow "more" link when too many events
                defaultDate: '2015-02-12',
                editable: false,
                droppable: false, // this allows things to be dropped onto the calendar
                events:{
                    url: host + 'phase/admin/phase_roster.php?intent=getStaffRoster'
                },
                loading: function(bool) {
                    $('#roster_loading').toggle(bool);
                }
            });
        }
    };
    $(function(){
        Roster.init();
    })
})(jQuery);

