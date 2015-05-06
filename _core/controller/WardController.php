<?php
class WardController {
    public function loadWards() {
        $feedback = WardModel::getAll();

        return $feedback;
    }

    public function getWardBeds($ward_id) {
        $ward_model = new WardModel($ward_id);

        $feedback = $ward_model->getWardBeds();

        return $feedback;
    }

    public static function isOccupied($bed_id) {
        $bed_model = new BedModel($bed_id);
        $feedback = $bed_model->getStatus();

        return ($feedback == OCCUPIED);
    }


    public function createWard($ward_description) {
        // check if current user has role to add ward (WARD ADMINISTRATOR)
        // check if current ward description doesn't exist
        if (WardModel::wardExists($ward_description)) {
            $response = array(
                P_STATUS    =>  STATUS_ERROR,
                P_MESSAGE   =>  "Ward already exists!"
            );
            return $response;
        }
        // add new ward
        $ward = new WardModel();
        $feedback = $ward->create($ward_description);
        if (!$feedback) {
            $response = array(
                P_STATUS    =>  STATUS_ERROR,
                P_MESSAGE   =>  "Unable to create new ward!"
            );
            return $response;
        }

        return $feedback;
    }

    public function createBed($ward_id, $bed_description) {
        // check if current user has WARD ADMINISTRATOR role
        // check if supplied ward ID is valid
        if (!WardModel::isValidWard($ward_id)) {
            $response = array(
                P_STATUS    =>  STATUS_ERROR,
                P_MESSAGE   =>  "Cannot add beds to a ward that does not exist!"
            );
            return $response;
        }
        // check if bed exists
        if (BedModel::bedExists($bed_description)) {
            $response = array(
                P_STATUS    =>  STATUS_ERROR,
                P_MESSAGE   =>  "Bed already exists!"
            );
            return $response;
        }
        // add new bed
        $bed = new BedModel();
        $feedback = $bed->create($ward_id, $bed_description);
        if (!$feedback) {
            $response = array(
                P_STATUS    =>  STATUS_ERROR,
                P_MESSAGE   =>  "Unable to create new bed!"
            );
            return $response;
        }

        return $feedback;
    }

    public function deleteBed($bed_id) {
        $bed = new BedModel($bed_id);
        $bed_status = $bed->getStatus();
        if ($bed_status == OCCUPIED) {
            $response = array(
                P_STATUS    =>  STATUS_ERROR,
                P_MESSAGE   =>  "Cannot remove bed that is currently occupied!"
            );
            return $response;
        }
        $feedback = $bed->delete();
        if (!$feedback) {
            $response = array(
                P_STATUS    =>  STATUS_ERROR,
                P_MESSAGE   =>  "Unable to delete bed!"
            );
            return $response;
        }

        return $feedback;
    }
}