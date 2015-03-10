<?php
class AdmissionController {
    public static function requestAdmission($treatment_id) {
        $admission_model = new AdmissionModel();
        $feedback = $admission_model->requestAdmission($treatment_id);

        return $feedback;
    }

    public static function admissionRequests() {
        $admission_model = new AdmissionModel();
        $feedback = $admission_model->getAdmissionRequests();

        return $feedback;
    }

    public function searchAdmissionRequests($parameter) {
        $admission_model = new AdmissionModel();
        $feedback = $admission_model->searchAdmissionRequests($parameter);

        return $feedback;
    }
}