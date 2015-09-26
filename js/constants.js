/**
 * Created by user on 1/28/2015.
 */
var host = "http://localhost/pms/";

function printElem(title, body, footer){
    console.log({
        title: title,
        body: body,
        footer: footer
    });
    var data = '';
    $.get(host + 'view/printout.php', function(html){
        if(title != null) {
            title = "<div class='panel-heading'><h2 class='panel-title'>" +
            title + "</h2></div>";
        }
        else {
            title = "";
        }

        if(body != null) {
            body = "<div class='panel-body'>" + body + "</div>";
        }
        else {
            body = "";
        }

        if(footer != null) {
            footer = "<div class='panel-footer'>" + footer + "</div>";
        }
        else {
            footer = "";
        }

        html = replaceAll("{{title}}", title, html);
        html = replaceAll("{{body}}", body, html);
        html = replaceAll("{{footer}}", footer, html);

        var mywindow = window.open('', 'PMS', 'height=400,width=600');
        mywindow.document.write('<html><head><title>PMS</title>');
        /*optional stylesheet*/
        mywindow.document.write('<link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(html);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        //mywindow.print();
        //mywindow.close();

        return true;
    });
}


function makeTable(){
    $('.dataTable').dataTable();
}

//Sign out
$('#sign-out').on('click', function () {
    $.get(host + "phase/phase_auth.php?intent=logout", function( data ) {
        var response = JSON.parse(data);
        if(response.status == 1){
            window.location.assign(host + 'index.php');
        }
    });
});

function toTitleCase(str) {
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

function replaceAll(find, replace, str) {
    return str.replace(new RegExp(find, 'g'), replace);
}

function showAlert(message){
    $('.alertMSG').html(message);
    $('.alertMSG').parent().removeClass('hidden');
    setTimeout(function(){
        $('.alertMSG').parent().addClass('hidden');
    }, 10000);
    location.href="#alertMSG";
}

function showSuccess(message){
    $('.successMSG').html(message);
    $('.successMSG').parent().removeClass('hidden');
    setTimeout(function(){
        $('.successMSG').parent().addClass('hidden');
    }, 10000);
    location.href="#successMSG";
}