/**
 * Created by user on 1/27/2015.
 */
var name;
var userid;
var addNewRoleOptionHTML = "";
var existingRolesTableHTML = "";

$(document).ready(function(){
    init();
});

function init(){
    $.get(host + "phase/admin/phase_admin.php?intent=getAllUsers", function(data){
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
                .replace("{{staffId}}", obj.regNo)
                .replace("{{name}}", name)
                .replace("{{userid}}", obj.userid);
        }

        $("#staffTable").html(html);
        makeTable();
    });
}

function rapModal(e){
    userid = $(e).attr('userid');

    initModal();
}

function initModal(){
    $.get(host + "phase/admin/phase_admin.php?intent=getStaffDetails&userid=" + userid, function(data){
        data = JSON.parse(data);
        console.log(data);
        if(data.data.surname == null){
            name = ""
        }
        else{
            name = data.data.surname + " " +
                data.data.firstname + " " +
                    data.data.middlename;
        }
        var availableRoles = data.data.roles.available;
        var existingRoles = data.data.roles.existing;

        for(var i = 0; i < availableRoles.length; i++){
            addNewRoleOptionHTML += "<option value='" + availableRoles[i].staff_role_id + "'>" +  availableRoles[i].role_label + "</option>";
        }

        for(var i = 0; i < existingRoles.length; i++){
            existingRolesTableHTML += "<tr></tr><td>" + existingRoles[i].role_label + "</td>" +
            "<td>" + existingRoles[i].staff_permission + "</td>" +
            "<td><button class='btn btn-sm btn-default' onclick='deleteRole(\"" +
            existingRoles[i].userid + "\", \"" + existingRoles[i].permission_role_id + "\"" +
            ")'>Delete</button></td></tr>";
        }

        $('#addNewRoleName').html(name);
        $('#addNewRoleSelect').html(addNewRoleOptionHTML);
        $('#existingRolesTable').html(existingRolesTableHTML);
        addNewRoleOptionHTML = existingRolesTableHTML = "";
        $('#rapModal').modal('show');
    });
}
//
//$('#rapModal').on('show.bs.modal', function (event) {
//    var modal = $(this);
//});

function newStaff(e){
    $(e).parent().addClass('active');
    var html = $('#tmplPopover').html();
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

$('#newStaff').on('hide.bs.popover', function (event) {
    $('#newStaff').removeClass('active');
});

function  generatePassword(){
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 5; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    $('#password').val(text);
    //return text;
}

function addNewStaff(e){
    var regNo = $('#regNo').val();
    var password = $('#password').val();

    if((regNo == "") || (password == "")){
        $(e).parent().find('.alert').removeClass('hidden');
    }
    else{
        $.get(host + "phase/admin/phase_admin.php?intent=addNewStaff&regNo=" + regNo + "&passcode=" + password,
            function(data){
                data = JSON.parse(data);
                //console.log(data);
                if(data.status == 2){
                    $(e).parent().find('.alert').removeClass('hidden');
                }
                else{
                    var printHTML = $('#tmplPrint').html().replace('{{username}}', regNo).replace('{{password}}', password);
                    printElem("Staff Credentials", printHTML, null);
                    $('#newStaff').popover('hide');
                    init();
                }
            });
    }
}

function addNewRole(e){
    if(e.preventDefault)
        e.preventDefault();
    else
        e.returnValue = false;

    var role_id = e.role.value;
    var permission_id = e.permission.value;

    console.log(userid + " " + role_id + " " + permission_id);

    $.get(host + "phase/admin/phase_role.php?intent=assignRole&userid=" + userid +
        "&role_id=" + role_id + "&permission_id=" + permission_id,
        function(data){
            data = JSON.parse(data);
            showAlert(data.message);
            initModal();
        });
    return false;
}

function deleteRole(userid, permissionRoleID){
    $.get(host + "phase/admin/phase_role.php?intent=dismissRole&permission_role_id=" + permissionRoleID,
        function(data){
            data = JSON.parse(data);
            showAlert(data.message);
            initModal();
    });
}