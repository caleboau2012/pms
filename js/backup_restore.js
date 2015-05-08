var Restore = {
    URL: {
        uri : "phase/phase_backup_restore.php"
    },

    init: function(){
        var payload = {
            intent : 'backup'
        }

        $("#backup").on('click', function(e){
            e.preventDefault();
            Restore.serverRequest(host + Restore.URL.uri, payload, function(data){
                console.log(data);
            }, 'GET');
        });

    },

    serverRequest: function(url, param, callback, request_type){
        if (request_type == 'POST') {
            /*console.log("Request..." + request_type);*/
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