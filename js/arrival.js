/**
 * Created by user on 2/8/2015.
 */
var patient;

$(document).ready(function(){
    init();
});

function init(){
    $.get((host + 'phase/arrival/phase_patient.php?intent=getRegNos'), function(data){
        if(data.status == 1){
            for(var i = 0; i < data.data.length; i++){
                $('#regNos').append("<option>" + data.data[i].regNo + "</option>");
            }
        }
    }, 'json');

    $('#search-form').on('submit', function(e){
        e.preventDefault();
    });

    $("input[name='search']").autocomplete({
        source : host + "phase/arrival/phase_patient_arrival.php?intent=search",
        minLength : 1,
        select : function(event, ui) {
            //$(this).attr("id", "user-" + ui.item.userid);
            $(this).val(ui.item.value);
            searchResult(ui.item);
            return false;
        },
        search: function( event, ui ) {
            /*start of search*/
            $("#search-empty-text").addClass('hidden');
            $("#search-loader").removeClass('hidden');
        },
        response: function( event, ui ) {
            if(ui.content.length == 0){
                $("#search-empty-text").removeClass('hidden');
            }else{
                $("#search-empty-text").addClass('hidden');
            }
            $("#search-loader").addClass('hidden');
        }
    }).autocomplete("instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
            .append( "<div class='panel-success'>" +
            "<div class='panel panel-heading' style='margin: 1px'>" +
            "<p class='panel-title'>" + toTitleCase(item.value) + "</p>" +
            "<p class='label label-info' style='margin-right: 10px;'> " + item.regNo + "</p>" +
            "<p class='label label-default'>" + item.sex + "</p>" +
            "</div>" +
            "</div>" )
            .appendTo( ul );
    };

    $('#verify').click(function(e){
        e.preventDefault();
        $('#verify-progress').removeClass('hidden');
        $.get((host + 'phase/arrival/phase_patient.php?intent=verifyRegNo&regNo=' + $('#regNo').val()), function(data){
            //console.log(data);
            $('#verify-progress').addClass('hidden');
            if(data.status == 2){
                showAlert(data.message);
            }
            else if(data.status == 1){
                showSuccess(data.data);
            }
        }, 'json').fail(function(e){
            //console.log(e.responseText);
        });
    });

    loadQueue();

    $.get((host + 'phase/arrival/phase_patient_arrival.php?intent=loadGenQueue'), function(data){
        data = JSON.parse(data);

        data = data.data;
        var patientHTML = "";

        if(data == null)
            return;

        for (var j = 0; j < data.length; j++) {
            if (data[j].regNo.substr(0, 4) == 'EMER'){
                panel = "panel-danger";
                patientName = data[j].regNo;
                sex = "";
            }
            else{
                panel = "panel-success";
                patientName = toTitleCase(data[j].surname) + " " + toTitleCase(data[j].firstname) + " " + toTitleCase(data[j].middlename);
                sex = data[j].sex;
            }
            patientHTML += $('#tmplPatients').html();
            patientHTML = patientHTML.replace('{{status}}', panel);
            patientHTML = replaceAll('{{userid}}', '0', patientHTML);
            patientHTML = replaceAll('{{patientid}}', data[j].patient_id, patientHTML);
            patientHTML = replaceAll('{{regNo}}', data[j].regNo, patientHTML);
            patientHTML = replaceAll('{{name}}', patientName, patientHTML);
            patientHTML = replaceAll('{{sex}}', sex, patientHTML);
        }

        $(".general").find('.drop').html(patientHTML);
        draggableDropabble();
    });
}

var limit;
function loadQueue(){
    $.get(host + "phase/arrival/phase_patient_arrival.php?intent=loadQueue", function(data){
        data = JSON.parse(data);

        limit = data.data.LMT;

        if(data.status == 1){
            data = data.data.queue;

            var name, obj, panel, patientName, regNo;

            $('#masonry').empty();
            for(var i = 0; i < data.length; i++) {
                var html;
                var doctorHTML = "";
                obj = data[i];

                if(obj.surname == null)
                    continue;

                name = toTitleCase(obj.surname) + " " + toTitleCase(obj.firstname) + " " + toTitleCase(obj.middlename);
                if (obj.online_status == '1')
                    panel = "panel-primary";
                else
                    panel = "panel-warning";

                doctorHTML += $('#tmplDoctor').html().replace('{{online_status}}', panel)
                    .replace("{{DoctorName}}", name);
                doctorHTML = replaceAll('{{userid}}', obj.userid, doctorHTML);

                var patientHTML = "";
                for (var j = 0; j < obj.queue.length; j++) {
                    if (obj.queue[j].regNo.substr(0, 4) == 'EMER') {
                        panel = "panel-danger";
                        patientName = obj.queue[j].regNo;
                        sex = "";
                    }
                    else {
                        panel = "panel-success";
                        patientName = toTitleCase(obj.queue[j].surname) + " " + toTitleCase(obj.queue[j].firstname) + " " + toTitleCase(obj.queue[j].middlename);
                        sex = obj.queue[j].sex;
                    }
                    patientHTML += $('#tmplPatients').html();
                    patientHTML = patientHTML.replace('{{status}}', panel);
                    patientHTML = replaceAll('{{userid}}', obj.userid, patientHTML);
                    patientHTML = replaceAll('{{patientid}}', obj.queue[j].patient_id, patientHTML);
                    patientHTML = replaceAll('{{regNo}}', obj.queue[j].regNo, patientHTML);
                    patientHTML = replaceAll('{{name}}', patientName, patientHTML);
                    patientHTML = replaceAll('{{sex}}', sex, patientHTML);

                }

                html = $.parseHTML(doctorHTML);
                //console.log($(html).find('.patients:first-child'));
                $(html).find('.drop').append(patientHTML);

                $('#masonry').append(html);
            }
            //$('#masonry').html(html);
            draggableDropabble();
            pollQueue();
        }
    });
}

function pollQueue(){
    setInterval(function(){
        $.getJSON(host + 'phase/arrival/phase_patient_arrival.php?intent=pollQueue', {
            LMT: limit
        }, function(data){
            //console.log({limit: limit, data: data});
            if(data.status == 1){
               loadQueue();
            }
        })
    }, 300000);
}

function draggableDropabble(){

    $('#masonry').masonry().masonry('reloadItems').masonry('layout');

    $('.patient').draggable({
        containment: 'body',
        cursor: 'move',
        snap: '.patients',
        helper: 'clone'
    });

    $('.doctor').droppable({
        drop: patientDrop
    });
}

function patientDrop(e, ui){
    var source = ui.draggable[0];
    var target = this;
    //console.log(target.innerHTML);

    var fromDoctor = ($(source).find('.doctorid').html());
    var patient = ($(source).find('.patientid').html());
    var toDoctor = ($(target).find('.to_doctor').html());

    console.log('Moving: ' + patient + ' From: ' + fromDoctor + ' To: ' + toDoctor)

    $(source).find('.doctorid').html(toDoctor);

    switchQueue(patient, fromDoctor, toDoctor);

    $(target).find('.drop').prepend(source);
    $('#masonry').masonry();
}

function addToQueue(patient){
    $.get((host + 'phase/arrival/phase_patient_arrival.php?intent=addToQueue&patient_id='
    + patient), function(data){
        //console.log('Adding to Gen Queue');
        //console.log(data);
    });
}

function removeFromQueue(patient){
    $.get((host + 'phase/arrival/phase_patient_arrival.php?intent=removeFromQueue&patient_id=' + patient.find('.patientid').html()), function(data){
        console.log(data);
        patient.remove();
    });
}

function switchQueue(patient, fromDoctor, toDoctor){
    $.get((host + 'phase/arrival/phase_patient_arrival.php?intent=switchQueue&patient_id='
    + patient + '&to_doctor=' + toDoctor + '&from_doctor=' + fromDoctor), function(data){
        //console.log('Switching Queues');
        //console.log(data);
    });
}

$("#newPatientForm").on('submit', function(e){
    e.preventDefault();
    addPatient(this);
});

$("#naija").on('change', function () {
   $('.non-naija').toggle();
});

function addPatient(form){
    var citizenship = $('#naija').is(':checked')?"Nigeria":form.citizenship;
    //console.log(citizenship);
    $('#loader').removeClass('hidden');

    $.get((host + 'phase/arrival/phase_patient.php?intent=verifyRegNo&regNo=' + $('#regNo').val()), function(data){
        $('#loader').addClass('hidden');
        if(data.status == 2){
            showAlert(data.message);
        }
        else{
            $.post(host + "phase/arrival/phase_patient.php?intent=addPatient",
                {
                    surname : form.surname.value,
                    firstname : form.firstname.value,
                    middlename : form.middlename.value,
                    regNo : form.regNo.value,
                    occupation: form.occupation.value,
                    home_address : form.home_address.value,
                    telephone : form.telephone.value,
                    sex : form.sex.value,
                    height : form.height.value,
                    weight : form.weight.value,
                    birth_date : form.birth_date.value,
                    nok_firstname : form.nok_firstname.value,
                    nok_middlename : form.nok_middlename.value,
                    nok_surname : form.nok_surname.value,
                    nok_address : form.nok_address.value,
                    nok_telephone : form.nok_telephone.value,
                    nok_relationship  : form.nok_relationship.value,
                    citizenship : citizenship,
                    religion : form.religion.value,
                    marital_status : form.marital_status.value,
                    registration_date : form.registration_date.value,
                    hmo : form.hmo.value,
                    allergies : form.allergies.value,
                    medical_history : form.medical_history.value,
                    alcohol_usage : form.alcohol_usage.value,
                    tobacco_usage : form.tobacco_usage.value,
                    surgical_history : form.surgical_history.value,
                    family_history : form.family_history.value
                },
                function(data){
                   // console.log(data);
                    data = JSON.parse(data);
                    //console.log(data);

                    var patientHTML = "";
                    patientName = toTitleCase(form.surname.value) + " " + toTitleCase(form.firstname.value) + " " + toTitleCase(form.middlename.value);
                    patientHTML += $('#tmplPatients').html();
                    patientHTML = patientHTML.replace('{{status}}', 'panel-success');
                    patientHTML = replaceAll('{{userid}}', '0', patientHTML);
                    patientHTML = replaceAll('{{patientid}}', data.data, patientHTML);
                    patientHTML = replaceAll('{{regNo}}', form.regNo.value, patientHTML);
                    patientHTML = replaceAll('{{name}}', patientName, patientHTML);
                    patientHTML = replaceAll('{{sex}}', form.sex.value, patientHTML);
                    addToQueue(data.data);

                    $(".general").find('.drop').prepend(patientHTML);
                    $('#newPatientModal').modal('hide');
                    draggableDropabble();

                }).fail(function(r){
                    console.log(r);
                    //console.log('shing');
                });
        }
    }, 'json').fail(function(e){
        //console.log(e.responseText);
    });

    return false;
}

function emergency(){
    var id;

    $.post(host + "phase/arrival/phase_patient.php?intent=addEmergencyPatient",
        function(data){
            if(data.status == 1){
                data = data.data;

                id = data.patient_id;

                var patientHTML = "";
                //patientName = toTitleCase(form.surname.value) + " " + toTitleCase(form.firstname.value) + " " + toTitleCase(form.middlename.value);
                patientHTML += $('#tmplPatients').html();
                patientHTML = patientHTML.replace('{{status}}', 'panel-danger');
                patientHTML = replaceAll('{{userid}}', '0', patientHTML);
                patientHTML = replaceAll('{{patientid}}', id, patientHTML);
                patientHTML = replaceAll('{{regNo}}', data.regNo, patientHTML);
                patientHTML = replaceAll('{{name}}', data.regNo, patientHTML);
                patientHTML = replaceAll('{{sex}}', '', patientHTML);
                addToQueue(id);

                $(".general").find('.drop').prepend(patientHTML);
                draggableDropabble();
            }
        }, 'json');
}

function searchResult(patientDetails){
    console.log(patientDetails);
    var patientHTML = "";
    //patientName = toTitleCase(form.surname.value) + " " + toTitleCase(form.firstname.value) + " " + toTitleCase(form.middlename.value);
    patientHTML += $('#tmplPatients').html();
    patientHTML = patientHTML.replace('{{status}}', 'panel-success');
    patientHTML = replaceAll('{{userid}}', '0', patientHTML);
    patientHTML = replaceAll('{{patientid}}', patientDetails.patient_id, patientHTML);
    patientHTML = replaceAll('{{regNo}}', patientDetails.regNo, patientHTML);
    patientHTML = replaceAll('{{name}}', patientDetails.value, patientHTML);
    patientHTML = replaceAll('{{sex}}', patientDetails.sex, patientHTML);
    addToQueue(patientDetails.patient_id);

    $(".general").find('.drop').prepend(patientHTML);
    draggableDropabble();
}

$('body').delegate('.remove-patient .fa', 'click', function(e){
    $patient = $(this).parent().parent().parent().parent();
    removeFromQueue($patient);
});

function openVitalsModal(e){
    document.vitalsForm.reset();
    //console.log($(e).parent().children());
    var data = $(e).parent().children();
    $('#patientName').text($(data[0]).text());
    $('#patientRegNo').text($(data[2]).text());
    document.vitalsForm.patient_id.value =  $(data[3]).text();
    $('#vitalsModal').modal('show');
}

$(document.vitalsForm).on('submit', function(e){

    e.preventDefault();
    var data = {};
    data.intent = "addVitals";
    data.patient_id = this.patient_id.value;
    data.vitals = {};

    data.vitals.temp = this.temp.value;
    data.vitals.pulse = this.pulse.value;
    data.vitals.respiratory_rate = this.respiratory_rate.value;
    data.vitals.blood_pressure = this.blood_pressure.value;
    data.vitals.height = this.height.value;
    data.vitals.weight = this.weight.value;
    data.vitals.bmi = this.bmi.value;
    data.vitals.var = this.var.value;
    data.vitals.val = this.val.value;

    $('#loading').removeClass('hidden');

    $.post(host + 'phase/phase_vitals.php', data, function(data){
        //console.log(data);
        if(data.status == 1){
            showSuccess(data.message);
            document.vitalsForm.reset();
        }else{
            showAlert(data.message);
        }
        $('#loading').addClass('hidden');
    }, 'json').fail(function(data){
        $('#loading').addClass('hidden');
        //$('#response').text(data.responseText).removeClass('hidden');
        //console.log(data.responseText);
    });
});