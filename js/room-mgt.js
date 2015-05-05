/**
 * Created by olajuwon on 2/20/2015.
 */
Room = {
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
        Room_REQ_ID: false,
        TREATMENT_ID: false,
        SELECTED_WARD_ID: false,
        SELECTED_WARD: false,
        SELECTED_BED_ID: false,
        SELECTED_BED: false,
        ACTIVE_OUT_PATIENT: {}
    },
    init: function(){
        $('.adm-menu').click(function(){
            Room.switchMenu(this);
        });

        //default page view
        Room.wardView();

        //Attach click on ward
        $('.ward').click(function(){
            Room.getWardAvailableBeds(this);
        });
        //
        $('#assignPatient').unbind('click').bind('click', function(){
            Room.assignPatient(this);
        });
        //IN-PATIENTS
        //$('#in-patient-form').on('submit', function(e){
        //    e.preventDefault();
        //    Room.getInPatients()
        //});
        //$('#log_encounter').on('submit', function(e){
        //    e.preventDefault();
        //    Room.logEncounter();
        //
        //});
        //$('#discharge_patient').unbind('click').bind('click', function(){
        //    Room.dischargePatient();
        //});

    },
    switchMenu : function(obj){
        $('.adm-menu').removeClass('active');
        $(obj).addClass('active');
        if($(obj).attr('data-view-id') == Room.CONSTANTS.IN_PATIENT_VIEW){
            Room.inPatientView();
        }else if($(obj).attr('data-view-id') == Room.CONSTANTS.OUT_PATIENT_VIEW){
            Room.wardView();
        }
    },
    wardView : function(){
        $('#in-patient-view').fadeOut('fast', function(){
            $('#ward-view').fadeIn('slow', function(){

            })
        });
        //hide content for in patient view
        $('#active_in_patient').addClass('hidden');
    },
    inPatientView : function(){
        $('#ward-view').fadeOut('fast', function(){
            $('#in-patient-view').fadeIn('slow', function(){

            })
        })  ;
    },
    requestList: function(){
        payload = {};
        payload.intent = 'getRoomRequests';
        $.getJSON(host + 'phase/phase_Room_request.php', payload, function(data){
            if(data.status == Room.CONSTANTS.REQUEST_SUCCESS){
                if(data.data === undefined){
                    console.log(data.message);
                    $('.pending-list').html("<h2 class='text-center text-muted'>" + data.message + "</h2>");
                }else{
                    content = "<ul class='patients-queue list-group'>";
                    data.data.forEach(function(record){
                        content += "<li class='list-group-item pointer patient patient-pill' data-regNum = '"+ record.regNo +"' data-patient-name = '" + record.patient + "' data-doctor-id = " + record.doctor_id +" data-patient-id = " + record.patient_id +" data-treatment-id = " + record.treatment_id + " data-Room-id = " + record.Room_req_id + " data-regNo = "+ record.regNo +">" +
                        record.patient + "<div class='small text-muted'>" + record.regNo +"</div></li>";
                    });
                    content += "</ul>";
                    $('.pending-list').html(content);
                    //attach click on patient
                    $('.patient').click(function(){
                        Room.attendToPatient(this)
                    });
                }
            }else if(data.status == Room.CONSTANTS.REQUEST_ERROR){
                console.log('Error in page');
            }
        });
    },
    attendToPatient: function(patient){
        if(!Room.GLOBAL.ACTIVE_PATIENT){
            Room.resetAction(Room.CONSTANTS.NOT_DONE_WITH_PATIENT);
            Room.deactivate = false;
            Room.GLOBAL.ACTIVE_PATIENT = patient;
            Room.GLOBAL.ACTIVE_PATIENT_ID = $(patient).attr('data-patient-id');
            Room.GLOBAL.ADMITTED_BY = $(patient).attr('data-doctor-id');
            Room.GLOBAL.Room_REQ_ID = $(patient).attr('data-Room-id');
            Room.GLOBAL.TREATMENT_ID = $(patient).attr('data-treatment-id');
            $('#empty_active').hide();
            $('#patient-panel').removeClass('hidden');
            content = "<h2 class='panel-title'>" + $(patient).attr('data-patient-name') +"</h2>";
            content += "<p>" + $(patient).attr('data-regNum') +"</p>";
            $('#request-heading').html(content);
        }
    },
    getWardAvailableBeds: function(ward){
        payload = {};
        payload.intent = "loadBeds";
        payload.ward_id = $(ward).attr("data-ward-id");
        $.getJSON(host + 'phase/phase_ward.php', payload, function(data){
            var button = "<button class='btn btn-sm btn-primary pull-right bed-add__action'><span class='fa fa-plus'>&nbsp;</span>Add Bed</button>" +
                "<div class='clearfix'></div>";
            var content  = "";
            if(data.status == Room.CONSTANTS.REQUEST_SUCCESS){
                //content = "<p class='small text-muted text-center'>select bed below</p>";
                //content = "<ol class='list-group'>";
                //data.data.forEach(function(record){
                //    content += "<li class='bed-item list-group-item pointer' data-ward-id = " + record.ward_id +" data-bed-id = "+ record.bed_id +">" + record.bed_description +"</li>"
                //});
                //content +="</ol>";
                //$('.room-bed-list').html(content);
                //$('.bed-item').click(function(){
                //    Room.selectAvailableBed(this);
                //});
                content = "<div class='room-bed-list-items'>";
                $(data.data).each(function () {
                    content += "<div class='col-xs-6 col-sm-4'><div class='room-bed-list-item'>" +
                    "<h3 class='room-bed-name text-primary pull-left'>"+ this.bed_description +"</h3>" +
                    "<p class='text-muted pull-right pointer bed-list-delete invisible'><span class='fa fa-remove fa-2x text-danger'>&nbsp;</span></p>" +
                    "<div class='clearfix'></div>" +
                    "<div class='bed-list-divider'></div>" +
                    "<p class='small text-muted'>Occupied by PMS002</p>" +
                    "</div></div>";
                });
                content += "</div>";
                //$('.room-bed-list').html("<div class='bed-list__empty'><h3 class='text-info text-center'>Bed available</h3></div>");
            }else if(data.status == Room.CONSTANTS.REQUEST_ERROR){
                //    temporary to show empty bed
                content = "<div class='bed-list__empty'><h3 class='text-info text-center'>" + data.message + "</h3></div>";
            }
                /*Display content*/
            $('.room-bed-list').html(button + content);
            /*
             * Adding actions*/
            $(".room-bed-list-item").hover(
                function() {
                    Room.showDeleteBedAction(this, true);
                },
                function () {
                    Room.showDeleteBedAction(this, false);
                }
            );

        });
        //make ward active
            $('li.ward').removeClass('list-group-item-success');
            $(ward).addClass('list-group-item-success');
        //if(!Room.deactivate){
        //    $('#step-1').addClass('active');
        //    $('#step-2').removeClass('active');
        //
        //    Room.resetAction(Room.CONSTANTS.NOT_DONE_WITH_PATIENT);
        //    payload = {};
        //    payload.intent = "loadBeds";
        //    payload.ward_id = $(ward).attr('data-ward-id');
        //
        //    $.getJSON(host + 'phase/phase_Room.php', payload, function(data){
        //        if(data.status == Room.CONSTANTS.REQUEST_SUCCESS){
        //            //content = "<p class='small text-muted text-center'>select bed below</p>";
        //            content = "<ol class='list-group'>";
        //            data.data.forEach(function(record){
        //                content += "<li class='bed-item list-group-item pointer' data-ward-id = " + record.ward_id +" data-bed-id = "+ record.bed_id +">" + record.bed_description +"</li>"
        //            });
        //            content +="</ol>";
        //            $('#bed-list').html(content);
        //            $('.bed-item').click(function(){
        //                Room.selectAvailableBed(this);
        //            });
        //        }else if(data.status == Room.CONSTANTS.REQUEST_ERROR){
        //            //    temporary to show empty bed
        //            $('#bed-list').html("<h3 class='text-muted text-center'>" + data.message + "</h3>");
        //        }
        //    });
        //    //make ward active
        //    $('li.ward').removeClass('list-group-item-success');
        //    $(ward).addClass('list-group-item-success');
        //    //make step 2 active
        //    //assign the ward details
        //    //Room.CONSTANTS.SELECTED_WARD_ID = $(ward).attr('data-ward-id');
        //    Room.GLOBAL.SELECTED_WARD = $(ward).html();
        //}
    },
    showDeleteBedAction: function(object, state){
        if(state){
            $(object).find(".bed-list-delete").removeClass("invisible");
        }else if(!state){
            $(object).find(".bed-list-delete").addClass("invisible");
        }
    },
    addBed: function(bed){
        payload = {};
        payload.ward_id = 1;
        payload.bed_description = 2;
        $.post(host + "phase/phase_ward.php", function (data) {
            console.log(data);
        })

    }
};

$(function(){
    Room.init();
});
