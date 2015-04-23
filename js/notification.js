/**
 * Created by olajuwon on 2/20/2015.
 */
Notification = {
    unread_count  : null,
    alerted       :      false,
    AudioElement  : document.getElementById('audio-element'),
    Constants     : {
        REQUEST_SUCCESS : 1,
        REQUEST_ERROR   : 2
    },
    init: function(){
        Notification.getCount();
    },
    checkout: function(curr_count){
        payload = {};
        payload.intent = "pollUnread";
        payload.count = curr_count;
        $.post(host + 'phase/phase_communication.php', payload, function(data){
            if(data.status == Notification.Constants.REQUEST_SUCCESS){
                Notification.unread_count = data.data.count;
                Notification.displayCount(data.data.count);
                Notification.AudioElement.play();
            }
        }, 'json');
    },
    getCount: function(){
        payload = {};
        payload.intent = "countUnread";
        $.post(host + "phase/phase_communication.php", payload, function(data){
            if(data.status == Notification.Constants.REQUEST_SUCCESS){
                Notification.displayCount(data.data.count);
            }
            Notification.unread_count = data.data.count;
        }, "json");
        /*
        * Send to polling action
        * */
        setInterval(function(){
            Notification.checkout(Notification.unread_count);
        }, 15000);
    },
    displayCount: function(unread_count){
        if(unread_count == 0){
            $("#msg_unread").addClass("invisible");
        }else if(unread_count > 0){
            $("#msg_unread").removeClass("invisible").html(unread_count);
        }
    }
};
(function(){
    Notification.init();
})();
