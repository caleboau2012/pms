/**
 * Created by user on 2/3/2015.
 */
/**
 * Created by user on 1/27/2015.
 */
var name;

$(document).ready(function(){
    init();
});

function init(){
    $.get(host + "phase/arrival/phase_patient.php?intent=getAllPatients", function(data){
        data = JSON.parse(data);

        var  html = "";
        for(var i = 0; i < data.data.length; i++){
            var obj = data.data[i];
            if(((obj.surname + " " + obj.firstname + " " + obj.middlename).trim() == "")
                || ((obj.surname + " " + obj.firstname + " " + obj.middlename).trim() == "null null null")){
                name = "[Incomplete Registration]";
            }
            else{
                name = obj.surname + " " + obj.firstname + " " + obj.middlename;
            }
            html += $('#tmplTable').html().replace('{{sn}}', (i + 1) )
                .replace("{{patientId}}", obj.regNo)
                .replace("{{name}}", name)
                .replace("{{dob}}", obj.birth_date)
                .replace("{{patient_id}}", obj.patient_id);
        }

        $("#patientsTable").html(html);
        makeTable();
    });
}

function printDetails(e){
    patientId = $(e).attr('patientId');
    prepareData(patientId);
}

function prepareData(patientID){
    $.get(host + "phase/arrival/phase_patient.php?intent=getPatient&patientId=" + patientID, function(data){
        data = JSON.parse(data);
        console.log(data.data);
        name = data.data.surname + " " +
            data.data.firstname + " " +
            data.data.middlename;

        var printHTML = $('#tmplPrint').html().replace('{{name}}', name)
            .replace('{{regNo}}', data.data.regNo)
            .replace('{{addy}}', data.data.home_address)
            .replace('{{phone}}', data.data.telephone)
            .replace('{{sex}}', data.data.sex)
            .replace('{{height}}', data.data.height)
            .replace('{{weight}}', data.data.weight)
            .replace('{{birth}}', data.data.birth_date);

        printElem("Patients Details", printHTML, null);
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
            family_position : form.family_position.value,
            mother_status : form.mother_status.value,
            father_status : form.father_status.value,
            marital_status : form.marital_status.value,
            no_of_children : form.no_of_children.value
        },
        function(data){
            data = JSON.parse(data);
            console.log(data);
            if(data.data){
                $('#newPatientModal').modal('hide');
                init();
            }
            else{
                alert('Sorry but something went wrong: ' + data.message)
            }
        }).fail(function(){
            console.log('shing');
        });

    return false;
}