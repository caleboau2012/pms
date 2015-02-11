<?php
//JSON RESPONSE CONSTANTS
define('STATUS_OK', 1);
define('STATUS_ERROR', 2);
define('STATUS_ACCESS_DENIED', 3);
define('STATUS_NO_DATA', 4);

define('P_STATUS', 'status');
define('P_DATA', 'data');
define('P_MESSAGE', 'message');
define('P_ACCESS_TOKEN', 'access_token');

//ONLINE STATUS CODES
define('ONLINE', 1);
define('OFFLINE', 0);

//user type
define('PATIENT', 1);
define('STAFF', 2);
define('ADMIN', 3);

//staff roles
define('ROLES', 'roles');
define('EXISTING', 'existing');
define('AVAILABLE', 'available');
define('ADMINISTRATOR', 1);
define('DOCTOR', 2);
define('PHARMACIST', 3);
define('MEDICAL_RECORD', 4);
define('PERMISSION_GRANTER', 5);
define('URINE_CONDUCTOR', 6);
define('VISUAL_CONDUCTOR', 7);
define('XRAY_CONDUCTOR', 8);
define('HEALTH_SCHEME', 9);
define('PARASITOLOGY_CONDUCTOR', 10);
define('CHEMICAL_PATHOLOGY_CONDUCTOR', 11);
define('STAFF_ADDING_OFFICER', 12);
define('STAFF_CLEARANCE_OFFICER', 13);
define('TREATMENT_RECORD', 14);

//ACTIVE STATUS CONSTANTS
define('ACTIVE', 1);
define('INACTIVE', 2);
define('UNCLEAR', 3);
define('CLEARED', 4);
define('PENDING', 5);
define('PROCESSING', 6);
define('COMPLETED', 7);

//PATIENT ARRIVAL CONSTANTS
define('PARAMETER', 'parameter');
define('WILDCARD', 'wildcard');
define('QUEUE', 'queue');
define('LMT', 'LMT');

//GENERAL CONSTANTS
define('COUNT', 'count');