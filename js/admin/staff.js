/**
 * Created by user on 1/27/2015.
 */
var name;
var userid;
var addNewRoleOptionHTML = "";
var existingRolesTableHTML = "";

$(document).ready(function(){
    $.get(host + "phase/admin/phase_admin.php?intent=getAllUsers", function(data){
        data = JSON.parse(data);
        console.log(data);

        var  html = "";
        for(var i = 0; i < data.data.length; i++){
            var obj = data.data[i];
            html += $('#tmplTable').html().replace('{{sn}}', (i + 1) )
                .replace("{{staffId}}", obj.regNo)
                .replace("{{name}}", obj.surname + " " + obj.firstname + " " + obj.middlename)
                .replace("{{userid}}", obj.userid);
        }

        $("#staffTable").html(html);
        //
        //var html = "<tr><td>1</td>
        //<td>Lorem</td>
        //<td>ipsum</td>
        //<td><button class="btn btn-sm btn-default" userid="1" onclick="rapModal(this)">Manage</button></td>
        //</tr>

    });
});

function rapModal(e){
    userid = $(e).attr('userid');

    $.get(host + "phase/admin/phase_admin.php?intent=getStaffDetails&userid=" + userid, function(data){
        data = JSON.parse(data);
        name = data.data.surname + " " +
            data.data.firstname + " " +
                data.data.middlename;
        var availableRoles = data.data.roles.available;
        var existingRoles = data.data.roles.existing;

        for(var i = 0; i < availableRoles.length; i++){
            addNewRoleOptionHTML += "<option>" +  availableRoles[i].role_label + "</option>";
        }

        for(var i = 0; i < existingRoles.length; i++){
            existingRolesTableHTML += "<tr></tr><td>" + existingRoles[i].role_label + "</td>" +
            "<td>" + existingRoles[i].staff_permission + "</td>" +
            "<td><button class='btn btn-sm btn-default' onclick='deleteRole(\"" +
            existingRoles[i].userid + "\", \"" + existingRoles[i].staff_role_id + "\"" +
            ")'>Delete</button></td></tr>";
        }

        $('#rapModal').modal('show');
    });
}

$('#rapModal').on('show.bs.modal', function (event) {
    var modal = $(this);
    $('#addNewRoleName').html(name);
    $('#addNewRoleSelect').html(addNewRoleOptionHTML);
    $('#existingRolesTable').html(existingRolesTableHTML);
});

function newStaff(e){
    $(e).parent().addClass('active');
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

$('#newStaff').on('hide.bs.popover', function (event) {
    $('#newStaff').removeClass('active');
});
