<?php
class CommunicationModel extends BaseModel {
    public function getInbox($userid, $page) {
        $page = intval($page);

        $stmt = CommunicationSqlStatement::GET_INBOX;
        $stmt = $this->prepareLimitStatement($stmt, $page);
        
        
        $data = array();
        $data[CommunicationTable::recipient_id] = $userid;

        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
    }

    public function getSent($userid, $page) {
        $page = intval($page);

        $stmt = CommunicationSqlStatement::GET_SENT_MESSAGES;
        $stmt = $this->prepareLimitStatement($stmt, $page);
        
        $data = array();
        $data[CommunicationTable::sender_id] = $userid;

        $result = $this->conn->fetchAll($stmt, $data);
        
        return $result;
    }

    public function sendMessage($msg_data) {
        $stmt = CommunicationSqlStatement::SEND_MESSAGE;

        $msg_body = $msg_data[CommunicationTable::msg_body];

        $msg_data[CommunicationTable::msg_body] = strlen($msg_body) > MAX_BODY_LENGTH ? substr($msg_body, 0, MAX_BODY_LENGTH) : $msg_body;

        $begin = $this->conn->beginTransaction();

        if ($begin) {

            $result = $this->conn->execute($stmt, $msg_data);

            
            if ($result) {
                $last_id = $this->conn->getLastInsertedId();
                $writer = $this->writeMessageToFile($msg_body, $last_id);

                if ($writer) {    
                    $this->conn->commit();
                    return true;
                } else {    
                    $this->conn->rollBack();
                    return false;
                }
            } else {
                $this->conn->rollBack();
            }
        }
        
        return false;
    }

    public function getMessage($userid, $msg_id) {
        $msg_type = $this->getMessageType($msg_id, $userid);
        
        if ($msg_type == INBOX_MESSAGE) {
            $stmt = CommunicationSqlStatement::GET_INBOX_MESSAGE;

            $data = array();
            $data[CommunicationTable::msg_id] = $msg_id;
            $data[CommunicationTable::recipient_id] = $userid;
        } elseif ($msg_type == SENT_MESSAGE) {
            $stmt = CommunicationSqlStatement::GET_SENT_MESSAGE;

            $data = array();
            $data[CommunicationTable::msg_id] = $msg_id;
            $data[CommunicationTable::sender_id] = $userid;
        } else {
            return false;
        }

        $result = $this->conn->fetch($stmt, $data);
        $result[MSG_TYPE] = $msg_type;
        $result[CommunicationTable::msg_body] = $this->getMessageBody($msg_id);

        if ($msg_type == INBOX_MESSAGE) {
            $this->markAsRead($userid, $msg_id);
        }

        return $result;
    }

    public function markAsRead($userid, $msg_id) {
        $data = array();
        $data[CommunicationTable::msg_id] = $msg_id;
        $data[CommunicationTable::recipient_id] = $userid;

        $msg_status = $this->checkMessageStatus($data);

        if ($msg_status == READ) {
            return true;
        }
        
        $stmt = CommunicationSqlStatement::MARK_AS_READ;
        

        $result = $this->conn->execute($stmt, $data, true);
        return $result;
    }

    public function markAsUnread($userid, $msg_id) {
        $data = array();
        $data[CommunicationTable::msg_id] = $msg_id;
        $data[CommunicationTable::recipient_id] = $userid;

        $msg_status = $this->checkMessageStatus($data);

        if ($msg_status == UNREAD) {
            return true;
        }

        $stmt = CommunicationSqlStatement::MARK_AS_UNREAD;

        $result = $this->conn->execute($stmt, $data, true);

        return $result;
    }

    private function checkMessageStatus($msg_data) {
        $stmt = CommunicationSqlStatement::CHECK_MSG_STATUS;

        $result = $this->conn->fetch($stmt, $msg_data);

        return isset($result[CommunicationTable::msg_status]) ? $result[CommunicationTable::msg_status] : false;
    }

    public function checkNewMessage($poll_data) {
        $stmt = CommunicationSqlStatement::CHECK_NEW_MESSAGE;

        $result = $this->conn->fetch($stmt, $poll_data);

        return $result[COUNT] > 0 ? true : false;
    }

    private function getMessageType($msg_id, $userid) {
        // CHECK FOR INBOX MESSAGE
        $stmt = CommunicationSqlStatement::CHECK_INBOX_MESSAGE;
        
        $data = array();
        $data[CommunicationTable::msg_id] = $msg_id;
        $data[CommunicationTable::recipient_id] = $userid;

        $result = $this->conn->fetch($stmt, $data);

        if ($result[COUNT] > 0) {
            return INBOX_MESSAGE;
        }


        // CHECK FOR SENT MESSAGE
        $stmt = CommunicationSqlStatement::CHECK_SENT_MESSAGE;

        $data = array();
        $data[CommunicationTable::msg_id] = $msg_id;
        $data[CommunicationTable::sender_id] = $userid;

        $result = $this->conn->fetch($stmt, $data);

        if ($result[COUNT] > 0) {
            return SENT_MESSAGE;
        } else {
            return false;
        }
    }

    private function writeMessageToFile($msg_body, $msg_id) {
        $path_arr = explode(PROJECT_NAME, __DIR__);
        $project_root = $path_arr[0] . PROJECT_NAME;

        $message_log_folder = $project_root . '/_resource/communication_logs/';

        $message_file_path = $message_log_folder . strval($msg_id) . '.msg';

        $write = file_put_contents($message_file_path, $msg_body);

        return ($write) ? true : false;
    }

    private function getMessageBody($msg_id) {
        $path_arr = explode(PROJECT_NAME, __DIR__);
        $project_root = $path_arr[0] . PROJECT_NAME;

        $message_log_folder = $project_root . '/_resource/communication_logs/';

        $message_file_path = $message_log_folder . strval($msg_id) . '.msg';

        $body = file_get_contents($message_file_path);

        return $body;
    }

    private function prepareLimitStatement($stmt, $page) {
        $offset = strval(intval($page) * intval(MAIL_PER_PAGE));
        $records = strval(intval(MAIL_PER_PAGE));

        $stmt = str_replace("@offset", $offset, $stmt);
        $stmt = str_replace("@count", $records, $stmt);

        return $stmt;
    }

    public function numberOfMesssages($userid, $msg_type) {
        if ($msg_type == INBOX_MESSAGE) {
            $stmt = CommunicationSqlStatement::COUNT_INBOX;
            
            $data = array();
            $data[CommunicationTable::recipient_id] = $userid;
        } elseif ($msg_type == SENT_MESSAGE) {
            $stmt = CommunicationSqlStatement::COUNT_SENT;

            $data = array();
            $data[CommunicationTable::sender_id] = $userid;
        } else {
            return false;
        }

        $result = $this->conn->fetch($stmt, $data);

        return $result;

    }
}