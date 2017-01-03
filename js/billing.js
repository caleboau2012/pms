/**
 * Created by olajuwon on 2/20/2015.
 */
Billing = {
    CONSTANTS: {
        treatment_id: 0,
        REQUEST_SUCCESS : 1,
        REQUEST_ERROR   : 2,
        INDEX: 4
    },
    init: function(){
        Billing.getQueue();
        Billing.getConstants();
        $('#patient_query').bind('change paste keyup', function(e){
            e.preventDefault();
            Billing.searchPatient($(this).val());
        });
        $('body').delegate('.patient', 'click', (function(){
            Billing.startBilling(this);
        }));
        $('body').delegate('.amount', 'change', function(e){
            Billing.computeTotal();
        });
        $('#add_more').click(function(e){
            Billing.addMore();
        });
        $(document).delegate('.remove-one', 'click', function(e){
            Billing.removeOne(this);
        });
        $('#print').click(function(e){
            Billing.endBilling(document.bill);
        });
    },
    getQueue: function(){
        var url = host + "phase/phase_billing.php?intent=unbilled_treatments";
        $.getJSON(url, function(data){
            //console.log(data);
            if(data.status == 1){
                data = data.data;
                $('#unbilled-patients').empty();

                for(var i = 0; i < data.length; i++){
                    if (data[i].regNo.substr(0, 4) == 'EMER') {
                        panel = "panel-danger";
                        patientName = data[i].regNo;
                    }
                    else {
                        panel = "panel-success";
                        patientName = toTitleCase(data[i].surname) + " " + toTitleCase(data[i].firstname) + " " + toTitleCase(data[i].middlename);
                    }

                    var patientHTML = "";
                    patientHTML += $('#tmplPatients').html();
                    patientHTML = patientHTML.replace('{{status}}', panel);
                    patientHTML = replaceAll('{{id}}', i, patientHTML);
                    patientHTML = replaceAll('{{bill_status}}', data[i].bill_status, patientHTML);
                    patientHTML = replaceAll('{{regNo}}', data[i].regNo, patientHTML);
                    patientHTML = replaceAll('{{name}}', patientName, patientHTML);
                    patientHTML = replaceAll('{{treatment_id}}', data[i].treatment_id, patientHTML);
                    patientHTML = replaceAll('{{encounter_id}}', (data[i].encounter_id)?data[i].encounter_id:"", patientHTML);
                    patientHTML = replaceAll('{{treatment_status}}', data[i].treatment_status, patientHTML);
                    patientHTML = replaceAll('{{home_address}}', data[i].home_address, patientHTML);
                    patientHTML = replaceAll('{{telephone}}', data[i].telephone, patientHTML);
                    patientHTML = replaceAll('{{modified_date}}', data[i].modified_date, patientHTML);

                    $('#unbilled-patients').append(patientHTML);
                }
            }
        });
    },
    getConstants: function(){
        var url = host + "phase/phase_billing.php?intent=getBillItems";
        $.getJSON(url, function(data){
            if(data.status == 1){
                data = data.data;
                $('tbody').empty();
                var html;

                for(i = 0; i < data.length; i++){
                    html = '<tr>' +
                        '<td><input class="form-control item" name="item[' +
                        i +
                        ']" disabled value="' + data[i].bill + '"></td> ' +
                        '<td><input class="form-control amount" type="number" name="amount[' +
                        i +
                        ']" value="' + data[i].amount + '"></td>' +
                        '<td><button type="button" class="remove-one btn btn-warning btn-sm">'
                        + '<span class="fa fa-minus"></span>' +
                        '   </button></td>' +
                        '</tr>';
                    $('.bill-body').append(html);
                }

                Billing.computeTotal();
            }
        });
    },
    searchPatient: function(query){
        $('.patient').each(function(index){
            var name = ($(this).find('.name').text()).toLowerCase();
            var regNo = ($(this).find('.regNo').text()).toLowerCase();

            if((name.indexOf(query.toLowerCase()) != -1) || (regNo.indexOf(query.toLowerCase()) != -1)){
                $(this).removeClass('hidden');
            }
            else{
                $(this).addClass('hidden');
            }
        });
    },
    startBilling: function(patient){
        var name = ($(patient).find('.name').text());
        var regNo = ($(patient).find('.regNo').text());
        var telephone = ($(patient).find('.telephone').text());
        var address = ($(patient).find('.home_address').text());
        var date = ($(patient).find('.modified_date').text());
        Billing.CONSTANTS.treatment_id = ($(patient).find('.treatment_id').text());
        Billing.CONSTANTS.encounter_id = ($(patient).find('.encounter_id').text());

        console.log({
            treatment_id: Billing.CONSTANTS.treatment_id,
            encounter_id: Billing.CONSTANTS.encounter_id
        });

        Billing.getDetails();

        $('.none').addClass('hidden');
        $('.one').removeClass('hidden');
        $('#patientName').text(name);
        $('#patientRegNo').text(regNo);
        $('#home_address').text(address);
        $('#telephone').text(telephone);
        $('#modified_date').text(date.substring(0, 10));
        $('#receipt_no').text(Billing.CONSTANTS.treatment_id);
        $('#print-header').removeClass('hidden');
        $('#print-footer').removeClass('hidden');

        $('.bill').removeClass('hidden');
    },
    computeTotal: function(){
        var sum = 0;
        var no;
        $('.amount').each(function(index){
            no = ($(this).val() == "")?0:parseFloat($(this).val());
            sum += no;
        });
        $('#total').text(sum.formatMoney(2));
    },
    addMore: function(){
        var count = $('tbody').children().length;
        var html = '<tr>' +
            '<td><input class="form-control item" name="item[' +
            count +
            ']"></td>' +
            '<td><input class="form-control amount" type="number" name="amount[' +
            count +
            ']"></td>' +
            '<td><button type="button" class="remove-one btn btn-warning btn-sm">'
            + '<span class="fa fa-minus"></span>' +
            '   </button></td>' +
            '</tr>';
        Billing.CONSTANTS.INDEX = count;
        $('.bill-body').append(html);
    },
    removeOne: function(button){
        console.log(button);
        $(button).parent().parent().remove();
        Billing.computeTotal();
        //$('#extra' + Billing.CONSTANTS.INDEX).remove();
    },
    getDetails: function(){
        $.getJSON(host + 'phase/phase_billing.php', {
            intent: 'details',
            treatment_id: Billing.CONSTANTS.treatment_id
        }, function(data){
            console.log(data);
            $('#test').empty();
            $("#procedure").empty();
            var days = "";
            if((data.data.days_spent.days_spent == null) || (data.data.days_spent.days_spent == "No admission")){
                days = "No admission";
            }
            else{
                days = data.data.days_spent.days_spent + " day(s)";
            }
            $('#days_spent').text(days);
            var prescriptionHTML = "";
            if(data.data.prescription.constructor === Array){
                for(var i = 0; i < data.data.prescription.length; i++){
                    prescriptionHTML += "<p class='text-center'>" + data.data.prescription[i].prescription + "</p>";
                }
            }
            else{
                prescriptionHTML = "<p class='text-center'>" + data.data.prescription.prescription + "</p>";
            }
            $('#prescription').html(prescriptionHTML);

            if(data.data.test.visual_test){
                $('#test').append("<tr>" +
                    "<td>Visual Test</td>" +
                    "<td>" + checkNull(data.data.test.visual_test.description) + "</td>" +
                    "<td>" + data.data.test.visual_test.created_date + "</td>" +
                    "</tr>");
            }
            if(data.data.test.chemical_test){
                $('#test').append("<tr>" +
                    "<td>Chemical Test</td>" +
                    "<td>" + checkNull(data.data.test.chemical_test.clinical_diagnosis) + "</td>" +
                    "<td>" + data.data.test.chemical_test.created_date + "</td>" +
                    "</tr>");
            }
            if(data.data.test.radiology_test){
                $('#test').append("<tr>" +
                    "<td>Radiology Test</td>" +
                    "<td>" + checkNull(data.data.test.radiology_test.radiologists_report) + "</td>" +
                    "<td>" + data.data.test.radiology_test.created_date + "</td>" +
                    "</tr>");
            }
            if(data.data.test.urine_test){
                $('#test').append("<tr>" +
                    "<td>Urine Test</td>" +
                    "<td>" + checkNull(data.data.test.urine_test.clinical_diagnosis_details) + "</td>" +
                    "<td>" + data.data.test.urine_test.created_date + "</td>" +
                    "</tr>")
            }
            if(data.data.test.parasitology_test){
                $('#test').append("<tr>" +
                    "<td>Parasitology Test</td>" +
                    "<td>" + checkNull(data.data.test.parasitology_test.diagnosis) + "</td>" +
                    "<td>" + data.data.test.parasitology_test.created_date + "</td>" +
                    "</tr>");
            }
            if(data.data.test.blood_test){
                $('#test').append("<tr>" +
                    "<td>Haematology Test</td>" +
                    "<td>" + checkNull(data.data.test.blood_test.clinical_diagnosis_details) +  "</td>" +
                    "<td>" + data.data.test.blood_test.created_date + "</td>" +
                    "</tr>");
            }
            if(data.data.test.test){
                $('#test').append("<tr>" +
                    "<td colspan='3'>No Test Performed</td></tr>")
            }

            if(Array.isArray(data.data.procedure)){
                $('#procedure').append("<p>"+ data.data.procedure[0].consultation +  "</p>");
                if(Array.isArray(data.data.admitted_procedure)){

                    for(var i = 0; i < data.data.admitted_procedure.length; i++){
                        if(data.data.admitted_procedure[i].consultation){
                            $('#procedure').append("<p>"+ data.data.admitted_procedure[i].consultation +  "</p>");
                        }
                    }
                }
            }
            else{
                $('#procedure').append("<p>No procedure was done during this session</p>");
            }
        });
    },
    endBilling: function(){
        var items = [];
        var amounts = [];

        var bill = $('#bill');

        $(bill).find(".item").each(function(index){
            items.push($(this).val());
            $(this).attr('value', $(this).val());
        });

        $(bill).find(".amount").each(function(index){
            amounts.push($(this).val());
            $(this).attr('value', $(this).val());
        });

        $("tfoot tr")[0].remove();
        $(".delete").remove();
        $(".remove-one").parent().remove();

        $.getJSON(host + 'phase/phase_billing.php', {
            intent: 'post_bills',
            treatment_id: Billing.CONSTANTS.treatment_id,
            encounter_id: Billing.CONSTANTS.encounter_id,
            item: items,
            amount: amounts
        }, function(data){
            if(data.status == Billing.CONSTANTS.REQUEST_SUCCESS){
                //console.log(bill.html());
                printElem($('#print-header').html(), $(bill).html(), $('#print-footer').html());
                location.reload();
            }
        }).fail(function(e){
            console.log({
                data: e.responseText,
                items: items,
                amount: amounts
            });
        });
    }
};

$(function(){
    Billing.init();
});
