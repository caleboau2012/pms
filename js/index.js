/**
 * Created by olajuwon on 1/27/2015.
 */

$(function(){
    $('#login').on('submit', function (e) {
        e.preventDefault();
        var form_data = $(this).serialize();
        var request = $.post('phase/phase_login.php', form_data);
        request.done(function(data){
            var response = JSON.parse(data);
            if(response.status == 2){
                console.log(response.message);
                $('#form-error').removeClass('hidden');
                $('#form-error').html(response.message);
            }else if(response.status == 1){
               window.location.assign('dashboard.php');
            }
        }).fail(function(data){
            console.log(data.responseText);
        });
    })
});