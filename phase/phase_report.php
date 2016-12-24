<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'ReportModel'));
Crave::requireFiles(CONTROLLER, array('ReportController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'allPatients') {
    $result = ReportController::allPatients();
    if (is_array($result)) {
        echo JsonResponse::success($result);
        exit();
    } else {
        echo JsonResponse::error("Unable to retrieve report of all patients!");
        exit();
    }
} elseif ($intent == 'newPatients') {
    ReportController::datesIncluded();
    $result = ReportController::newPatients();
    if (is_array($result)) {
        echo JsonResponse::success($result);
        exit();
    } else {
        echo JsonResponse::error("Unable to retrieve new patient report for the specified dates!");
        exit();
    }
} elseif ($intent == 'currentPatients') {
    ReportController::datesIncluded();

    $result = ReportController::currentPatients();
    if (is_array($result)) {
        echo JsonResponse::success($result);
        exit();
    } else {
        echo JsonResponse::error("Unable to retrieve current patient report for the specified dates!");
        exit();
    }
} elseif ($intent == 'patientsAge') {
    ReportController::datesIncluded();

    $result = ReportController::patientsAge();
    if (is_array($result)) {
        echo JsonResponse::success($result);
        exit();
    } else {
        echo JsonResponse::error("Unable to retrieve patient age report for the specified dates!");
        exit();
    }
} elseif ($intent == 'patientVisits') {
    if (!isset($_REQUEST[DAY])) {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }

    $result = ReportController::patientVisits();
    if (is_array($result)) {
        echo JsonResponse::success($result);
        exit();
    } else {
        echo JsonResponse::error("Unable to retrieve patient visitation report for the specified date!");
        exit();
    }
} elseif ($intent == 'inPatients') {
    ReportController::datesIncluded();

    $result = ReportController::inPatients();
    if (is_array($result)) {
        echo JsonResponse::success($result);
        exit();
    } else {
        echo JsonResponse::error("Unable to retrieve in-patient report for the specified dates!");
        exit();
    }
} elseif ($intent == 'consultationReport') {
    ReportController::datesIncluded();

    $result = ReportController::consultationReport();
    if (is_array($result)) {
        echo JsonResponse::success($result);
        exit();
    } else {
        echo JsonResponse::error("Unable to retrieve consultation report for the specified dates!");
        exit();
    }
} elseif ($intent == 'patientDiagnosis') {
    ReportController::datesIncluded();

    $result = ReportController::patientDiagnosis();
    if (is_array($result)) {
        echo JsonResponse::success($result);
        exit();
    } else {
        echo JsonResponse::error("Unable to retrieve patient diagnosis report for the specified dates!");
        exit();
    }
} else {
    echo JsonResponse::error("Invalid request intent!");
    exit();
}