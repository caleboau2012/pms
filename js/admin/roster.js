/**
 * Created by olajuwon on 2/10/2015.
 */
(function ($){

    Roster = {
        init: function(){
            console.log('initialize');
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
        droppedStaff: function(){
            console.log('staff droped');
        }
    };

    Roster.allStaffs();
})(jQuery);

