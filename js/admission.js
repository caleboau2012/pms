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
        DISCHARGE_IN_PATIENT: 7,
        DONE_WITH_IN_PATIENT: 5,
        NOT_DONE_WITH_IN_PATIENT: 6,
        BED_OCCUPIED : 1,
        BED_VACANT : 0
    },
    GLOBAL:{
        ACTIVE_PATIENT: false,
        ACTIVE_IN_PATIENT: false,
        ACTIVE_PATIENT_ID: false,
        ACTIVE_IN_PATIENT_BED_ID: false,
        ADMITTED_BY: false,
        ADMISSION_REQ_ID: false,
        PATIENT_ADMISSION_ID: false,
        TREATMENT_ID: false,
        SELECTED_WARD_ID: false,
        SELECTED_WARD: false,
        SELECTED_BED_ID: false,
        LOADED_BED_ID: false,
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
            Admission.assignPatient();
        });
        $('#switchPatient').unbind('click').bind('click', function(){
            Admission.switchPatient();
        });
        //

        /*Get All In Patients*/
        Admission.getAllInPatients();

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
            if(confirm("Are you sure you want to discharge this patient")){
                Admission.dischargePatient();
            }
        });

        Admission.getWardBedCounter();

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
                    $('.pending-list').html("<h2 class='text-center text-muted'>" + data.message + "</h2>");
                }else{
                    var content = "<ul class='patients-queue list-group'>";
                    data.data.forEach(function(record){
                        content += "<li class='list-group-item pointer patient patient-pill text-capitalize' data-regNum = '"+ record.regNo +"' data-patient-name = '" + record.patient + "' data-doctor-id = " + record.doctor_id +" data-patient-id = " + record.patient_id +" data-treatment-id = " + record.treatment_id + " data-admission-id = " + record.admission_req_id + " data-regNo = "+ record.regNo +">" +
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
                $('.pending-list').html("<h2 class='text-center text-muted'>Unable to complete request at the moment</h2>");
            }
        });
    },
    attendToPatient: function(patient){
        Admission.deactivate = false;
        Admission.GLOBAL.ACTIVE_PATIENT = patient;
        Admission.GLOBAL.ACTIVE_PATIENT_ID = $(patient).attr('data-patient-id');
        Admission.GLOBAL.ADMITTED_BY = $(patient).attr('data-doctor-id');
        Admission.GLOBAL.ADMISSION_REQ_ID = $(patient).attr('data-admission-id');
        Admission.GLOBAL.TREATMENT_ID = $(patient).attr('data-treatment-id');
        //$('#empty_active').hide();
        //$('#patient-panel').removeClass('hidden');
        var content = "<h2 class='panel-title text-capitalize'>" + $(patient).attr('data-patient-name') +"</h2>";
        content += "<p>" + $(patient).attr('data-regNum') +"</p>";
        $('#request-heading').html(content);

        $( "#patient-panel" ).animate({
            opacity: 0
        }, 500, "linear", function() {
            Admission.resetAction(Admission.CONSTANTS.NOT_DONE_WITH_OUT_PATIENT);
            $('#empty_active').hide();
            $('#patient-panel').removeClass('hidden').css("opacity", 1);
        });
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

        //reset response msg
        $("#assign-response").empty();
        if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
            content = "<p class='small text-muted text-center'>select bed below</p>";
            content = "<ol class='list-group out-patient-bed-list-items'>";
            data.data.forEach(function(record){
                if(record.bed_status == Admission.CONSTANTS.BED_VACANT){
                    content += "<li class='bed-item list-group-item pointer text-capitalize' data-ward-id = " + record.ward_id +" data-bed-id = "+ record.bed_id +">" + record.bed_description +"</li>"
                }
            });
            content +="</ol>";
            $('#bed-list').html(content);
            $('.bed-item').click(function(){
                Admission.selectAvailableBed(this, Admission.prepareAdmissionAssign);
            });
            Admission.validatedBedLists("bed-list");
        }else if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
            //    temporary to show empty bed
            $('#bed-list').html("<h3 class='text-danger text-center'>" + data.message + "</h3>");
        }
        Admission.GLOBAL.SELECTED_WARD = $(ward).html();
    },
    prepareInPatientBedList : function(data, ward){
        $("#switch-response").empty();
        if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
            content = "<p class='small text-muted text-center'>select bed below</p>";
            content = "<ol class='list-group in-patient-bed-list-items'>";
            data.data.forEach(function(record){
                if(record.bed_id == Admission.GLOBAL.ACTIVE_IN_PATIENT_BED_ID){
                    content += "<li class='list-group-item list-group-item-success' data-ward-id = " + record.ward_id +" data-bed-id = "+ record.bed_id +">" + record.bed_description +"</li>"
                }else if(record.bed_status == Admission.CONSTANTS.BED_VACANT){
                    content += "<li class='bed-item list-group-item pointer' data-ward-id = " + record.ward_id +" data-bed-id = "+ record.bed_id +">" + record.bed_description +"</li>"
                }else if(record.bed_status == Admission.CONSTANTS.BED_OCCUPIED){
                    content += "<li class='list-group-item list-group-item-muted disabled pointer' data-ward-id = " + record.ward_id +" data-bed-id = "+ record.bed_id +">" + record.bed_description +"</li>"
                }
                $(".step-2").addClass("active");

            });
            content +="</ol>";
            $('#in-patient-bed-list').html(content);
            $('.bed-item').click(function(){
                Admission.selectAvailableBed(this, Admission.prepareAdmissionSwitch);
            });
        }else if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
            //    temporary to show empty bed
            $('#in-patient-bed-list').html("<h3 class='text-muted text-center'>" + data.message + "</h3>");
        }
        //select the active bed if any
        Admission.GLOBAL.SELECTED_WARD = $(ward).html();
    },
    validatedBedLists: function (content_id) {
        if($("#" + content_id).find("ol").html() == ""){
            $("#" + content_id).html("<h3 class='text-danger text-center'>No vacant bed in this ward</h3>");
        }
    },
    selectAvailableBed: function(bed, call_back){
        if(!Admission.deactivate){
            $('.step-2').addClass('active');
            $(".bed-item").removeClass("list-group-item-success");
            $(bed).addClass("list-group-item-success");
            Admission.GLOBAL.SELECTED_BED = $(bed).html();
            Admission.GLOBAL.SELECTED_BED_ID = $(bed).attr("data-bed-id");
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
            var response_msg = "";
            $.getJSON(host + 'phase/phase_admission.php', payload, function(data){
                $('#loader').addClass('hidden');
                if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
                    response_msg = '<div class="alert alert-dismissible alert-danger text-center">' +
                    ' <button type="button" class="close" data-dismiss="alert">×</button>' +
                    '' + data.message +'' +
                    '</div>';
                    $('#assign-response').html(response_msg);
                }else if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                    Admission.deactivate = true;
                    $('.step-3').addClass('active');
                    response_msg = '<div class="alert alert-dismissible alert-success text-center">' +
                    ' <button type="button" class="close" data-dismiss="alert">×</button>' +
                    '' + data.message +'' +
                    '</div>';
                    $('#assign-response').html(response_msg);
                    Admission.resetAction(Admission.CONSTANTS.DONE_WITH_OUT_PATIENT);
                }
            }).fail(function(data){
                response_msg = '<div class="alert alert-dismissible alert-danger text-center">' +
                ' <button type="button" class="close" data-dismiss="alert">×</button>' +
                'Unfortunately this transaction cannot be completed at the moment. Please, try again' +
                '</div>';
                $('#assign-response').html(response_msg);
            });
        }
    },
    switchPatient: function(){
        if(!Admission.deactivate){
            $('#switch-loader').removeClass('hidden');
            payload = {};
            payload.intent = "switchBed";
            payload.bed_id = Admission.GLOBAL.SELECTED_BED_ID;
            payload.admission_id = Admission.GLOBAL.PATIENT_ADMISSION_ID;
            $.post(host + 'phase/phase_admission.php', payload, function(data){
                $('#switch-loader').addClass('hidden');
                var response_msg = "";
                if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
                    response_msg = '<div class="alert alert-dismissible alert-danger text-center">' +
                    ' <button type="button" class="close" data-dismiss="alert">×</button>' +
                    '' + data.message +'' +
                    '</div>';
                    $('#switch-response_msg').html(response_msg);
                }else if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                    $('.step-3').addClass('active');
                    response_msg = '<div class="alert alert-dismissible alert-success text-center">' +
                    ' <button type="button" class="close" data-dismiss="alert">×</button>' +
                    '' + data.message +'' +
                    '</div>';
                    $('#switch-response_msg').html(response_msg);
                    Admission.resetAction(Admission.CONSTANTS.DONE_WITH_IN_PATIENT);
                }
            }, "json").fail(function(data){
                response_msg = '<div class="alert alert-dismissible alert-danger text-center">' +
                ' <button type="button" class="close" data-dismiss="alert">×</button>' +
                'Unfortunately, this transaction cannot be completed at the moment. Please, try again' +
                '</div>';
                $('#switch-response_msg').html(response_msg);
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
            $('.thin-separator').empty().addClass('hidden');
            $('#assignPatient').addClass('hidden');
            $('.step-3').removeClass('active');
            $('.step-2').removeClass('active');
            $(".admitted-out-patients_ward li").each(function () {
                $(this).removeClass("list-group-item-success");
            });
            $(".bed-item").removeClass("list-group-item-success");
            $("#assign-response").empty();
        }else if(state == Admission.CONSTANTS.DONE_WITH_IN_PATIENT){
            //updated patient bed id
            Admission.GLOBAL.ACTIVE_IN_PATIENT_BED_ID = Admission.GLOBAL.SELECTED_BED_ID;
            $(".admitted-patients-in-ward li").each(function () {
                if($(this).attr("data-ward-id") == Admission.GLOBAL.SELECTED_WARD_ID){
                    //get bed of the patient
                    $(this).trigger("click");
                    return false;
                }

            });
            //hide switch button
            $("#switchPatient").addClass("hidden");

        }else if(state == Admission.CONSTANTS.NOT_DONE_WITH_IN_PATIENT){
            Admission.deactivate = false;
        }else if(state == Admission.CONSTANTS.DISCHARGE_IN_PATIENT){
            $(".discharge-container").addClass("hidden");
            $(Admission.GLOBAL.ACTIVE_IN_PATIENT).remove();
            Admission.deactivate = true;
        }
    },
    prepareAdmissionAssign: function () {
        $('#ward_chosen').html(Admission.GLOBAL.SELECTED_WARD).removeClass('hidden');
        $('.thin-separator').removeClass('hidden');
        $('#bed_chosen').html(Admission.GLOBAL.SELECTED_BED).removeClass('hidden');
        $('#assignPatient').removeClass('hidden');
    }
    //IN-PATIENTS
    ,getAllInPatients: function () {
        var payload = {};
        payload.intent = "getPatients";

        $.getJSON(host + 'phase/phase_admission.php', payload, function (data) {
            if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                Admission.prepareInPatients(data.data);
            }else{
                $('#in-patient-result').html("<h4 class='text-muted text-center'>"+ data.message +"</h4>")
            }
        });
    }
    ,getInPatients: function(){
        var query = $('#patient_query').val();
        var payload = {};
        payload.intent = "searchPatients";
        if(query !== ''){
            payload.term = query;
            $.getJSON(host + 'phase/phase_admission.php', payload, function(data){
                if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
                    $('#in-patient-result').html("<h4 class='text-muted text-center'>"+ data.message +"</h4>")
                }else if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                    Admission.prepareInPatients(data.data);
                }
            }).fail(function(data){
                $('#in-patient-result').html("<h4 class='text-muted text-center'>Unable to complete request at the moment</h4>")
            });
        }else{
            //    get all in patients
            Admission.getAllInPatients();
        }
    },
    prepareInPatients: function (patients) {
        var content = "<ul class='patients-queue list-group'>";
        patients.forEach(function(record){
            content += "<li class='text-capitalize list-group-item pointer in-patient patient-pill' data-ward-id =" +  record.ward_id +" data-bed-id="+ record.bed_id  +" data-regNum = '"+ record.regNo +"' data-patient-name = '" + record.patient + "' data-doctor = '" + record.doctor + "' data-patient-id = " + record.patient_id +" data-treatment-id = " + record.treatment_id + " data-admission-id = " + record.admission_id + " data-regNo = "+ record.regNo +" data-entry-date ='"+ record.entry_date +"'>" +
            record.patient + "<div class='small text-muted'>" + record.regNo +"</div></li>";
        });
        content += "</ul>";
        $('#in-patient-result').html(content);
        $('.in-patient').bind('click', function(){
            Admission.attendToInPatient(this);
            Admission.getPatientRoomDetails(this);
        });
    }
    ,attendToInPatient: function(patient){
        //remove patient from search queue
        Admission.deactivate = false;
        Admission.GLOBAL.ACTIVE_IN_PATIENT = patient;
        //setup selected in patient
        Admission.GLOBAL.ACTIVE_IN_PATIENT_BED_ID = $(patient).attr("data-patient-id");
        Admission.GLOBAL.PATIENT_ADMISSION_ID = $(patient).attr("data-admission-id");
        Admission.GLOBAL.ACTIVE_PATIENT_ID = $(patient).attr('data-patient-id');
        Admission.GLOBAL.TREATMENT_ID = $(patient).attr('data-treatment-id');

        $("#patient_name").empty().html($(patient).attr('data-patient-name'));
        $("#patient_reg_num").empty().html($(patient).attr('data-regNo'));
        $("#req_doctor").empty().html($(patient).attr('data-doctor'));

        //$('#in-patient-identity').html(patient_identity);

        $(".admitted-patients-in-ward li").click(function(){
            Admission.getWardAvailableBeds(this, Admission.prepareInPatientBedList);
        });
        //Get patient details
        Admission.getPatientRoomDetails(patient);

    },
    getPatientRoomDetails: function(patient){
        //console.log(patient);
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
        $(".discharge-container").removeClass("hidden");

        /*Admission Details*/
        var format_datetime = Admission.toDateString($(patient).attr('data-entry-date')) + " by " + Admission.toLocaleTimeString($(patient).attr('data-entry-date'));
        $("#entry_date").html(format_datetime);
    },
    prepareAdmissionSwitch: function () {
        $('.assign-patient-column #ward_chosen').html(Admission.GLOBAL.SELECTED_WARD).removeClass('hidden');
        $('.assign-patient-column .thin-separator').removeClass('hidden');
        $('.assign-patient-column #bed_chosen').html(Admission.GLOBAL.SELECTED_BED).removeClass('hidden');
        $('.assign-patient-column #assignPatient').removeClass('hidden');
        $("#switchPatient").removeClass("hidden");
    },
    logEncounter: function(){
        $('#log_encounter_response').empty();
        $('#log_encounter_loading').removeClass('hidden');
        var payload = {};
        payload.intent = 'logEncounter';
        payload.admission_id = Admission.GLOBAL.PATIENT_ADMISSION_ID;
        payload.patient_id =  Admission.GLOBAL.ACTIVE_PATIENT_ID;
        payload.treatment_id =  Admission.GLOBAL.TREATMENT_ID;
        payload.comments = $('#comment').val();
        payload.vitals = {};
        console.log(payload);

        $("#log_encounter input").each(function () {
            if($(this).val() !== "" && $(this).attr("name") !== "comments"){
                payload.vitals[$(this).attr("name")] = $(this).val();
            }
        });

        $.post(host + 'phase/phase_admission.php', payload, function(data){
            console.log(data);
            var response;
            if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                response = '<div class="alert alert-dismissible alert-success text-center">' +
                ' <button type="button" class="close" data-dismiss="alert">×</button>' +
                '<strong>' + data.message +'</strong>' +
                '</div>';
                $('#log_encounter_response').html(response);
                $('#log_encounter').trigger('reset');
                $('#log_encounter_loading').addClass('hidden');
            }else if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
                response = '<div class="alert alert-dismissible alert-danger text-center">' +
                ' <button type="button" class="close" data-dismiss="alert">×</button>' +
                '<strong>' + data.message +'</strong><br/> Ensure to enter appropriate values' +
                '</div>';
                $('#log_encounter_loading').addClass('hidden');
                $('#log_encounter_response').html(response);
            }
        }).fail(function(data){
            response = '<div class="alert alert-dismissible alert-danger text-center">' +
            ' <button type="button" class="close" data-dismiss="alert">×</button>' +
            'Unfortunately, an unexpected occur, Please try again' +
            '</div>';
            $('#log_encounter_loading').addClass('hidden');
            $('#log_encounter_response').html(response);
        }, 'json');
    },
    dischargePatient: function(){
        payload = {};
        payload.intent = 'dischargePatient';
        payload.patient_id = Admission.GLOBAL.ACTIVE_PATIENT_ID;

        $.getJSON(host + 'phase/phase_admission.php', payload, function(data){
            var response_msg;
            if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                response_msg = '<br/><div class="alert alert-dismissible alert-success text-center">' +
                ' <button type="button" class="close" data-dismiss="alert">×</button>' +
                '<h4>' + data.message +'</h4>' +
                '</div>';
                $("#discharge_patient_response").html(response_msg);
                Admission.resetAction(Admission.CONSTANTS.DISCHARGE_IN_PATIENT)
            }else if(data.status == Admission.CONSTANTS.REQUEST_ERROR){
                response_msg = '<div class="alert alert-dismissible alert-danger text-center">' +
                ' <button type="button" class="close" data-dismiss="alert">×</button>' +
                '' + data.message +'' +
                '</div>';
                $("#discharge_patient_response").html(response_msg);
            }
        });
    },
    toDateString: function (dateString){
        date = new Date(dateString);
        if(isNaN(date.getTime())){
            return dateString.substr(0, 10);
        }
        else{
            //console.log(date instanceof String)
            return date.toDateString();
        }
    },
    toLocaleTimeString: function (dateString){
        date = new Date(dateString);
        if(isNaN(date.getTime())){
            return dateString.substr(dateString.length - 8);
        }
        else{
            //console.log(date instanceof String)
            return date.toLocaleTimeString();
        }
    },
    getWardBedCounter: function(){
        var payload = {};
        payload.intent = "getWardBedCounter";
        $.getJSON(host + "phase/phase_ward.php", payload, function (data) {

            if(data.status == Admission.CONSTANTS.REQUEST_SUCCESS){
                var num_of_wards = data.data.wards;
                if(num_of_wards > 1){
                    $(".num_of_wards").html(num_of_wards + " wards");
                }else{
                    $(".num_of_wards").html(num_of_wards + " ward");

                }
                var num_of_available_beds = data.data.beds.available;
                if(num_of_available_beds > 1){
                    $(".num_of_available_beds").html(num_of_available_beds + " available beds");
                }else{
                    $(".num_of_available_beds").html(num_of_available_beds + " available bed");
                }
                var num_of_beds = parseInt(data.data.beds.occupied) + parseInt(data.data.beds.available);
                if(num_of_beds > 1){
                    $(".num_of_beds").html(num_of_beds + " beds");
                }else{
                    $(".num_of_beds").html(num_of_beds + " bed");
                }
            }else{

            }
        })
    }
};

$(function(){
    Admission.init();
});
