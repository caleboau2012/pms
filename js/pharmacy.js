/**
 * Created by olajuwon on 2/20/2015.
 */
Pharmacy = {
    init: function(){
        $('.patients-list_item').click(function(){
            Pharmacy.transferPatient(this);
        });
    },
    checkQueue: function(){
        if($('ul.patients-list_body li').length == 0){
            $('.patients-list_body').html("<h3 class='text-muted'>No Pending patient</h3>");
        }
    },
    removeFromQueue: function(patient){
        $(patient).remove();
    },
    transferPatient: function(patient){
        content = "<h2>" + $(patient).attr("data-name") + "</h2>";
        content += "<p>" + $(patient).attr("data-reg") + "</p>";
        $('#empty_active').hide();
        $('#patient_name').html($(patient).attr("data-name"));
        $('#patient_reg').html($(patient).attr("data-reg"));
        Pharmacy.checkQueue();
        $('.active_patient').removeClass('hidden');
    },
    attendPatient: function(){

    }
};

$(function(){
    Pharmacy.init();
});
