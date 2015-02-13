/**
 * Created by olajuwon on 2/10/2015.
 */
$(function(){
    //$('#nav-link-2-content').hide();
var active_link_id = '';

   //swap caret-down/caret-up
    $('.accordion-heading').click(function(){
        $('#' + this.id + '-title').toggleClass('fa-caret-down fa-caret-up');
    });
    //swap view
    $('.nav-link').bind('click', function(e){
        e.preventDefault();
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
        active_link_id = this.id;

        $('.nav-link-content').animate({
                opacity: '0.3'
            },
            {
                easing: 'linear',
                duration: 500,
                always: function(){
                    $('.nav-link-content').addClass('hidden');
                    $('#' + active_link_id +'-content').removeClass('hidden');
                    $('#' + active_link_id +'-content').css('opacity', '1');
                }
            });
    });

    //show/hide remove staff icon
    $('.staff').hover(
        function(){
            $('#' + this.id + '-remove').removeClass('hidden');
        }
        ,function(){
            $('#' + this.id + '-remove').addClass('hidden');
    });

    //date picker
    $('.date-picker').datepicker({
        format: 'yyyy-mm-dd'
        //startDate: '3d'
    })


});