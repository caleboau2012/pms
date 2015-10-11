/**
 * Created by Olaniyi on 6/12/15.
 */

var Report = {
    INTENT: {
        NEW_PATIENTS:           'newPatient',
        CURRENT_PATIENTS:       'currentPatients',
        PATIENT_VISITS:         'patientVisits',
        INPATIENTS:             'inPatients',
        CONSULTATION_REPORT:    'consultationReport',
        PATIENTS_AGE:           'patientsAge',
        PATIENT_DIAGNOSIS:      'patientDiagnosis'
    },

    URL: {
        phase: "phase/phase_report.php"
    },

    currentDate: function() {
        var now = new Date();
        var year = now.getFullYear().toString();
        var month = (now.getMonth() + 1).toString();
        var day = now.getDate().toString();

        month = (month.length < 2) ? ('0' + month) : month;
        day = (day.length < 2) ? ('0' + day) : day;

        return year + "-" + month + "-" + day;
    },

    yestardayDate: function(){
        var now = new Date();
        var year = now.getFullYear().toString();
        var month = (now.getMonth() + 1).toString();
        var day = (now.getDate() - 1).toString();

        month = (month.length < 2) ? ('0' + month) : month;
        day = (day.length < 2) ? ('0' + day) : day;
        return year + "-" + month + "-" + day;
    },

    ajaxRequest: function(url, param, callback, request_type) {
        if (request_type == "POST"){
            $.post(url, param, function(data){
                if (typeof callback == 'function') {
                    callback(JSON.parse(data));
                }
            }).done(function(){
                    window.dispatchEvent(new Event('PostComplete'));
                });
        } else {
            $.getJSON(url, param, function(data){
                if (typeof callback == 'function'){
                    callback(data);
                }
            }).done(function(){
                    window.dispatchEvent(new Event('ServerRequestComplete'))
                });
        }
    },

    payload: function(intent, start_date, end_date, gender, day) {
        return {
            intent:         intent,
            start_date:     start_date,
            end_date:       end_date,
            gender:         gender,
            day:            day
        }
    },

    doTableOdd: function(sort, header, footer){
        $('.table').DataTable( {
            dom: 'T<"clear">lfrtip',
            iDisplayLength: 25,
            "bSort": sort,
            tableTools: {
                "sSwfPath": "swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    {
                        "sExtends":    "copy",
                        "bHeader": header,
                        "bFooter": footer
                    },
                    {
                        "sExtends":    "csv",
                        "bHeader": header,
                        "bFooter": footer
                    },
                    {
                        "sExtends":    "xls",
                        "bHeader": header,
                        "bFooter": footer
                    },
                    {
                        "sExtends": "pdf",
                        "sPdfOrientation": "landscape",
                        //"sPdfMessage": "PMS REPORT.",
                        "bHeader": header,
                        "bFooter": footer
                    },
                    {
                        //"sMessage": "PMS REPORT.",
                        "sExtends": "print"
                    }
                ]
            }
        } );
        Report.printTable();
    },

    switcher: function(){
        var opt = $('option:selected', '#view').attr('opt');
        var gender = $('#gender'), ifram = $("#report_iframe"), start_date = $('#start_date'), end_date = $('#end_date');
        if (opt == 'no') {
            $('#day').hide();
            $('#range').show();
            $('.gender').hide();
            gender.attr('disabled', 'disabled');
        }
        else if (opt == 'yes') {
            $('#day').hide();
            $('#range').show();
            $(".gender").show();
            gender.removeAttr('disabled');
        }
        else if (opt == 'day') {
            $('#range').hide();
            $("#day").val(Report.currentDate());
            $('#day').show();

        }

        switch ($("#view").val()){
            case Report.INTENT.NEW_PATIENTS:
                if (gender.val() != ''){
                    ifram.attr('src', Report.INTENT.NEW_PATIENTS.toLowerCase() + ".php?start_date="+start_date.val()+"&end_date="+end_date.val()+"&gender="+gender.val());
                } else {
                    ifram.attr('src', Report.INTENT.NEW_PATIENTS.toLowerCase() + ".php?start_date="+start_date.val()+"&end_date="+end_date.val());
                }
                break;
            case Report.INTENT.CURRENT_PATIENTS:
                if (gender.val() != ''){
                    ifram.attr('src', Report.INTENT.CURRENT_PATIENTS.toLowerCase() + ".php?start_date="+start_date.val()+"&end_date="+end_date.val()+"&gender="+gender.val());
                } else {
                    ifram.attr('src', Report.INTENT.CURRENT_PATIENTS.toLowerCase() + ".php?start_date="+start_date.val()+"&end_date="+end_date.val());
                }
                break;
            case Report.INTENT.PATIENTS_AGE:
                if (gender.val() != ''){
                    ifram.attr('src', Report.INTENT.PATIENTS_AGE.toLowerCase() + ".php?start_date="+start_date.val()+"&end_date="+end_date.val()+"&gender="+gender.val());
                } else {
                    ifram.attr('src', Report.INTENT.PATIENTS_AGE.toLowerCase() + ".php?start_date="+start_date.val()+"&end_date="+end_date.val());
                }
                break;
            case Report.INTENT.PATIENT_VISITS:
                ifram.attr('src', Report.INTENT.PATIENT_VISITS.toLowerCase()+".php?day="+$("input[name=day]").val());
                break;
            case Report.INTENT.INPATIENTS:
                ifram.attr('src', Report.INTENT.INPATIENTS.toLowerCase() + ".php?start_date="+start_date.val()+"&end_date="+end_date.val());
                break;
            case Report.INTENT.CONSULTATION_REPORT:
                ifram.attr('src', Report.INTENT.CONSULTATION_REPORT.toLowerCase() + ".php?start_date="+start_date.val()+"&end_date="+end_date.val());
                break;
            case Report.INTENT.PATIENT_DIAGNOSIS:
                ifram.attr('src', Report.INTENT.PATIENT_DIAGNOSIS.toLowerCase() + ".php?start_date="+start_date.val()+"&end_date="+end_date.val());
                break;

        }
    },

    table: function(){
        $('.table').DataTable( {
            dom: 'T<"clear">lfrtip',
            "processing": false,
            iDisplayLength: 10,
            tableTools: {
                "sSwfPath": "swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    "copy",
                    "csv",
                    "xls",
                    {
                        "sExtends": "pdf",
                        "sPdfOrientation": "portrait",
                        "sPdfMessage": "PMS Report."
                    },
                    {
                        "sExtends": "print",
                        "sMessage": "PMS Report."
                    }
                ]
            }
        } );
        Report.printTable();
    },

    printTable: function(){
        $('.DTTT_button_print').click(function(){
            setTimeout(function(){
                window.print();
                location.reload();
            }, 500);
        });
    }
}

$(document).ready(function(){
    $("#start_date").val(Report.yestardayDate());
    $("#end_date").val(Report.currentDate());
    $("#day").hide();

    $('#report_iframe').attr('src', "newpatient.php?start_date="+Report.yestardayDate()+"&end_date="+Report.currentDate());
    Report.table();


    $("#start_date, #end_date, #gender").on('change', function(){
        var view = $('option:selected', '#view');
        if (view == Report.INTENT.PATIENT_VISITS){
            $('#report_iframe').attr('src', view.val().toLowerCase()+".php?day="+$("input[name=day]").val());
            Report.table();
        } else {
            $('#report_iframe').attr('src', view.val().toLowerCase()+".php?start_date="+$('#start_date').val()+"&end_date="+$('#end_date').val()+"&gender="+$('#gender').val());
            Report.table();
        }


    });

    $("#day").on('change', function(){
        $('#report_iframe').attr('src', "patientvisits.php?day="+$("input[name=day]").val());
    });

    $('#DataTables_Table_0_filter').addClass('form-inline').find('input').addClass('form-control');
    $('#DataTables_Table_0_length select').addClass('btn btn-default');
    $('.paginate_button').addClass('btn btn-link');
});