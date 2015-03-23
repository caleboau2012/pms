<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ODUGUWA A
 * Date: 3/17/15
 * Time: 2:36 PM
 * To change this template use File | Settings | File Templates.
 */

require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse', 'CxSessionHandler'));
Crave::requireFiles(MODEL, array('BaseModel', 'TreatmentModel'));
Crave::requireFiles(CONTROLLER, array('TreatmentController'));


if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'getPatientQueue') {

    $treat = new TreatmentController();

    if (isset($_REQUEST['doctorid'])){
        $doctor_id = $_REQUEST['doctorid'];
    }
    else{
        echo JsonResponse::error("Doctor_id not Set");
        exit();
    }
    $patient_queue =$treat->getPatientQueue($doctor_id);

    if(is_array($patient_queue)){
        echo JsonResponse::success($patient_queue);
        exit();
    } else {
        echo JsonResponse::error("Could not Find any Patient queue. Please try again!");
        exit();
    }
}

elseif ($intent == 'getInpatientQueue') {

    $treat = new TreatmentController();
    $inpatient_queue = $treat->getInpatientQueue();

    if(is_array($inpatient_queue)){
        echo JsonResponse::success($inpatient_queue);
        exit();
    } else {
        echo JsonResponse::error("Could not Find any In Patient queue. Please try again!");
        exit();
    }

}

elseif ($intent == 'getAdmittedPatientQueue') {

    $treat = new TreatmentController();
    $adpatient_queue = $treat->getAdmittedPatientQueue();

    if(is_array($adpatient_queue)){
        echo JsonResponse::success($adpatient_queue);
        exit();
    } else {
        echo JsonResponse::error("Could not Find any adPatient queue. Please try again!");
        exit();
    }

}

elseif  ($intent == 'requestAdmission') {

    if (isset($_REQUEST['treatment_id'])){
        $treatment_id = $_REQUEST['treatment_id'];
    }
    else{
        echo JsonResponse::error("treatment_id not Set");
        exit();
    }

    $treat = new TreatmentController();
    $request_adm = $treat->requestAdmission($treatment_id);

    if(is_array($request_adm)){
        echo JsonResponse::success($request_adm);
        exit();
    } else {
        echo JsonResponse::error("Could not admission. Please try again!");
        exit();
    }


}

elseif  ($intent == 'addTreatment1') {

    $treat = new TreatmentController();

    $doctorid ="";
    $patientid ="";
//    $consultation ="";
//    $symptoms ="";
//    $comments= "";
//    $diagnosis ="";
    //    $diagnosis ="";



    if (isset($_REQUEST['doctor_id']) && isset($_REQUEST['patient_id'])){  // change surname to what you thin should be set.

        // var_dump($_REQUEST);

        $doctorid =$_REQUEST[TreatmentTable::doctor_id];
        $patientid =$_REQUEST[TreatmentTable::patient_id];
       // $consultation =$_REQUEST[TreatmentTable::consultation];
       // $symptoms =$_REQUEST[TreatmentTable::symptoms];
       // $comments= $_REQUEST[TreatmentTable::comments];
       // $diagnosis =$_REQUEST[TreatmentTable::diagnosis];

    }
    else {
        echo JsonResponse::error("things are not set");
        exit();
    }

    $admission_add = null;

    if (empty($doctorId) || empty ($patientId) ){

        print_r($_REQUEST);
        echo JsonResponse::error("Some fields are not filled, Ensure All fields are filled");
        exit();
    }
    else{

        $newaddm = new TreatmentController();
        $admission_add = $newaddm->addTreatment1($doctorId, $patientId);
    }


    if($admission_add){
        echo JsonResponse::success($admission_add);
        exit();
    } else {
//        print_r($_REQUEST);
        echo JsonResponse::error("Error addmitting patient");
        exit();
    }


}

elseif  ($intent == 'addTreatment2') {

    $treat = new TreatmentController();

    $doctorid ="";
    $patientid ="";
    $consultation ="";
    $symptoms ="";
    $comments= "";
    $diagnosis ="";



    if (isset($_REQUEST['doctor_id']) && isset($_REQUEST['patient_id'])){  // change surname to what you thin should be set.

        // var_dump($_REQUEST);

        $doctorid =$_REQUEST[TreatmentTable::doctor_id];
        $patientid =$_REQUEST[TreatmentTable::patient_id];
        $consultation =$_REQUEST[TreatmentTable::consultation];
        $symptoms =$_REQUEST[TreatmentTable::symptoms];
        $comments= $_REQUEST[TreatmentTable::comments];
        $diagnosis =$_REQUEST[TreatmentTable::diagnosis];

    }
    else {
        echo JsonResponse::error("things are not set");
        exit();
    }

    $admission_add = null;

    if (empty($doctorId) || empty ($patientId) || empty ($consultation) || empty ($symptoms) || empty ($diagnosis) || empty ($comments)){

        print_r($_REQUEST);
        echo JsonResponse::error("Some fields are not filled, Ensure All fields are filled");
        exit();
    }
    else{

        $newaddm = new TreatmentController();
        $admission_add = $newaddm->addTreatment($doctorId, $patientId, $consultation, $symptoms, $diagnosis, $comments);
    }


    if($admission_add){
        echo JsonResponse::success($admission_add);
        exit();
    } else {
//        print_r($_REQUEST);
        echo JsonResponse::error("Error addmitting patient");
        exit();
    }


}


elseif  ($intent == 'getTreatmentHistory') {

    if (isset($_REQUEST['patient_id'])){
        $patientid_id = $_REQUEST['patient_id'];
    }
    else{
        echo JsonResponse::error("patient_id not Set");
        exit();
    }

    $treat = new TreatmentController();
    $request_adm = $treat->getTreatmentHistory($patientid_id);

    if(is_array($request_adm)){
        echo JsonResponse::success($request_adm);
        exit();
    } else {
        echo JsonResponse::error("Could not get history. Please try again!");
        exit();
    }
}

elseif  ($intent == 'requestLabTest') {

    $treat = new TreatmentController();

    $treatmentId ="";
    $patientid ="";
    $doctorId ="";
    $labTestType ="";
    $comment= "";

    if (isset($_REQUEST['treatment_id']) && isset($_REQUEST['patient_id'])){  // change surname to what you thin should be set.

        // var_dump($_REQUEST);

        $doctorid =$_REQUEST[TreatmentTable::doctor_id];
        $treatmentId =$_REQUEST[TreatmentTable::treatment_id];
        $patientid =$_REQUEST[TreatmentTable::patient_id];
        $doctorId =$_REQUEST[TreatmentTable::doctor_id];
        $labTestType = $_REQUEST['test_id'];  // no tbale for this variable.
        $comment= $_REQUEST[TreamentTable::comments];
    }
    else {
        echo JsonResponse::error("things are not set");
        exit();
    }

    $admission_add = null;

    if (empty($treatmentId) || empty ($patientId) || empty ($doctorId) || empty ($labTestType) || empty ($comments)){

        print_r($_REQUEST);
        echo JsonResponse::error("Some fields are not filled, Ensure All fields are filled");
        exit();
    }
    else{

        $newaddm = new TreatmentController();
        $admission_add = $newaddm->addTreatment($doctorId, $treatmentId, $labTestType, $comment);
    }

    if($admission_add){
        echo JsonResponse::success($admission_add);
        exit();
    } else {
//        print_r($_REQUEST);
        echo JsonResponse::error("Error requesting lab test");
        exit();
    }


}

elseif  ($intent == 'logEncounter') {
    $treat = new TreatmentController();


    $doctorId ="";
    $patientId="";
    $admissionId="";
    $comments="";



    if (/*isset($_REQUEST['admissionId']) &&*/ isset($_REQUEST['patient_id'])){  // change surname to what you thin should be set.

        // var_dump($_REQUEST);

        $doctorId =$_REQUEST[TreatmentTable::doctor_id];
        $patientId=$_REQUEST[TreatmentTable::patient_id];
        $admissionId=$_REQUEST[AdmissionTable::admission_id];
        $comments=$_REQUEST[TreatmentTable::comments];

    }
    else {
        echo JsonResponse::error("things are not set");
        exit();
    }

    $admission_add = null;

    if (empty($doctorId) || empty ($patientId) || empty ($admissionId) || empty ($comments)){


        //print_r($_REQUEST);
        echo JsonResponse::error("Some fields are not filled, Ensure All fields are filled");
        exit();
    }
    else{

        $newaddm = new TreatmentController();
        $admission_add = $newaddm->logEncounter($doctorId, $patientId , $admissionId, $comments);
    }

    if($admission_add){
        echo JsonResponse::success($admission_add);
        exit();
    } else {
//        print_r($_REQUEST);
        echo JsonResponse::error("Error logging Encounter");
        exit();
    }


}

elseif  ($intent == 'getEncounterHistory') {

        if (isset($_REQUEST['admission_id'])){
            $admissionId = $_REQUEST['admission_id'];
        }
        else{
            echo JsonResponse::error("patient_id not Set");
            exit();
        }

        $treat = new TreatmentController();
        $request_adm = $treat->getTreatmentHistory($admissionId);

        if(is_array($request_adm)){
            echo JsonResponse::success($request_adm);
            exit();
        } else {
            echo JsonResponse::error("Could not get history. Please try again!");
            exit();
        }
    }


elseif  ($intent == 'searchPatient') {

    $treat = new TreatmentController();

    $treatmentId ="";
    $patientid ="";
    $doctorId ="";
    $labTestType ="";
    $comment= "";

    if (isset($_REQUEST['treatment_id']) && isset($_REQUEST['patient_id'])){  // change surname to what you thin should be set.

        // var_dump($_REQUEST);

        $doctorid =$_REQUEST[TreatmentTable::doctor_id];
        $treatmentId =$_REQUEST[TreatmentTable::treatment_id];
        $patientid =$_REQUEST[TreatmentTable::patient_id];
        $doctorId =$_REQUEST[TreatmentTable::doctor_id];
        $labTestType = $_REQUEST['test_id'];  // no tbale for this variable.
        $comment= $_REQUEST[TreamentTable::comments];
    }
    else {
        echo JsonResponse::error("things are not set");
        exit();
    }

    $admission_add = null;

    if (empty($treatmentId) || empty ($patientId) || empty ($doctorId) || empty ($labTestType) || empty ($comments)){

        print_r($_REQUEST);
        echo JsonResponse::error("Some fields are not filled, Ensure All fields are filled");
        exit();
    }
    else{

        $newaddm = new TreatmentController();
        $admission_add = $newaddm->addTreatment($doctorId, $treatmentId, $labTestType, $comment);
    }

    if($admission_add){
        echo JsonResponse::success($admission_add);
        exit();
    } else {
//        print_r($_REQUEST);
        echo JsonResponse::error("Error requesting lab test");
        exit();
    }


}
elseif  ($intent == 'getLabHistory') {

    $treat = new TreatmentController();

    $treatmentId ="";
    $patientid ="";
    $doctorId ="";
    $labTestType ="";
    $comment= "";

    if (isset($_REQUEST['treatment_id']) && isset($_REQUEST['patient_id'])){  // change surname to what you thin should be set.

        // var_dump($_REQUEST);

        $doctorid =$_REQUEST[TreatmentTable::doctor_id];
        $treatmentId =$_REQUEST[TreatmentTable::treatment_id];
        $patientid =$_REQUEST[TreatmentTable::patient_id];
        $doctorId =$_REQUEST[TreatmentTable::doctor_id];
        $labTestType = $_REQUEST['test_id'];  // no tbale for this variable.
        $comment= $_REQUEST[TreamentTable::comments];
    }
    else {
        echo JsonResponse::error("things are not set");
        exit();
    }

    $admission_add = null;

    if (empty($treatmentId) || empty ($patientId) || empty ($doctorId) || empty ($labTestType) || empty ($comments)){

        print_r($_REQUEST);
        echo JsonResponse::error("Some fields are not filled, Ensure All fields are filled");
        exit();
    }
    else{

        $newaddm = new TreatmentController();
        $admission_add = $newaddm->addTreatment($doctorId, $treatmentId, $labTestType, $comment);
    }

    if($admission_add){
        echo JsonResponse::success($admission_add);
        exit();
    } else {
//        print_r($_REQUEST);
        echo JsonResponse::error("Error requesting lab test");
        exit();
    }


}
