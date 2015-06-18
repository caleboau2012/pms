/**
 * Created by Olaniyi on 6/12/15.
 */

var Report = {
    INTENT: {
        NEW_PATIENTS:        'newPatients',
        CURRENT_PATIENTS:    'currentPatients',
        PATIENTS_AGE:        'patientsAge',
        PATIENT_VISITS:      'patientVisits',
        INPATIENTS:         'inPatients',
        CONSULTATION_REPORT: 'consultationReport',
        PATIENT_DIAGNOSIS:  'patientDiagnosis'
    },

    URL: {
        phase: "phase/phase_report.php"
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
                        "sPdfMessage": "PMS REPORT.",
                        "bHeader": header,
                        "bFooter": footer
                    },
                    {
                        "sExtends": "print",
                        "sMessage": "PMS REPORT."
                    }
                ]
            }
        } );
        Report.printTable();
    },


    table: function(){
        $('.table').DataTable( {
            dom: 'T<"clear">lfrtip',
            iDisplayLength: 25,
            tableTools: {
                "sSwfPath": "swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    "copy",
                    "csv",
                    "xls",
                    {
                        "sExtends": "pdf",
                        "sPdfOrientation": "landscape",
                        "sPdfMessage": "PMS Report."
                    },
                    {
                        "sExtends": "print",
                        "sMessage": "PMS Report."
                    }
                ]
            }
        } );
//        Report.printTable();
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
    $('#view').on('change', function(){
        var view = $(this).val().toLowerCase();
        window.open(view +'.php', '_self');
    });

    $("#start_date, #end_date").on('change', function(e){
        e.preventDefault();
        var intent = $('#view').val(), template = "", total = "";
        var start_date = $('#start_date').val(), end_date = $('#end_date').val(), gender = $('#gender').val(), param;
        param = Report.payload(Report.INTENT.CURRENT_PATIENTS, start_date, end_date, gender, null);
        Report.ajaxRequest(host + Report.URL.phase, param, function(data){
            if (data.status == 1){
                console.log(data);
                $.each(data.data, function(index, item){
                    template += "<tr><td>"+(index+1) +"</td>";
                    template += "<td>"+ item.patient_name +"</td>"
                    template += "<td>"+ item.regNo +"</td>"
                    template += "<td>"+ item.sex +"</td></tr>"
                });
                total += "<th><td>&nbsp;</td><td>&nbsp;</td>";
                total += "<td>Total</td><td>"+ data.data.length +"</td>"
            }
            $('#new_patient').html("");
            $('#new_patient').append(template);
            $('#total').html("");
            $('#total').append(total);
        }, 'GET');
        Report.table();
    });
});