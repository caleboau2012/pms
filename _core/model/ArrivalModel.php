<?php
class ArrivalModel extends BaseModel {
    public function getOnlineDoctors() {
        $stmt = PatientQueueSqlStatement::ONLINE_DOCTORS;
        $data = array();
        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
    }

    private function getQueueDoctors() {
        //GET ALL ONLINE DOCTORS
        $doctors = $this->getOnlineDoctors();

        //GET RECENTLY OFFLINE DOCTORS WITH PATIENTS ON THEIR QUEUE
        $stmt = PatientQueueSqlStatement::OFFLINE_DOCTORS_WITH_QUEUE;
        $data = array();
        $result = $this->conn->fetchAll($stmt, $data);

        if (is_array($result)) {
            foreach ($result as $row) {
                array_push($doctors, $row);
            }
        }

        return $doctors;
    }

    public function getDoctorQueue($doctor_id) {
        $stmt = PatientQueueSqlStatement::DOCTOR_QUEUE;
        $data = array();
        $data[PatientQueueTable::userid] = $doctor_id;
        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
    }

    public function getQueue() {
        $doctors = $this->getQueueDoctors();

        $num_doctors = sizeof($doctors);

        for ($i=0; $i < $num_doctors; $i++) {
            $doctor_id = $doctors[$i][UserAuthTable::userid];
            $queue = $this->getDoctorQueue($doctor_id);
            $doctors[$i][QUEUE] = $queue;
        }

        $queue = array();
        $queue[LMT] = $this->getLastModifiedTime();
        $queue[QUEUE] = $doctors;

        return $queue;
    }

    public function getLastModifiedTime() {
        $stmt = PatientQueueSqlStatement::GET_LAST_MODIFIED_TIME;
        $data = array();
        $result = $this->conn->fetch($stmt, $data);

        return $result[LMT];
    }
}