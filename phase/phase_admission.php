<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'AdmissionModel', 'RoleModel', 'BedModel', 'WardModel', 'VitalsModel'));
Crave::requireFiles(CONTROLLER, array('AdmissionController', 'RoleController', 'VitalsController', 'WardController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'admitPatient') {
    if (isset($_REQUEST[AdmissionTable::bed_id], $_REQUEST[AdmissionTable::patient_id], $_REQUEST[AdmissionTable::treatment_id])) {
        $admitted_by = CxSessionHandler::getItem(UserAuthTable::userid);
        $comments = isset($_REQUEST[AdmissionTable::comments]) ? $_REQUEST[AdmissionTable::comments] : NULL;

        $warden = new AdmissionController();
        $response = $warden->admitPatient($_REQUEST[AdmissionTable::patient_id], $_REQUEST[AdmissionTable::treatment_id], $admitted_by, $_REQUEST[AdmissionTable::bed_id], $comments);
        if ($response[P_STATUS] == STATUS_OK) {
            echo JsonResponse::message(STATUS_OK, $response[P_MESSAGE]);
            exit();
        } else {
            echo JsonResponse::error($response[P_MESSAGE]);
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'loadWards') {
    $warden = new AdmissionController();
    $response = $warden->loadWards();
    if (is_array($response)) {
        echo JsonResponse::success($response);
        exit();
    } else {
        echo JsonResponse::error("Unable to load wards!");
        exit();
    }
} elseif ($intent == 'loadBeds') {
    if (isset($_REQUEST[BedTable::ward_id])) {
        $warden = new AdmissionController();
        $response = $warden->getWardBeds($_REQUEST[BedTable::ward_id]);
        if (is_array($response)) {
            echo JsonResponse::success($response);
            exit();
        } else {
            echo JsonResponse::error("No beds in this ward!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'searchPatients') {
    if (isset($_REQUEST[TERM])) {
        $warden = new AdmissionController();
        $patient_details = $warden->searchPatients($_REQUEST[TERM]);
        if(sizeof($patient_details) !== 0) {
            echo JsonResponse::success($patient_details);
            exit();
        } else {
            echo JsonResponse::error("No admitted patients match the search parameter!");
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'searchPatientsJQueryUI') {
    if (isset($_REQUEST[TERM])) {
        $warden = new AdmissionController();
        $patient_details = $warden->searchPatients($_REQUEST[TERM]);
        if(sizeof($patient_details) !== 0) {
            echo json_encode($patient_details);
            exit();
        } else {
            $patient_details = array('id' => 'empty');
            echo json_decode($patient_details);
            exit();
//            echo JsonResponse::error("No admitted patients match the search parameter!");
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'getPatients') {
    $response = AdmissionController::getPatients();
    if (is_array($response)) {
        echo JsonResponse::success($response);
        exit();
    } else {
        echo JsonResponse::error("No admitted patients!");
        exit();
    }
} elseif ($intent == 'dischargePatient') {
    if (isset($_REQUEST[AdmissionTable::patient_id])) {
        $patient_id = $_REQUEST[AdmissionTable::patient_id];
        if (!AdmissionController::isAdmitted($patient_id)) {
            echo JsonResponse::error("Cannot discharge a patient that is not admitted!");
            exit();
        }

        $discharged_by = CxSessionHandler::getItem(UserAuthTable::userid);
        $warden = new AdmissionController();
        $response = $warden->dischargePatient($patient_id, $discharged_by);
        if ($response) {
            echo JsonResponse::message(STATUS_OK, "Patient successfully discharged!");
            exit();
        } else {
            echo JsonResponse::error("Unable to discharge patient!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'logEncounter') {
    if (isset($_REQUEST[AdmissionTable::admission_id], $_REQUEST[AdmissionTable::patient_id])) {
        $personnel_id = CxSessionHandler::getItem(UserAuthTable::userid);

        if (isset($_REQUEST[VITALS])) {
            $vitals_data = $_REQUEST[VITALS];
            $valid_vitals = VitalsController::validateVitals($vitals_data);

            if (is_array($valid_vitals)) {
                $vitals_data = $valid_vitals;
            } else {
                echo JsonResponse::error("Invalid vitals data!");
                exit();
            }
        } else {
            $vitals_data = null;
        }

        $warden = new AdmissionController();
        $response = $warden->logEncounter($personnel_id, $_REQUEST[EncounterTable::treatment_id], $_REQUEST[AdmissionTable::patient_id], $_REQUEST[AdmissionTable::admission_id], $vitals_data);
        if ($response) {
            echo JsonResponse::message(STATUS_OK, "Vitals successfully saved!");
            exit();
        } else {
            echo JsonResponse::error($_REQUEST);
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'switchBed') {
    if (isset($_POST[AdmissionBedTable::admission_id], $_POST[AdmissionBedTable::bed_id])) {
        $warden = new AdmissionController();
        $response = $warden->switchBed($_POST[AdmissionBedTable::admission_id], $_POST[AdmissionBedTable::bed_id]);
        if (is_array($response)) {
            echo JsonResponse::error($response[P_MESSAGE]);
            exit();
        } else {
            echo JsonResponse::message(STATUS_OK, "Bed successfully assigned!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} else {
    echo JsonResponse::error("Invalid intent!");
    exit();
}