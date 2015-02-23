var Mail = {};

Mail.CONSTANTS = {
    MSG_STATUS : {
        UNREAD : "1",
        READ : "0"        
    },

    MSG_TYPE : {
        INBOX_MESSAGE : "1",
        SENT_MESSAGE : "2",
        INBOX : 'inbox',
        SENT : 'sent'
    },

    ALERT_TYPE : {
        SUCCESS : 0,
        INFO : 1,
        WARNING : 2,
        DANGER : 3,
    }
};

Mail.resource = {
    URL : {
        communication : "phase/phase_communication.php"
    },
    current_page : 1,
    unread_count : 0,

    getCurrentPage: function(){
        return Mail.resource.current_page;
    }
}

Mail.Template = {
    messageElement : function(msg){
        var get_status = Mail.Template.statusIndicator(msg);
        var msg_status = get_status.msg_status;
        var msg_status_indicator = get_status.msg_status_indicator;

        subject = (typeof msg.msg_subject == 'undefined' || msg.msg_subject == "") ? "(no subject)" : msg.msg_subject;
        var html = "<tr id='msg-" + msg.msg_id + "' class= '" + msg_status + "'>\
            <td class='msg-name truncate'>" + msg.name + "</td>\
            <td class='msg-actions'>" + msg_status_indicator + "</td>\
            <td class='msg-message truncate'>\
                " + subject + ' - ' + msg.msg_body + "\
            </td>\
            <td class='msg_date truncate'>" + msg.created_date + "</td>\
        </tr>";

        return html;
    },

    viewMessage : function(msg){
        var msg_status_indicator = "";
        if (msg.msg_type == Mail.CONSTANTS.MSG_TYPE.INBOX_MESSAGE) {
            msg_status_indicator = "<span class='fa fa-circle-o fa-1x msg-status-indicator msg-read' title='Mark as Unread' data='" + msg.msg_id + "'></span>";
        };

        var participant_id = (typeof msg.sender_id == 'undefined') ? msg.recipient_id : msg.sender_id;
        var participant_name = (typeof msg.sender_name == 'undefined') ? msg.recipient_name : msg.sender_name;
        
        var pronoun = (typeof msg.sender_id == 'undefined') ? "recipient" : "sender";
        var preposition = (pronoun == "sender") ? "From: " : "To: ";
        
        var subject = (typeof msg.msg_subject == 'undefined' || msg.msg_subject == "") ? "(no subject)" : msg.msg_subject;

        html = "<div class='panel panel-default message-panel' id='" + msg.msg_id + "'>\
                    <div class='panel-heading'><h3 class='panel-title'>" + msg_status_indicator + subject + "</h3></div>\
                    <div class='panel-body'>\
                        <h4 class='msg-participant' id='" + participant_id + "'>"
                            + preposition + participant_name + "\
                            <small> " + msg.created_date + "</small>\
                        </h4>\
                        <p class='msg-body'>" + msg.msg_body + "</p>\
                    </div>\
                </div>";
        return html;
    },

    statusIndicator : function(msg) {

        if (typeof msg.msg_status !== 'undefined') {
            if (msg.msg_status == Mail.CONSTANTS.MSG_STATUS.UNREAD) {
                msg_status = "unread";
                msg_status_indicator = "<span class='fa fa-circle fa-1x msg-status-indicator msg-unread' title='Mark as Read' data='" + msg.msg_id + "'></span>";
            } else if (msg.msg_status == Mail.CONSTANTS.MSG_STATUS.READ) {
                msg_status = "";
                msg_status_indicator = "<span class='fa fa-circle-o fa-1x msg-status-indicator msg-read' title='Mark as Unread' data='" + msg.msg_id + "'></span>";
            }
        } else {
            /*
            This else block might seem redundant but removing it causes sent messages
            to carry a message status indicator (which they shouldn't) with the ID of
            another message.

            So, PLEASE JUST LEAVE THIS ELSE BLOCK AS IT IS
            THANK YOU!!!
            */            
            msg_status = "";
            msg_status_indicator = "";
        }

        var result = {
            msg_status : msg_status,
            msg_status_indicator : msg_status_indicator
        };

        return result;
    },

    alertMessage : function(msg, alert_type) {
        var alert_class;
        switch(alert_type) {
            case Mail.CONSTANTS.ALERT_TYPE.SUCCESS:
                alert_class = 'alert-success';
                break;
            case Mail.CONSTANTS.ALERT_TYPE.INFO:
                alert_class = 'alert-info';
                break;
            case Mail.CONSTANTS.ALERT_TYPE.WARNING:
                alert_class = 'alert-warning';
                break;
            case Mail.CONSTANTS.ALERT_TYPE.DANGER:
                alert_class = 'alert-danger';
                break;
            default:
                return;
        }

        var html = '<div class="alert ' + alert_class + ' alert-dismissible" role="alert">\
                        <button type="button" class="close" data-dismiss="alert">\
                            <span aria-hidden="true">&times;</span>\
                            <span class="sr-only">Close</span>\
                        </button>\
                        <strong>' + msg + '</strong>\
                    </div>';

        return html;
    }
}

Mail.serverReq = function(url, param, callback) {
    $.getJSON(url, param, function(data){
        if (typeof callback == 'function') {
            callback(data);
        };
    }).done(function(){
        window.dispatchEvent(new Event('ServerRequestComplete'));
    });
}

Mail.sendMail = function() {
    var message_modal = $(".message-modal-body");

    var recipient_field = $("input[name='recipient']");
    
    if (typeof recipient_field.attr("id") == 'undefined') {
        var parent_field = recipient_field.parent();
        parent_field.addClass("has-error");
        return false;
    } else {
        var recipient_id = recipient_field.attr("id").split("-")[1];
    }


    var msg_subject = $("input[name='subject']").val();
    var msg_body = $("textarea[name='body']").val();

    var payload = {
        intent : 'sendMessage',
        recipient_id : recipient_id,
        msg_subject : msg_subject,
        msg_body : msg_body
    }

    console.log(payload);
    Mail.serverReq(Mail.resource.URL.communication, payload, function(data){
        if (data.status == 1) {
            Mail.dismissModal();
            Mail.alertMessage(data.message, Mail.CONSTANTS.ALERT_TYPE.SUCCESS);
        } else {
            Mail.alertMessage(data.message, Mail.CONSTANTS.ALERT_TYPE.DANGER, message_modal);
        }
    })
}

Mail.getMessage = function(msg_id) {
    var payload = {
        intent : 'getMessage',
        msg_id : msg_id
    }

    Mail.serverReq(Mail.resource.URL.communication, payload, function(data){
        Mail.dismissAlerts();
        if (data.status == 1) {
            Mail.viewMessage(data.data);
        };
    });
}

Mail.viewMessage = function(data) {
    if (data.msg_status == Mail.CONSTANTS.MSG_STATUS.UNREAD) {
        Mail.markAsRead(data.msg_id);
    };
    //get active tab
    var active_tab = $('.tab-pane.active');
    //hide empty box message
    active_tab.find(".empty-box-message").addClass("hidden");
    //get message view panel
    var msg_view_panel = active_tab.find(".view-message");
    //load message details in view panel
    msg_view_panel.append(Mail.Template.viewMessage(data));
    //hide message list
    active_tab.find(".message-pane").addClass("hidden");
    //show view message panel
    msg_view_panel.removeClass("hidden");

    Mail.regDOM();
}

Mail.markAsRead = function(msg_id, indicator) {
    if (typeof indicator == 'undefined') {
        var indicator = $("span.msg-status-indicator[data='" + msg_id + "']");
    };
    $("tr#msg-" + msg_id).removeClass("unread");
    Mail.resource.unread_count = (Mail.resource.unread_count == 0) ? 0 : Mail.resource.unread_count - 1;
    Mail.displayUnreadCount();

    if (typeof indicator != 'undefined') {
        indicator.removeClass("fa-circle msg-unread");
        indicator.addClass("fa-circle-o msg-read");
    };

    var payload = {
        intent : 'markAsRead',
        msg_id : msg_id
    };

    Mail.serverReq(Mail.resource.URL.communication, payload, function(data){
        if (data.status == 1) {
            return;
        } else {
            alert(data.message);
            $("tr#msg-" + msg_id).addClass("unread");
            Mail.resource.unread_count += 1;
            Mail.displayUnreadCount();
        }
    })
}

Mail.markAsUnread = function(msg_id) {
    if (typeof indicator == 'undefined') {
        var indicator = $("span.msg-status-indicator[data='" + msg_id + "']");
    };

    var payload = {
        intent : 'markAsUnread',
        msg_id : msg_id
    }

    Mail.serverReq(Mail.resource.URL.communication, payload, function(data){
        if(data.status == 1){
            console.log($("tr#msg-" + msg_id));
            $("tr#msg-" + msg_id).addClass("unread");
            Mail.resource.unread_count += 1;
            Mail.displayUnreadCount();
            if (typeof indicator != 'undefined') {
                indicator.removeClass("fa-circle-o msg-read");
                indicator.addClass("fa-circle msg-unread");                
            };
        } else {
            alert(data.message);
        }
    })
}


Mail.loadMessages = function(active_tab){
    var active_tab = (active_tab == null) ? $(".tab-pane.active") : active_tab;
    var active_tab_id = $(active_tab).attr("id");

    console.log(active_tab_id);
    
    var payload = {};

    if (active_tab_id == "inbox") {
        payload.intent = "getInbox";
        payload.page = Mail.resource.getCurrentPage();
    } else if (active_tab_id == "sentmails"){
        payload.intent = "getSent";
        payload.page = Mail.resource.getCurrentPage();
    }

    Mail.serverReq(Mail.resource.URL.communication, payload, function(data){
        Mail.dismissAlerts();
        if (data.status == 1) {
            console.log(data.data);
            Mail.displayMessages(data.data);
        } else {
            Mail.renderEmptyMessagePane();
        }
    })
}

Mail.renderEmptyMessagePane = function() {
    var active_tab = $(".tab-pane.active");
    active_tab.find(".message-pane").addClass("hidden");
    active_tab.find(".empty-box-message").removeClass("hidden");
}

Mail.displayMessages = function(data, active_tab) {
    var active_tab = (active_tab == null) ? $(".tab-pane.active") : active_tab;
    
    active_tab.find(".message-pane").removeClass("hidden");
    active_tab.find(".empty-box-message").addClass("hidden");

    var start_index = data.start_index;
    var end_index = data.end_index;
    var total = data.total;
    var page = data.current_page;

    Mail.setMailNavigation(active_tab, start_index, end_index, total, page);

    var message_list = active_tab.find("table.message-list > tbody");
    message_list.html("");
    
    var msg_type = data.msg_type;
    
    if (msg_type == Mail.CONSTANTS.MSG_TYPE.INBOX) {
        Mail.resource.unread_count = parseInt(data.unread);
    };
    
    $(data[msg_type]).each(function(index, value){
        value.name = value.surname + " " + value.firstname + " " + value.middlename;
        message_list.append(Mail.Template.messageElement(value));
    })

    Mail.displayUnreadCount();

    Mail.regDOM();
}

Mail.displayUnreadCount = function() {
    var unread_badge = $("span.unread-count");
    if (Mail.resource.unread_count == 0) {
        unread_badge.addClass("hidden");
    } else {
        unread_badge.removeClass("hidden");
        unread_badge.text(Mail.resource.unread_count);
    }
}

Mail.setMailNavigation = function(active_tab, start_index, end_index, total, page) {
    Mail.resource.current_page = page;

    var nav_newer = active_tab.find(".newer");
    var nav_older = active_tab.find(".older");
    
    nav_newer.addClass("disabled_msg_nav_icon")
    nav_older.addClass("disabled_msg_nav_icon")

    var newer = (start_index - 1 ) > 0;
    var older = (end_index < total);

    active_tab.find("span.start_index").text(start_index);
    active_tab.find("span.end_index").text(end_index);
    active_tab.find("span.total").text(total);


    (newer) ? nav_newer.removeClass("disabled_msg_nav_icon") : null;
    (older) ? nav_older.removeClass("disabled_msg_nav_icon") : null;
}

Mail.removeMessagePane = function(active_tab){
    if (typeof active_tab == 'undefined') {
        var active_tab = $(".tab-pane.active");
    }

    var active_message_pane = active_tab.find(".message-pane");
    var active_message_view = active_tab.find(".view-message");

    active_message_view.addClass("hidden");
    active_message_pane.removeClass("hidden");
    active_message_view.find(".message-panel").remove();
}

Mail.regDOM = function(){
    $(".message-list tr").unbind('click').bind('click', function(event){
        if ($(event.target).hasClass("msg-status-indicator")) {
            event.preventDefault();
            return;
        } else {
            var msg_id = $(this).attr("id").split("-")[1];

            Mail.getMessage(msg_id);
        }
    });

    $(".back-button").unbind('click').bind('click', function(event){
        Mail.removeMessagePane();
    })

    $(".msg-status-indicator").unbind('click').bind('click', function(event){
        var indicator = $(this);
        var msg_id = indicator.attr("data");
        if (indicator.hasClass("msg-unread")) {
            Mail.markAsRead(msg_id);
            return;
        } else if (indicator.hasClass("msg-read")) {
            Mail.markAsUnread(msg_id);
            indicator.removeClass("fa-circle-o msg-read");
            indicator.addClass("fa-circle msg-unread");
            return;
        }
    })
}

Mail.alertMessage = function(message, alert_type, display_pane) {
    if (typeof display_pane == 'undefined') {
        var display_pane = $(".tab-pane.active");
    }

    display_pane.prepend(Mail.Template.alertMessage(message, alert_type));
}

Mail.dismissModal = function(){
    Mail.clearModal();
    $(".modal-backdrop").trigger('click');
}

Mail.dismissAlerts = function(){
    $("div.alert").remove();
}

Mail.clearModal = function() {
    $("input[name='recipient']").removeAttr("id");
    $("input[name='recipient']").val("");
    $("input[name='subject']").val("");
    $("textarea[name='body']").val("");

    console.log("clear modal complete!");
}