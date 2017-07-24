
/**
 * Created by olajuwon on 5/18/2015.
 */
Setup = {
    Constants: {
        REQUEST_SUCCESS: 1,
        REQUEST_ERROR: 2,
        STEP_ONE_PROGRESS_MAX_WIDTH: 45,
        STEP_TWO_PROGRESS_MAX_WIDTH: 85,
        STEP_THREE_PROGRESS_MAX_WIDTH: 100
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
        $("#add-bill").click(function (e) {
            e.preventDefault();
            Setup.addBill();
        });
        $("body").delegate(".delete-unit", "click", function () {
            Setup.removeUnit(this);
        });
        $("body").delegate(".delete-bill", "click", function () {
            Setup.removeBill(this);
        });
        $("#get-started").click(function () {
            Setup.getStarted(this);
        });
    },
    processStepOne: function (form_data) {
        $("#response").empty();
        $(form_data).find(":submit").addClass("disabled").html("Processing...");

        payload = $(form_data).serialize();
        //console.log(payload);

        $.post(host + "phase/phase_system_setup.php", payload, function (data) {
            //console.log(data);
            if (data.status == Setup.Constants.REQUEST_SUCCESS) {
                //    Proceed to step 2
                $("#response").empty();
                Setup.prepareStepTwo();
            } else if (data.status == Setup.Constants.REQUEST_ERROR) {
                var response = '<h5 class="text-danger text-center">' +
                    '' + data.message + '' +
                    '</h5>';
                $("#response").html(response);
                $(form_data).find(":submit").removeClass("disabled").html("Proceed");
            }
        }, "json").fail(function(e){
            // console.log(e.responseText);
        });
    },
    processStepTwo: function (form_data) {
        $("#step-2-response").empty();
        $(".step-2-form-group").removeClass("has-error");

        //Setup.prepareStepThree();
        if ($("#units-list").find("li").length == 0) {
            $(".step-2-form-group").addClass("has-error");
            $("#step-2-response").html("No drug unit added");
        } else {
            payload = {};
            payload.intent = "addHospitalInfoAndUnits";
            payload.name = $("#hos_name").val();
            payload.address = $("#hos_add").val();
            payload.values = [];

            $("#units-list").find("li").each(function (index) {
                payload.values.push({
                    "unit": $(this).attr("data-unit-field"),
                    "symbol": $(this).attr("data-unit-symbol")
                });
            });
            $(form_data).find(":submit").addClass("disabled").html("Processing...");
            // console.log(payload);

            $.post(host + "phase/phase_system_setup.php", payload, function (data) {
                // console.log(data);
                if (data.status == Setup.Constants.REQUEST_SUCCESS) {
                    //    Proceed to step 2
                    $("#response").empty();
                    Setup.prepareStepThree();
                } else if (data.status == Setup.Constants.REQUEST_ERROR) {
                    var response = '<div class="alert alert-danger text-center">' +
                        '' + data.message + '' +
                        '</div>';
                    $("#step-2-response").html(response);
                    $(form_data).find(":submit").removeClass("disabled").html("Proceed");
                }
            }, "json").fail(function (e) {
                // console.log(e.responseText);
            });
        }

    },
    processStepThree: function (form_data) {
        $(form_data).find(":submit").addClass("disabled").html("Processing...");
        payload = {};
        payload.intent = "addBillingItems";
        payload.billItems = [];

        $("#bill-list").find("li").each(function () {
            payload.billItems.push({"bill": $(this).attr("data-bill-name"), "amount": $(this).attr("data-bill-price")});
        });

        $.post(host + "phase/phase_system_setup.php", payload, function (data) {
            if (data.status == Setup.Constants.REQUEST_SUCCESS) {
                //    Proceed to step 2
                $("#response").empty();
                Setup.prepareStepFour();
            } else if (data.status == Setup.Constants.REQUEST_ERROR) {
                var response = '<div class="alert alert-danger text-center">' +
                    '' + data.message + '' +
                    '</div>';
                $("#response").html(response);
                $(form_data).find(":submit").removeClass("disabled").html("Proceed");
            }
        }, "json");

    },
    prepareStepTwo: function () {
        //indicator
        $("#step-one-indicator").removeClass("setup-nav-active").append("<span class='fa fa-check-circle text-success'></span>");
        $("#step-two-indicator").addClass("setup-nav-active");
        //content
        $('#step-1_content').fadeOut('fast', function () {
            $('#step-2_content').fadeIn('slow', function () {

            }).removeClass("hidden");
        });
        Setup.progressBar(Setup.Constants.STEP_ONE_PROGRESS_MAX_WIDTH);
    },
    prepareStepThree: function () {
        //indicator
        $("#step-two-indicator").removeClass("setup-nav-active").append("<span class='fa fa-check-circle text-success'></span>");
        $("#step-three-indicator").addClass("setup-nav-active");
        //content
        $('#step-2_content').fadeOut('fast', function () {
            $('#step-3_content').fadeIn('slow', function () {

            }).removeClass("hidden");
        });
        Setup.progressBar(Setup.Constants.STEP_TWO_PROGRESS_MAX_WIDTH);
    },
    prepareStepFour: function () {
        //indicator
        $("#step-three-indicator").removeClass("setup-nav-active").append("<span class='fa fa-check-circle text-success'></span>");
        $("#step-four-indicator").addClass("setup-nav-completed");
        //content
        $('#step-3_content').fadeOut('fast', function () {
            $('#step-4_content').fadeIn('slow', function () {

            }).removeClass("hidden");
        });
        Setup.progressBar(Setup.Constants.STEP_THREE_PROGRESS_MAX_WIDTH);

    },
    progressBar: function (max_width) {
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
        var unit_field = $("#drug_unit").val();
        var unit_symbol = $("#drug_symbol").val();
        if (unit_field !== '' && unit_symbol !== "") {
            $(".units-indicator").addClass("hidden");
            $("#units-list").append("<li class='' data-unit-field='" + unit_field + "' data-unit-symbol ='" + unit_symbol + "'>" + unit_field + "&nbsp;(" + unit_symbol + ")" +
            "<p class='pull-right'>" +
            "<span class='fa fa-remove text-danger pointer delete-unit'></span>" +
            "</p><div class='clearfix'></div>" +
            "</li>");
            $("#drug_unit").val("");
            $("#drug_symbol").val("");
        }
    },
    removeUnit: function (unit) {
        $(unit).parent().parent().remove();
        if ($("#units-list li").length == 0) {
            $(".units-indicator").removeClass("hidden");
        }
    },
    addBill: function () {
        $(".form-response").empty();
        $(".bill-form-group").removeClass("has-error");
        var bill_name = $("#bill-name").val();
        var bill_price = $("#bill-cost").val();
        if (bill_name == "") {
            $("#bill-name-input").addClass("has-error");
            $("#bill-name-response").html("Bill name is required");
        }
        else if (isNaN(bill_price) || bill_price == "") {
            $("#bill-cost-input").addClass("has-error");
            $("#bill-cost-response").html("Bill cost should be a number. The comma in the price should be omitted");
        }
        else {
            $(".units-indicator").addClass("hidden");
            $("#bill-list").append("<li class='' data-bill-name='" + bill_name + "' data-bill-price ='" + bill_price + "'>" + bill_name + " - <span class='text-danger'>" + bill_price + "</span>" +
            "<p class='pull-right'>" +
            "<span class='fa fa-remove text-danger pointer delete-bill'></span>" +
            "</p><div class='clearfix'></div>" +
            "</li>");
            $("#bill-name").val("");
            $("#bill-cost").val("");
            $("#add-bill-btn").removeClass("disabled");
        }
    },
    removeBill: function (unit) {
        $(unit).parent().parent().remove();
        if ($("#units-list li").length == 0) {
            $(".units-indicator").removeClass("hidden");
        }
    }
    , getStarted: function (button) {
        $(button).addClass("disabled");
        payload.intent = "setupComplete";
        $.post(host + "phase/phase_system_setup.php", payload, function (data) {
            if (data.status == Setup.Constants.REQUEST_SUCCESS) {
                $("#response").empty();
                window.location.href = "../index.php";
            } else if (data.status == Setup.Constants.REQUEST_ERROR) {
                var response = '<h5 class="text-danger text-center">' +
                    '' + data.message + '' +
                    '</h5>';
                $("#response").html(response);
                $(button).removeClass("disabled").html("Proceed");
            }
        }, "json");
    }
};
$(function(){
    Setup.init();
});