/**
 * Created by user on 2/27/2015.
 */
Treatment = {
    CONSTANTS: {
        doctorid: $('#doctorid').html(),
        treatmentid: null
    },
    init: function(){
        $('body').delegate('.patient', 'click', function(e){
            console.log(this);
            Treatment.startTreatment(this);
        });

        $(document.addTreatmentForm).on('submit', function(e){
            e.preventDefault();
            Treatment.submitTreatment(this);
        });

        $(document.requestTestForm).on('submit', function(e){
            e.preventDefault();
            Treatment.requestTest(this);
        });

        $('.th').click(function(){
            Treatment.getTreatmentHistory();
        });

        Treatment.getPatientQueue();
        $('.well').addClass('hidden');
    },
    getPatientQueue: function(){
        var url = host + "phase/phase_treatment.php?intent=getPatientQueue&doctorid=" + Treatment.CONSTANTS.doctorid;
        $.getJSON(url, function(data){
            data = data.data;
            //console.log(data);

            for(i = 0; i < data.length; i++){
                var currentYear = new Date().getFullYear();
                var age = currentYear - parseInt(data[i].birth_date.split('-')[0]);
                console.log(age);

                var patientHTML = "";
                patientName = toTitleCase(data[i].surname) + " " + toTitleCase(data[i].firstname) + " " + toTitleCase(data[i].middlename);
                patientHTML += $('#tmplPatients').html();
                patientHTML = patientHTML.replace('{{status}}', 'panel-success');
                patientHTML = replaceAll('{{userid}}', Treatment.CONSTANTS.doctorid, patientHTML);
                patientHTML = replaceAll('{{patientid}}', data[i].patient_id, patientHTML);
                patientHTML = replaceAll('{{regNo}}', data[i].regNo, patientHTML);
                patientHTML = replaceAll('{{name}}', patientName, patientHTML);
                patientHTML = replaceAll('{{sex}}', data[i].sex, patientHTML);
                patientHTML = replaceAll('{{Age}}', age, patientHTML);

                $('.patients').append(patientHTML);
            }
        });
    },
    startTreatment: function(patient){
        var url = host + "phase/phase_treatment.php?intent=startTreatment&doctor_id=" + Treatment.CONSTANTS.doctorid
            + "&patient_id=" + $(patient).find('.patientid').html();
        $.getJSON(url, function (data) {
            console.log(data);
            $('.treatment-ID').html(data.data);
            Treatment.CONSTANTS.treatmentid = $('.treatment-ID').html();
            $('.patient-name').html($(patient).find('.patientName').html());
            $('.patient-RegNo').html($(patient).find('.patientRegNo').html());
            $('.patient-Sex').html($(patient).find('.patientSex').html());
            $('.patient-Age').html($(patient).find('.patientAge').html());
            $('.patient-ID').html($(patient).find('.patientid').html());
        });
        patient.remove();
        $('.well').removeClass('hidden');
    },
    submitTreatment: function(data){
        var url = host + "phase/phase_treatment.php";
        $.post(url, {
            intent: "submitTreatment",
            treatment_id: Treatment.CONSTANTS.treatmentid,
            doctor_id: Treatment.CONSTANTS.doctorid,
            patient_id: $('.patient-ID').html(),
            symptoms: data.symptoms.value,
            consultation: data.consultation.value,
            comments: data.comment.value,
            diagnosis: data.diagnosis.value
        }, function(data){
            console.log(data);
        })
    },
    getTreatmentHistory: function() {
        var url = host + "phase/phase_treatment.php?intent=getTreatmentHistory&patient_id=" + $('.patient-ID').html();
        $.getJSON(url, function (data) {
            data = data.data;
            for(i = 0; i < data.length; i++){
                var patientHTML = "";
                patientHTML += $('#tmplTreatmentHistory').html();
                patientHTML = replaceAll('{{userid}}', Treatment.CONSTANTS.doctorid, patientHTML);
                patientHTML = replaceAll('{{treatmentid}}', data[i].treatment_id, patientHTML);
                patientHTML = replaceAll('{{comments}}', data[i].comments, patientHTML);
                patientHTML = replaceAll('{{consultation}}', patientName, patientHTML);
                patientHTML = replaceAll('{{diagnosis}}', data[i].diagnosis, patientHTML);
                patientHTML = replaceAll('{{doctorid}}', data[i].doctor_id, patientHTML);
                patientHTML = replaceAll('{{symptoms}}', data[i].symptoms, patientHTML);
                $('.history').append(patientHTML);
            }
        });
    },
    requestTest: function(form){
        var url = host + "phase/phase_treatment.php";
        $.post(url, {
            intent: "requestLabTest",
            doctor_id: Treatment.CONSTANTS.doctorid,
            patient_id: $('.patient-ID').html(),
            treatment_id: Treatment.CONSTANTS.treatmentid,
            comments: form.deescription.value,
            test_id: form.test_id.value
        }, function(data){
            console.log(data);
        })
    }
};

function switchTabs(tab, t){
    $('.add-treatment').addClass('hidden');
    $('.request-test').addClass('hidden');
    $('.treatment-history').addClass('hidden');
    $('.lab-history').addClass('hidden');
    $('.' + tab).removeClass('hidden');
    $('.at').removeClass('active');
    $('.rt').removeClass('active');
    $('.th').removeClass('active');
    $('.lh').removeClass('active');
    $('.' + t).addClass('active');
}

$(function(){
    Treatment.init();
});