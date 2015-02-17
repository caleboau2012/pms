<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse'));
Crave::requireFiles(MODEL, array('BaseModel', 'UserModel', 'StaffRosterModel'));
Crave::requireFiles(CONTROLLER, array('UserController', 'StaffRosterController'));


//--------------------------------------------------------------------------------------------------
// This script reads event data from a JSON file and outputs those events which are within the range
// supplied by the "start" and "end" GET parameters.
//
// An optional "timezone" GET parameter will force all ISO8601 date stings to a given timezone.
//
// Requires PHP 5.2.0 or higher.
//--------------------------------------------------------------------------------------------------

// Require our Event class and datetime utilities
require dirname(__FILE__) . '/utils.php';

// Short-circuit if the client did not give us a date range.
if (!isset($_GET['start']) || !isset($_GET['end'])) {
    die("Please provide a date range.");
}

// Parse the start/end parameters.
// These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
// Since no timezone will be present, they will parsed as UTC.
$range_start = parseDateTime($_GET['start']);
$range_end = parseDateTime($_GET['end']);

// Parse the timezone parameter if it is present.
$timezone = null;
if (isset($_GET['timezone'])) {
    $timezone = new DateTimeZone($_GET['timezone']);
}

// Read and parse our events JSON file into an array of event data arrays.
$json = file_get_contents(dirname(__FILE__) . '/json/events.json');
$input_arrays = json_decode($json, true);

$staffs = new StaffRosterController();
$staffRoster = $staffs->getAllStaffsRoster();

// Accumulate an output array of event data arrays.
$output_arrays = array();
$params = array();

foreach ($staffRoster as $array) {

    $params['title'] = ucwords($array['firstname'] ." ".$array['middlename'] . " " .$array['lastname']);
    $params['start'] = $array['duty_date'];

    if($array['duty'] == 9){
        $params['color'] = "#4CA618";
    }else if($array['duty'] == 10){
        $params['color'] = "#3F3C3C";
    }else{
        $params['color'] = "#3A87AD";
    }


    // Convert the input array into a useful Event object
    $event = new Event($params, $timezone);
    $output_arrays[] = $event->toArray();
    // If the event is in-bounds, add it to the output
//    if ($event->isWithinDayRange($range_start, $range_end)) {
//        $output_arrays[] = $event->toArray();
//    }
}

// Send JSON to the client.
echo json_encode($output_arrays);