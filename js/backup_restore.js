var Restore = {
    URL: {
        uri : "phase/phase_backup_restore.php"
    },

    init: function(){

        var backup = $("#backup");
        backup.popover({
            placement: 'top',
            content : "Database Successfully Backup",
            animation : true,
            trigger: 'click'
        });

       backup.unbind('click').bind('click', function(e){
            e.preventDefault();
            Restore.serverRequest(host + Restore.URL.uri, Restore.payload('backup'), function(data){
                console.log(data);
                if (data.status == 1) {
                    backup.popover('show');
                    setTimeout(function (){
                        backup.popover('hide');
                    }, 6000);
                }
            }, 'GET');

        });

        var restore = $("#restore");
        restore.unbind('click').bind('click', function(e){
            e.preventDefault();
            Restore.serverRequest(host + Restore.URL.uri, Restore.payload('restore'), function(data){
                console.log(data);
            })
        });
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
    }
}

$(document).ready(function(){
    Restore.init();
})