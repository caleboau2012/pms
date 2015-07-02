
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

        //Hospital drugs units process
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

        //Hospital Billing process
        EditSetup.getHospitalBills();
        $("body").delegate(".delete-bill", "click", function () {
            EditSetup.removeBill(this);
        });
        $("#add-bill").click(function (e) {
            e.preventDefault();
            EditSetup.addBill();
        });
        $("#step_bill_form").on("submit", function (e) {
            e.preventDefault();
            EditSetup.updateHospitalBills(this);
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
                $("#units-indicator").addClass("hidden");
                $(data.data).each(function (index) {
                    var unit_field = this.unit;
                    var unit_symbol = this.symbol;
                    var unit_ref_id = this.unit_ref_id;

                    var html = "<tr data-unit-ref-id='"+ unit_ref_id +"' data-unit-field='" + unit_field + "' data-unit-symbol ='" + unit_symbol + "'>";
                    html += "<td>" + (index + 1) + "</td>";
                    html += "<td class='text-capitalize'>" + unit_field + "</td>";
                    html += "<td>" + unit_symbol + "</td>";
                    html += "<td> <span class='small text-warning pointer delete-unit'>Remove</span></td>";
                    html += "</tr>";
                    $("#unit-list-table").append(html);
                });
                $("#units_table").removeClass("hidden");

            }else if(data.status == EditSetup.Constants.REQUEST_ERROR){
                //NO DRUG
                $(".units-indicator").removeClass("hidden");
                $("#units_table").addClass("hidden");
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
                //remove new label
                $(this).removeAttr("data-unit-new");
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

            var num_of_units = $("#unit-list-table tr").length;

            var html = "<tr>";
            html += "<td>" + (num_of_units + 1) + "</td>";
            html += "<td class='text-capitalize'>" + unit_field + "</td>";
            html += "<td>" + unit_symbol + "</td>";
            html += "<td> <span class='small text-warning pointer delete-unit'>Remove</span></td>";
            html += "</tr>";
            $("#unit-list-table").append(html);
            $("#units_table").removeClass("hidden");


        }
    },
    removeUnit: function (unit) {
        var payload = {};
        payload.intent = "removeDrugUnit";
        payload.id = $(unit).parent().parent().attr("data-unit-ref-id");
        $.post(host + "phase/phase_pharmacist.php", payload, function(data){
            if(data.status == EditSetup.Constants.REQUEST_SUCCESS){
                $(unit).parent().parent().remove();
                if ($("#unit-list-table tr").length == 0) {
                    $(".units-indicator").removeClass("hidden");
                    $("#units_table").addClass("hidden");

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
    },
    getHospitalBills: function(){
        payload = {};
        payload.intent = "getBillItems";

        $.getJSON(host + "phase/phase_billing.php", payload, function (data) {
            if(data.status == EditSetup.Constants.REQUEST_SUCCESS){
                $(".units-indicator").addClass("hidden");
                $(data.data).each(function(index){
                    var bill_name = this.bill;
                    var bill_price = this.amount;
                    //$("#bill-list").append("<li class='' data-bill-name='" + bill_name + "' data-bill-price ='" + bill_price + "'><span class='text-capitalize'>" + bill_name + "</span> - <span class='text-danger'>" + bill_price + "</span>" +
                    //"<p class='pull-right'>" +
                    //"<span class='fa fa-remove text-danger pointer delete-bill'></span>" +
                    //"</p><div class='clearfix'></div>" +
                    //"</li>");

                    var html = "<tr data-bill-name='" + bill_name + "' data-bill-price ='" + bill_price + "'>";
                    html += "<td>" + (index + 1) + "</td>";
                    html += "<td class='text-capitalize'>" + bill_name + "</td>";
                    html += "<td>" + bill_price + "</td>";
                    html += "<td> <span class='small text-warning pointer delete-bill'>Remove</span></td>";
                    html += "</tr>";
                    $("#bill-list-table").append(html);
                });
            }
        });
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
            var num_of_bills = $("#bill-list-table tr").length;
            $(".units-indicator").addClass("hidden");
            $("#bill-name").val("");
            $("#bill-cost").val("");
            $("#add-bill-btn").removeClass("disabled");

            var html = "<tr data-bill-new="+ true + " data-bill-name='" + bill_name + "' data-bill-price ='" + bill_price + "'>";
            html += "<td>" + (num_of_bills + 1) + "</td>";
            html += "<td class='text-capitalize'>" + bill_name + "</td>";
            html += "<td>" + bill_price + "</td>";
            html += "<td> <span class='small text-warning pointer delete-bill'>Remove</span></td>";
            html += "</tr>";
            $("#bill-list-table").empty().append(html);
        }
    },
    removeBill: function (unit) {
        $(unit).parent().parent().remove();
        if ($("#bill-list-table tr").length == 0) {
            $("#bill-list-table").html("<p class='small text-center text-info'>No bill added</p>");
        }
    },
    updateHospitalBills: function(form_data){
        $(form_data).find(":submit").addClass("disabled").html("Updating...");
        var payload = {};
        payload.intent = "addBillingItems";
        payload.billItems = [];

        $("#bill-list-table").find("tr").each(function () {
            if($(this).attr("data-bill-new")){
                payload.billItems.push({
                    "bill": $(this).attr("data-bill-name"),
                    "amount": $(this).attr("data-bill-price")
                });
            }
            //remove new label
            $(this).removeAttr("data-unit-new");
        });

        $.post(host + "phase/phase_system_setup.php", payload, function (data) {
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
            $(form_data).find(":submit").addClass("disabled").html("Update");

        }, "json");
    }
};
$(function(){
    EditSetup.init();
});