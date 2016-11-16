/**
 * Created by user on 1/27/2015.
 */
var name, status;
var userid;
var addNewRoleOptionHTML = "";
var existingRolesTableHTML = "";

$(document).ready(function(){
    init();
});

function init(){
    $.get(host + "phase/admin/phase_admin.php?intent=getAllUsers", function(data){
        data = JSON.parse(data);
        console.log(data);
        var  html = "";
        for(var i = 0; i < data.data.length; i++){
            var obj = data.data[i];
            if(((obj.surname + " " + obj.firstname + " " + obj.middlename).trim() == "")
                || ((obj.surname + " " + obj.firstname + " " + obj.middlename).trim() == "null null null")){
                name = "[Incomplete Registration]";
                status = 0;
            }
            else{
                name = obj.surname + " " + obj.firstname + " " + obj.middlename;
                status = 1;
            }
            html += $('#tmplTable').html().replace('{{sn}}', (i + 1) )
                .replace("{{staffId}}", obj.regNo)
                .replace("{{name}}", name)
                .replace("{{userid}}", obj.userid)
                .replace("{{userid}}", obj.userid)
                .replace("{{userid}}", obj.userid)
                .replace("{{userid}}", obj.userid)
                .replace("{{profile-status}}", status)
                .replace("{{userid}}", obj.userid)
                .replace("{{active_fg}}", obj.active_fg);
        }

        $("#staffTable").html(html).find('.btn').each(function(e){
            if($(this).attr('userid') == 'null'){
                $(this).attr('disabled', 'disabled');
            }
        });
        $('#staffTable').find('label').each(function(e){
            if($(this).attr('userid') == 'null'){
                $(this).addClass('hidden');
            }
        });
        $('#staffTable').find('label').each(function(e){
            if($(this).attr('active_fg') == 0){
                $(this).attr('data-origin', 'auto').click().removeAttr('data-origin');
            }
        });

        makeTable();
    });
}

function rapModal(e){
    userid = $(e).attr('userid');

    initModal();
}

function toggleDelete(e){
    userid = $(e).attr('userid');

    if($(e).attr('data-origin') == 'auto'){
        return true;
    }
    else{
        var confirmed;
        if($(e).attr('active_fg') == 1) {
            confirmed = confirm("You are about to deactivate this account. The person will no longer be able to log in and if the person is logged in, he will no longer be able to do anything." +
                "\n Are you sure you want to continue?");
            if(confirmed){
                $.post(host + "phase/admin/phase_admin.php", {
                    intent: 'deleteStaff',
                    userid: userid
                }, function(data){
                    console.log(data);
                    $(e).attr('active_fg', '0');
                }, 'json');
            }
            else{
                return false;
            }
        }
        else{
            confirmed = confirm("You are about to reactivate this account. The person will now be able to log in." +
                "\n Are you sure you want to continue?");
            if(confirmed){
                $.post(host + "phase/admin/phase_admin.php", {
                    intent: 'restoreStaff',
                    userid: userid
                }, function(data){
                    if(data.status == 1){
                        $(e).attr('active_fg', '1');
                    }
                    else if(data.status == 2){
                        alert(data.message);
                        location.reload();
                    }
                    //console.log(data);
                }, 'json');
            }
            else{
                return false;
            }
        }
    }

    //if($(e).find('input').attr('checked')){
    //    $(e).find('input').removeAttr('checked');
    //}
    //else{
    //    $(e).find('input').attr('checked', 'checked');
    //    $(e).find('span').css('right', '10px');
    //}
}

function profileModal(e){
    userid = $(e).attr('userid');
    status = $(e).attr('data-status');

    $("#profile-form")[0].reset();

    if(status == 1){
        $("#intent").val("updateProfile")
    }
    else{
        $("#intent").val("addProfile")
    }

    console.log({
        userid: userid,
        status: status,
        intent: $("#intent").val()
    });

    $.getJSON(host + "phase/phase_profile.php?intent=getProfile&userid=" + userid, function(data){
        console.log(data);
        $('#profile-user-id').attr('value', userid);

        if(data.status == 1){
            data = data.data;
            $('#first-name').val(data.firstname);
            $('#middle-name').val(data.middlename);
            $('#surname').val(data.surname);
            $('#dob').val(data.birth_date);
            $('#height').val(data.height);
            $('#weight').val(data.weight);
            if(data.sex == "MALE"){
                $("#sex-male").attr('selected', 'selected')
            }
            else if (data.sex == "FEMALE"){
                $("#sex-female").attr('selected', 'selected');
            }
            $('#telephone').val(data.telephone);
            if(data.dept_id == 1){
                $("#dept-doctor").attr('selected', 'selected')
            }
            else if(data.dept_id == 2){
                $("#dept-pharmacy").attr('selected', 'selected');
            }
            else if(data.dept_id == 3){
                $("#dept-mro").attr('selected', 'selected');
            }
            else if(data.dept_id == 7){
                $("#dept-urine").attr('selected', 'selected');
            }
            else if(data.dept_id == 5){
                $("#dept-visual").attr('selected', 'selected');
            }
            else if(data.dept_id == 6){
                $("#dept-xray").attr('selected', 'selected');
            }
            else if(data.dept_id == 4){
                $("#dept-parasitology").attr('selected', 'selected');
            }
            else if(data.dept_id == 8){
                $("#dept-pathology").attr('selected', 'selected');
            }
            $('#h-address').text(data.home_address);
            $('#l-address').text(data.work_address);
        }

        $('#password-userid').val(userid);

        initProfileModal();
    });
}

function initProfileModal(){
    $("#profileModal").modal('show');
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