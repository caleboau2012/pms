/**
 * Created by user on 1/28/2015.
 */
var host = "http://code.caleb.com.ng/pms/";

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
        mywindow.document.write('<html><head><title>ELYON 1.0</title>');
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
    $('.dataTables_wrapper select, .dataTables_filter input').addClass('btn');
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

function checkNull(field){
    return (field)?field:"None";
}

Number.prototype.formatMoney = function(c, d, t){
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

var Loader = {
    _html : function (text) {
        return "<div id='loaderOverlay'><div id='loader' class='text-center'>" +
        "<h2 class='text-content'>" + text + "</h2></div></div>";
    },
    content: 'Processing...',
    show : function(content) {
        var _html = (content) ? this._html(content) : this._html(this.content);
        $('body').append(_html);
    },
    hide : function() {
        $('#loaderOverlay').remove();
    }
};
var ResponseModal = {
    _html : function (text, successful, reload) {
        var _h;
        if(reload){
             _h = "<div id='responseOverlay'><div id='loader' class='text-center'><h1 class='text-right'><span class='fa fa-close pointer closeResponseOverlayReload'></span></h1>";
        }else{
            _h = "<div id='responseOverlay'><div id='loader' class='text-center'><h1 class='text-right'><span class='fa fa-close pointer closeResponseOverlay'></span></h1>";
        }
        if(successful){
            _h +=  "<h1 class='font-70 text-center text-success'><span class='fa fa-check-circle'></span></h1>";
        }else{
            _h +=  "<h1 class='font-70 text-danger text-center'><span class='fa fa-info-circle'></span></h1>";
        }
         _h += "<p class='text-center'>" + text + "</p></div></div>";
        return _h;
    },
    content: 'Transaction Completed',
    show : function(content, successful, reload) {
        var _html = this._html(content, successful, reload);
        $('body').append(_html);
    },
    hide : function() {
        $('#responseOverlay').remove();
    }
};

//ResponseModal.show('Patient Added', true, true);
//Loader.show();

$("body").delegate('.closeResponseOverlay', 'click', function () {
    ResponseModal.hide();
}).delegate('.closeResponseOverlayReload', 'click', function () {
    ResponseModal.hide();
    window.location.reload();
});