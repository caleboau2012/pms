<?php
class LaboratoryController{
    private $chemicalPathology;
    private $haematology;
    private $parasitology;
    private $microscopy;
    private $visual;
    private $radiology;

    public function __construct(){
        $this->chemicalPathology = new ChemicalPathologyModel();
        $this->haematology = new HaematologyModel();
        $this->parasitology = new ParasitologyModel();
        $this->microscopy = new MicroscopyModel();
        $this->visual = new VisualModel();
        $this->radiology = new RadiologyModel();
    }

    public function getPatientQueue($labType){
        switch($labType){
            case CHEMICAL_PATHOLOGY:
                return $this->chemicalPathology->getPatientQueue();
            case HAEMATOLOGY:
                return $this->haematology->getPatientQueue();
            case PARASITOLOGY:
                return $this->parasitology->getPatientQueue();
            case MICROSCOPY:
                return $this->microscopy->getPatientQueue();
            case VISUAL:
                return $this->visual->getPatientQueue();
            case RADIOLOGY:
                return $this->radiology->getPatientQueue();
            default:
                return array();
        }
    }

    public function getAllTest($labType){
        switch($labType){
            case CHEMICAL_PATHOLOGY:
                return $this->chemicalPathology->getAllTest();
            case HAEMATOLOGY:
                return $this->haematology->getAllTest();
            case PARASITOLOGY:
                return $this->parasitology->getAllTest();
            case MICROSCOPY:
                return $this->microscopy->getAllTest();
            case VISUAL:
                return $this->visual->getAllTest();
            case RADIOLOGY:
                return $this->radiology->getAllTest();
            default:
                return array();
        }
    }

    public function getLabDetails($testId, $labType, $treatmentId, $encounterId){
        switch($labType){
            case CHEMICAL_PATHOLOGY:
                return $this->chemicalPathology->getTestDetails($treatmentId, $encounterId);
            case HAEMATOLOGY:
                return $this->haematology->getTestDetails($treatmentId, $encounterId);
            case PARASITOLOGY:
                return $this->parasitology->getTestDetails($treatmentId, $encounterId);
            case MICROSCOPY:
                return $this->microscopy->getTestDetails($testId, $treatmentId, $encounterId);
            case VISUAL:
                return $this->visual->getTestDetails($testId, $treatmentId, $encounterId);
            case RADIOLOGY:
                return $this->radiology->getTestDetails($testId, $treatmentId, $encounterId);
            default:
                return array();
        }
    }

    public function setLabDetails($labType, $data){
        switch($labType){
            case CHEMICAL_PATHOLOGY:
                return $this->chemicalPathology->updateTestDetails($data);
            case HAEMATOLOGY:
                return $this->haematology->updateTestDetails($data);
            case PARASITOLOGY:
                return $this->parasitology->updateTestDetails($data);
            case MICROSCOPY:
                return $this->microscopy->updateTestDetails($data);
            case VISUAL:
                return $this->visual->updateTestDetails($data);
            case RADIOLOGY:
                return $this->radiology->updateTestDetails($data);
            default:
                return false;
        }
    }

    public function updateLabDetails($labType, &$data){
        switch($labType){
            case CHEMICAL_PATHOLOGY:
                return $this->chemicalPathology->updateTestDetails($data);
            case HAEMATOLOGY:
                $haematology_id = $data['details']['haematology_id'];
                $data['blood_test']['haematology_id'] = $haematology_id;
                $data['film_appearance']['haematology_id'] = $haematology_id;
                $data['differential_count']['haematology_id'] = $haematology_id;
                return $this->haematology->updateTestDetails($data);
            case PARASITOLOGY:
                return $this->parasitology->updateTestDetails($data);
            case MICROSCOPY:
                return $this->microscopy->updateTestDetails($data);
            case VISUAL:
                return $this->visual->updateTestDetails($data);
            case RADIOLOGY:
                return $this->radiology->updateTestDetails($data);
            default:
                return false;
        }
    }

    public function requestLabTest($labTestType, $doctorId, $treatmentId, $encounterId, $description){
        switch($labTestType){
            case RADIOLOGY:
                return $this->radiology->radiologyRequest($doctorId, $treatmentId, $encounterId, $description);

            case HAEMATOLOGY:
                return $this->haematology->haematologyRequest($doctorId, $treatmentId, $encounterId, $description);

            case MICROSCOPY:
                return $this->microscopy->microscopyRequest($doctorId, $treatmentId, $encounterId, $description);

            case VISUAL:
                return $this->visual->visualRequest($doctorId, $treatmentId, $encounterId, $description);

            case CHEMICAL_PATHOLOGY:
                return $this->chemicalPathology->chemicalPathologyRequest($doctorId, $treatmentId, $encounterId, $description);

            case PARASITOLOGY:
                return $this->parasitology->parasitologyRequest($doctorId, $treatmentId, $encounterId, $description);

            default:
                return false;
        }
    }

    public function getLabHistory($labTestType, $patientId){
        switch($labTestType){
            case RADIOLOGY:
                return $this->radiology->getLabHistory($patientId);

            case HAEMATOLOGY:
                return $this->haematology->getLabHistory($patientId);

            case MICROSCOPY:
                return $this->microscopy->getLabHistory($patientId);

            case VISUAL:
                 return $this->visual->getLabHistory($patientId);

            case CHEMICAL_PATHOLOGY:
                return $this->chemicalPathology->getLabHistory($patientId);

            case PARASITOLOGY:
                return $this->parasitology->getLabHistory($patientId);

            default:
                return array();
        }
    }

}