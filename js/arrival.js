/**
 * Created by user on 2/8/2015.
 */
var patient;

$(document).ready(function(){
    init();
});

function init(){

    $('#search-form').on('submit', function(e){
        e.preventDefault();
    })

    $("input[name='search']").autocomplete({
        source : host + "phase/arrival/phase_patient_arrival.php?intent=search",
        minLength : 3,
        select : function(event, ui) {
            //$(this).attr("id", "user-" + ui.item.userid);
            $(this).val(ui.item.value);
            searchResult(ui.item);
            return false;
        }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        //console.log(item);
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

    $.get(host + "phase/arrival/phase_patient_arrival.php?intent=loadQueue", function(data){
        data = JSON.parse(data);

        if(data.status == 1){
            data = data.data.queue;

            var name, obj, panel, patientName, regNo;

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
                    if (obj.queue[j].regNo == 'EMER') {
                        panel = "panel-danger";
                        patientName = toTitleCase(obj.queue[j].surname) + obj.queue[j].patient_id;
                        regNo = (obj.queue[j].surname).toUpperCase() + obj.queue[j].patient_id;
                    }
                    else {
                        panel = "panel-success";
                        patientName = toTitleCase(obj.queue[j].surname) + " " + toTitleCase(obj.queue[j].firstname) + " " + toTitleCase(obj.queue[j].middlename);
                        regNo = obj.queue[j].regNo;
                    }
                    patientHTML += $('#tmplPatients').html();
                    patientHTML = patientHTML.replace('{{status}}', panel);
                    patientHTML = replaceAll('{{userid}}', obj.userid, patientHTML);
                    patientHTML = replaceAll('{{patientid}}', obj.queue[j].patient_id, patientHTML);
                    patientHTML = replaceAll('{{regNo}}', regNo, patientHTML);
                    patientHTML = replaceAll('{{name}}', patientName, patientHTML);
                    patientHTML = replaceAll('{{sex}}', obj.queue[j].sex, patientHTML);

                }

                html = $.parseHTML(doctorHTML);
                //console.log($(html).find('.patients:first-child'));
                $(html).find('.drop').append(patientHTML);

                $('#masonry').append(html);
            }
            //$('#masonry').html(html);
            draggableDropabble();
        }
    });

    $.get((host + 'phase/arrival/phase_patient_arrival.php?intent=loadGenQueue'), function(data){
        data = JSON.parse(data);

        data = data.data;
        var patientHTML = "";

        if(data == null)
            return;

        for (var j = 0; j < data.length; j++) {
            if (data[j].regNo == 'EMER')
                panel = "panel-danger";
            else
                panel = "panel-success";
            patientName = toTitleCase(data[j].surname) + " " + toTitleCase(data[j].firstname) + " " + toTitleCase(data[j].middlename);
            patientHTML += $('#tmplPatients').html();
            patientHTML = patientHTML.replace('{{status}}', panel);
            patientHTML = replaceAll('{{userid}}', '0', patientHTML);
            patientHTML = replaceAll('{{patientid}}', data[j].patient_id, patientHTML);
            patientHTML = replaceAll('{{regNo}}', data[j].regNo + data[j].patient_id, patientHTML);
            patientHTML = replaceAll('{{name}}', patientName + data[j].patient_id, patientHTML);
            patientHTML = replaceAll('{{sex}}', data[j].sex, patientHTML);
        }

        $(".general").find('.drop').html(patientHTML);
        draggableDropabble();
    });
}

function draggableDropabble(){
    $('#masonry').masonry();

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

    //if((toDoctor == '') && (fromDoctor))
    //    console.log('Moving ' + patient + ' from ' + fromDoctor + ' to ' + toDoctor);
    //else if(fromDoctor)
    //    console.log('switching');
    //else if(toDoctor == '')
    //    console.log('adding to gen queue');
    //    //addToGenQueue(patient);

    switchQueue(patient, fromDoctor, toDoctor);

    $(target).find('.drop').prepend(source);
    $('#masonry').masonry();
}

function addToQueue(patient){
    $.get((host + 'phase/arrival/phase_patient_arrival.php?intent=addToQueue&patient_id='
    + patient), function(data){
        console.log('Adding to Gen Queue');
        console.log(data);
    });
}

//function addToGenQueue(patient){
//    $.get((host + 'phase/arrival/phase_patient_arrival.php?intent=addToGeneralQueue&patient_id=' + patient), function(data){
//        //console.log('Adding to Gen Queue');
//        //console.log(data);
//    });
//}

//function addToDoctor(patient, doctor){
//    //console.log(patient, doctor);
//
//    $.get((host + 'phase/arrival/phase_patient_arrival.php?intent=addToDoctor&patient_id=' + patient + '&doctor_id=' + doctor), function(data){
//        //console.log('Adding to Doctor Queue');
//        //console.log(data);
//    });
//}
//
//function returnToGenQueue(patient){
//    $.get((host + 'phase/arrival/phase_patient_arrival.php?intent=returnToGenQueue&patient_id=' + patient), function(data){
//        //console.log('Returning to Gen Queue');
//        //console.log(data);
//    });
//}

function removeFromQueue(patient){
    $.get((host + 'phase/arrival/phase_patient_arrival.php?intent=removeFromQueue&patient_id=' + patient), function(data){
        //console.log(data);
    });
}

function switchQueue(patient, fromDoctor, toDoctor){
    $.get((host + 'phase/arrival/phase_patient_arrival.php?intent=switchQueue&patient_id='
    + patient + '&to_doctor=' + toDoctor + '&from_doctor=' + fromDoctor), function(data){
        console.log('Switching Queues');
        console.log(data);
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

    $.post(host + "phase/arrival/phase_patient.php?intent=addPatient",
        {
            surname : form.surname.value,
            firstname : form.firstname.value,
            middlename : form.middlename.value,
            regNo : form.regNo.value,
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
            family_position : form.family_position.value,
            mother_status : form.mother_status.value,
            father_status : form.father_status.value,
            marital_status : form.marital_status.value,
            no_of_children : form.no_of_children.value
        },
    function(data){
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
        addToGenQueue(data.data);

        $(".general").find('.drop').prepend(patientHTML);
        $('#newPatientModal').modal('hide');
        draggableDropabble();

    }).fail(function(){
            console.log('shing');
        });

    return false;
}

function emergency(){
    var id;

    $.post(host + "phase/arrival/phase_patient.php?intent=addPatient",
        {
            surname : 'EMER',
            firstname : 'EMER',
            middlename : 'EMER',
            regNo : 'EMER',
            home_address : 'EMER',
            telephone : 'EMER',
            sex : 'Emer',
            height : '0',
            weight : '0',
            birth_date : '0000-00-00',
            nok_firstname : 'EMER',
            nok_middlename : 'EMER',
            nok_surname : 'EMER',
            nok_address : 'EMER',
            nok_telephone : 'EMER',
            nok_relationship  : 9,
            citizenship : 'EMER',
            religion : 'EMER',
            family_position : 0,
            mother_status : 'EMER',
            father_status : 'EMER',
            marital_status : 'EMER',
            no_of_children : 0
        },
        function(data){
            //console.log(data);
            data = JSON.parse(data);
            //console.log(data);
            id = data.data;

            var patientHTML = "";
            //patientName = toTitleCase(form.surname.value) + " " + toTitleCase(form.firstname.value) + " " + toTitleCase(form.middlename.value);
            patientHTML += $('#tmplPatients').html();
            patientHTML = patientHTML.replace('{{status}}', 'panel-danger');
            patientHTML = replaceAll('{{userid}}', '0', patientHTML);
            patientHTML = replaceAll('{{patientid}}', id, patientHTML);
            patientHTML = replaceAll('{{regNo}}', 'EMER' + id, patientHTML);
            patientHTML = replaceAll('{{name}}', 'EMER' + id, patientHTML);
            patientHTML = replaceAll('{{sex}}', '', patientHTML);
            addToQueue(id);

            $(".general").find('.drop').prepend(patientHTML);
            draggableDropabble();
        });
}

function searchResult(patientDetails){
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

//function randomID(){
//    return Math.floor((Math.random() * 1000));
//}