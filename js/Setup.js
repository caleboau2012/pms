
/**
 * Created by olajuwon on 5/18/2015.
 */
var xhr = new window.XMLHttpRequest();
xhr.addEventListener('progress', function(e) {
    console.log(e);
    //$('.progressbar .bar').css('width', '' + (100 * e.loaded / e.total) + '%');
    //$('.progresspercent').text((100 * e.loaded / e.total) + '%');
});
Setup = {
    Constants: {
        REQUEST_SUCCESS: 1,
        REQUEST_ERROR: 2,
        STEP_ONE_PROGRESS_MAX_WIDTH : 45,
        STEP_TWO_PROGRESS_MAX_WIDTH : 85,
        STEP_THREE_PROGRESS_MAX_WIDTH : 100
    },
    init: function () {
        $("#step_one_form").on("submit", function (e) {
            e.preventDefault();
            Setup.processStepOne(this);
        });
        $("#step_two_form").on("submit", function (e) {
            e.preventDefault();
            Setup.processStepTwo(this);
        });
        $("#step_three_form").on("submit", function (e) {
            e.preventDefault();
            Setup.processStepThree(this);
        });
        $("#add-unit").click(function (e) {
            e.preventDefault();
            Setup.addUnits();
        });
        $("body").delegate(".delete-unit", "click", function () {
            Setup.removeUnit(this);
        });
    },
    processStepOne : function(form_data){
        $("#response").empty();
        $(form_data).find(":submit").addClass("disabled").html("Processing...");

        //console.log(form_data);
        payload = $(form_data).serialize();

        //payload.intent = "initialSetup";
        //$.post(host + "phase/phase_system_setup.php", payload, function (data){
        //    if(data.status == Setup.Constants.REQUEST_SUCCESS){
        //        //    Proceed to step 2
        //        Setup.prepareStepTwo();
        //    }else if(data.status == Setup.Constants.REQUEST_ERROR){
        //        var response = '<div class="alert alert-danger text-center">' +
        //            '' + data.message +'' +
        //            '</div>';
        //        $("#response").html(response);
        //        $(form_data).find(":submit").removeClass("disabled").html("Proceed");
        //    }
        //}, "json");
        Setup.prepareStepTwo();

    },
    processStepTwo: function (form_data) {
        $(form_data).find(":submit").addClass("disabled").html("Processing...");
        Setup.prepareStepThree();

    },
    processStepThree: function (form_data) {
        $(form_data).find(":submit").addClass("disabled").html("Processing...");
        Setup.prepareStepFour();

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
        Setup.progressBar(Setup.Constants.STEP_ONE_PROGRESS_MAX_WIDTH);
    },
    prepareStepThree : function(){
        //indicator
        $("#step-two-indicator").removeClass("setup-nav-active").append("<span class='fa fa-check-circle text-success'></span>");
        $("#step-three-indicator").addClass("setup-nav-active");
        //content
        $('#step-2_content').fadeOut('fast', function(){
            $('#step-3_content').fadeIn('slow', function(){

            }).removeClass("hidden");
        })  ;
        Setup.progressBar(Setup.Constants.STEP_TWO_PROGRESS_MAX_WIDTH);
    },
    prepareStepFour : function(){
        //indicator
        $("#step-three-indicator").removeClass("setup-nav-active").append("<span class='fa fa-check-circle text-success'></span>");
        $("#step-four-indicator").addClass("setup-nav-completed");
        //content
        $('#step-3_content').fadeOut('fast', function(){
            $('#step-4_content').fadeIn('slow', function(){

            }).removeClass("hidden");
        })  ;
        Setup.progressBar(Setup.Constants.STEP_THREE_PROGRESS_MAX_WIDTH);

    },
    progressBar: function(max_width){
        $('.progress-bar').width(max_width + '%');
        //var progress_updater = setInterval(function(){
        //     var progress_width = $(".progress-bar").width();
        //    console.log(progress_width + "<" + max_width);
        //     if(parseInt($(".progress-bar").width()) < max_width){
        //         $('.progress-bar').width(parseInt($(".progress-bar").width()) + 5 + '%');
        //     }
        //     else if(progress_width > max_width){
        //         clearInterval(progress_updater);
        //     }
        //    console.log(max_width);
        // }, 1000);
    },
    addUnits: function () {
        var unit_field = $("#unitField").val();
        if(unit_field  !== ''){
            $(".units-indicator").addClass("hidden");
            $("#units-list").append("<li class=''>" + unit_field +
            "<p class='pull-right'>" +
            "<span class='fa fa-remove text-danger pointer delete-unit'></span>" +
            "</p><div class='clearfix'></div>" +
            "</li>");
            $("#unitField").val("");
        }

    },
    removeUnit: function(unit){
        $(unit).parent().parent().remove();
        if($("#units-list li").length == 0){
            $(".units-indicator").removeClass("hidden");
        }
    }
};
$(function(){
    Setup.init();
});