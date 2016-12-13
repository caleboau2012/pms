<?php
require_once '../../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse', 'CxSessionHandler'));
Crave::requireFiles(MODEL, array('BaseModel', 'PatientModel', 'ArrivalModel', 'RoleModel'));
Crave::requireFiles(CONTROLLER, array('ArrivalController', 'RoleController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'search') {
    //Search and retrieve patient details
    if (isset($_REQUEST['term'])) {
        $usher = new ArrivalController();
        $patient_details = $usher->searchPatient($_REQUEST['term']);
        if (is_array($patient_details)) {
            echo json_encode($patient_details);
            exit();
        } else {
            $patient_details = array('id' => 'empty');
            echo json_encode($patient_details);
//            echo JsonResponse::error("No patient matches your search request!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'loadQueue') {
    //Load patient queue
    $usher = new ArrivalController();
    $queue = $usher->getQueue();
    if (is_array($queue)) {
        echo JsonResponse::success($queue);
        exit();
    } else {
        echo JsonResponse::error("Queue is empty!");
        exit();
    }
} elseif ($intent == 'loadGenQueue') {
    //Load general queue
    $usher = new ArrivalController();
    $queue = $usher->getGenQueue();
    if (is_array($queue)) {
        echo JsonResponse::success($queue);
        exit();
    } else {
        echo JsonResponse::error("Queue is empty!");
        exit();
    }
} elseif ($intent == 'loadDoctorQueue') {
    $doctor_id = CxSessionHandler::getItem(UserAuthTable::userid);
    $is_doctor = RoleController::hasRole($doctor_id, DOCTOR);
    if ($is_doctor) {
        $usher = new ArrivalController();
        $response = $usher->getDoctorQueue($doctor_id);
        if (is_array($response)) {
            echo JsonResponse::success($response);
            exit();
        } else {
            echo JsonResponse::error("Doctorr queue is empty!");
            exit();
        }
    } else {
        echo JsonResponse::error("Logged in user is not a doctor!");
        exit();
    }
} elseif ($intent == 'addToQueue') {
    if (isset($_REQUEST[PatientQueueTable::patient_id])) {
        $usher = new ArrivalController();

        $patient_id = $_REQUEST[PatientQueueTable::patient_id];
        $doctor_id = (isset($_REQUEST[PatientQueueTable::doctor_id])) ? $_REQUEST[PatientQueueTable::doctor_id] : GENERAL_QUEUE;

        $response = $usher->addPatient($patient_id, $doctor_id);

        if (is_array($response)) {
            echo JsonResponse::error($response[P_MESSAGE]);
            exit();
        } else {
            echo ($response) ? JsonResponse::message(STATUS_OK, "Patient succesfully added to queue!") : JsonResponse::error("Error adding patient to queue!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'removeFromQueue') {
    if (isset($_REQUEST[PatientQueueTable::patient_id])) {
        $usher = new ArrivalController();
        $response = $usher->removePatient($_REQUEST[PatientQueueTable::patient_id]);

        if ($response) {
            echo JsonResponse::success("Patient succesfully removed from queue!");
            exit();
        } else {
            echo JsonResponse::error("Error removing patient from queue!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'switchQueue') {
    if (isset($_REQUEST['patient_id'], $_REQUEST['to_doctor'], $_REQUEST['from_doctor'])) {

        // die(var_dump($_REQUEST));
        $usher = new ArrivalController();
        $patient = $_REQUEST['patient_id'];
        $to_doctor = empty($_REQUEST['to_doctor']) ? GENERAL_QUEUE : $_REQUEST['to_doctor'];

        //switch patient to doctor queue
        $response = $usher->switchQueue($patient, $to_doctor);

        if (is_array($response)) {
            echo JsonResponse::error($response[P_MESSAGE]);
            exit();
        } else {
            echo ($response) ? JsonResponse::message(STATUS_OK, "Patient succesfully switched!") : JsonResponse::error("Error adding patient to queue!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'pollQueue') {
    if (isset($_REQUEST[LMT])) {
        $lmt = $_REQUEST[LMT];
        $usher = new ArrivalController();
        $change = false;
        for ($i=0; $i < MAX_NUM_POLL; $i++) {
            $change = $usher->changeInQueue($lmt);
            if ($change) {
                echo JsonResponse::message(STATUS_OK, "Patient queue modified!");
                exit();
            }
            sleep(POLLING_SLEEP_TIME);
            $i += 1;
        }
        if ($usher->changeInQueue($lmt)) {
            echo JsonResponse::message(STATUS_OK, "Patient queue modified!");
            exit();
        } else {
            echo JsonResponse::error("No change in queue!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} else {
    echo JsonResponse::error("Invalid intent");
    exit();
}