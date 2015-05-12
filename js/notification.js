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
                //only alert if there is a new message
                if(Notification.unread_count < data.data.count){
                    Notification.AudioElement.play();
                }
                Notification.unread_count = data.data.count;
                Notification.displayCount(data.data.count);
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
        }, 300000);
    },
    displayCount: function(unread_count){
        if(unread_count == 0){
            $(".message_unread").addClass("invisible");
        }else if(unread_count > 0){
            $(".message_unread").removeClass("invisible").html(unread_count);
        }
    //    update for message page
        $('.unread-count').html(unread_count);
    }
};
(function(){
    Notification.init();
})();
