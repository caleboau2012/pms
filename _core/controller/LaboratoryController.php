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

    public function getLabDetails($labType, $treatmentId){
        switch($labType){
            case CHEMICAL_PATHOLOGY:
                return $this->chemicalPathology->getTestDetails($treatmentId);
            case HAEMATOLOGY:
                return $this->haematology->getTestDetails($treatmentId);
            case PARASITOLOGY:
                return $this->parasitology->getTestDetails($treatmentId);
            case MICROSCOPY:
                return $this->microscopy->getTestDetails($treatmentId);
            case VISUAL:
                return $this->visual->getTestDetails($treatmentId);
            case RADIOLOGY:
                return $this->radiology->getTestDetails($treatmentId);
            default:
                return array();
        }
    }

    public function setLabDetails($labType, $data){
        switch($labType){
            case CHEMICAL_PATHOLOGY:
                return $this->chemicalPathology->getTestDetails($data);
            case HAEMATOLOGY:
                return $this->haematology->getTestDetails($data);
            case PARASITOLOGY:
                return $this->parasitology->getTestDetails($data);
            case MICROSCOPY:
                return $this->microscopy->getTestDetails($data);
            case VISUAL:
                return $this->visual->getTestDetails($data);
            case RADIOLOGY:
                return $this->radiology->getTestDetails($data);
            default:
                return false;
        }
    }

    public function updateLabDetails($labType, $data){
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

}