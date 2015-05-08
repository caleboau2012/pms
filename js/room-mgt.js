/**
 * Created by olajuwon on 2/20/2015.
 */
Room = {
    CONSTANTS: {
        REQUEST_SUCCESS: 1,
        REQUEST_ERROR: 2
    },
    GLOBAL:{
        ROOM_MODAL : $('#room-modal')
    },
    init: function(){
        $('.adm-menu').click(function(){
            Room.switchMenu(this);
        });
        //default page view
        Room.wardView();
        Room.setupWardActions();

        //
        $('#assignPatient').unbind('click').bind('click', function(){
            Room.assignPatient(this);
        });
        /*ward action*/
        $("#new-ward-action").click(function () {
            Room.addWardForm();
        });
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
    getWardAvailableBeds: function(ward){
        if(ward) {
            payload = {};
            payload.intent = "loadBeds";
            payload.ward_id = $(ward).attr("data-ward-id");
            $.getJSON(host + 'phase/phase_ward.php', payload, function (data) {
                var ward_name = "<div class='col-sm-8'><h3 class='no-margin text-muted text-capitalize'>" + $(ward).attr("data-ward-name") + "</h3></div>";
                var button = "<div class='col-sm-4'><button class='btn btn-sm btn-primary pull-right bed-add__action' data-ward-id =" + $(ward).attr('data-ward-id') + "><span class='fa fa-plus'>&nbsp;</span>Add Bed</button>" +
                    "</div><div class='clearfix'></div><div class='bed-list-divider'></div>";
                var content = "";
                if (data.status == Room.CONSTANTS.REQUEST_SUCCESS) {
                    content = "<div class='room-bed-list-items'>";
                    $(data.data).each(function () {
                        content += "<div class='col-xs-6 col-sm-4'><div class='room-bed-list-item'>" +
                        "<h3 class='room-bed-name text-primary pull-left'>" + this.bed_description + "</h3>" +
                        "<p class='text-muted pull-right pointer bed-list-delete invisible' data-bed-id=" + this.bed_id + "><span class='fa fa-remove fa-2x text-danger'>&nbsp;</span></p>" +
                        "<div class='clearfix'></div>" +
                        "<div class='bed-list-divider'></div>" +
                        "<p class='small text-muted'>Occupied by PMS002</p>" +
                        "</div></div>";
                    });
                    content += "</div><div class='clearfix'></div>";
                } else if (data.status == Room.CONSTANTS.REQUEST_ERROR) {
                    //    temporary to show empty bed
                    content = "<div class='room-bed-list-items'>" +
                    "<div class='bed-list__empty'><h3 class='text-info text-center'>" + data.message + "</h3>" +
                    "</div></div>";
                }
                /*Display content*/
                $('.room-bed-list').html(ward_name + button + content);
                /*
                 * Adding actions*/
                Room.setupBedActions();

            });
            //make ward active
            $('li.ward').removeClass('list-group-item-success');
            $(ward).addClass('list-group-item-success');
        }
    },
    setupBedActions: function () {
        $(".room-bed-list-item").hover(
            function() {
                Room.showDeleteBedAction(this, true);
            },
            function () {
                Room.showDeleteBedAction(this, false);
            }
        );
        /*
         * Attach new bed form action*/
        $(".bed-add__action").click(function () {
            Room.addBedForm($(this));
        });
        /*
         * Delete bed action*/
        $(".bed-list-delete").click(function () {
            Room.deleteBed(this);
        });
    },
    setupWardActions: function () {
        $(".ward-item").hover(
            function() {
                Room.showDeleteWardAction(this, true);
            },
            function () {
                Room.showDeleteWardAction(this, false);
            }
        );
        $('.ward-list-name').click(function () {
                Room.getWardAvailableBeds($(this).parent());
            });
        /*
         * Delete ward action*/
        $(".ward-list-delete").click(function (e) {
            if(confirm("Are you sure you want to delete " + $(this).attr("data-ward-name"))){
                Room.deleteWard(this);
            }
            return false;
        });
    },
    showDeleteBedAction: function(object, state){
        if(state){
            $(object).find(".bed-list-delete").removeClass("invisible");
        }else if(!state){
            $(object).find(".bed-list-delete").addClass("invisible");
        }
    },
    showDeleteWardAction: function(object, state){
        if(state){
            $(object).find(".ward-list-delete").removeClass("invisible");
        }else if(!state){
            $(object).find(".ward-list-delete").addClass("invisible");
        }
    },
    addBedForm: function(bed_object){
        $(".modal-title").html("Add New Bed");
        $(".modal-body").html(
            "<p class='text-info'>Enter Bed description</p><form> " +
            "<input type='text' required class='form-control' id='bed_description' placeholder='Bed description'>" +
            "</form"
        );
        $(".modal-footer").html(
            "<span id='response-msg' class='text-danger'></span><img src='../images/loading.gif' id='is-loading' class='hidden'>" +
            "<button class='btn btn-primary btn-sm' id='bed-add-action'><span class='fa fa-plus'>&nbsp;</span>Add bed</button>"
        );
        Room.GLOBAL.ROOM_MODAL.modal("show");

        Room.GLOBAL.ROOM_MODAL.on("hidden.bs.modal", function (e) {
            //    reset Modal
        });

        /*Set action*/
        $("#bed-add-action").click(function () {
            if($("#bed_description").val() !== ""){
                Room.addBed(bed_object.attr("data-ward-id"), $("#bed_description").val());
            }
        });

    },
    addWardForm: function(){
        $(".modal-title").html("Add New Ward");
        $(".modal-body").html(
            "<p class='text-info'>Enter Ward description</p><form> " +
            "<input type='text' required class='form-control' id='ward_description' placeholder='Ward description'>" +
            "</form"
        );
        $(".modal-footer").html(
            "<span id='response-msg' class='text-danger'></span><img src='../images/loading.gif' id='is-loading' class='hidden'>" +
            "<button class='btn btn-primary btn-sm' id='ward-add-action'><span class='fa fa-plus'>&nbsp;</span>Add ward</button>"
        );
        Room.GLOBAL.ROOM_MODAL.modal("show");

        /*Set action*/
        $("#ward-add-action").click(function () {
            var ward_desc = $("#ward_description").val();
            if(ward_desc !== ""){
                Room.addWard(ward_desc);
            }
        });

    },
    addWard: function(ward){
        $("#is-loading").removeClass("hidden");
        payload = {};
        payload.intent = "newWard";
        payload.description = ward;
        $.post(host + "phase/phase_ward.php", payload, function (data) {
            if(data.status == Room.CONSTANTS.REQUEST_SUCCESS){
                /*
                 * Append new ward*/
                /*
                 * */
                var content = "<li class='list-group-item ward-item ward text-primary' data-ward-id="+ data.data.ward_ref_id +" data-ward-name='"+ ward +"'>" +
                    "<div class='pull-left ward-list-name'>" + ward +"</div>" +
                    "<p class='text-muted pull-right pointer ward-list-delete invisible' data-ward-name ='" + ward + "' data-ward-id = '"+ data.data.ward_ref_id +"'> <span class='fa fa-remove fa-2x text-danger'>&nbsp;</span></p>" +
                    "<div class='clearfix'></div></li>";
                if($(".ward-item").length == 0){
                    $('.ward-list-items').html(content);
                    Room.setupWardActions();
                }else{
                    $('.ward-list-items').append(content);
                    Room.setupWardActions();
                }
                Room.GLOBAL.ROOM_MODAL.modal("hide");
            }else if(data.status == Room.CONSTANTS.REQUEST_ERROR){
                $("#response-msg").html(data.message + "&nbsp;&nbsp;");
            }
            $("#is-loading").addClass("hidden");
        }, "json");
    },
    addBed: function(ward, bed){
        $("#is-loading").removeClass("hidden");
        payload = {};
        payload.intent = "newBed";
        payload.ward_id = ward;
        payload.bed_description = bed;
        $.post(host + "phase/phase_ward.php", payload, function (data) {
            if(data.status == Room.CONSTANTS.REQUEST_SUCCESS){
                /*
                 * Append new bed*/
                /*
                 * */
                var content = "<div class='col-xs-6 col-sm-4'><div class='room-bed-list-item'>" +
                    "<h3 class='room-bed-name text-primary pull-left'>"+ bed +"</h3>" +
                    "<p class='text-muted pull-right pointer bed-list-delete invisible' data-bed-id="+ data.data.bed_id +"><span class='fa fa-remove fa-2x text-danger'>&nbsp;</span></p>" +
                    "<div class='clearfix'></div>" +
                    "<div class='bed-list-divider'></div>" +
                    "<p class='small text-muted'>Occupied by None</p>" +
                    "</div></div>";
                if($(".room-bed-list-item").length == 0){
                    $('.room-bed-list-items').html(content);
                    Room.setupWardActions();
                }else{
                    $('.room-bed-list-items').append(content);
                    Room.setupWardActions();
                }
                Room.GLOBAL.ROOM_MODAL.modal("hide");
            }else if(data.status == Room.CONSTANTS.REQUEST_ERROR){
                $("#response-msg").html(data.message + "&nbsp;&nbsp;");
            }
            $("#is-loading").addClass("hidden");
        }, "json");

    },
    deleteWard: function(ward){

        payload = {};
        payload.intent = "deleteWard";
        payload.ward_ref_id = $(ward).attr("data-ward-id");
        $.post(host + "phase/phase_ward.php", payload, function (data) {
            if(data.status == Room.CONSTANTS.REQUEST_SUCCESS){
                $(".room-bed-list").html("<div class='bed-list__default-text'><h2 class='text-center text-muted'>Select ward from the left pane</h2></div>");
                $(ward).parent().remove();
            }
        }, "json");
    },
    deleteBed: function(bed){
        $(".ward-item").unbind("click");
        payload = {};
        payload.intent = "deleteBed";
        payload.bed_id = $(bed).attr("data-bed-id");
        $.post(host + "phase/phase_ward.php", payload, function (data) {
            if(data.status == Room.CONSTANTS.REQUEST_SUCCESS){
                $(bed).parent().parent().remove();
            }
        }, "json");
    }
};

$(function(){
    Room.init();
});
