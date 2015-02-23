<?php
require_once '../../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse'));
Crave::requireFiles(MODEL, array('BaseModel', 'PatientModel', 'ArrivalModel'));
Crave::requireFiles(CONTROLLER, array('ArrivalController'));

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
            echo JsonResponse::error("No patient matches your search request!");
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
} elseif ($intent == 'addToQueue') {
    if (isset($_REQUEST[PatientQueueTable::patient_id], $_REQUEST[PatientQueueTable::doctor_id])) {
        $usher = new ArrivalController();
        $response = $usher->addPatient($_REQUEST[PatientQueueTable::patient_id], $_REQUEST[PatientQueueTable::doctor_id]);

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
} elseif ($intent == 'addToGeneralQueue') {
    if (isset($_REQUEST[PatientQueueTable::patient_id])) {
        $usher = new ArrivalController();
        $response = $usher->addPatientToGeneralQueue($_REQUEST[PatientQueueTable::patient_id]);

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
} elseif ($intent == 'addToDoctor') {
    if (isset($_REQUEST[PatientQueueTable::patient_id]) && isset($_REQUEST[PatientQueueTable::doctor_id])) {
        $usher = new ArrivalController();
        $response = $usher->addToDoctor($_REQUEST[PatientQueueTable::patient_id], $_REQUEST[PatientQueueTable::doctor_id]);

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
} elseif ($intent == 'returnToGenQueue') {
    if (isset($_REQUEST[PatientQueueTable::patient_id])) {
        $usher = new ArrivalController();
        $response = $usher->returnToGenQueue($_REQUEST[PatientQueueTable::patient_id]);

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
}
elseif ($intent == 'removeFromQueue') {
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

        $usher = new ArrivalController();
        $patient = $_REQUEST['patient_id'];
        $to_doctor = $_REQUEST['to_doctor'];
        $from_doctor = $_REQUEST['from_doctor'];

        if ($from_doctor == $to_doctor) {
            echo JsonResponse::error("Origin queue cannot be equal to destination queue!");
            exit();
        }

        //switch patient to doctor queue
        $response = $usher->addToDoctor($patient, $to_doctor);

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