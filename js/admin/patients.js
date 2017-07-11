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

        var nok_name = data.data.nok_surname + " " +
            data.data.nok_firstname + " " +
            data.data.nok_middlename;

        var relationship = [
            "None",
            "Father",
            "Mother",
            "Son",
            "Daughter",
            "Brother",
            "Sister",
            "Husband",
            "Wife",
            "Other"
        ];

        var printHTML = $('#tmplPrint').html().replace('{{name}}', name)
            .replace('{{regNo}}', data.data.regNo)
            .replace('{{occupation}}', data.data.occupation)
            .replace('{{addy}}', data.data.home_address)
            .replace('{{phone}}', data.data.telephone)
            .replace('{{sex}}', data.data.sex)
            .replace('{{height}}', data.data.height)
            .replace('{{weight}}', data.data.weight)
            .replace('{{birth}}', data.data.birth_date)
            .replace('{{nok_name}}', nok_name)
            .replace('{{nok_address}}', data.data.nok_address)
            .replace('{{nok_telephone}}', data.data.nok_telephone)
            .replace('{{nok_relationship}}', relationship[data.data.nok_relationship])
            .replace('{{citizenship}}', data.data.citizenship)
            .replace('{{religion}}', data.data.religion)
            .replace('{{family_position}}', data.data.family_position)
            .replace('{{mother_status}}', data.data.mother_status)
            .replace('{{father_status}}', data.data.father_status)
            .replace('{{marital_status}}', data.data.marital_status)
            .replace('{{no_of_children}}', data.data.no_of_children);

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
            console.log(data);
            data = JSON.parse(data);
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
            form.hmo.value = data.hmo;
            form.registration_date.value = data.registration_date;
            form.allergies.value = data.allergies;
            form.medical_history.value = data.medical_history;
            form.alcohol_usage.value = data.alcohol_usage;
            form.tobacco_usage.value = data.tobacco_usage;
            form.surgical_history.value = data.surgical_history;
            form.family_history.value = data.family_history;
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
                console.log(data);
                if(data.status == 2){
                    showAlert(data.message);
                }else{
                    $('#managePatientModal').modal('hide');
                    init();
                }

            }, 'json').fail(function(data){
                showAlert(data.message);
                console.log('shing');
            });
    });
}