<?php
class ReportController {
    public static function allPatients() {
        return ReportModel::allPatients(ReportController::getGender());
    }

    public static function newPatients() {
        return ReportModel::newPatients(ReportController::getGender());
    }

    public static function currentPatients() {
        return ReportModel::currentPatients(ReportController::getGender());
    }

    public static function patientsAge() {
        return ReportModel::patientsAge();
    }

    public static function patientVisits() {
        return ReportModel::patientVisits();
    }

    public static function inPatients() {
        return ReportModel::inPatients();
    }

    public static function consultationReport() {
        return ReportModel::consultationReport();
    }

    public static function patientDiagnosis() {
        return ReportModel::patientDiagnosis(ReportController::getGender());
    }

    public static function datesIncluded() {
        if (!isset($_REQUEST[START_DATE], $_REQUEST[END_DATE])) {
            echo JsonResponse::error("Incomplete request parameters!");
            exit();
        }
    }

    public static function getGender() {
        $gender = NULL;
        if (isset($_REQUEST[GENDER])) {
            if ($_REQUEST[GENDER] == GENDER_MALE) {
                $gender = GENDER_MALE;
            } elseif ($_REQUEST[GENDER] == GENDER_FEMALE) {
                $gender = GENDER_FEMALE;
            }
        }

        return $gender;
    }
}