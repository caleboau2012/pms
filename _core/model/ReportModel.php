<?php
class ReportModel extends BaseModel {
    public static function newPatients($gender) {
        $data = array(
            START_DATE  =>  $_REQUEST[START_DATE],
            END_DATE    =>  $_REQUEST[END_DATE]
        );
        if ($gender == NULL) {
            $stmt = ReportSqlStatement::NEW_PATIENTS;
        } else {
            $stmt = ReportSqlStatement::NEW_PATIENTS_WITH_GENDER;
            $data[GENDER] = $gender;
        }

        $model = new ReportModel();

        $result = $model->conn->fetchAll($stmt, $data);
        return $result;
    }

    public static function currentPatients($gender) {
        $data = array(
            START_DATE  =>  $_REQUEST[START_DATE],
            END_DATE    =>  $_REQUEST[END_DATE]
        );
        if ($gender == NULL) {
            $stmt = ReportSqlStatement::CURRENT_PATIENTS;
        } else {
            $stmt = ReportSqlStatement::CURRENT_PATIENTS_WITH_GENDER;
            $data[GENDER] = $gender;
        }

        $model = new ReportModel();

        $result = $model->conn->fetchAll($stmt, $data);
        return $result;
    }

    public static function patientsAge() {
        $stmt = ReportSqlStatement::PATIENTS_AND_AGE_GRAPH;
        $data = array(
            START_DATE  =>  $_REQUEST[START_DATE],
            END_DATE    =>  $_REQUEST[END_DATE]
        );

        $model = new ReportModel();

        $result = $model->conn->fetchAll($stmt, $data);
        return $result;
    }

    public static function patientVisits() {
        $stmt = ReportSqlStatement::PATIENTS_VISIT_PER_DAY;
        $data = array(
            DAY =>  $_REQUEST[DAY]
        );

        $model = new ReportModel();

        $result = $model->conn->fetchAll($stmt, $data);
        return $result;
    }

    public static function inPatients() {
        $stmt = ReportSqlStatement::INPATIENTS;
        $data = array(
            START_DATE  =>  $_REQUEST[START_DATE],
            END_DATE    =>  $_REQUEST[END_DATE]
        );

        $model = new ReportModel();

        $result = $model->conn->fetchAll($stmt, $data);
        return $result;
    }

    public static function consultationReport() {
        $stmt = ReportSqlStatement::CONSULTATIONS;
        $data = array(
            START_DATE  =>  $_REQUEST[START_DATE],
            END_DATE    =>  $_REQUEST[END_DATE]
        );

        $model = new ReportModel();

        $result = $model->conn->fetchAll($stmt, $data);
        return $result;
    }

    public static function patientDiagnosis() {
        $data = array(
            START_DATE  =>  $_REQUEST[START_DATE],
            END_DATE    =>  $_REQUEST[END_DATE]
        );

        if ($gender == NULL) {
            $stmt = ReportSqlStatement::PATIENT_AGAINST_DIAGNOSIS;
        } else {
            $stmt = ReportSqlStatement::PATIENT_SEX_AGAINST_DIAGNOSIS;
            $data[GENDER] = $gender;
        }

        $model = new ReportModel();

        $result = $model->conn->fetchAll($stmt, $data);
        return $result;
    }
}