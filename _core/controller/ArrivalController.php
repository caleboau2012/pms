<?php
class ArrivalController {
    public function searchPatient($parameter){
        $patient_model = new PatientModel();
        $search_result = array();
        $feedback = $patient_model->searchPatient($parameter);

        foreach($feedback as $patient){
            $patient_array = array();
            $patient_array[PatientTable::patient_id] = $patient[PatientTable::patient_id];
            $patient_array['value'] = $patient[PatientTable::surname] . " " . $patient[PatientTable::firstname] . " " . $patient[PatientTable::middlename];
            $patient_array[PatientTable::firstname] = $patient[PatientTable::firstname];
            $patient_array[PatientTable::surname] = $patient[PatientTable::surname];
            $patient_array[PatientTable::middlename] = $patient[PatientTable::middlename];
            $patient_array[PatientTable::regNo] = $patient[PatientTable::regNo];
            $patient_array[PatientTable::sex] = $patient[PatientTable::sex];
            array_push($search_result, $patient_array);
        }

        return $search_result;
    }

    public function getQueue() {
        $arrival = new ArrivalModel();
        return $arrival->getQueue();
    }

    public function getGenQueue() {
        $arrival = new ArrivalModel();
        $feedback = $arrival->getDoctorQueue(GENERAL_QUEUE);

        return $feedback;
    }

    public function getDoctorQueue($doctor_id) {
        $arrival = new ArrivalModel();
        $feedback = $arrival->getDoctorQueue($doctor_id);
        return $feedback;
    }

    public function addPatient($patient, $doctor) {
        $arrival = new ArrivalModel();

        $response = array();
        
        $is_doctor = RoleController::hasRole($doctor, DOCTOR);
        if (!$is_doctor) {
            $response[P_STATUS] = STATUS_ERROR;
            $response[P_MESSAGE] = "Error!!! Invalid doctor!";
            return $response;
        }

        //CHECK IF PATIENT IS NOT ALREADY ON A QUEUE
        if ($arrival->patientOnQueue($patient)) {
            $response[P_STATUS] = STATUS_ERROR;
            $response[P_MESSAGE] = "Error!!! Patient already on queue";
            return $response;
        }

        $arrival_data = array();
        $arrival_data[PatientQueueTable::patient_id] = $patient;
        $arrival_data[PatientQueueTable::doctor_id] = $doctor;

        $feedback = $arrival->add($arrival_data);

        return $feedback;
    }

    public function switchQueue($patient, $to_doctor) {
        //Remove patient from "from_doctor" queue
        $this->removePatient($patient);

        $result = $this->addPatient($patient, $to_doctor);

        return $result;
    }

    public function removePatient($patient) {
        $arrival = new ArrivalModel();
        $feedback = $arrival->remove($patient);
        return $feedback;
    }

    public function changeInQueue($lmt) {
        $arrival = new ArrivalModel();

        $poll_data = array();
        $poll_data[PatientQueueTable::modified_date] = $lmt;

        $feedback = $arrival->changeInQueue($poll_data);
        return $feedback;
    }
}