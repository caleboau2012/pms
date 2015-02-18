<?php
class CommunicationController {
    public function getInbox($userid) {
        $comm_model = new CommunicationModel();
        $feedback = $comm_model->getInbox($userid);
        
        if ($feedback) {
            return $feedback;
        } else {
            return false;
        }
    }

    public function getSent($userid) {
        $comm_model = new CommunicationModel();
        $feedback = $comm_model->getSent($userid);

        if ($feedback) {
            return $feedback;
        } else {
            return false;
        }
    }

    public function sendMessage($sender_id, $recipient_id, $msg_subject, $msg_body) {
        $msg_data = array();
        $msg_data[CommunicationTable::sender_id] = $sender_id;
        $msg_data[CommunicationTable::recipient_id] = $recipient_id;
        $msg_data[CommunicationTable::msg_subject] = $msg_subject;
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
}