/**
 * Created by Olaniyi on 3/11/15.
 */


String.prototype.firstCharUpper = function(){
    return this.substring(0, 1).toUpperCase() + this.toLowerCase().substring(1);
}

var Laboratory = {
    CONSTANTS:{
        FIVE: 'Pending',
        SIX: 'Processing',
        SEVEN: 'Completed'

    },
    URL: {
        lab_uri: "phase/phase_laboratory.php"
    },
    init:function(){
        $('#addTestForm').on('submit', function(e){
            e.preventDefault();


        });
    },

    ajaxRequest:function(url, data, request_type){
        var test_data = "";
        var pending = "";
        var action;
        $.ajax({
            type : request_type,
            data : data,
            url : url,
            dataType: 'json',
            success: function(returnedData){
                var count = 0;
                if(returnedData.status == 2){
                    test_data = "<tr>" +
                        "<td colspan='7' class='text-center'>"+ returnedData.message + "</td>"
                        "</tr>"

                    pending += '<p class="text-warning">No pending test</p>';

                }else {
                    $(returnedData.data).each(function(){
                        var name = this.surname.toUpperCase() + ' ' + this.firstname + ' ' + this.middlename;
                        test_data += "<tr>";
                        test_data += "<td>" + ++count + "</td>";
                        test_data += "<td>" + name + "</td>";
                        test_data += "<td>" + this.regNo + "</td>";
                        test_data += "<td class='text-capitalize'>" + $('#type').val() + "</td>";
                        if (this.status_id == 5){
                            action = "Select";
                            test_data += "<td>" + Laboratory.CONSTANTS.FIVE + "</td>";
                        }
                        else if (this.status_id == 6){
                            action = "Select";
                            test_data += "<td>" + Laboratory.CONSTANTS.SIX + "</td>";
                        } else {
                            action = "View";
                            test_data += "<td>" + Laboratory.CONSTANTS.SEVEN + "</td>";
                        }
                        test_data += '<td id="action"><a href="#haematology" class="btn btn-default" data-toggle="modal">';
                        test_data += action + '</a></td>';
                        test_data += "<td>" + this.created_date + "</td>";
                        test_data += "</tr>";

                        pending += '<div class="patient-queue__item">';
                        pending += '<div class="patient-queue__item-label-block">' + name;
                        pending += '<small class="sub">' + $("#type").val() + '</small>';
                        pending += '</div>';
                        pending += '</div>';

                    });
                }
                $('#test_table tbody').empty().append(test_data);
                $('#pending .patient-queue__list').empty().append(pending);
            },
            error: function(){
                console.log('failed');
            }
        });
    },

    onTestChange: function(){
        var mySelect = $('#type'),
            test = mySelect.val();

        mySelect.on('change', function(){
            test = mySelect.val();


        });
        var data = {
            intent: 'getAllTest',
            labType: test
        }

        Laboratory.ajaxRequest(host + Laboratory.URL.lab_uri,data,'GET')
        var aref = '#' + test;
        $("#action a").attr("href", aref);
    }
};





$(function(){
    Laboratory.init();
});





