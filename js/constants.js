/**
 * Created by user on 1/28/2015.
 */
var host = "http://localhost/pms/";

function printElem(data){
    var mywindow = window.open('', 'my div', 'height=400,width=600');
    mywindow.document.write('<html><head><title>my div</title>');
    /*optional stylesheet*/
    mywindow.document.write('<link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" type="text/css" />');
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10

    mywindow.print();
    mywindow.close();

    return true;
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