/**
 * Created by olajuwon on 2/20/2015.
 */
Pharmacy = {
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
        if($('ul.patients-list_body li').length == 0){
            $('.patients-list_body').html("<h3 class='text-muted'>No Pending patient</h3>");
        }
    },
    removeFromQueue: function(patient){
        $(patient).remove();
    },
    transferPatient: function(patient){
        $('#empty_active').hide();
        $('#patient_name').html($(patient).attr("data-name"));
        $('#patient_reg').html($(patient).attr("data-reg"));

        //get patient prescriptions
        var payload = {
            intent : 'getPrescription',
            treatmentId : $(patient).attr("data-treatment-id")
        };
        Pharmacy.serverReq(host + 'phase/phase_pharmacist.php', payload,function(data){
            if(data.status == Pharmacy.CONSTANTS.REQUEST_SUCCESS){
                //console.log(data.data);
                prescriptions = Object.keys(data.data);
                prescriptions.forEach(function(record){
                    $('.patientPrescriptions').append('<li class="prescription-item" data-prescription-id = "' + data.data[record].prescription_id + '"">' + data.data[record].prescription + '</li>');
                });
                Pharmacy.addClickEventToPrescription();
            }else if(data.status == Pharmacy.CONSTANTS.REQUEST_ERROR){

            }
        });
        $('.patients-list_item').removeClass('active_selected_patient');
        $(patient).addClass('active_selected_patient');
        Pharmacy.checkQueue();

        $('.active_patient').removeClass('hidden');
    },
    transferPrescription: function(prescription){
        if($(prescription).hasClass('text-cancel')){
            $(prescription).removeClass('text-cancel');
            Pharmacy.returnPrescription(prescription);
        }else{
            $(prescription).addClass('text-cancel');
            selected = "<li data-prescription-id="+ $(prescription).attr('data-prescription-id') +">" + $(prescription).html() + "</li>";
            $('.selected_prescription').append(selected);
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

            content = "<div class='clearDrug'>" +
            "<span class='cancelClear small pull-right'>cancel</span>" +
            "<h5 data-drug-id="+  drugId +">" + drugName.toUpperCase() + "</h5>" +
            "<ul>";

            $('.selected_prescription li').each(function(){
                content += "<li data-prescription-id='2'>" + $(this).html() + "</li>" + "<span>" + drugQuantity + " " + drugUnit+ "</span>";
                Pharmacy.removePrescription(this);
            });
            content += "</ul></div>";
            $('#clearPrescriptions').append(content);
            //clear form
            //clear formadd
            $('#addToClear').trigger('reset');
            $('.selected_prescription').empty();
            //show clear button
            Pharmacy.showClearButton();
            //$('#clrPrescription').removeClass('hidden');
        }
        $('.cancelClear').click(function(){
            Pharmacy.unClearPrescription($(this).parent());
        });

    },
    showClearButton: function(){
        //console.log($('#clearPrescriptions').children('div'));
            $('#clrPrescription').removeClass('hidden');

        //if ($('#clearPrescriptions').is(':empty')){
        //    //do something
        //    $('#clrPrescription').addClass('hidden');
        //}else{
        //    $('#clrPrescription').removeClass('hidden');
        //}
    },
    unClearPrescription: function(drug_panel){
        $(drug_panel).find('li').each(function(){
            $('.patientPrescriptions').append("<li class='prescription_item' data-prescription-id='"+ $(this).attr('data-prescription-id') +"'>" + $(this).html() +  "</li>");
        });
        $('.prescription_item').unbind('click').bind('click',function(){
            Pharmacy.transferPrescription(this);
        });
        $(drug_panel).remove();
        Pharmacy.showClearButton();
    },
    clearPrescription: function(){
        var info = [];
      $('.clearDrug').each(function(){
          var drugName = $(this).children('h5').html();
          var temp = {};
          temp.drugId = $(this).children('h5').attr('data-drug-id');
          temp.drugName = $(this).children('h5').html();
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
        Pharmacy.serverReq(host + 'phase/phase_pharmacist.php', payload, function(data){
            console.log(data);
        });
    },
    removePrescription: function(prescription){
        $('.patientPrescriptions li').each(function(){
            if($(this).html() == $(prescription).html()){
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
};

$(function(){
    Pharmacy.init();
});
