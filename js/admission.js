/**
 * Created by olajuwon on 2/20/2015.
 */
Admission = {
    deactivate : false,
    CONSTANTS: {
        REQUEST_SUCCESS: 1,
        REQUEST_ERROR: 2,
        IN_PATIENT_VIEW : 2,
        OUT_PATIENT_VIEW: 1,
        DONE_WITH_PATIENT: 3,
        NOT_DONE_WITH_PATIENT: 4
    },
    GLOBAL:{
        ACTIVE_PATIENT: false,
        ACTIVE_PATIENT_ID: false,
        ADMITTED_BY: false,
        ADMISSION_REQ_ID: false,
        TREATMENT_ID: false,
        SELECTED_WARD_ID: false,
        SELECTED_WARD: false,
        SELECTED_BED_ID: false,
        SELECTED_BED: false
    },
    init: function(){
        $('.adm-menu').click(function(){
            Admission.switchMenu(this);
        });

        //default page view
        Admission.outPatientView();
        //Admission list
        Admission.requestList();
        //Attach click on ward
        $('.ward').click(function(){
            Admission.getWardAvailableBeds(this);
        });
        //
        $('#assignPatient').unbind('click').bind('click', function(){
            Admission.assignPatient();
        });

    },
    switchMenu : function(obj){
        $('.adm-menu').removeClass('active');
        $(obj).addClass('active');
        if($(obj).attr('data-view-id') == Admission.CONSTANTS.IN_PATIENT_VIEW){
            Admission.inPatientView();
        }else if($(obj).attr('data-view-id') == Admission.CONSTANTS.OUT_PATIENT_VIEW){
            Admission.outPatientView();
        }
    },
    outPatientView : function(){
        $('#in-patient-view').fadeOut('fast', function(){
            $('#out-patient-view').fadeIn('slow', function(){

            })
        })  ;
    },
    inPatientView : function(){
        $('#out-patient-view').fadeOut('fast', function(){
            $('#in-patient-view').fadeIn('slow', function(){

            })
        })  ;
    },
    requestList: function(){
        payload = {};
        payload.intent = 'getAdmissionRequests';
        $.getJSON(host + 'phase/phase_admission_request.php', payload, function(data){
            console.log(data);
            if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                if(data.data === undefined){
                    console.log(data.message);
                    $('.pending-list').html("<h2 class='text-center text-muted'>" + data.message + "</h2>");
                }else{
                    content = "<ul class='list-group'>";
                    data.data.forEach(function(record){
                        content += "<li class='list-group-item pointer patient' data-regNum = '"+ record.regNo +"' data-patient-name = '" + record.patient + "' data-doctor-id = " + record.doctor_id +" data-patient-id = " + record.patient_id +" data-treatment-id = " + record.treatment_id + " data-admission-id = " + record.admission_req_id + " data-regNo = "+ record.regNo +">" +
                        record.patient + "<div class='small text-muted'>" + record.regNo +"</div></li>";
                    });
                    content += "</ul>";
                    $('.pending-list').html(content);
                    //attach click on patient
                    $('.patient').click(function(){
                        Admission.attendToPatient(this)
                    });
                }
            }else if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
                console.log('Error in page');
            }
        });
    },
    attendToPatient: function(patient){
        Admission.GLOBAL.ACTIVE_PATIENT = patient;
        Admission.GLOBAL.ACTIVE_PATIENT_ID = $(patient).attr('data-patient-id');
        Admission.GLOBAL.ADMITTED_BY = $(patient).attr('data-doctor-id');
        Admission.GLOBAL.ADMISSION_REQ_ID = $(patient).attr('data-admission-id');
        Admission.GLOBAL.TREATMENT_ID = $(patient).attr('data-treatment-id');
        $('#empty_active').hide();
        $('#patient-panel').removeClass('hidden');
        content = "<h2 class='panel-title'>" + $(patient).attr('data-patient-name') +"</h2>";
        content += "<p>" + $(patient).attr('data-regNum') +"</p>";
        $('#request-heading').html(content);
    },
    getWardAvailableBeds: function(ward){
        Admission.resetAction(Admission.CONSTANTS.NOT_DONE_WITH_PATIENT);
        payload = {};
        payload.intent = "loadBeds";
        payload.ward_id = $(ward).attr('data-ward-id');

        $.getJSON(host + 'phase/phase_admission.php', payload, function(data){
            if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                //content = "<p class='small text-muted text-center'>select bed below</p>";
                content = "<ol class='list-group'>";
                data.data.forEach(function(record){
                    content += "<li class='bed-item list-group-item pointer' data-ward-id = " + record.ward_id +" data-bed-id = "+ record.bed_id +">" + record.bed_description +"</li>"
                });
                content +="</ol>";
                $('#bed-list').html(content);
                $('.bed-item').click(function(){
                    Admission.selectAvailableBed(this);
                });
            }else if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
                //    temporary to show empty bed
                $('#bed-list').html("<h3 class='text-muted text-center'>" + data.message + "</h3>");
            }
        });

        //make ward active
        $('li.ward').removeClass('list-group-item-success');
        $(ward).addClass('list-group-item-success');
        //make step 2 active
        $('#step-2').addClass('active');
        //assign the ward details
        //Admission.CONSTANTS.SELECTED_WARD_ID = $(ward).attr('data-ward-id');
        Admission.GLOBAL.SELECTED_WARD = $(ward).html();

    },
    selectAvailableBed: function(bed){
        $('#step-3').addClass('active');

        $('.bed-item').removeClass('list-group-item-success');
        $(bed).addClass('list-group-item-success');
        //set global variable
        Admission.GLOBAL.SELECTED_BED_ID = $(bed).attr('data-bed-id');
        Admission.GLOBAL.SELECTED_WARD_ID = $(bed).attr('data-ward-id');
        $('#ward_chosen').html(Admission.GLOBAL.SELECTED_WARD).removeClass('hidden');
        $('.thin-separator').removeClass('hidden');
        $('#bed_chosen').html($(bed).html()).removeClass('hidden');
        $('#assignPatient').removeClass('hidden');
        //show selected details

    },
    assignPatient: function(){
        $('#loader').removeClass('hidden');
        payload = {};
        payload.intent = "admitPatient";
        payload.bed_id = Admission.GLOBAL.SELECTED_BED_ID;
        payload.patient_id = Admission.GLOBAL.ACTIVE_PATIENT_ID;
        payload.treatment_id = Admission.GLOBAL.TREATMENT_ID;

        console.log(payload);
        $.getJSON(host + 'phase/phase_admission.php', payload, function(data){
            $('#loader').addClass('hidden');
            console.log(data);
            if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
                $('#response_msg').html("<p class='text-danger'>" + data.message +"</p>");
            }
        }).fail(function(data){
            console.log(data.responseText);
        });

    },
    resetAction: function(state){
        if(state == Admission.CONSTANTS.DONE_WITH_PATIENT){
            //    remove from panel
        }else if(state == Admission.CONSTANTS.NOT_DONE_WITH_PATIENT) {
            $('#ward_chosen').empty().addClass('hidden');
            $('#bed_chosen').empty().addClass('hidden');
            $('#assignPatient').addClass('hidden');
            $('#step-3').removeClass('active');
        }
    }
};

$(function(){
    Admission.init();
});
