<?php

require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse', 'CxSessionHandler'));
Crave::requireFiles(MODEL, array('BaseModel', 'CommunicationModel'));
Crave::requireFiles(CONTROLLER, array('CommunicationController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'getInbox') {
    if (isset($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
    } else {
        $page = 1;
    }

    /*$userid = CxSessionHandler::getItem(UserAuthTable::userid);*/
    $userid = 2;
    $announcer = new CommunicationController();
    $response = $announcer->getInbox($userid, $page);
    if (is_array($response)) {
        echo JsonResponse::success($response);
        exit();
    } else {
        echo JsonResponse::error("No messages to display on this page!");
        exit();
    }
} elseif ($intent == 'getSent') {
    if (isset($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
    } else {
        $page = 1;
    }

    /*$userid = CxSessionHandler::getItem(UserAuthTable::userid);*/
    $userid = 1;
    $announcer = new CommunicationController();
    $response = $announcer->getSent($userid, $page);

    if (is_array($response)) {
        echo JsonResponse::success($response);
        exit();
    } else {
        echo JsonResponse::error("No messages to display on this page!");
        exit();
    }
} elseif ($intent == 'sendMessage') {
    if (isset($_REQUEST[CommunicationTable::recipient_id], $_REQUEST[CommunicationTable::msg_subject], $_REQUEST[CommunicationTable::msg_body])) {
        $sender_id = intval(CxSessionHandler::getItem(UserAuthTable::userid));
        $recipient_id = intval($_REQUEST[CommunicationTable::recipient_id]);
        $msg_subject = $_REQUEST[CommunicationTable::msg_subject];
        $msg_body = $_REQUEST[CommunicationTable::msg_body];
        
        $announcer = new CommunicationController();
        $response = $announcer->sendMessage($sender_id, $recipient_id, $msg_subject, $msg_body);
        if ($response) {
            echo JsonResponse::message(STATUS_OK, "Message sent!");
            exit();
        } else {
            echo JsonResponse::error("Unable to send message!");
            exit();
        } 
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'getMessage') {
    if (isset($_REQUEST[CommunicationTable::msg_id])) {
        $userid = CxSessionHandler::getItem(UserAuthTable::userid);

        $announcer = new CommunicationController();
        $response = $announcer->getMessage($userid, $_REQUEST[CommunicationTable::msg_id]);
        if (is_array($response)) {
            echo JsonResponse::success($response);
            exit();
        } else {
            echo JsonResponse::error("Unable to get message details!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters");
        exit();
    }
} elseif ($intent == 'pollInbox') {
    if (isset($_REQUEST[LMT])) {
        $lmt = $_REQUEST[LMT];
        /*$userid = CxSessionHandler::getItem(UserAuthTable::userid);*/
        $userid = 2;
        
        $announcer = new CommunicationController();
        
        $change = false;
        for ($i=0; $i < MAX_NUM_POLL; $i++) { 
            $change = $announcer->checkNewMessage($userid, $lmt);
            if ($change) {
                echo JsonResponse::message(STATUS_OK, "New inbox message!");
                exit();
            }
            sleep(POLLING_SLEEP_TIME);
            $i += 1;
        }
        if ($announcer->checkNewMessage($userid, $lmt)) {
            echo JsonResponse::message(STATUS_OK, "New inbox message!");
            exit();
        } else {
            echo JsonResponse::error("No new inbox message!");
            exit();
        }
    } else {
        echo JsonResponse::error('Incomplete request parameters!');
        exit();
    }
} elseif ($intent == 'markAsRead') {
    if (isset($_REQUEST[CommunicationTable::msg_id])) {
        $userid = CxSessionHandler::getItem(UserAuthTable::userid);
        /*$userid = 2;*/

        $announcer = new CommunicationController();
        $response = $announcer->markAsRead($userid, $_REQUEST[CommunicationTable::msg_id]);
        if ($response) {
            echo JsonResponse::message(STATUS_OK, "Successfully marked as read!");
            exit();
        } else {
            echo JsonResponse::error("Unable to mark message as read!");
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'markAsUnread') {
    if (isset($_REQUEST[CommunicationTable::msg_id])) {
        /*$userid = CxSessionHandler::getItem(UserAuthTable::userid);*/
        $userid = 2;

        $announcer = new CommunicationController();
        $response = $announcer->markAsUnread($userid, $_REQUEST[CommunicationTable::msg_id]);

        if ($response) {
            echo JsonResponse::message(STATUS_OK, "Successfully marked as unread!");
            exit();
        } else {
            echo JsonResponse::error("Unable to mark message as unread!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} else {
    echo JsonResponse::error("Invalid intent!");
    exit();
}