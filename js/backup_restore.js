var Restore = {
    URL: {
        uri : "phase/phase_backup_restore.php"
    },

    serverRequest: function(url, param, callback, request_type){
        if (request_type == 'POST') {
            $.post(url, param, function(data){
                if (typeof callback == 'function') {
                    callback(JSON.parse(data));
                };
            }).done(function(){
                    window.dispatchEvent(new Event('PostComplete!'));
                })
        } else {
            $.getJSON(url, param, function(data){
                if (typeof callback == 'function') {
                    callback(data);
                };
            }).done(function(){
                    window.dispatchEvent(new Event('ServerRequestComplete'));
                });
        }
    },

    payload: function(intent){
        return {
            intent : intent
        }
    },

    init: function(){
        $('#success').hide();
        var tableData = "";
        Restore.serverRequest(host + Restore.URL.uri, Restore.payload('getFiles'), function(data){
            if (data.status == 1){
                $.each(data.data, function(index, item){
                    tableData += "<tr><td>"+ (index+1) +"</td>";
                    tableData += "<td>"+ item.substring(7, 17).split("-").reverse().join("/") +"</td>";
                    tableData += "<td><a href=";
                    tableData += "../backup/"+item;
                    tableData += " download='pms.sql'>Download</a>";
                    if (index == 9){
                        return false;
                    }
                });
            }
            $("#backup").empty().append(tableData);
        }, 'GET');

        var files_to_restore = "";
        Restore.serverRequest(host + Restore.URL.uri, Restore.payload('getFiles'), function(data){
            if (data.status == 1){

                $.each(data.data, function(index, item){
                    files_to_restore += "<tr><td>"+ (index+1) +"</td>";
                    files_to_restore += "<td>"+ item.substring(7, 17).split("-").reverse().join("/") +"</td>";
                    files_to_restore += "<td><a href=";
                    files_to_restore += "backup/"+item;
                    files_to_restore += ">Restore</a>";
                    if (index == 9){
                        return false;
                    }
                });
            }
            $("#filesToRestore").empty().append(files_to_restore);
        }, 'GET');
    },

    fileUpload: function(){
       $('#form').on('submit', function(){
//           e.preventDefault();
           $(this).attr('target', 'upload_frame');
           $(this).submit();
           $('#success').show();
       });
        return false;
    }
}

$(document).ready(function(){
    Restore.init();
    Restore.fileUpload();
})