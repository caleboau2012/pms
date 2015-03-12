<?php 
class VitalsController {
    public function addVitals($vitals_data, $added_by, $encounter_id = null) {
        //---------------------------------------------------------------------
        //check if adding officer has role to add vitals!
        //NOT YET IMPLEMENTED!!!
        //IMPLEMENT WHEN ROLE FOR ADDING VITALS HAS BEEN DETERMINED
        //OR IF NEEDED!!!
        //---------------------------------------------------------------------

        
        $vitals_data[VitalsTable::added_by] = $added_by;
        $vitals_data[VitalsTable::encounter_id] = $encounter_id;
        
        $vitalsModel = new VitalsModel($vitals_data);
        
        $feedback = $vitalsModel->add();

        return $feedback;
    }

    public function getVitals($patient_id) {
        $vitalsModel = new VitalsModel();
        $feedback = $vitalsModel->getVitals($patient_id);

        return $feedback;
    }
}