<?php
class VitalsController {
    public function addVitals($vitals_data, $added_by, $encounter_id = null) {
        //---------------------------------------------------------------------
        // check if adding officer has role to add vitals!
        // NOT YET IMPLEMENTED!!!
        // IMPLEMENT WHEN ROLE FOR ADDING VITALS HAS BEEN DETERMINED
        // OR IF NEEDED!!!
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

        if (!$feedback) {
            $response = array(
                P_STATUS    =>  STATUS_ERROR,
                P_MESSAGE   =>  "No vitals recorded for this patient!"
            );

            return $response;
        }

        return $feedback;
    }

    public static function validateVitals($vitals_data) {
        if (!is_array($vitals_data)) {
            return false;
        }

        $vitals_label = array('temp', 'pulse', 'respiratory_rate', 'blood_pressure', 'height', 'weight', 'bmi');

        $is_empty = true;
        $valid_vitals = array();

        foreach ($vitals_label as $label) {
            if (isset($vitals_data[$label])) {
                $is_empty = false;
                $valid_vitals[$label] = $vitals_data[$label];
            } else {
                $valid_vitals[$label] = null;
            }
        }

        if ($is_empty) {
            return false;
        } else {
            return $valid_vitals;
        }
    }
}