<?php
require_once '../../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse', 'Event'));
Crave::requireFiles(MODEL, array('BaseModel', 'UserModel', 'StaffRosterModel'));
Crave::requireFiles(CONTROLLER, array('UserController', 'StaffRosterController'));

$staffs = new StaffRosterController();
$staffRoster = $staffs->getAllStaffsRoster();

// Accumulate an output array of event data arrays.
$output_arrays = array();
$params = array();

foreach ($staffRoster as $array) {

    $params['title'] = ucwords($array['firstname'] ." ".$array['middlename'] . " " .$array['lastname']);
    $params['start'] = $array['duty_date'];
    $params['roster_id'] = $array['roster_id'];

    if($array['duty'] == 9){
        $params['color'] = "#4CA618";
    }else if($array['duty'] == 10){
        $params['color'] = "#3F3C3C";
    }else{
        $params['color'] = "#3A87AD";
    }


    // Convert the input array into a useful Event object
    $event = new Event($params, null);
    $output_arrays[] = $event->toArray();
    // If the event is in-bounds, add it to the output
//    if ($event->isWithinDayRange($range_start, $range_end)) {
//        $output_arrays[] = $event->toArray();
//    }
}

// Send JSON to the client.
echo json_encode($output_arrays);