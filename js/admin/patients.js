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
    $.get(host + "phase/phase_patient.php?intent=getAllPatients", function(data){
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
    $.get(host + "phase/phase_patient.php?intent=getPatient&patientId=" + patientID, function(data){
        data = JSON.parse(data);
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

        printElem(printHTML);
    });
}