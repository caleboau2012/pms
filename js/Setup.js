
/**
 * Created by olajuwon on 5/18/2015.
 */

Setup = {
    init: function () {
        $("#step_one_form").on("submit", function (e) {
            e.preventDefault();
            Setup.processStepOne(this);
        })
    },
    processStepOne : function(form_data){

        //    Proceed to step 2
        Setup.prepareStepTwo();

    },
    prepareStepTwo : function(){
        //indicator
        $("#step-one-indicator").removeClass("setup-nav-active").append("<span class='fa fa-check-circle text-success'></span>");
        $("#step-two-indicator").addClass("setup-nav-active");
        //content
        $('#step-1_content').fadeOut('fast', function(){
            $('#step-2_content').fadeIn('slow', function(){

            }).removeClass("hidden");
        })  ;

    }
};
$(function(){
    Setup.init();
});