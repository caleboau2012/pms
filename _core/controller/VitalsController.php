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

    public static function validateVitals($vitals_data) {
        $vitals_label = array('temp', 'pulse', 'respiratory_rate', 'blood_pressure', 'height', 'weight', 'bmi');

        $is_empty = true;
        foreach ($vitals_data as $key => $value) {
            if (!in_array($key, $vitals_label)) {
                return false;
            } elseif ($value != null || $value != '') {
                $is_empty = false;
            }
        }

        if ($is_empty) {
            return false;
        } else {
            return true;
        }
    }
}