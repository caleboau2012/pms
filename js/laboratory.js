/**
 * Created by Olaniyi on 3/11/15.
 */

var Laboratory = {
    CONSTANTS:{
        FIVE: 'Pending',
        SIX: 'Processing',
        SEVEN: 'Completed',
        DATA_TABLE: false
    },
    URL: {
        lab_uri: "phase/phase_laboratory.php",
        lab: "view/laboratory.php"
    },
    init:function(){
        $('#submit').on('click', function(){
            $('#status').attr('value', 7);
        });
        $('#save').on('click', function(){
            $('#status').attr('value', 6);
        });
        $('#addTestForm').on('submit', function(e){
            e.preventDefault();
            var data = $(this).serialize();
            Laboratory.updateLabDetails(host + Laboratory.URL.lab_uri, data, 'POST');
        });

        Laboratory.onDocReady();

        $('#back').on('click', function(e){
            e.preventDefault();
            history.go(0);

        });

        $('#print').click(function(e){
            printElem($('#print-head').html(), $('#print-body').html(), $('#print-footer').html());
        })
    },

    ajaxRequest:function(url, data, request_type){
        $.ajax({
            type : request_type,
            data : data,
            url : url,
            dataType: 'json',
            success: function(returnedData){
                var test_data = "";
                var pending = "";
                var action;
                if(returnedData.status == 2){
                    //test_data = "<tr>" +
                    //    "<td colspan='7' class='text-center'>"+ returnedData.message + "</td>"
                    //"</tr>"

                    pending += '<p class="text-warning">No pending test</p>';

                }else {

                    $(returnedData.data).each(function(){
//                        console.log(this);
                        var name = this.surname.toUpperCase() + ' ' + this.firstname + ' ' + this.middlename;
                        test_data += "<tr>";
                        test_data += "<td>" + this.treatment_id + "</td>";
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
                        test_data += '<td><a target="_blank" href='+Laboratory.selectedOption()+'.php?labType='+Laboratory.selectedOption()+'&treatment_id='+this.treatment_id+'&encounter_id='+this.encounter_id;
                        test_data += ' data-id='+this.treatment_id + ' data-status='+this.status_id + ' data-regNo='+this.regNo + ' data-sex='+this.sex;
                        test_data += ' data-surname='+this.surname;
                        test_data += ' data-firstname='+this.firstname;
                        test_data += ' data.middlename='+this.middlename;
                        test_data += ' class="btn btn-default btn-sm action">';
                        test_data += action + '</a></td>';
                        test_data += "<td>" + this.created_date + "</td>";
                        test_data += "</tr>";

                        pending += '<a target="_blank" href='+Laboratory.selectedOption()+'.php?labType='+Laboratory.selectedOption()+'&treatment_id='+this.treatment_id+'&encounter_id='+this.encounter_id;
                        pending += ' data-id='+this.treatment_id + ' data-status='+this.status_id + ' data-regNo='+this.regNo + ' data-sex='+this.sex;
                        pending += ' data-surname='+this.surname + ' data-encounter_id='+this.encounter_id;
                        pending += ' data-firstname='+this.firstname;
                        pending += ' data.middlename='+this.middlename;
                        pending += ' class="pending">';
                        var hidden = '';
                        if(this.status_id == 7){
                            hidden = 'hidden';
                        }
                        pending += '<div class="patient-queue__item ' + hidden + '">';
                        pending += '<div class="patient-queue__item-label-block">' + name;
                        pending += '<small class="sub">' + $("#type").val() + '</small>';
                        pending += '</div>';
                        pending += '</div>';
                        pending += '</a>';

                    });
                }
                $('#test_table tbody').empty().html(test_data);
                $('#pending .patient-queue__list').empty().html(pending);
                Laboratory.CONSTANTS.DATA_TABLE = $('table.dataTable').dataTable({
                    "aaSorting": [[ 0, "desc" ]]
                });
            },

            error: function(){
                console.log('failed');
            }
        });
    },

    onTestChange: function(){
        var test = Laboratory.selectedOption();
        var data = Laboratory.payload('getAllTest', test);
//        Laboratory.changeAction();
        Laboratory.CONSTANTS.DATA_TABLE.fnDestroy();
        Laboratory.ajaxRequest(host + Laboratory.URL.lab_uri,data,'GET');
    },

    selectedOption: function(){
        return $('#type').val();
    },

    payload: function(intent, labType, treatment_id, encounter_id, status_id, surname, firstname, middlename, regNo, sex){
        return {
            intent: intent,
            labType: labType,
            treatment_id: treatment_id,
            encounter_id: encounter_id,
            status_id: status_id,
            surname: surname,
            firstname: firstname,
            middlename: middlename,
            regNo: regNo,
            sex: sex
        }
    },

    changeAction: function(){
        $('a.action').attr('href', Laboratory.selectedOption());
    },

    onDocReady: function(){
        $(document).ready(function(){
            $('#success').hide();
            var test = Laboratory.selectedOption();
            var data = Laboratory.payload('getAllTest', test);
            Laboratory.changeAction();
            Laboratory.ajaxRequest(host + Laboratory.URL.lab_uri,data,'GET');
            Laboratory.getLabDetails(test);
        });
    },
    getLabDetails: function(test){
        var data = Laboratory.payload(
            'getLabDetails',
            Laboratory.selectedOption(),
            $(test).attr('data-encounter_id'),
            $(test).attr('data-id'),
            $(test).attr('data-status'),
            $(test).attr('data-surname'),
            $(test).attr('data-firstname'),
            $(test).attr('data.middlename'),
            $(test).attr('data-regno'),
            $(test).attr('data-sex')
        );
//        console.log(data);
        /*$('#mainContent').load($(test).attr('data-ref'), data, function(response, status, xhr){
            if (status == 'error'){
                var msg = 'there is error on this page';
                $('#mainContent').html(msg + xhr.status + " " + xhr.statusText);
            }
        }).fadeIn('slow');*/
    },

    updateLabDetails: function(url, data, request_type){
        $.ajax({
            type : request_type,
            data : data,
            url : url,
            dataType: 'json',
            success: function(returnedData){
                console.log(returnedData);
                $('body,html').animate({scrollTop : 0}, 800);
                if (returnedData.status == 3){
                    showAlert(returnedData.message);
                } else{
                    showSuccess(returnedData.data);
                }
                if($('#status').attr('value') ==  7){
                    location.reload();
                }
            },
            error: function(data){
                console.log(data.responseText);
                $('body,html').animate({scrollTop : 0}, 800);
                showAlert("Update not Successful. Check your input")
            }
        });
    }
};

$(function(){
    Laboratory.init();
});





