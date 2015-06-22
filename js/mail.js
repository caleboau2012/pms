/*BEGIN---jQuery code snippets to set cursor position in textarea field---BEGIN*/
jQuery.fn.setSelection = function(selectionStart, selectionEnd) {
    if(this.length == 0) return this;
    input = this[0];

    if (input.createTextRange) {
        var range = input.createTextRange();
        range.collapse(true);
        range.moveEnd('character', selectionEnd);
        range.moveStart('character', selectionStart);
        range.select();
    } else if (input.setSelectionRange) {
        input.focus();
        input.setSelectionRange(selectionStart, selectionEnd);
    }

    return this;
}

jQuery.fn.setCursorPosition = function(position){
    if(this.length == 0) return this;
    return $(this).setSelection(position, position);
};

/*END----jQuery code snippets to set cursor position in textarea field----END*/

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
    },

    ACTION : {
        COMPOSE : 'compose',
        FORWARD : 'forward',
        REPLY : 'reply'
    }
};

Mail.resource = {
    URL : {
        communication : host + "phase/phase_communication.php"
    },
    current_page : 1,
    unread_count : 0,
    send_mail_action : 'compose',

    getCurrentPage: function(){
        return Mail.resource.current_page;
    },

    nl2br : function(string){
        var breakTag = '<br />';
        return (string + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    },

    setUsername : function(username) {
        Mail.resource.username = username;
    }
}

Mail.Template = {
    messageElement : function(msg){
        var get_status = Mail.Template.statusIndicator(msg);
        var msg_status = get_status.msg_status;
        var msg_status_indicator = get_status.msg_status_indicator;

        var display_date = Mail.Template.formatDate(msg.created_date);

        subject = (typeof msg.msg_subject == 'undefined' || msg.msg_subject == "") ? "(no subject)" : msg.msg_subject;
        var html = "<tr id='msg-" + msg.msg_id + "' class= '" + msg_status + "'>\
            <td class='msg-name truncate'>" + msg.name + "</td>\
            <td class='msg-actions'>" + msg_status_indicator + "</td>\
            <td class='msg-message truncate'>\
                " + subject + ' - ' + msg.msg_body + "\
            </td>\
            <td class='msg_date'><span class='pull-right'>" + display_date + "</span></td>\
        </tr>";

        return html;
    },

    viewMessage : function(msg){
        var msg_actions = "";
        var msg_status_indicator = "";
        if (msg.msg_type == Mail.CONSTANTS.MSG_TYPE.INBOX_MESSAGE) {
            msg_status_indicator = "<span class='fa fa-circle-o fa-1x msg-action msg-status-indicator msg-read' title='Mark as Unread' data='" + msg.msg_id + "'></span>";
            msg_reply_action = "<span class='fa fa-reply fa-1x msg-action msg-action-reply' title='Reply' data=' " + JSON.stringify(msg) + "'></span>";
            msg_forward_action = "<span class='fa fa-share fa-1x msg-action msg-action-forward' title='Forward' data=' " + JSON.stringify(msg) + "'></span>";
            msg_actions = msg_status_indicator + msg_reply_action + msg_forward_action;
        } else if (msg.msg_type == Mail.CONSTANTS.MSG_TYPE.SENT_MESSAGE) {
            msg_forward_action = "<span class='fa fa-share fa-1x msg-action msg-action-forward' title='Forward' data=' " + JSON.stringify(msg) + "'></span>";
            msg_actions = msg_forward_action;
        }

        /*console.log(msg);*/

        var participant_id = (typeof msg.sender_id == 'undefined') ? msg.recipient_id : msg.sender_id;
        var participant_name = toTitleCase((typeof msg.sender_name == 'undefined') ? msg.recipient_name : msg.sender_name);

        var pronoun = (typeof msg.sender_id == 'undefined') ? "recipient" : "sender";
        var preposition;
        if(pronoun == "sender"){
            preposition = "<span class='label label-default'>From </span>";
        }
        else{
            preposition = "<span class='label label-default'>To </span>";
        }

        var subject = (typeof msg.msg_subject == 'undefined' || msg.msg_subject == "") ? "(no subject)" : msg.msg_subject;

        var display_date = Mail.Template.formatDate(msg.created_date);

        html = "<div class='panel panel-info message-panel' id='" + msg.msg_id + "'>\
                    <div class='panel-heading'>\
                        <h3 class='panel-title'>" + msg_actions + subject + "</h3>\
                    </div>\
                    <div class='panel-body'>\
                        <h4 class='msg-participant' id='" + participant_id + "'>"
                            + preposition + "&nbsp; " +  participant_name + "\
                            <small> " + display_date + "</small>\
                        </h4>\
                        <p class='msg-body'>" + Mail.resource.nl2br(msg.msg_body) + "</p>\
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
    },

    replySuffix : function(msg_data) {
        var date_obj = new Date(msg_data.created_date);
        var date = date_obj.toDateString();
        var time = date_obj.toLocaleTimeString();
        var text = "On " + date + " at " + time + ", " + msg_data.sender_name + " wrote: " + "\n";

        return text;
    },

    forwardSuffix : function(msg_data) {
        var from, to;
        var date_obj = new Date(msg_data.created_date);
        var date = date_obj.toDateString();
        var time = date_obj.toLocaleTimeString();
        if (msg_data.msg_type == Mail.CONSTANTS.MSG_TYPE.INBOX_MESSAGE) {
            from = msg_data.sender_name;
            to = Mail.resource.username;
        } else if (msg_data.msg_type == Mail.CONSTANTS.MSG_TYPE.SENT_MESSAGE) {
            from = Mail.resource.username;
            to = msg_data.recipient_name;
        }

        var text = "\n---------- Forwarded message ----------\nFrom: " + from + "\nDate: " + date + " at " + time + "\nSubject: " + msg_data.msg_subject + "\nTo: " + to + "\n\n" + msg_data.msg_body + "\n-------------------------------------------------------------------------------";

        return text;
    },

    formatDate : function(date_string) {
        var date_obj = new Date(date_string);

        var now_date_obj = new Date();
        var now_date = now_date_obj.getDate();
        var now_month = now_date_obj.getMonth();
        var now_year = now_date_obj.getFullYear();

        if (date_obj.getFullYear() == now_year) {
            if (date_obj.getMonth() == now_month && date_obj.getDate() == now_date) {
                var split_arr = date_obj.toLocaleTimeString().split(" ")
                return split_arr[0].substr(0, split_arr[0].lastIndexOf(":")) + " " +split_arr[1];
            } else {
                return date_obj.toDateString().split(" " + date_obj.getFullYear())[0].substr(4);
            }
        } else {
            return date_obj.toDateString().split(" " + date_obj.toTimeString())[0].substr(4);
        }
        if (date_obj.getDate() == now_date && date_obj.getMonth() == now_month && date_obj.getFullYear() == now_year) {
            return date_obj.toDateString().split(" " + b.toTimeString())[0];
        }
    }
}

Mail.serverReq = function(url, param, callback, request_type) {
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

Mail.sendMail = function() {
    var action = $("input[name='send_mail_action']").val();
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

    /*console.log(payload);*/
    Mail.serverReq(Mail.resource.URL.communication, payload, function(data){
        if (data.status == 1) {
            Mail.dismissModal();
            /*console.log("send message success...");*/
            if (typeof action == 'undefined' || action == Mail.CONSTANTS.ACTION.COMPOSE) {
                Mail.loadMessages(null, function(loadMessageData){
                    /*console.log("Load message complete!");*/
                    Mail.alertMessage(data.message, Mail.CONSTANTS.ALERT_TYPE.SUCCESS);
                    /*console.log("alert displayed..." + data.message);*/
                });
            } else {
                Mail.alertMessage(data.message, Mail.CONSTANTS.ALERT_TYPE.SUCCESS);
            }
        } else {
            Mail.alertMessage(data.message, Mail.CONSTANTS.ALERT_TYPE.DANGER, message_modal);
        }
    }, 'POST');
}

Mail.replyMail = function(msg_data) {
    /*console.log("Replying...");*/
    var recipient_id = msg_data.sender_id;
    var recipient_name = msg_data.sender_name;
    var recipient_field = $("input[name='recipient']");

    recipient_field.val(recipient_name);
    recipient_field.attr("id", "user-" + recipient_id);
    recipient_field.attr("disabled", "disabled");

    var subject = "Re: " + msg_data.msg_subject;
    $("input[name='subject']").val(subject);

    Mail.resource.send_mail_action = Mail.CONSTANTS.ACTION.REPLY;
    Mail.displayModal();
}

Mail.forwardMail = function(msg_data) {
    /*console.log("Forwarding...");*/

    var subject = "Fwd: " + msg_data.msg_subject;
    $("input[name='subject']").val(subject);

    var msg_container = $("textarea.msg-body");
    msg_container.val(Mail.Template.forwardSuffix(msg_data));

    Mail.resource.send_mail_action = Mail.CONSTANTS.ACTION.FORWARD;
    Mail.displayModal();
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
        indicator.attr("title", "Mark as Unread");
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
            /*console.log($("tr#msg-" + msg_id));*/
            $("tr#msg-" + msg_id).addClass("unread");
            Mail.resource.unread_count += 1;
            Mail.displayUnreadCount();
            if (typeof indicator != 'undefined') {
                indicator.removeClass("fa-circle-o msg-read");
                indicator.addClass("fa-circle msg-unread");
                indicator.attr("title", "Mark as Read");
            };
        } else {
            alert(data.message);
        }
    })
}


Mail.loadMessages = function(active_tab, callback){
    var active_tab = (active_tab == null) ? $(".tab-pane.active") : active_tab;
    var active_tab_id = $(active_tab).attr("id");

    /*console.log(active_tab_id);*/

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
            /*console.log(data.data);*/
            Mail.displayMessages(data.data);
        } else {
            Mail.renderEmptyMessagePane();
        }

        if (typeof callback == 'function') {
            /*console.log("making callback...");*/
            callback(data);
        };
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

    $('.msg-action').unbind('click').bind('click', function(event){
        var clicked = $(this);
        if (clicked.hasClass("msg-action-reply")) {
            Mail.replyMail(JSON.parse(clicked.attr("data")));
        } else if (clicked.hasClass("msg-action-forward")) {
            Mail.forwardMail(JSON.parse(clicked.attr("data")));
        } else {
            return;
        }
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


    /*$(".msg-action-reply").unbind('click').bind('click', function(event){
        var msg_data = $(this).attr("data");
        Mail.replyMail(msg_data);
    })

    $(".msg-action-forward").unbind('click').bind('click', function(event) {
        var msg_data = $(this).attr("data");
        Mail.forwardMail(msg_data);
    })*/
}

Mail.alertMessage = function(message, alert_type, display_pane) {
    if (typeof display_pane == 'undefined') {
        var display_pane = $(".tab-pane.active");
    }

    /*console.log(display_pane);*/

    display_pane.prepend(Mail.Template.alertMessage(message, alert_type));
}

Mail.dismissAlerts = function(){
    $("div.alert").remove();
}

Mail.displayModal = function() {
    var modal = $("#myModal");
    modal.modal('show');
}

Mail.dismissModal = function(){
    Mail.clearModal();
    $(".modal-backdrop").trigger('click');
}

Mail.clearModal = function() {
    $("input[name='recipient']").removeAttr("id");
    $("input[name='recipient']").removeAttr("disabled");
    $("input[name='recipient']").val("");
    $("input[name='subject']").val("");
    $("textarea[name='body']").val("");
    /*console.log("clear modal complete!");*/
}