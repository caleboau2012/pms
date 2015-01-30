/**
 * Created by olajuwon on 1/30/2015.
 */
/**
 * Created by olajuwon on 1/27/2015.
 */

$(function(){
    //change password
    $('#profile-form').on('submit', function (e) {
        $('#form-loading').removeClass('hidden');
        var form_data = $(this).serialize();
        e.preventDefault();

        var request = $.post('phase/phase_profile.php', form_data);
        console.log(form_data);

        request.done(function(data){
                var response = JSON.parse(data);
                console.log(response);
                if(response.status == 2){
                    $('#form-loading').addClass('hidden');
                    $('#form-error').removeClass('hidden');
                    $('#form-error').html(response.message);
                }else if(response.status == 1){
                    window.location.assign('dashboard.php');
                }
            }).fail(function(data){
                console.log(data.responseText);
            });
    });
    //calendar pop out
    calendar_pop();
});
function calendar_pop(){
    $('.date-picker').datepicker({
        format: 'yyyy-mm-dd'
        //startDate: '3d'
    })
}
