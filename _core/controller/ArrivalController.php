<?php
class ArrivalController {
    public function searchPatient($parameter){
        $patient_model = new PatientModel();
        return $patient_model->searchPatient($parameter);
    }
}