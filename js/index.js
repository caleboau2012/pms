/**
 * Created by olajuwon on 1/27/2015.
 */

$(function(){
    $('#shutdownForm').on('submit', function (e) {
        e.preventDefault();

        $('#shutdownForm-error').addClass('hidden');
        $('#shutdownForm-loading').removeClass('hidden');

        var regNo = $('#shutRegInput').val();
        var payload = { intent: 'shutdown', 'regNo' : regNo };

        var request = $.post('phase/phase_auth.php', payload);
        request.done(function (data) {
            var response = JSON.parse(data);

            if(response.status == 2){
                $('#shutdownForm-error').removeClass('hidden');
                $('#shutdownForm-loading').addClass('hidden');
                $('#shutdownForm-error-msg').html(response.message);
            }else{
                $('#shutdownForm').trigger('reset');
                $('#shutdownForm-loading').addClass('hidden');
                $('#shutdownUserModal').hide();
                ResponseModal.show(response.message, true);
            }

        }).fail(function (data) {
            $('#shutdownForm-error').removeClass('hidden');
            $('#shutdownForm-loading').addClass('hidden');
            $('#shutdownForm-error-msg').html('Currently unable to process request.');

        })
    });

    $('#login').on('submit', function (e) {
        e.preventDefault();

        $('#form-error').addClass('hidden');
        $('#form-loading').removeClass('hidden');

        var form_data = $(this).serialize();
        var request = $.post('phase/phase_auth.php', form_data);
        request.done(function(data){
            var response = JSON.parse(data);
            console.log(response);
            if(response.status == 2){
                $('#form-loading').addClass('hidden');
                $('#form-error').removeClass('hidden');
                $('#form-error').html(response.message);
            }else if(response.status == 1){
                if(response.data.status == 2){
                    //inactive users
                    window.location.assign(host + 'view/change_password.php');
                }else if(response.data.status == 6){
                    //user on processing stage
                    window.location.assign(host + 'view/setup-profile.php');
                }else if(response.data.status == 1){
                    //active user
                    window.location.assign(host + 'view/dashboard.php');
                }
            }
        }).fail(function(data){
            $('#form-loading').addClass('hidden');
            $('#form-error').removeClass('hidden');
            $('#form-error').html("Unexpected Error occur");
        });
    });

    //change password
    $('#change-password, #passwordForm').on('submit', function (e) {
        $('#form-loading').removeClass('hidden');
        $('#form-info').addClass('hidden');

        e.preventDefault();
        var form_data = $(this).serialize();
        if($('#passcode').val() == $('#confirm_passcode').val()){
            var request = $.post(host + 'phase/phase_auth.php', form_data);
            request.done(function(data){
                var response = JSON.parse(data);
                console.log(response.data.message);
                if(response.status == 1){
                    $('#form-loading').addClass('hidden');
                    $('#form-error').addClass('hidden');
                    $('#form-success').removeClass('hidden');
                    $('#form-success').html(response.data.message);

                    setTimeout(function(){
                        window.location.href = host;
                    }, 1500);
                }else if(response.status == 2){
                    $('#form-loading').addClass('hidden');
                        $('#form-error').removeClass('hidden');
                        $('#form-error').html(response.message);
                }
            }).fail(function(data){
                console.log('fail');
                console.log(data.responseText);
            });
        }else{
            $('#form-loading').addClass('hidden');
            $('#form-error').removeClass('hidden');
            $('#form-error').html('Password did not match');
        }

    });
});

