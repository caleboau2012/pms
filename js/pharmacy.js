/**
 * Created by olajuwon on 2/20/2015.
 */
Pharmacy = {
    selectedPatient : null,
    deactivate : false,
    CONSTANTS: {
        REQUEST_SUCCESS: 1,
        REQUEST_ERROR: 2
    },
    init: function(){
        $('.patients-list_item').click(function(){
            Pharmacy.transferPatient(this);
        });
        //add to clear button
        $('#addToClear').on('submit', function(e){
            e.preventDefault();
            Pharmacy.addToClear();
        });

        //clear prescription button
        $('#clrPrescription').click(function(){
            Pharmacy.clearPrescription();
        });

    },
    addClickEventToPrescription: function () {
        $('.prescription-item').click(function(){
            Pharmacy.transferPrescription(this);
        });
    },
    checkQueue: function(){
        if($('ul.patients-list li').length == 0){
            $('.patients-list').html("<h3 class='text-muted text-center'>No pending patient</h3>");
        }
    },
    removeFromQueue: function(patient){
        $(patient).remove();
    },
    transferPatient: function(patient){
        //active patient selected
        Pharmacy.selectedPatient = patient;
        $('#empty_active').hide();
        $('#patient_name').html($(patient).attr("data-name"));
        $('#patient_reg').html($(patient).attr("data-reg"));

        //get patient prescriptions
        var payload = {
            intent : 'getPrescription',
            treatmentId : $(patient).attr("data-treatment-id"),
            encounterId : $(patient).attr("data-encounter-id")
        };
        console.log(payload);
        //reset list of prescriptions
        $('.patientPrescriptions').empty();
        //reset selected list of prescription
        $('.selected_prescription').empty();
        $('#clearPrescriptions').empty();
        Pharmacy.showClearButton();

        Pharmacy.serverReq(host + 'phase/phase_pharmacist.php', payload,function(data){
            console.log(data);
            if(data.status == Pharmacy.CONSTANTS.REQUEST_SUCCESS){
                prescriptions = Object.keys(data.data);
                prescriptions.forEach(function(record){
                    $('.patientPrescriptions').append('<li class="prescription-item  list-group-item" data-prescription-id = "' + data.data[record].prescription_id + '"">' + data.data[record].prescription + '</li>');
                });
                Pharmacy.addClickEventToPrescription();
            }else if(data.status == Pharmacy.CONSTANTS.REQUEST_ERROR){
                $('.patientPrescriptions').append("<p class='text-danger small text-center'>" + data.message + "</p>");

            }
        });
        $('.patients-list_item').removeClass('active_selected_patient');
        $(patient).addClass('active_selected_patient');
        Pharmacy.checkQueue();
        $('.active_patient').removeClass('hidden');
    },
    transferPrescription: function(prescription){
        //remove previous error message encountered if any
        $('#response_msg').empty().removeClass('alert-danger').removeClass('alert-success');
        if(!Pharmacy.deactivate){
            if($(prescription).hasClass('text-cancel')){
                $(prescription).removeClass('text-cancel');
                Pharmacy.returnPrescription(prescription);
            }else{
                $(prescription).addClass('text-cancel');
                selected = "<li data-prescription-id="+ $(prescription).attr('data-prescription-id') +">" + $(prescription).html() + "</li>";
                $('.selected_prescription').append(selected);
            }
        }
    },
    returnPrescription: function(prescription){
        $('.selected_prescription li').each(function(){
            if($(this).html() == $(prescription).html()){
                $(this).remove();
            }
        });
    },
    addToClear: function(){
        if(!Pharmacy.deactivate){
            if($('.selected_prescription').children('li').length != 0){
                drugName = $('#drugName').val();
                drugQuantity = $('#drugQuantity').val();
                var drugId = null;
                $('#drugNames option').filter(function(){
                    if(this.value == drugName){
                        drugId = $(this).attr('data-drug-id');
                    }
                });
                //console.log(drugId);
                drugUnit = $('#drugUnit').val();
                if(drugName !== ''){
                    content = "<div class='clearDrug' data-drug-quantity = "+ drugQuantity +" data-quantity-unit = "+  $('#drugUnit :selected').html() +">" +
                    "<span class='cancelClear small pull-right fa fa-close pointer'>&nbsp;</span>" +
                    "<h5 data-drug-id="+ drugId +">" + drugName.toUpperCase() + "</h5>" +
                    "<span class='small'>(" + drugQuantity + " " + $('#drugUnit :selected').html() + ")</span>" +
                    "<ul>";

                    $('.selected_prescription li').each(function(){
                        content += "<li data-prescription-id=" + $(this).attr('data-prescription-id') +">" + $(this).html() + "</li>";
                        Pharmacy.removePrescription(this);
                    });
                    content += "</ul></div>";
                    $('#clearPrescriptions').append(content);
                    //clear form
                    //clear formadd
                    $('#addToClear').trigger('reset');
                    $('.selected_prescription').empty();
                    //show clear button
                    $('#clrPrescription').removeClass('hidden');
                    //Pharmacy.showClearButton();
                }
                $('.cancelClear').click(function(){
                    Pharmacy.unClearPrescription($(this).parent());
                });
                $('#response_msg').empty().removeClass('alert-danger').removeClass('alert-success');

            }else{
                $('#response_msg').empty().addClass('alert-danger').removeClass('alert-success').html('No prescription selected');
            }
        }

    },
    showClearButton: function(){
        if($('#clearPrescriptions').empty()){
            $('#clrPrescription').addClass('hidden');
        }else{
            $('#clrPrescription').removeClass('hidden');
        }
        //console.log($('#clearPrescriptions').children('div'));

        //if ($('#clearPrescriptions').is(':empty')){
        //    //do something
        //    $('#clrPrescription').addClass('hidden');
        //}else{
        //    $('#clrPrescription').removeClass('hidden');
        //}
    },
    unClearPrescription: function(drug_panel){
        $(drug_panel).find('li').each(function(){
            $('.patientPrescriptions').append("<li class='prescription_item list-group-item' data-prescription-id='"+ $(this).attr('data-prescription-id') +"'>" + $(this).html() +  "</li>");
        });
        $('.prescription_item').unbind('click').bind('click',function(){
            Pharmacy.transferPrescription(this);
        });
        $(drug_panel).remove();
        Pharmacy.showClearButton();
    },
    clearPrescription: function(){
        //deactivate page
        Pharmacy.deactivate = true;

        var info = [];
        //check for uncleared prescriptions
        if($('.patientPrescriptions').children('li').length !== 0){
            var drugName = null;
            var temp = {};
            temp.drugId = null;
            temp.drugName = null;
            temp.quantity = null;
            temp.unitId = null;
            temp.prescription = [];
            var prescriptions = [];
            $('.prescription-item').each(function(){
                temp.prescription.push($(this).attr('data-prescription-id'));
            });
            info.push(temp);
        }

        //prescriptions with drug
      $('.clearDrug').each(function(){
          var drugName = $(this).children('h5').html();
          var temp = {};
          temp.drugId = $(this).children('h5').attr('data-drug-id');
          temp.drugName = $(this).children('h5').html();
          temp.quantity = 2;
          temp.unitId = 1;
          temp.prescription = [];
          var prescriptions = [];
          $(this).find('li').each(function() {
              temp['prescription'].push($(this).attr('data-prescription-id'));
          });
          info.push(temp);
      });
        var payload = {
            intent : 'clearPrescription',
            data : info
        };
        //console.log(info);
        Pharmacy.serverReq(host + 'phase/phase_pharmacist.php', payload, function(data){
            if(data.status == Pharmacy.CONSTANTS.REQUEST_SUCCESS){
                //remove from queue
                Pharmacy.removeFromQueue(Pharmacy.selectedPatient);
                Pharmacy.checkQueue();
                $('#response_msg').empty().removeClass('alert-danger').addClass('alert-success').html(data.data);
                Pharmacy.printOut();
            }else if(data.status == Pharmacy.CONSTANTS.REQUEST_ERROR){
                $('#response_msg').empty().removeClass('alert-success').addClass('alert-danger').html(data.data);
            }
        });
    }
    ,removePrescription: function(prescription){
        $('.patientPrescriptions li').each(function(){
            if($(this).attr("data-prescription-id") == $(prescription).attr("data-prescription-id")){
                $(this).remove();
            }
        });
    },
    serverReq:  function(url, param, callback) {
        $.getJSON(url, param, function(data){
            if (typeof callback == 'function') {
                callback(data);
            }
        }).done(function(){

        });
    }
    ,printOut: function () {
        var content = "<h4>List of cleared drug(s)</h4>";
        var clear_drugs ="<ol>";
        $('.clearDrug').each(function(){
            clear_drugs += "<li><h5>" + $(this).children('h5').html() + " (" + $(this).attr("data-drug-quantity") + " " + $(this).attr("data-quantity-unit") + ") </h5></li>";
            clear_drugs += "<ul>";
            $(this).find('li').each(function() {
                clear_drugs += "<li class='text-capitalize'>" + $(this).html() + "</li>";
            });

            clear_drugs += "</ul>";
        });
        clear_drugs += "</ol>";

        var unclear_drugs = "";
        if($('.patientPrescriptions').children('li').length !== 0){
            unclear_drugs = "<h4>List of uncleared prescription(s)</h4>";
            unclear_drugs += "<ol>";
            $('.prescription-item').each(function(){
                unclear_drugs += "<li class='text-capitalize'>" + $(this).html() + "</li>";
            });
            unclear_drugs += "</ol>";
        }else{
            unclear_drugs += "<p>There are no uncleared prescription(s)</p>";
        }
        content += clear_drugs;
        content += unclear_drugs;

        printElem("Pharmacy Printout", content, null);
    }
};

$(function(){
    Pharmacy.init();
});
