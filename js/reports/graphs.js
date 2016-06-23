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

    currentDate: function() {
        var now = new Date();
        var year = now.getFullYear().toString();
        var month = now.getMonth().toString();
        var day = now.getDate().toString();

        month = (month.length < 2) ? ('0' + month) : month;
        day = (day.length < 2) ? ('0' + day) : day;

        var today = year + "-" + month + "-" + day;
        return today;
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
    makeDoughnutChart: function(param, data){
        $('#doughnut').empty();
        $('.alert').addClass('hidden');
        //console.log({
        //    data: data,
        //    params: param
        //});
        var maleCount = 0;
        var femaleCount = 0;
        var emergencies = 0;
        for(var i = 0; i < data.length; i++){
            if(data[i].sex == 'Male')
                maleCount++;
            else if(data[i].sex == 'Female')
                femaleCount++;
            else
                emergencies++;
        }
        if((femaleCount == 0) && (maleCount == 0) && (emergencies == 0)){
            showAlert('No patients to report in the chosen time range');
        }
        else if(param.intent == 'newPatients'){
            Morris.Donut({
                element: 'doughnut',
                data: [
                    {label: "New Male Patients", value: maleCount},
                    {label: "New Female Patients", value: femaleCount},
                    {label: "New Emergencies", value: emergencies}
                ]
            });
        }
        else if(param.intent == 'currentPatients'){
            Morris.Donut({
                element: 'doughnut',
                data: [
                    {label: "Current Male Patients", value: maleCount},
                    {label: "Current Female Patients", value: femaleCount},
                    {label: "Current Emergencies", value: emergencies}
                ]
            });
        }
        else if(param.intent == 'inPatients'){
            Morris.Donut({
                element: 'doughnut',
                data: [
                    {label: "Admitted Male Patients", value: maleCount},
                    {label: "Admitted Female Patients", value: femaleCount},
                    {label: "Admitted Emergencies", value: emergencies}
                ]
            });
        }
        else if(param.intent == 'consultationReport'){
            Morris.Donut({
                element: 'doughnut',
                data: [
                    {label: "Male Patients with Consultations", value: maleCount},
                    {label: "Female Patients with consultations", value: femaleCount},
                    {label: "Emergencies with consultations", value: emergencies}
                ]
            });
        }
        else if(param.intent == 'patientDiagnosis'){
            Morris.Donut({
                element: 'doughnut',
                data: [
                    {label: "Male Patients Diagnosed", value: maleCount},
                    {label: "Female Patients Diagnosed", value: femaleCount},
                    {label: "Emergencies Diagnosed", value: emergencies}
                ]
            });
        }
    },
    makeBarChart: function(param, data){
        $('#bar').empty();
        console.log({
            data: data,
            params: param
        });

        var count1_5 = 0;
        var count2_5 = 0;
        var count3_5 = 0;
        var count4_5 = 0;
        var count5_5 = 0;

        var baseDate = (new Date(param.start_date)).getTime();
        var dateInterval = ((new Date(param.end_date)).getTime() - baseDate) / 5;
        //console.log(dist);
        var date;

        for(var i = 0; i < data.length; i++){
            if((param.intent == 'patientDiagnosis') || (param.intent == 'consultationReport')){
                date = (new Date(data[i].consultation_date)).getTime();
            }
            else{
                date = (new Date(data[i].created_date)).getTime();
            }
            //console.log({
            //    date: date,
            //    range: (dateInterval * 2)
            //});
            if(date < (baseDate + dateInterval))
                count1_5++;
            else if(date < (baseDate + (dateInterval * 2)))
                count2_5++;
            else if(date < (baseDate + (dateInterval * 3)))
                count3_5++;
            else if(date < (baseDate + (dateInterval * 4)))
                count4_5++;
            else if(date < (baseDate + (dateInterval * 5)))
                count5_5++;
        }
        var graphData = [
            {
                date:  (new Date(baseDate + dateInterval)).toLocaleDateString(),
                count: count1_5
            },
            {
                date:  (new Date(baseDate + (dateInterval * 2))).toLocaleDateString(),
                count: count2_5
            },
            {
                date:  (new Date(baseDate + (dateInterval * 3))).toLocaleDateString(),
                count: count3_5
            },
            {
                date:  (new Date(baseDate + (dateInterval * 4))).toLocaleDateString(),
                count: count4_5
            },
            {
                date:  (new Date(baseDate + (dateInterval * 5))).toLocaleDateString(),
                count: count5_5
            }
        ];
        //console.log(graphData);

        if((count1_5 == 0) && (count2_5 == 0) && (count3_5 == 0) && (count4_5 == 0) && (count5_5 == 0)){
            showAlert('No patients to report in the chosen time range');
        }
        else{
            Morris.Bar({
                element: 'bar',
                data: graphData,
                xkey: 'date',
                ykeys: ['count'],
                labels: ['Date', 'Number']
            });
        }
    }
};

$(document).ready(function(){
    fire();

    $("#start_date, #end_date").val(Report.currentDate());

    $("#view, #gender, #start_date, #end_date").on('change', function(e){
        e.preventDefault();
        fire();
    });
});

function fire(){
    var intent = $('#view').val(), template = "", total = "";
    var start_date = $('#start_date').val(), end_date = $('#end_date').val(), gender = $('#gender').val(), param;
    param = Report.payload(intent, start_date, end_date, gender, null);
    //console.log(param);
    Report.ajaxRequest(host + Report.URL.phase, param, function(data){
        //console.log(data);
        if (data.status == 1){
            data = data.data;
            //console.log(data);
            Report.makeDoughnutChart(param, data);
            Report.makeBarChart(param, data);
        }
    }, 'GET');
}