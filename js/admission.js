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
        SELECTED_BED: false,
        ACTIVE_OUT_PATIENT: {}
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
            Admission.assignPatient(this);
        });

        //IN-PATIENTS
        $('#in-patient-form').on('submit', function(e){
            e.preventDefault();
            Admission.getInPatients()
        });
        $('#log_encounter').on('submit', function(e){
            e.preventDefault();
            Admission.logEncounter();

        });
        $('#discharge_patient').unbind('click').bind('click', function(){
            Admission.dischargePatient();
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
        });
        //hide content for in patient view
        $('#active_in_patient').addClass('hidden');
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
            if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                if(data.data === undefined){
                    console.log(data.message);
                    $('.pending-list').html("<h2 class='text-center text-muted'>" + data.message + "</h2>");
                }else{
                    content = "<ul class='patients-queue list-group'>";
                    data.data.forEach(function(record){
                        content += "<li class='list-group-item pointer patient patient-pill' data-regNum = '"+ record.regNo +"' data-patient-name = '" + record.patient + "' data-doctor-id = " + record.doctor_id +" data-patient-id = " + record.patient_id +" data-treatment-id = " + record.treatment_id + " data-admission-id = " + record.admission_req_id + " data-regNo = "+ record.regNo +">" +
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
        if(!Admission.GLOBAL.ACTIVE_PATIENT){
            Admission.resetAction(Admission.CONSTANTS.NOT_DONE_WITH_PATIENT);
            Admission.deactivate = false;
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
        }
    },
    getWardAvailableBeds: function(ward){
        if(!Admission.deactivate){
            $('#step-1').addClass('active');
            $('#step-2').removeClass('active');

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
            //assign the ward details
            //Admission.CONSTANTS.SELECTED_WARD_ID = $(ward).attr('data-ward-id');
            Admission.GLOBAL.SELECTED_WARD = $(ward).html();
        }
    },
    selectAvailableBed: function(bed){
        if(!Admission.deactivate){
            $('#step-2').addClass('active');

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
        }
    },
    assignPatient: function(){
        if(!Admission.deactivate){
            $('#loader').removeClass('hidden');
            payload = {};
            payload.intent = "admitPatient";
            payload.bed_id = Admission.GLOBAL.SELECTED_BED_ID;
            payload.patient_id = Admission.GLOBAL.ACTIVE_PATIENT_ID;
            payload.treatment_id = Admission.GLOBAL.TREATMENT_ID;
            $.getJSON(host + 'phase/phase_admission.php', payload, function(data){
                $('#loader').addClass('hidden');
                //console.log(data);
                if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
                    $('#response_msg').html("<p class='text-danger'>" + data.message +"</p>");
                }else if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                    Admission.deactivate = true;
                    $('#step-3').addClass('active');
                    $('#response_msg').html("<p class='text-success'>" + data.message +"</p>");
                    console.log(Admission.GLOBAL.ACTIVE_PATIENT);
                    Admission.resetAction(Admission.DONE_WITH_PATIENT);
                }
            }).fail(function(data){
                console.log(data.responseText);
            });
        }
    },
    queueChecker: function(){
        if($('.patients-queue li').length == 0){
            $('.pending-list').html("<h2 class='text-center text-muted'>" + "No pending admission requests!" + "</h2>");
        }
    },
    resetAction: function(state){
        if(state == Admission.CONSTANTS.DONE_WITH_PATIENT){
            //remove patient form queue
            $(Admission.GLOBAL.ACTIVE_PATIENT).remove();
            Admission.queueChecker();
            Admission.GLOBAL.ACTIVE_PATIENT = false;
        }else if(state == Admission.CONSTANTS.NOT_DONE_WITH_PATIENT) {
            $('#ward_chosen').empty().addClass('hidden');
            $('#bed_chosen').empty().addClass('hidden');
            $('#assignPatient').addClass('hidden');
            $('#step-3').removeClass('active');
            $('#step-2').removeClass('active');
        }
        Admission.deactivate = false;
    }

    //IN-PATIENTS
    ,getInPatients: function(){
        query = $('#patient_query').val();
        payload = {};
        payload.intent = "searchPatients";
        if(query !== ''){
            payload.term = query;
            $.getJSON(host + 'phase/phase_admission.php', payload, function(data){
                console.log(data);
                if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
                    $('#in-patient-result').html("<h4 class='text-muted text-center'>"+ data.message +"</h4>")
                }else if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                    content = "<ul class='patients-queue list-group'>";
                    data.data.forEach(function(record){
                        content += "<li class='list-group-item pointer in-patient patient-pill' data-regNum = '"+ record.regNo +"' data-patient-name = '" + record.patient + "' data-doctor = " + record.doctor +" data-patient-id = " + record.patient_id +" data-treatment-id = " + record.treatment_id + " data-admission-id = " + record.admission_id + " data-regNo = "+ record.regNo +">" +
                        record.patient + "<div class='small text-muted'>" + record.regNo +"</div></li>";
                    });
                    content += "</ul>";
                    $('#in-patient-result').html(content);
                    $('.in-patient').bind('click', function(){
                        Admission.attendToInPatient(this);
                    })
                }
            }).fail(function(data){
                console.log(data.responseText);
            });
        }
    }
    ,attendToInPatient: function(patient){
        console.log(patient);
    //
        $('#empty_active_in_patient').addClass('hidden');
        $('#active_in_patient').removeClass('hidden');

        patient_identity = "<h2 class='text-primary'>"+ $(patient).attr('data-patient-name') + "</h2>";
        patient_identity += "<p>" + $(patient).attr('data-regNo') +"</p>";
        $('#in-patient-identity').html(patient_identity);

        Admission.GLOBAL.ACTIVE_OUT_PATIENT.admission_id = $(patient).attr('data-admission-id');
        Admission.GLOBAL.ACTIVE_OUT_PATIENT.patient_id = $(patient).attr('data-patient-id');



    },
    logEncounter: function(){
        $('#log_encounter_loading').removeClass('hidden');
        payload = {};
        payload.intent = 'logEncounter';
        payload.admission_id = Admission.GLOBAL.ACTIVE_OUT_PATIENT.admission_id;
        payload.patient_id = Admission.GLOBAL.ACTIVE_OUT_PATIENT.patient_id;
        payload.comments = $('#comment').val();
        payload.vitals = {};

        payload.vitals.temp = $('#temp').val();
        payload.vitals.pulse = $('#pulse').val();
        payload.vitals.respiratory_rate = $('#respiratory_rate').val();
        payload.vitals.blood_pressure = $('#blood_pressure').val();
        payload.vitals.height = $('#height').val();
        payload.vitals.weight = $('#weight').val();
        payload.vitals.bmi = $('#bmi').val();

        $.getJSON(host + 'phase/phase_admission.php', payload, function(data){
            if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                $('#log_encounter_response').html("<p class='text-success'>" + data.message +"</p>");
                $('#log_encounter').trigger('reset');
                $('#log_encounter_loading').addClass('hidden');
            }else if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
                $('#log_encounter_loading').addClass('hidden');
                $('#log_encounter_response').html("<p class='text-danger'>" + data.data +"</p>");

            }

        }).fail(function(data){
            console.log(data);
        });
    },
    dischargePatient: function(){
        payload = {};
        payload.intent = 'dischargePatient';
        payload.patient_id = Admission.GLOBAL.ACTIVE_OUT_PATIENT.patient_id;

        $.getJSON(host + 'phase/phase_admission.php', payload, function(data){
            if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                $('#dischage_patient_content').html("<h2>" + data.message +"</h2>");
            }else if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
                $('#discharge_patient_error').html("<h4>" + data.data +"</h4>");
            }
        });
    }
};

$(function(){
    Admission.init();
});
