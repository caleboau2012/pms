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
Crave::requireFiles(MODEL, array('BaseModel', 'TreatmentModel', 'ChemicalPathologyModel', 'HaematologyModel', 'MicroscopyModel', 'ParasitologyModel', 'VisualModel', 'RadiologyModel', 'PharmacistModel'));
Crave::requireFiles(CONTROLLER, array('TreatmentController', 'LaboratoryController', 'PharmacistController'));


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

elseif  ($intent == 'startTreatment') { //working


    $treat = new TreatmentController();

    $doctorid ="";
    $patientid ="";
//    $consultation ="";
//    $symptoms ="";
//    $comments= "";
//    $diagnosis ="";

    if (isset($_REQUEST['doctor_id']) && isset($_REQUEST['patient_id'])){  // change surname to what you thin should be set.

        $doctorid =$_REQUEST[TreatmentTable::doctor_id];
        $patientid =$_REQUEST[TreatmentTable::patient_id];
        $consultation =" ";
        $symptoms =" ";
        $comments= " ";
        $diagnosis =" ";



    }
    else {
        echo JsonResponse::error("things are not set");
        exit();
    }

    $admission_add = null;

    if (empty($doctorid) || empty ($patientid) ){

//        print_r($_REQUEST);
        echo JsonResponse::error("Some fields are not filled, Ensure All fields are filled");
        exit();
    }
    else{

        $newaddm = new TreatmentController();
        $newpat = new PatientController();
        $all_info=array();

        // check if patient has treatment before, if so return existing treatment_id, otherwise, create ne treament id.
        $hasTreatmentbefore = $newaddm->doesTreatmentExist ($patientid);

        if ($hasTreatmentbefore == 0)
        {
            $admission_add = $newaddm->addTreatment1($doctorid, $patientid, $consultation, $symptoms, $diagnosis, $comments);
        } else {
            $admission_add= array(TreatmentTable::treatment_id => $hasTreatmentbefore);
            $patient_info = $newpat->retrievePatientInfo($patientid);
            $treatid = $newaddm->doesTreatmentExist($patientid);
            $all_info = array_merge($treatid,$patient_info);

        }
    }


    if($admission_add){
        echo JsonResponse::success($admission_add);
        echo JsonResponse::success($all_info);  //  all patient info coming from here treatment id and patient info as you have requested.
        exit();
    } else {
        echo $admission_add;
        echo JsonResponse::error("Error starting treatment process");
        exit();
    }

}
elseif  ($intent == 'endTreatment') { //working
    $treat = new TreatmentController();

    $treatment_id ="";
    $patientid ="";

    if (isset($_REQUEST['treatment_id']) && isset($_REQUEST['patient_id'])){  // change surname to what you thin should be set.

        $treatment_id = $_REQUEST[TreatmentTable::treatment_id];
        $patientid = $_REQUEST[TreatmentTable::patient_id];
        $consultation ="";
        $symptoms ="";
        $comments= "";
        $diagnosis ="";

    }
    else {
        echo JsonResponse::error("things are not set");
        exit();
    }

    $admission_end = null;

    if (empty($treatment_id) || empty ($patientid) ){

//        print_r($_REQUEST);
        echo JsonResponse::error("Some fields are not filled, Ensure All fields are filled");
        exit();
    }
    else{

        $newaddm = new TreatmentController();

        $admission_end = $newaddm->endTreatment($treatment_id);

    }

    if(! $admission_end ){
        echo print_r($admission_end);
        echo JsonResponse::success(!$admission_end);
        exit();

    }
    else {
        echo print_r($admission_end);
        echo JsonResponse::error("Error ending treatment process");
        exit();

    }



}


elseif  ($intent == 'submitTreatment') { //working
    $treat = new TreatmentController();

    $doctorid =" ";
    $patientid =" ";
    $treatment_id=" ";
    $consultation =" ";
    $symptoms =" ";
    $comments= " ";
    $diagnosis =" ";
    $prescription =" ";


    if (isset($_REQUEST['doctor_id']) && isset($_REQUEST['patient_id'])){  // change surname to what you thin should be set.

        $doctorid =$_REQUEST[TreatmentTable::doctor_id];
        $patientid =$_REQUEST[TreatmentTable::patient_id];
        $consultation =$_REQUEST[TreatmentTable::consultation];
        $symptoms =$_REQUEST[TreatmentTable::symptoms];
        $comments= $_REQUEST[TreatmentTable::comments];
        $diagnosis =$_REQUEST[TreatmentTable::diagnosis];
        $treatment_id =$_REQUEST['treatment_id'];
        $prescription = $_REQUEST['prescription'];
        $encounter_id = (isset($_REQUEST['encounter_id'])) ? $_REQUEST['encounter_id'] : 0;
    }
    else {
        echo JsonResponse::error("things are not set");
        exit();
    }

    $admission_add = null;

    $newaddm = new TreatmentController();
    $admission_add = $newaddm->addTreatment2($doctorid, $patientid, $consultation, $symptoms, $diagnosis, $comments, $treatment_id);

    if ($admission_add){

        foreach ($prescription as $somepre) {
            $status = ACTIVE;
            $mod = DOCTOR;
            $pre  = new PharmacistController();
            $pre->AddPrescription($somepre, $treatment_id, $status, $mod, $encounter_id);
            if(!$pre){
                exit();
            }
        }
    }

    if($admission_add || $pre){
        echo JsonResponse::success($admission_add);
        exit();
    } else {
        echo JsonResponse::error("Automatic Error creating treatment and prescription");
        exit();
    }


}

elseif  ($intent == 'getTreatmentHistory') {

    if (isset($_REQUEST['patient_id'])){
        $patientid = $_REQUEST['patient_id'];
    }
    else{
        echo JsonResponse::error("patient_id not Set");
        exit();
    }

    $treat = new TreatmentController();
    $history = $treat->getTreatmentHistory($patientid);

    if(is_array($history)){
        echo JsonResponse::success($history);
        //echo array($request_adm);
        exit();
    } else {
        echo JsonResponse::error("Could not get history. Please try again!");
        exit();
    }
}

elseif  ($intent == 'requestLabTest') {

    $treat = new TreatmentController();

    //$doctorId, $treatmentId, $labTestType, $comment

    $treatmentId ="";
    $doctorId ="";
    $labTestType ="";
    $comment= "";

    if (isset($_REQUEST['treatment_id']) && isset($_REQUEST['doctor_id'])){  // change surname to what you thin should be set.

        // var_dump($_REQUEST);

        $doctorId =$_REQUEST[TreatmentTable::doctor_id];
        $treatmentId =$_REQUEST[TreatmentTable::treatment_id];
        $labTestType = $_REQUEST['test_id'];
        $comment= $_REQUEST[TreatmentTable::comments];
        $encounterId = (isset($_REQUEST[EncounterTable::encounter_id])) ? $_REQUEST[EncounterTable::encounter_id] : 0;
    }
    else {
        echo JsonResponse::error("things are not set");
        exit();
    }

    $admission_add = null;

    if (empty($treatmentId) || empty ($doctorId) || empty ($labTestType) || empty ($comment)){

        echo JsonResponse::error("Some fields are not filled, Ensure All fields are filled");
        exit();
    }
    else{

        $newaddm = new TreatmentController();
        $admission_add = $newaddm->requestLabTest($labTestType, $doctorId, $treatmentId, $encounterId, $comment);
    }

    if($admission_add){
        echo JsonResponse::success($admission_add);
        exit();
    } else {
        print_r($_REQUEST);
        echo JsonResponse::error("Error requesting lab test");
        exit();
    }


}

elseif($intent == 'getEncounterId'){
    $doctor_id    = CxSessionHandler::getItem('userid');
    $patient_id   = isset($_REQUEST[EncounterTable::patient_id]) ? $_REQUEST[EncounterTable::patient_id] : null;
    $admission_id = isset($_REQUEST[EncounterTable::admission_id]) ? $_REQUEST[EncounterTable::admission_id] : null;
    $treatment_id = isset($_REQUEST[EncounterTable::treatment_id]) ? $_REQUEST[EncounterTable::treatment_id] : null;

    $encounter = new TreatmentController();
    $response = $encounter->getEncounterId($treatment_id, $patient_id, $admission_id, $doctor_id);

    if($response['result']){
        echo JsonResponse::success($response['value']);
        exit;
    } else {
        echo JsonResponse::error($response['message']);
        exit;
    }
}

elseif($intent == 'logEncounter'){
    $doctor_id     = CxSessionHandler::getItem('userid');
    $patient_id    = isset($_REQUEST[EncounterTable::patient_id]) ? $_REQUEST[EncounterTable::patient_id] : null;
    $admission_id  = isset($_REQUEST[EncounterTable::admission_id]) ? $_REQUEST[EncounterTable::admission_id] : null;
    $treatment_id  = isset($_REQUEST[EncounterTable::treatment_id]) ? $_REQUEST[EncounterTable::treatment_id] : null;
    $encounter_id  = isset($_REQUEST[EncounterTable::encounter_id]) ? $_REQUEST[EncounterTable::encounter_id] : null;
    $consultation  = isset($_REQUEST[EncounterTable::consultation]) ? $_REQUEST[EncounterTable::consultation] : "";
    $symptoms      = isset($_REQUEST[EncounterTable::symptoms]) ? $_REQUEST[EncounterTable::symptoms] : "";
    $comments      = isset($_REQUEST[EncounterTable::comments]) ? $_REQUEST[EncounterTable::comments] : "";
    $diagnosis     = isset($_REQUEST[EncounterTable::diagnosis]) ? $_REQUEST[EncounterTable::diagnosis] : "";
    $prescription = isset($_REQUEST[PrescriptionTable::prescription]) ? $_REQUEST[PrescriptionTable::prescription] : array();

    if($doctor_id && $patient_id && $admission_id && $treatment_id && $encounter_id){
        $encounter = new TreatmentController();
        $response = $encounter->logEncounter($doctor_id, $patient_id, $admission_id, $treatment_id, $encounter_id, $consultation, $symptoms, $diagnosis, $comments, $prescription);

        if($response['result']){
            echo JsonResponse::success($response['message']);
            exit;
        } else {
            echo JsonResponse::error($response['message']);
            exit;
        }
    } else {
        echo JsonResponse::error('Some needed parameters not set');
        exit;
    }
}

elseif($intent == 'closeEncounter'){
    $treatment_id = isset($_REQUEST[EncounterTable::treatment_id]) ? $_REQUEST[EncounterTable::treatment_id] : null;
    $encounter_id = isset($_REQUEST[EncounterTable::encounter_id]) ? $_REQUEST[EncounterTable::encounter_id] : null;


    if($treatment_id && $encounter_id){
        $encounter = new TreatmentController();
        $result = $encounter->closeEncounter($treatment_id, $encounter_id);

        if($result){
            echo JsonResponse::success("Successfully ended encounter");
            exit;
        } else {
            echo JsonResponse::error("Could not end encounter");
            exit;
        }
    } else {
        echo JsonResponse::error('Some needed parameters not set');
        exit;
    }
}

elseif($intent == 'getEncounters'){
    $treatment_id = isset($_REQUEST[EncounterTable::treatment_id]) ? $_REQUEST[EncounterTable::treatment_id] : null;

    if($treatment_id){
        $encounter = new TreatmentController();
        $result = $encounter->getEncounters($treatment_id);

        if($result && is_array($result)){
            echo JsonResponse::success($result);
            exit;
        } else {
            echo JsonResponse::error('Patient was not admitted during this treatment session');
            exit;
        }
    } else {
        echo JsonResponse::error('treatment id not set');
        exit;
    }
}

elseif  ($intent == 'logEncounterOld') {
    $treat = new TreatmentController();

    $doctorId ="";
    $patientId="";
    $admissionId="";
    $comments="";


    if (/*isset($_REQUEST['admissionId']) &&*/ isset($_REQUEST['patient_id'])){

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
        //$admission_add = $newaddm->logEncounter($doctorId, $patientId , $admissionId, $comments);
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


    if (isset($_REQUEST['treatment_id']) ){  // change surname to what you thin should be set.

        $patientName =$_REQUEST[''];

    }
    else {
        echo JsonResponse::error("things are not set");
        exit();
    }

    $admission_add = null;

    if (empty($patientName) ){

        echo JsonResponse::error("Some fields are not filled, Ensure All fields are filled");
        exit();
    }
    else{

        $newaddm = new TreatmentController();
        $admission_add = $newaddm->searchPatient($patientName);
    }

    if($admission_add){
        echo JsonResponse::success($admission_add);
        exit();
    } else {
//        print_r($_REQUEST);
        echo JsonResponse::error("No patient found");
        exit();
    }


}
elseif  ($intent == 'getLabHistory') {

    $treat = new TreatmentController();

    $patientId ="";
    $labTestType ="";

    if (isset($_REQUEST['treatment_id']) && isset($_REQUEST['patient_id'])){  // change surname to what you thin should be set.

        // var_dump($_REQUEST);

        $patientId =$_REQUEST[TreatmentTable::patient_id];
        $labTestType = $_REQUEST['test_id'];  // no tbale for this variable.

    }
    else {
        echo JsonResponse::error("things are not set");
        exit();
    }

    $admission_add = null;

    if (empty ($patientId) || empty ($labTestType) ){

        //print_r($_REQUEST);
        echo JsonResponse::error("Some fields are not filled, Ensure All fields are filled");
        exit();
    }
    else{

        $newaddm = new TreatmentController();
        $admission_add = $newaddm->getLabHistory($patientId, $labTestType);
    }

    if($admission_add){
        echo JsonResponse::success($admission_add);
        exit();
    } else {
//        print_r($_REQUEST);
        echo JsonResponse::error("Error getting lab history");
        exit();
    }


}

elseif($intent == 'labHistory'){
    if(isset($_REQUEST['labType'])){
        $type = $_REQUEST['labType'];
        $patientId = intval($_REQUEST['patientId']);
        $lab = new LaboratoryController();

        $result = $lab->getLabHistory($type, $patientId);
        if($result){
            echo JsonResponse::success($result);
            exit();
        } else {
            echo JsonResponse::error("No test found for this patient");
            exit();
        }
    } else {
        echo JsonResponse::error("Please select a lab type");
        exit();
    }
}
elseif($intent == 'labRequest'){
    if(isset($_REQUEST['labType'])){
        $type = $_REQUEST['labType'];
        $doctorId = intval(CxSessionHandler::getItem('userid'));
        $treatmentId = intval($_REQUEST['treatmentId']);
        $encounterId = isset($_REQUEST['encounterId']) ? $_REQUEST['encounterId'] : 0;
        $description = isset($_REQUEST['description']) ? $_REQUEST['description'] : "";
        $lab = new LaboratoryController();

        $result = $lab->requestLabTest($type, $doctorId, $treatmentId, $encounterId, $description);
        if($result){
            echo JsonResponse::success("Request successful");
            exit();
        } else {
            echo JsonResponse::error("Request unsuccessful. Try again!");
            exit();
        }
    } else {
        echo JsonResponse::error("Please select a lab type");
        exit();
    }
}
else{
    JsonResponse::error("No intent set");
}