<?php
class ArrivalController {
    public function searchPatient($parameter){
        $patient_model = new PatientModel();
        return $patient_model->searchPatient($parameter);
    }

    public function getQueue() {
        $arrival = new ArrivalModel();
        return $arrival->getQueue();
    }

    public function addPatient($patient, $doctor) {
        $arrival = new ArrivalModel();

        $reponse = array();
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