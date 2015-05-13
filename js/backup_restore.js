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
        Restore.serverRequest(host + Restore.URL.uri, Restore.payload('getFiles'), function(data){
            console.log(data);
        });
    }
}

$(document).ready(function(){
    Restore.init();
})