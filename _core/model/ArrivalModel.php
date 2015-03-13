<?php
class ArrivalModel extends BaseModel {
    public function add($arrival_data) {
        $stmt = PatientQueueSqlStatement::ADD;
        $result = $this->conn->execute($stmt, $arrival_data, true);

        return $result;
    }

    public function addToGenQueue($arrival_data) {
        $stmt = PatientQueueSqlStatement::ADDTOGENERALQUEUE;
        $result = $this->conn->execute($stmt, $arrival_data, true);

        return $result;
    }

    public function addToDoctor($arrival_data) {
        $stmt = PatientQueueSqlStatement::ADDTODOCTOR;
        $result = $this->conn->execute($stmt, $arrival_data, true);

        return $result;
    }

    public function returnToGenQueue($patient) {
        $stmt = PatientQueueSqlStatement::RETURNTOGENERALQUEUE;
        $data = array();
        $data[PatientQueueTable::patient_id] = $patient;

        $result = $this->conn->execute($stmt, $data);
        return $result;
    }

    public function remove($patient) {
        $stmt = PatientQueueSqlStatement::REMOVE;
        $data = array();
        $data[PatientQueueTable::patient_id] = $patient;

        $result = $this->conn->execute($stmt, $data);
        return $result;
    }

    public function patientOnQueue($patient_id) {
        $stmt = PatientQueueSqlStatement::PATIENT_ON_QUEUE;
        $data = array();
        $data[PatientQueueTable::patient_id] = $patient_id;

        $result = $this->conn->fetch($stmt, $data);
        return $result[COUNT] > 0 ? true : false;
    }

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
        $data[PatientQueueTable::doctor_id] = $doctor_id;
        $result = $this->conn->fetchAll($stmt, $data);

        return (sizeof($result) > 0) ? $result : false;
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

    public function getGenQueue() {
        $stmt = PatientQueueSqlStatement::GENERAL_QUEUE;
        $data = array();
        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
    }

    public function getLastModifiedTime() {
        $stmt = PatientQueueSqlStatement::GET_LAST_MODIFIED_TIME;
        $data = array();
        $result = $this->conn->fetch($stmt, $data);

        return $result[LMT];
    }

    public function changeInQueue($poll_data) {
        $stmt = PatientQueueSqlStatement::CHANGE_IN_QUEUE;
        $result = $this->conn->fetch($stmt, $poll_data);

        return $result[COUNT] > 0 ? true : false;
    }
}