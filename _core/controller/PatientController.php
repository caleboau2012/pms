<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ODUGUWA A
 * Date: 1/27/15
 * Time: 8:20 AM
 * To change this template use File | Settings | File Templates.
 */


//require_once '../_core/global/_require.php';


//Crave::requireAll(GLOBAL_VAR);
//Crave::requireAll(UTIL);
//Crave::requireFiles(MODEL, array('BaseModel', 'UserModel', 'PatientModel'));



class PatientController {

    private $patient;

    public function __construct (){
        $this->patient = new PatientModel();
    }

    public function  addPatient ($data ){

        //$patient = new PatientModel();
        return $this->patient->InsertPatient($data);

    }

    public function  EditPatientInfo ($data ){

        $patient = new PatientModel();
        return $this->patient->UpdatePatientInfo($data);


    }

    public function  EditPatientBasicInfo ($data ){

        $patient = new PatientModel();
        return $patient->UpdatePatientBasicInfo($data);

    }

    public function  retrievePatientInfo ($patient_id ){

       return $this->patient->GetPatientDetails($patient_id);

    }

    public function  retrieveAllPatientInfo ( ){

        return $this->patient->GetAllPatientDetails();

    }



}