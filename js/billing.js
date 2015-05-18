/**
 * Created by olajuwon on 2/20/2015.
 */
Billing = {
    CONSTANTS: {
        treatment_id: 0
    },
    init: function(){
        Billing.getQueue();
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
        })
    },
    getQueue: function(){
        var url = host + "phase/phase_billing.php?intent=unbilled_treatments";
        $.getJSON(url, function(data){
            if(data.status == 1){
                data = data.data;
                $('#unbilled-patients').empty();

                for(i = 0; i < data.length; i++){
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
                    patientHTML = replaceAll('{{treatment_status}}', data[i].treatment_status, patientHTML);

                    $('#unbilled-patients').append(patientHTML);
                }
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
        Billing.CONSTANTS.treatment_id = ($(patient).find('.treatment_id').text());
        Billing.getDetails();

        $('.none').addClass('hidden');
        $('.one').removeClass('hidden');
        $('#patientName').text(name);
        $('#patientRegNo').text(regNo);
        $('.bill').removeClass('hidden');
    },
    computeTotal: function(){
        var sum = 0;
        var no;
        $('.amount').each(function(index){
            no = ($(this).val() == "")?0:parseFloat($(this).val());
            sum += no;
        });
        $('#total').text(sum.toFixed(2));
    },
    addMore: function(){
        var count = $('tbody').children().length;
        var html = '<tr>' +
            '<td><input class="form-control" name="item[{{' +
                count +
                '}}]"></td>' +
            '<td><input class="form-control amount" type="number" name="amount[{{' +
                count +
                '}}]"></td>' +
            '</tr>';
        $('tbody').append(html);
    },
    getDetails: function(){
        $.getJSON(host + 'phase/phase_billing.php', {
            intent: 'details',
            treatment_id: Billing.CONSTANTS.treatment_id
        }, function(data){
            console.log(data);
            $('#test').empty();
            $('#days_spent').text(data.data.days_spent.days_spent);
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

            if(data.data.test.visual_test !== 'undefined'){
                $('#test').append("<p>Visual Test</p>")
            }
            if(data.data.test.chemical_test !== 'undefined'){
                $('#test').append("<p>Chemical Test</p>")
            }
            if(data.data.test.radiology_test !== 'undefined'){
                $('#test').append("<p>Radiology Test</p>")
            }
        });
    }
};

$(function(){
    Billing.init();
});
