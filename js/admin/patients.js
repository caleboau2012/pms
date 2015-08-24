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
    $.get((host + 'phase/arrival/phase_patient.php?intent=getRegNos'), function(data){
        if(data.status == 1){
            for(var i = 0; i < data.data.length; i++){
                $('#regNos').append("<option>" + data.data[i].regNo + "</option>");
            }
        }
    }, 'json');

    $('.verify').click(function(e){
        e.preventDefault();
        console.log($('.regNo'));
        $.get((host + 'phase/arrival/phase_patient.php?intent=verifyRegNo&regNo=' + $(this).parent().find('.regNo').val()), function(data){
            console.log(data);
            if(data.status == 2){
                showAlert(data.message);
            }
            else if(data.status == 1){
                showSuccess(data.data);
            }
        }, 'json').fail(function(e){
            console.log(e.responseText);
        });
    });

    $(".naija").on('change', function () {
        $('.non-naija').toggle();
    });

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
                .replace("{{regNo}}", obj.regNo)
                .replace("{{name}}", name)
                .replace("{{dob}}", obj.birth_date)
                .replace("{{patient_id}}", obj.patient_id)
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

$(".naija").on('change', function () {
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

function manage(id){
    var form = document.managePatientForm;
    $.getJSON(host + "phase/arrival/phase_patient.php?intent=getPatient&patientId=" + $(id).attr('patientid'), function(data){
        console.log(data);
        if(data.status == 1){
            data = data.data;
            form.patient_id.value = data.patient_id;
            form.surname.value = data.surname;
            form.firstname.value = data.firstname;
            form.middlename.value = data.middlename;
            form.regNo.value = data.regNo;
            form.occupation.value = data.occupation;
            form.home_address.value = data.home_address;
            form.telephone.value = data.telephone;
            form.sex.value = data.sex;
            form.birth_date.value = data.birth_date;
            form.height.value = data.height;
            form.weight.value = data.weight;
            form.nok_surname.value = data.nok_surname;
            form.nok_firstname.value = data.nok_firstname;
            form.nok_middlename.value = data.nok_middlename;
            form.nok_address.value = data.nok_address;
            form.nok_telephone.value = data.nok_telephone;
            form.nok_relationship.value = data.nok_relationship;
            form.citizenship.value = data.citizenship;
            form.religion.value = data.religion;
            form.family_position.value = data.family_position;
            form.mother_status.value = data.mother_status;
            form.father_status.value = data.father_status;
            form.marital_status.value = data.marital_status;

            $('#managePatientModal').modal({
                backdrop: 'static'
            }).modal('show').on('hidden.bs.modal', function (e) {
                form.reset();
            });
        }
    });

    $(form).on('submit', function(e){
        e.preventDefault();
        $.post(host + "phase/arrival/phase_patient.php?intent=ManagePatient",
            {
                patient_id: form.patient_id.value,
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
                citizenship : form.citizenship.value,
                religion : form.religion.value,
                family_position : form.family_position.value,
                mother_status : form.mother_status.value,
                father_status : form.father_status.value,
                marital_status : form.marital_status.value,
                no_of_children : form.no_of_children.value
            },
            function(data){
                console.log(data);
                showSuccess(data.message);
            }, 'json').fail(function(){
                console.log('shing');
            });
    });
}