<?php
class CommunicationController {
    public function getInbox($userid, $page) {
        $page = intval($page) - 1;

        $comm_model = new CommunicationModel();
        $messages = $comm_model->getInbox($userid, $page);

        if ($messages) {
            $feedback = array();
            $feedback[INBOX] = $messages;
            $num_messages = sizeof($messages);

            $total_message_count = $comm_model->numberOfMesssages($userid, INBOX_MESSAGE);

            $feedback[MSG_TYPE] = INBOX;
            $feedback[START_INDEX] = ($page * MAIL_PER_PAGE) + 1;
            $feedback[END_INDEX] = $feedback[START_INDEX] + $num_messages - 1;
            $feedback[TOTAL] = $total_message_count[COUNT];
            $feedback[UNREAD_MESSAGE] = $total_message_count[UNREAD_MESSAGE];
            $feedback[CURRENT_PAGE] = $page + 1;

            return $feedback;
        } else {
            return false;
        }
    }

    public function getSent($userid, $page) {
        $page = intval($page) - 1;

        $comm_model = new CommunicationModel();
        $messages = $comm_model->getSent($userid, $page);

        if ($messages) {
            $feedback = array();
            $feedback[SENT] = $messages;
            $num_messages = sizeof($messages);
            $total_message_count = $comm_model->numberOfMesssages($userid, SENT_MESSAGE);

            $feedback[MSG_TYPE] = SENT;
            $feedback[START_INDEX] = ($page * MAIL_PER_PAGE) + 1;
            $feedback[END_INDEX] = $feedback[START_INDEX] + $num_messages - 1;
            $feedback[TOTAL] = $total_message_count[COUNT];
            $feedback[CURRENT_PAGE] = $page + 1;

            return $feedback;
        } else {
            return false;
        }
    }

    public function sendMessage($sender_id, $recipient_id, $msg_subject, $msg_body) {
        $msg_data = array();
        $msg_data[CommunicationTable::sender_id] = $sender_id;
        $msg_data[CommunicationTable::recipient_id] = $recipient_id;
        $msg_data[CommunicationTable::msg_subject] = ($msg_subject == "") ? "(no subject)" : $msg_subject;
        $msg_data[CommunicationTable::msg_body] = $msg_body;

        //die(var_dump($msg_data));

        $comm_model = new CommunicationModel();
        $feedback = $comm_model->sendMessage($msg_data);

        return $feedback;
    }

    public function getMessage($userid, $msg_id) {
        $comm_model = new CommunicationModel();

        $feedback = $comm_model->getMessage($userid, $msg_id);

        return $feedback;
    }

    public function checkNewMessage($userid, $lmt) {
        $comm_model = new CommunicationModel();

        $poll_data = array();
        $poll_data[CommunicationTable::recipient_id] = $userid;
        $poll_data[CommunicationTable::created_date] = $lmt;

        $feedback = $comm_model->checkNewMessage($poll_data);

        return $feedback;
    }

    public function markAsRead($userid, $msg_id) {
        $comm_model = new CommunicationModel();

        $feedback = $comm_model->markAsRead($userid, $msg_id);

        return $feedback;
    }

    public function markAsUnread($userid, $msg_id) {
        $comm_model = new CommunicationModel();

        $feedback = $comm_model->markAsUnread($userid, $msg_id);

        return $feedback;
    }

    public function countUnread() {
        $comm_model = new CommunicationModel();
        $userid = CxSessionHandler::getItem(UserAuthTable::userid);
        $feedback = $comm_model->countUnread($userid);

        return $feedback;
    }
}