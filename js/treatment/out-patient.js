/**
 * Created by user on 2/27/2015.
 */
var labTable;
Treatment = {
    CONSTANTS: {
        doctorid: $('#doctorid').html(),
        treatmentid: null
    },
    Global: {
        Lab_Table: null
    },
    init: function(){
        $('.navbar-form').on('submit', function(e){
            e.preventDefault();
        });

        $("input[name='search']").autocomplete({
            source : host + "phase/arrival/phase_patient_arrival.php?intent=search",
            minLength : 1,
            select : function(event, ui) {
                //$(this).attr("id", "user-" + ui.item.userid);
                $(this).val(ui.item.value);
                Treatment.searchResult(ui.item);
                return false;
            },
            search: function( event, ui ) {;
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
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
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

        $('body').delegate('.patient', 'click', function(e){
            $('.patient').removeClass('panel-warning').addClass('panel-success');
            $(this).removeClass('panel-success').addClass('panel-warning');
            Treatment.startTreatment(this);
        });

        $(document.addTreatmentForm).on('submit', function(e){
            e.preventDefault();
            Treatment.submitTreatment(this);
        });

        $('#end').popover({
            content: "This will terminate the treatment session with the patient permanently",
            trigger: "hover",
            title: "What is this?",
            placement: "bottom"
        }).click(function(e){
            var empty = true;
            $(".treatment-form .form-control").each(function(){
                if(this.value.trim() != ""){
                    empty = false;
                }
            });
            if(empty){
                if(confirm("Are you sure you want to do this? It cannot be undone.")){
                    Treatment.endTreatment();
                }
            }
            else{
                alert("You have not completed the treatment for this patient");
            }
        });

        $('#end-incomplete').popover({
            content: "This will suspend the treatment session with the patient",
            trigger: "hover",
            title: "What is this?",
            placement: "bottom"
        }).click(function(e){
            if(confirm("Are you sure you want to do this?")){
                Treatment.removeFromQueue($('.patient-ID').html());
            }
        });

        $(document.requestTestForm).on('submit', function(e){
            e.preventDefault();

            Treatment.requestTest(this);
        });

        $('.th').click(function(){
            Treatment.getTreatmentHistory();
        });

        $('.lh').click(function(){
            Treatment.getLabHistory();
        });

        $('.vi').click(function(){
            Treatment.getVitals();
        });

        $('#type').change(function(e){
            Treatment.getLabHistory();
        });

        Treatment.getPatientQueue();
        $('.well').addClass('hidden');

        $('#prescriptionInput').keydown(function(e){
            if(e.keyCode == 13) {
                e.preventDefault();
                Treatment.addPrescription(this.value);
                this.value = '';
            }
        });

        $('body').delegate('#prescriptions .close', 'click', function(e){
            $(this).parent().remove();
        });

        $('body').delegate('.treatment-history-template', 'click', function(e){
            e.preventDefault();
            //console.log([e, this]);
            Treatment.getEncounterHistory($(this).parent().find('.treatmentid').html());
        });

    },
    addPrescription: function(drug){
        var drugHTML = "";
        drugHTML = "<li class='list-group-item'>" + drug +
            "<button type='button' class='close' aria-label='Close'><span aria-hidden='true'>&times;</span></button></li>";
        $('#prescriptions').append(drugHTML);
    },
    searchResult: function(patientDetails){
        Treatment.addToQueue(patientDetails.patient_id);
        $('.patients').empty();
        Treatment.getPatientQueue();
    },
    addToQueue: function (patient){
        $.get((host + 'phase/arrival/phase_patient_arrival.php?intent=addToQueue&patient_id='
        + patient + "&doctor_id=" + Treatment.CONSTANTS.doctorid), function(data){
            console.log(data);
        });
    },
    getPatientQueue: function(){
        var url = host + "phase/arrival/phase_patient_arrival.php?intent=loadDoctorQueue&doctorid=" + Treatment.CONSTANTS.doctorid;
        $.getJSON(url, function(data){
            data = data.data;

            for(i = 0; i < data.length; i++){
                var currentYear = new Date().getFullYear();
                var age = currentYear - parseInt(data[i].birth_date.split('-')[0]);

                if (data[i].regNo.substr(0, 4) == 'EMER') {
                    panel = "panel-danger";
                    patientName = data[i].regNo;
                    sex = "";
                }
                else {
                    panel = "panel-success";
                    patientName = toTitleCase(data[i].surname) + " " + toTitleCase(data[i].firstname) + " " + toTitleCase(data[i].middlename);
                    sex = data[i].sex;
                }

                var patientHTML = "";
                patientHTML += $('#tmplPatients').html();
                patientHTML = patientHTML.replace('{{status}}', panel);
                patientHTML = replaceAll('{{userid}}', Treatment.CONSTANTS.doctorid, patientHTML);
                patientHTML = replaceAll('{{patientid}}', data[i].patient_id, patientHTML);
                patientHTML = replaceAll('{{regNo}}', data[i].regNo, patientHTML);
                patientHTML = replaceAll('{{name}}', patientName, patientHTML);
                patientHTML = replaceAll('{{sex}}', sex, patientHTML);
                patientHTML = replaceAll('{{Age}}', age, patientHTML);

                $('.patients').append(patientHTML);
            }
        });
    },
    startTreatment: function(patient){
        var url = host + "phase/phase_treatment.php?intent=startTreatment&doctor_id=" + Treatment.CONSTANTS.doctorid
            + "&patient_id=" + $(patient).find('.patientid').html();
        $.getJSON(url, function (data) {
            document.addTreatmentForm.reset();
            data = data.data;
            $('.treatment-ID').html(data.treatment_id);
            Treatment.CONSTANTS.treatmentid = $('.treatment-ID').html();
            $('.patient-name').html($(patient).find('.patientName').html());
            $('.patient-RegNo').html(data.regNo);
            $('.patient-Sex').html(data.sex);
            $('.patient-Age').html($(patient).find('.patientAge').html());
            $('.patient-ID').html($(patient).find('.patientid').html());
            $('.father_status').text(checkNull(data.father_status));
            $('.mother_status').text(checkNull(data.mother_status));
            $('.marital_status').text(checkNull(data.marital_status));
            $('.home_address').text(checkNull(data.home_address));
            $('.occupation').text(checkNull(data.occupation));
            $('.citizenship').text(checkNull(data.citizenship));
            $('.religion').text(checkNull(data.religion));
            $('.height').text(checkNull(data.height));
            $('.weight').text(checkNull(data.weight));
            $('.telephone').text(checkNull(data.telephone));
            $('.allergies').text(checkNull(data.allergies));
            $('.alcohol_usage').text(checkNull(data.alcohol_usage));
            $('.surgical_history').text(checkNull(data.surgical_history));
            $('.family_history').text(checkNull(data.family_history));
            $('.tobacco_usage').text(checkNull(data.tobacco_usage));
            $('.medical_history').text(checkNull(data.medical_history));

            //    Pre-populate form
            if(typeof data.consultation != "undefined"){
                // document.addTreatmentForm.consultation.value = data.consultation;
                document.addTreatmentForm.symptoms.value = data.symptoms;
                document.addTreatmentForm.diagnosis.value = data.diagnosis;
                document.addTreatmentForm.comment.value = data.comments;

                $("#end-incomplete").animate({"opacity": "0"}, "slow").animate({"opacity": "1"}, "slow")
                    .animate({"opacity": "0"}, "slow").animate({"opacity": "1"}, "slow");
            }
        });
        $('.end').removeClass('hidden');
        $('.well').removeClass('hidden');
        $('.at').click();
    },
    endTreatment: function(){
        var url = host + "phase/phase_treatment.php?intent=endTreatment&treatment_id=" + Treatment.CONSTANTS.treatmentid
            + "&patient_id=" + $('.patient-ID').html();
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
        Treatment.removeFromQueue($('.patient-ID').html());
        //$('.patient-name').html("Please Select a Patient from the Queue <span class='fa fa-long-arrow-right'></span> ");
        //$('#end').addClass('hidden');
        //$('.well').addClass('hidden');
    },
    submitTreatment: function(data){
        Loader.show();
        var prescription = [];
        $('#prescriptions li').each(function(index){
            //console.log(index + ": " + $(this).text());
            prescription.push($(this).text().substring(0, $(this).text().length - 1));
        });

        var url = host + "phase/phase_admission_request.php?treatment_id=" + Treatment.CONSTANTS.treatmentid +
            "&intent=requestAdmission";

        if(data.admit.checked){
            $.get(url, function(data){
                //console.log(data);
                Loader.hide();
                if(data.status == 2){
                    ResponseModal.show('Patient Already Admitted', true);
                    //showSuccess('Patient Already Admitted');
                }

            }).fail(function(e){
                ResponseModal.show('Unable to complete request', false);
                //console.log(e.responseText);
            });
        }
        //console.log({
        //    intent: "submitTreatment",
        //    treatment_id: Treatment.CONSTANTS.treatmentid,
        //    doctor_id: Treatment.CONSTANTS.doctorid,
        //    patient_id: $('.patient-ID').html(),
        //    symptoms: data.symptoms.value,
        //    consultation: data.consultation.value,
        //    comments: data.comment.value,
        //    diagnosis: data.diagnosis.value,
        //    prescription: prescription
        //});

        url = host + "phase/phase_treatment.php";
        $.post(url, {
            intent: "submitTreatment",
            treatment_id: Treatment.CONSTANTS.treatmentid,
            doctor_id: Treatment.CONSTANTS.doctorid,
            patient_id: $('.patient-ID').html(),
            symptoms: data.symptoms.value,
            consultation: data.consultation.value,
            comments: data.comment.value,
            diagnosis: data.diagnosis.value,
            glass_prescription: data.glass_prescription.value,
            prescription: prescription
        }, function(response){
            $('#loader').addClass('hidden');
            Loader.hide();
            if(response.status == 1){
                ResponseModal.show('Done, please end the session if you are done', true);
                //showSuccess("");
                $(data)[0].reset();
                $('#prescriptions > li').remove();
            }
            else{
                ResponseModal.show(response.message, false);
                //showAlert(response.message);
            }
        }, 'json');
    },
    removeFromQueue: function (patient){
        $.get((host + 'phase/arrival/phase_patient_arrival.php?intent=removeFromQueue&patient_id='
        + patient), function(data){
            location.reload();
        });
    },
    getTreatmentHistory: function() {
        var url = host + "phase/phase_treatment.php?intent=getTreatmentHistory&patient_id=" + $('.patient-ID').html();
        $.getJSON(url, function (data) {

            data = data.data;

            $('.history').empty();
            var prescriptions, prescriptionHTML, patientHTML;

            for(var i = data.length - 1; i >= 0; i--){
                prescriptions = data[i].prescriptions;
                prescriptionHTML = "";
                for(var j = 0; j < prescriptions.length; j++){
                    /*Show only prescription prescribed when patient was */
                    if(prescriptions[j].encounter_id == 0) {
                        prescriptionHTML += $('#tmplPrescription').html();
                        prescriptionHTML = replaceAll('{{prescription}}', prescriptions[j].prescription, prescriptionHTML);
                    }
                }

                patientHTML = "";
                patientHTML += $('#tmplTreatmentHistory').html();
                patientHTML = replaceAll('{{userid}}', Treatment.CONSTANTS.doctorid, patientHTML);
                patientHTML = replaceAll('{{treatmentid}}', data[i].treatment_id, patientHTML);
                patientHTML = replaceAll('{{comments}}', data[i].comments, patientHTML);
                patientHTML = replaceAll('{{consultation}}', data[i].consultation, patientHTML);
                patientHTML = replaceAll('{{diagnosis}}', data[i].diagnosis, patientHTML);
                patientHTML = replaceAll('{{doctorid}}', data[i].doctor_id, patientHTML);
                patientHTML = replaceAll('{{symptoms}}', data[i].symptoms, patientHTML);
                patientHTML = replaceAll('{{date}}', data[i].created_date, patientHTML);
                patientHTML = replaceAll('{{prescriptions}}', prescriptionHTML, patientHTML);

                //console.log(patientHTML);
                $('.history').append(patientHTML);
            }
        });
    },
    getEncounterHistory: function(id) {
        //console.log(id);
        var url = host + "phase/phase_treatment.php?intent=getEncounters&treatment_id=" + id;
        $.getJSON(url, function (data) {
            //console.log(data);

            if(data.status == 1){
                data = data.data;

                $('#encounteraccordion' + id).empty();

                var prescriptions, prescriptionHTML, patientHTML;


                for(var i = data.length - 1; i >= 0; i--){
                    prescriptions = data[i].prescriptions;
                    prescriptionHTML = "";
                    for(var j = 0; j < prescriptions.length; j++){
                        prescriptionHTML += $('#tmplPrescription').html();
                        prescriptionHTML = replaceAll('{{prescription}}', prescriptions[j].prescription, prescriptionHTML);
                        //console.log(prescriptionHTML);
                    }

                    patientHTML = "";
                    patientHTML += $('#tmplEncounterHistory').html();
                    patientHTML = replaceAll('{{userid}}', id, patientHTML);
                    patientHTML = replaceAll('{{treatmentid}}', data[i].encounter_id, patientHTML);
                    patientHTML = replaceAll('{{comments}}', checkNull(data[i].comments), patientHTML);
                    patientHTML = replaceAll('{{consultation}}', checkNull(data[i].consultation), patientHTML);
                    patientHTML = replaceAll('{{diagnosis}}', checkNull(data[i].diagnosis), patientHTML);
                    patientHTML = replaceAll('{{doctorid}}', data[i].doctor_id, patientHTML);
                    patientHTML = replaceAll('{{symptoms}}', checkNull(data[i].symptoms), patientHTML);
                    patientHTML = replaceAll('{{date}}', data[i].created_date, patientHTML);
                    patientHTML = replaceAll('{{prescriptions}}', prescriptionHTML, patientHTML);

                    //console.log(patientHTML);
                    $('#encounteraccordion' + id).append(patientHTML);
                }
            }
            else{
                $('#encounteraccordion' + id).text(data.message);
            }
        });
    },
    requestTest: function(form){
        Loader.show();
        var url = host + "phase/phase_treatment.php";
        $.post(url, {
            intent: "labRequest",
            doctor_id: Treatment.CONSTANTS.doctorid,
            patient_id: $('.patient-ID').html(),
            treatmentId: Treatment.CONSTANTS.treatmentid,
            description: form.description.value,
            labType: form.test_id.value
        }, function(data){
            //showSuccess(data.data);
            form.reset();
            Loader.hide();
            ResponseModal.show(data.data, true);
        }, 'json')
    },
    getLabHistory: function(){
        var type = $("#type").val();
            var url = host + "phase/phase_treatment.php";
            $.post(url, {
                intent: "labHistory",
                patientId: $('.patient-ID').html(),
                labType: type
            }, function(data){
                if(data.status == 1){
                    data = data.data;
                    var html = "";
                    for(var i = 0; i < data.length; i++){
                        var status;
                        switch(data[i].status){
                            case '5':
                                status = "Pending";
                                break;
                            case '6':
                                status = "Processing";
                                break;
                            case '7':
                                status = "Completed";
                                break;
                            default :
                                status = "No status put in";
                        }
                        html += "<tr>" +
                            "<td>" + data[i].treatment_id + "</td>" +
                            "<td>" + data[i].diagnosis + "</td>" +
                            "<td>" + data[i].modified_date + "</td>" +
                            "<td>" + status + "</td>" +
                            "<td><a target='_blank' href='" +
                            host + "view/" + type + ".php?labType=" + type + "&treatment_id=" + data[i].treatment_id +
                            "&encounter_id=" + data[i].encounter_id +  "&testId=" + data[i].testId + "' class='btn btn-sm btn-default'>View</a>" +
                            "</td>" +
                            "</tr>";
                    }

                    if(data.length > 0){
                        if($.fn.dataTable.isDataTable('#labHistoryTable')) {
                            labTable.destroy();
                            $('.table-data').html(html);
                            labTable = $('#labHistoryTable').DataTable( {
                                aaSorting : [[2, 'desc']]
                            } );
                        }
                        else {
                            $('.table-data').html(html);
                            labTable = $('#labHistoryTable').DataTable( {
                                aaSorting : [[2, 'desc']]
                            } );
                        }
                    }

                }
                else if(data.status == 2){
                    var html = "<tr><td class='text-center' colspan='5'>" + data.message +  "</td></tr>"
                    $('.table-data').html(html);
                    //$('.lab-history .dataTable').dataTable();
                }
            }, 'json');


    },
    getVitals: function(){
        var url = host + "phase/phase_vitals.php";
        $.post(url, {
            intent: "getVitals",
            patient_id: $('.patient-ID').html()
        }, function(data){
            //console.log(data);
            $('.vitals ul').empty();
            if(data.status == 1){
                data = data.data;
                var html = "";
                for(var i = 0; i < data.length; i++){
                    var patientHTML = "";
                    patientHTML += $('#tmplVitals').html();
                    patientHTML = replaceAll('{{userid}}', Treatment.CONSTANTS.doctorid, patientHTML);
                    patientHTML = replaceAll('{{id}}', i, patientHTML);
                    patientHTML = replaceAll('{{created_date}}', data[i].created_date, patientHTML);
                    patientHTML = replaceAll('{{blood_pressure}}', data[i].blood_pressure, patientHTML);
                    patientHTML = replaceAll('{{bmi}}', data[i].bmi, patientHTML);
                    patientHTML = replaceAll('{{pulse}}', data[i].pulse, patientHTML);
                    patientHTML = replaceAll('{{respiratory_rate}}', data[i].respiratory_rate, patientHTML);
                    patientHTML = replaceAll('{{temp}}', data[i].temp, patientHTML);
                    patientHTML = replaceAll('{{weight}}', data[i].weight, patientHTML);
                    patientHTML = replaceAll('{{height}}', data[i].height, patientHTML);
                    patientHTML = replaceAll('{{var}}', data[i].var, patientHTML);
                    patientHTML = replaceAll('{{val}}', data[i].val, patientHTML);
                    patientHTML = replaceAll('{{encounter_id}}', data[i].encounter_id, patientHTML);
                    patientHTML = replaceAll('{{patient_id}}', data[i].patient_id, patientHTML);

                    //console.log(patientHTML);
                    $('.vitals ul').append(patientHTML);
                }
            }
            else if(data.status == 2){
                $('.vitals ul').html("<li class='list-group-item'>" + data.message + "</li>");
            }
        }, 'json');
    }
};

function switchTabs(tab, t){
    $('.add-treatment').addClass('hidden');
    $('.request-test').addClass('hidden');
    $('.treatment-history').addClass('hidden');
    $('.lab-history').addClass('hidden');
    $('.vitals').addClass('hidden');
    $('.' + tab).removeClass('hidden');
    $('.at').removeClass('active');
    $('.rt').removeClass('active');
    $('.th').removeClass('active');
    $('.lh').removeClass('active');
    $('.vi').removeClass('active');
    $('.' + t).addClass('active');
}

$(function(){
    Treatment.init();
});