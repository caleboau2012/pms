var Restore = {
    URL: {
        uri : "phase/phase_backup_restore.php"
    },

    init: function(){
        var payload = {
            intent : 'backup'
        };

        $("#backup").popover({
            placement: 'top',
            content : "Database Successfully Backup",
            animation : true,
            trigger: 'click'
        });

        $("#backup").unbind('click').bind('click', function(e){
            e.preventDefault();
            Restore.serverRequest(host + Restore.URL.uri, payload, function(data){
                console.log(data);
                if (data.status == 1) {
                    $("#backup").popover('show');
                    setTimeout(function (){
                        $('#backup').popover('hide');
                    }, 6000);
                }
            }, 'GET');

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
    }
}

$(document).ready(function(){
    Restore.init();
})