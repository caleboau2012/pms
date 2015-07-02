
/**
 * Created by olajuwon on 5/18/2015.
 */
EditSetup = {
    Global: {
        Hospital_Info_ID: null
    },
    Constants: {
        REQUEST_SUCCESS: 1,
        REQUEST_ERROR: 2
    },
    init: function () {
        $("#step--info").click(function () {
            EditSetup.resetView();
            EditSetup.openInfoSetup();
            $(".steps").removeClass("setup-nav-active");
            $(this).addClass("setup-nav-active");
        });
        $("#step--drugs").click(function () {
            EditSetup.resetView();
            EditSetup.openDrugSetup();
            $(".steps").removeClass("setup-nav-active");
            $(this).addClass("setup-nav-active");
        });
        $("#step--bills").click(function () {
            EditSetup.resetView();
            EditSetup.openBillsSetup();
            $(".steps").removeClass("setup-nav-active");
            $(this).addClass("setup-nav-active");

        });

        //Previous Hospital info
        EditSetup.getHospitalInfo();

        //Update hospital info
        $("#step_info_form").on('submit', function (e) {
            e.preventDefault();
            EditSetup.updateHospitalInfo();
        });

        //Previous drugs units
        EditSetup.getHospitalDrugUnits();

        $("body").delegate(".delete-unit", "click", function () {
            EditSetup.removeUnit(this);
        });
        $("#add-unit").click(function (e) {
            e.preventDefault();
            EditSetup.addUnits();
        });
        $("#step_drug_units_form").on("submit", function (e) {
            e.preventDefault();
            EditSetup.updateHospitalDrugUnits();
        });
    },
    getHospitalInfo: function () {
        var payload = {};
        payload.intent = "getHospitalDetails";

        $.getJSON(host + "phase/admin/phase_admin.php", payload, function (data) {
            if(data.status == EditSetup.Constants.REQUEST_SUCCESS){
                //fill hospital details
                $("#hos_name").val(data.data.name);
                $("#hos_add").val(data.data.address);
                EditSetup.Global.Hospital_Info_ID = data.data.hospital_info_id;
            }
        })
    },
    updateHospitalInfo: function () {
        var payload = {};
        payload.intent = "updateHospitalDetails";
        payload.name = $("#hos_name").val();
        payload.address = $("#hos_add").val();
        payload.id = EditSetup.Global.Hospital_Info_ID;
        $.getJSON(host + "phase/admin/phase_admin.php", payload, function (data){
            var response;
            if(data.status == EditSetup.Constants.REQUEST_SUCCESS){
                response = '<div class="alert alert-dismissible alert-success text-center">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span></button>' +
                '<strong><span class="fa fa-2x fa-check-circle">&nbsp;</span></strong>' + data.data + '' +
                '</div>';
                $("#response").html(response);
            }else if(data.status == EditSetup.Constants.REQUEST_ERROR){
                response = '<div class="alert alert-danger text-center">' +
                '' + "Unable to perform operation at the moment, try again later" + '' +
                '</div>';
                $("#response").html(response);
            }
        })

    },
    getHospitalDrugUnits: function () {
        var payload = {};
        payload.intent = "getUnits";

        $.getJSON(host + "phase/phase_pharmacist.php", payload, function(data){
            if(data.status == EditSetup.Constants.REQUEST_SUCCESS){
                $("#units-list").empty();
                $(data.data).each(function () {
                    var unit_field = this.unit;
                    var unit_symbol = this.symbol;
                    var unit_ref_id = this.unit_ref_id;
                    $("#units-list").append("<li data-unit-ref-id='"+ unit_ref_id +"' data-unit-field='" + unit_field + "' data-unit-symbol ='" + unit_symbol + "'>" + unit_field + "&nbsp;(" + unit_symbol + ")" +
                    "<p class='pull-right'>" +
                    "<span class='fa fa-remove text-danger pointer delete-unit'></span>" +
                    "</p><div class='clearfix'></div>" +
                    "</li>");
                });
            }else if(data.status == EditSetup.Constants.REQUEST_ERROR){
                //NO DRUG
            }
        });
    },
    updateHospitalDrugUnits: function () {
        var payload = {};
        payload.intent = "addDrugUnits";
        payload.values = [];

        $("#units-list").find("li").each(function (index) {
            if($(this).attr("data-unit-new")){
                payload.values.push({
                    "unit": $(this).attr("data-unit-field"),
                    "symbol": $(this).attr("data-unit-symbol")
                });
            }
        });
        $.post(host + "phase/phase_pharmacist.php", payload, function(data){
            var response;
            if(data.status == EditSetup.Constants.REQUEST_SUCCESS){
                response = '<div class="alert alert-dismissible alert-success text-center">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span></button>' +
                '<strong><span class="fa fa-2x fa-check-circle">&nbsp;</span></strong>' + data.data + '' +
                '</div>';
                $("#response").html(response);
            }else if(data.status == EditSetup.Constants.REQUEST_ERROR){
                response = '<div class="alert alert-danger text-center">' +
                '' + "Unable to perform operation at the moment, try again later" + '' +
                '</div>';
                $("#response").html(response);
            }

        }, 'json');
    },
    addUnits: function () {
        var unit_field = $("#drug_unit").val();
        var unit_symbol = $("#drug_symbol").val();
        if (unit_field !== '' && unit_symbol !== "") {
            $(".units-indicator").addClass("hidden");
            $("#units-list").append("<li class='' data-unit-new="+ true +" data-unit-field='" + unit_field + "' data-unit-symbol ='" + unit_symbol + "'>" + unit_field + "&nbsp;(" + unit_symbol + ")" +
            "<p class='pull-right'>" +
            "<span class='fa fa-remove text-danger pointer delete-unit'></span>" +
            "</p><div class='clearfix'></div>" +
            "</li>");
            $("#drug_unit").val("");
            $("#drug_symbol").val("");
        }
    },
    removeUnit: function (unit) {
        var payload = {};
        payload.intent = "removeDrugUnit";
        payload.id = $(unit).parent().parent().attr("data-unit-ref-id");
        $.post(host + "phase/phase_pharmacist.php", payload, function(data){
            if(data.status == EditSetup.Constants.REQUEST_SUCCESS){
                $(unit).parent().parent().remove();
                if ($("#units-list li").length == 0) {
                    $(".units-indicator").removeClass("hidden");
                }
            }
        }, 'json');
    },
    openInfoSetup: function(){
        $('.steps_content').fadeOut('fast', function () {
            $('#step--info_content').fadeIn('slow', function () {

            }).removeClass("hidden");
        });
        $(".steps").removeClass("setup-nav-active");
        $(this).addClass("setup-nav-active");
    },
    openDrugSetup: function () {
        $('.steps_content').fadeOut('fast', function () {
            $('#step--drugs_content').fadeIn('slow', function () {

            }).removeClass("hidden");
        });


    },
    openBillsSetup: function(){
        $('.steps_content').fadeOut('fast', function () {
            $('#step--bills_content').fadeIn('slow', function () {

            }).removeClass("hidden");
        });

        $(".steps").removeClass("setup-nav-active");
        $(this).addClass("setup-nav-active");
    },
    resetView: function(){
        $("#response").empty();
    }

};
$(function(){
    EditSetup.init();
});