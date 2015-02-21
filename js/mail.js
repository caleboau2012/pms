var Mail = {};

Mail.resource = {
    URL : {
        communication : "phase/phase_communication.php"
    },
    current_page : 1,

    getCurrentPage: function(){
        return Mail.resource.current_page;
    }
}

Mail.Template = {
    messageElement : function(msg){
        msg_status = (msg.msg_status == 1) ? "unread" : "";
        console.log(msg_status);
        var html = "<tr id='" + msg.msg_id + "' class= '" + msg_status + "'>\
            <td class='msg_name truncate'>" + msg.name + "</td>\
            <td class='msg_message truncate'>" + msg.msg_subject + ' - ' + msg.msg_body + "</td>\
            <td class='msg_date truncate'>" + msg.created_date + "</td>\
        </tr>";

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

    console.log(payload);

    Mail.serverReq(Mail.resource.URL.communication, payload, function(data){
        if (data.status == 1) {
            console.log(data.data);
            Mail.displayMessages(data.data);
        } else {
            Mail.renderEmptyMessagePane();
        }
    })
}

Mail.displayMessages = function(data, active_tab) {
    var active_tab = (active_tab == null) ? $(".tab-pane.active") : active_tab;
    console.log(data, active_tab.attr("id"));

    var start_index = data.start_index;
    var end_index = data.end_index;
    var total = data.total;
    var page = data.current_page;

    Mail.setMailNavigation(active_tab, start_index, end_index, total, page);

    var message_list = active_tab.find("table.message_list > tbody");
    message_list.html("");
    
    var msg_type = data.msg_type;
    
    $(data[msg_type]).each(function(index, value){
        console.log(value);
        value.name = value.surname + " " + value.firstname + " " + value.middlename;
        message_list.append(Mail.Template.messageElement(value));
    })
}

Mail.setMailNavigation = function(active_tab, start_index, end_index, total, page) {
    Mail.resource.current_page = page;
    console.log(page);

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

