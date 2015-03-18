/**
 * Created by Olaniyi on 3/11/15.
 */


String.prototype.firstCharUpper = function(){
    return this.substring(0, 1).toUpperCase() + this.toLowerCase().substring(1);
}

var Laboratory = {
    CONSTANTS:{
        PENDING: 5,
        PROCESSING: 6,
        COMPLETED: 7,
        HOST: "http://localhost/pms/"
    },
    URL: {
        incoming_lab_data: "phase/phase_laboratory.php"
    },
    init:function(){
        $('#addTestForm').on('submit', function(e){
            e.preventDefault();
            var payload = {};
            payload.data = $(this).serialize();
            payload.intent = 'setLabDetails';
            payload.labType ='haematology';
            //var form_data = $(this).serialize();
            //payload.data = form_data;
            //console.log(payload);
            var request = $.getJSON(host + Laboratory.URL.incoming_lab_data, payload, function(data){
                console.log(data);
            }).fail(function(data){
                    console.log(data.responseText);
                });
           /* request.done(function(data){
                var response = JSON.parse(data);
                //console.log(form_data);
                console.log(response);
            })*/
        });
    }
};

$(function(){
    Laboratory.init();
});





