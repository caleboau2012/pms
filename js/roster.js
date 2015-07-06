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
                //defaultDate: '2015-02-12',
                editable: false,
                droppable: false, // this allows things to be dropped onto the calendar
                events:{
                    url: host + 'phase/admin/phase_roster.php?intent=getStaffRoster'
                },
                loading: function(bool) {
                    $('#roster_loading').toggle(bool);
                }
            });
            //*Legend */
            var content = '<div class="text-center" id="roster-legend">' +
                            '<span class="m-duty small">Morning</span>' +
                            '<span class="a-duty small">Afternoon</span>' +
                            '<span class="n-duty small">Night&nbsp;&nbsp;&nbsp;</span><br/>' +
                          '</div>';
            $('.fc-toolbar').append(content)
        }
    };
    $(function(){
        Roster.init();
    })
})(jQuery);

