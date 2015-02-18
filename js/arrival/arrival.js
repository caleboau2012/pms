/**
 * Created by user on 2/8/2015.
 */
var patient;

$(document).ready(function(){
    init();
});

function init(){
    $.get(host + "phase/arrival/phase_patient_arrival.php?intent=loadQueue", function(data){
        data = JSON.parse(data);

        if(data.status == 1){
            data = data.data.queue;

            var name, obj, panel, patientName;

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
                    .replace("{{userid}}", obj.userid)
                    .replace("{{DoctorName}}", name);

                var patientHTML = "";
                for (var j = 0; j < obj.queue.length; j++) {
                    patientName = toTitleCase(obj.queue[j].surname) + " " + toTitleCase(obj.queue[j].firstname) + " " + toTitleCase(obj.queue[j].middlename);
                    patientHTML += $('#tmplPatients').html();
                    patientHTML = replaceAll('{{userid}}', obj.userid, patientHTML);
                    patientHTML = replaceAll('{{patientid}}', obj.queue[j].patient_id, patientHTML);
                    patientHTML = replaceAll('{{regNo}}', obj.queue[j].regNo, patientHTML);
                    patientHTML = replaceAll('{{name}}', patientName, patientHTML);
                    patientHTML = replaceAll('{{sex}}', obj.queue[j].sex, patientHTML);



                    //patientHTML += $('#tmplPatients').html().replace('{{userid}}', obj.userid)
                    //    .replace('{{patientid}}', obj.queue[j].patient_id)
                    //    .replace('{{regNo}}', obj.queue[j].regNo)
                    //    .replace('{{name}}', patientName)
                    //    .replace('{{sex}}', obj.queue[j].sex);
                }
                //console.log(patientHTML);

                html = $.parseHTML(doctorHTML);
                $(html).find('.patients').first().append(patientHTML);

                $('#masonry').append(html);
            }
            //$('#masonry').html(html);
            draggableDropabble();
        }
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

//function getDraggedPatient(e, ui){
//    patient = verifyEvent(e);
//
//    //console.log($(data).html());
//}
//
//function verifyEvent(e){
//    if (!e)
//        var e = window.event;
//    if (e.target)
//        data = e.target;
//    else if(e.srcElement)
//        data = e.srcElement;
//
//    return data;
//}

function patientDrop(e, ui){
    var source = ui.draggable[0];
    var target = this;

    $(target).find('.drop').prepend(source);
    $('#masonry').masonry();
}

function toTitleCase(str) {
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

function replaceAll(find, replace, str) {
    return str.replace(new RegExp(find, 'g'), replace);
}

$("#newPatientForm").on('submit', function(e){
    e.preventDefault();

    addPatient(this);
});

//$("#naija").on('change', function () {
//   $('.non-naija').toggle();
//});

function addPatient(form){

    var citizenship = $('#naija').is(':checked')?"Nigeria":form.citizenship;
    console.log(citizenship);

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
        //data = JSON.parse(data);
        console.log(data);
    }).fail(function(){
            console.log('shing');
        });

    return false;
}