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
        DONE_WITH_OUT_PATIENT: 3,
        NOT_DONE_WITH_OUT_PATIENT: 4,
        DONE_WITH_IN_PATIENT: 5,
        NOT_DONE_WITH_IN_PATIENT: 6
    },
    GLOBAL:{
        ACTIVE_PATIENT: false,
        ACTIVE_PATIENT_ID: false,
        ACTIVE_IN_PATIENT_BED_ID: false,
        ADMITTED_BY: false,
        ADMISSION_REQ_ID: false,
        PATIENT_ADMISSION_ID: false,
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
        //$('.ward').click(function(){
        //    Admission.getWardAvailableBeds(this);
        //});
        $('.admitted-in-patients_ward li').click(function(){
            Admission.getWardAvailableBeds(this, Admission.prepareInPatientBedList);
        });
        $('.admitted-out-patients_ward li').click(function(){
            Admission.getWardAvailableBeds(this, Admission.prepareOutPatientBedList);
        });
        //
        $('#assignPatient').unbind('click').bind('click', function(){
            Admission.assignPatient(this);
        });
        $('#switchPatient').unbind('click').bind('click', function(){
            Admission.switchPatient();
        });
        //

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
        //$('#in-patient-view').addClass('hidden');
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
    getWardAvailableBeds: function(ward, call_back){
        if(!Admission.deactivate){
            $('.step-1').addClass('active');
            $('.step-2').removeClass('active');

            Admission.resetAction(Admission.CONSTANTS.NOT_DONE_WITH_PATIENT);
            payload = {};
            payload.intent = "loadBeds";
            payload.ward_id = $(ward).attr('data-ward-id');

            $.getJSON(host + 'phase/phase_admission.php', payload, function(data){
                call_back(data, ward);
            });
            //make ward active
            $('li.ward').removeClass('list-group-item-success');
            $(ward).addClass('list-group-item-success');
            //make step 2 active
            //assign the ward details
            //Admission.CONSTANTS.SELECTED_WARD_ID = $(ward).attr('data-ward-id');
            //Admission.GLOBAL.SELECTED_WARD = $(ward).html();
        }
    },
    prepareOutPatientBedList : function(data, ward){
        if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
            content = "<p class='small text-muted text-center'>select bed below</p>";
            content = "<ol class='list-group'>";
            data.data.forEach(function(record){
                content += "<li class='bed-item list-group-item pointer' data-ward-id = " + record.ward_id +" data-bed-id = "+ record.bed_id +">" + record.bed_description +"</li>"
            });
            content +="</ol>";
            $('#bed-list').html(content);
            $('.bed-item').click(function(){
                Admission.activateBed(this);
                Admission.GLOBAL.SELECTED_BED = $(this).html();
                Admission.selectAvailableBed($(this).attr("data-ward"), $(this).attr("data-bed-id"), Admission.prepareAdmissionAssign);
            });
        }else if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
            //    temporary to show empty bed
            $('#bed-list').html("<h3 class='text-muted text-center'>" + data.message + "</h3>");
        }
        Admission.GLOBAL.SELECTED_WARD = $(ward).html();
    },
    prepareInPatientBedList : function(data, ward){
        if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
            content = "<p class='small text-muted text-center'>select bed below</p>";
            content = "<ol class='list-group in-patient-bed-list-items'>";
            data.data.forEach(function(record){
                if(record.bed_id == Admission.GLOBAL.ACTIVE_IN_PATIENT_BED_ID){
                    $(".step-2").addClass("active");
                    content += "<li class='bed-item list-group-item list-group-item-success pointer' data-ward-id = " + record.ward_id +" data-bed-id = "+ record.bed_id +">" + record.bed_description +"</li>"
                }else{
                    content += "<li class='bed-item list-group-item pointer' data-ward-id = " + record.ward_id +" data-bed-id = "+ record.bed_id +">" + record.bed_description +"</li>"
                }
            });
            content +="</ol>";
            $('#in-patient-bed-list').html(content);
            $('.bed-item').click(function(){
                Admission.activateBed(this);
                Admission.GLOBAL.SELECTED_BED = $(this).html();
                Admission.GLOBAL.SELECTED_BED_ID = $(this).attr("data-bed-id");
                Admission.selectAvailableBed($(this).attr("data-bed-id"), $(this).attr("data-ward-id"), Admission.prepareAdmissionSwitch);
            });
        }else if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
            //    temporary to show empty bed
            $('#bed-list').html("<h3 class='text-muted text-center'>" + data.message + "</h3>");
        }
        //select the active bed if any
        Admission.GLOBAL.SELECTED_WARD = $(ward).html();
    },
    activateBed: function(bed){
        if(!Admission.deactivate){
            $(".bed-item").removeClass("list-group-item-success");
            $(bed).addClass("list-group-item-success");
        }
    },
    selectAvailableBed: function(bed, ward, call_back){
        if(!Admission.deactivate){
            $('.step-2').addClass('active');
            Admission.GLOBAL.SELECTED_BED_ID = bed;
            Admission.GLOBAL.SELECTED_WARD_ID = ward;
            call_back();
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
                if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
                    $('#response_msg').html("<p class='text-danger'>" + data.message +"</p>");
                }else if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                    Admission.deactivate = true;
                    $('.step-3').addClass('active');
                    $('#response_msg').html("<p class='text-success'>" + data.message +"</p>");
                    Admission.resetAction(Admission.CONSTANTS.DONE_WITH_OUT_PATIENT);
                }
            }).fail(function(data){
                console.log(data.responseText);
            });
        }
    },
    switchPatient: function(){
        if(!Admission.deactivate){
            $('#switch-loader').removeClass('hidden');
            payload = {};
            payload.intent = "switchBed";
            payload.bed_id = Admission.GLOBAL.SELECTED_BED_ID;
            payload.admission_id = Admission.GLOBAL.ACTIVE_PATIENT_ID;
            $.post(host + 'phase/phase_admission.php', payload, function(data){
                $('#switch-loader').addClass('hidden');
                //console.log(data);
                if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
                    $('#switch-response_msg').html("<p class='text-danger'>" + data.message +"</p>");
                }else if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                    $('.step-3').addClass('active');
                    $('#switch-response_msg').html("<p class='text-success'>" + data.message +"</p>");
                    Admission.resetAction(Admission.CONSTANTS.DONE_WITH_IN_PATIENT);
                }
            }, "json").fail(function(data){
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
        if(state == Admission.CONSTANTS.DONE_WITH_OUT_PATIENT){
            //remove patient form queue
            $(Admission.GLOBAL.ACTIVE_PATIENT).remove();
            Admission.queueChecker();
            Admission.GLOBAL.ACTIVE_PATIENT = false;
            Admission.deactivate = true;

        }else if(state == Admission.CONSTANTS.NOT_DONE_WITH_OUT_PATIENT) {
            $('#ward_chosen').empty().addClass('hidden');
            $('#bed_chosen').empty().addClass('hidden');
            $('#assignPatient').addClass('hidden');
            $('.step-3').removeClass('active');
            $('.step-2').removeClass('active');
        }else if(state == Admission.CONSTANTS.DONE_WITH_IN_PATIENT){

            //hide switch button
            $("#switchPatient").addClass("hidden");

        }else if(state == Admission.CONSTANTS.NOT_DONE_WITH_IN_PATIENT){
            console.log("Not done with in patient");
            Admission.deactivate = false;

        }
    },
    prepareAdmissionAssign: function () {
        $('#ward_chosen').html(Admission.GLOBAL.SELECTED_WARD).removeClass('hidden');
        $('.thin-separator').removeClass('hidden');
        $('#bed_chosen').html(Admission.GLOBAL.SELECTED_BED).removeClass('hidden');
        $('#assignPatient').removeClass('hidden');
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
                        content += "<li class='list-group-item pointer in-patient patient-pill' data-ward-id =" +  record.ward_id +" data-bed-id="+ record.bed_id  +" data-regNum = '"+ record.regNo +"' data-patient-name = '" + record.patient + "' data-doctor = " + record.doctor +" data-patient-id = " + record.patient_id +" data-treatment-id = " + record.treatment_id + " data-admission-id = " + record.admission_id + " data-regNo = "+ record.regNo +">" +
                        record.patient + "<div class='small text-muted'>" + record.regNo +"</div></li>";
                    });
                    content += "</ul>";
                    $('#in-patient-result').html(content);
                    $('.in-patient').bind('click', function(){
                        Admission.attendToInPatient(this);
                        Admission.getPatientRoomDetails(this);
                    })
                }
            }).fail(function(data){
                console.log(data.responseText);
            });
        }
    }
    ,attendToInPatient: function(patient){
        //setup selected in patient
        Admission.GLOBAL.ACTIVE_IN_PATIENT_BED_ID = $(patient).attr("data-patient-id");
        Admission.GLOBAL.PATIENT_ADMISSION_ID = $(patient).attr("data-admission-id");
        patient_identity = "<h2 class='text-primary'>"+ $(patient).attr('data-patient-name') + "</h2>";
        patient_identity += "<p>" + $(patient).attr('data-regNo') +"</p>";
        $('#in-patient-identity').html(patient_identity);

        $(".admitted-patients-in-ward li").click(function(){
            Admission.getWardAvailableBeds(this, Admission.prepareInPatientBedList);
        });
        //Get patient details
        Admission.getPatientRoomDetails(patient);


    },
    getPatientRoomDetails: function(patient){
        console.log($(patient).attr("data-bed-id"));
        //set patient bed id
        Admission.GLOBAL.ACTIVE_IN_PATIENT_BED_ID = $(patient).attr("data-bed-id");

        $(".admitted-patients-in-ward li").each(function () {
            if($(patient).attr("data-ward-id") == $(this).attr("data-ward-id")){
                //get bed of the patient
                $(this).trigger("click");
                return false;
            }
        });
        $("#empty_active_in_patient").addClass("hidden");
        $(".in-patient-content").removeClass("hidden");
    },
    prepareAdmissionSwitch: function () {
        $('.assign-patient-column #ward_chosen').html(Admission.GLOBAL.SELECTED_WARD).removeClass('hidden');
        $('.assign-patient-column .thin-separator').removeClass('hidden');
        $('.assign-patient-column #bed_chosen').html(Admission.GLOBAL.SELECTED_BED).removeClass('hidden');
        $('.assign-patient-column #assignPatient').removeClass('hidden');
        $("#switchPatient").removeClass("hidden");
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
                $('#discharge_patient_content').html("<h2 class='text-success'>" + data.message +"</h2>");
            }else if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
                $('#discharge_patient_error').html("<h4>" + data.message +"</h4>");
            }
        });
    }
};

$(function(){
    Admission.init();
});
