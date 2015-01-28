/**
 * Created by user on 1/27/2015.
 */
function rapModal(regNo){
    $('#rapModal').modal('show');
}

function newStaff(){
    var html = "<form class='form'>" +
        "<input class='form-control' name='username' placeholder='Username'><br>" +
        "<input class='form-control' name='password' placeholder='Password'><br>" +
        "<button class='form-control btn btn-info' id='addNewStaff'>Add</button> " +
        "</form>";
    var title = "Add new Staff";
    var options = {
        "html" : true,
        "title" : title,
        "content" : html,
        "placement" : "bottom"
    };
    $('#newStaff').popover(options);
    return false;
}