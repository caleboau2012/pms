<?php
require_once '../global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'UserModel'));

$test = new UserModel();
$date = Date("Y/m/d");
var_dump($date);
$profileData =  array(UserAuthTable::userid => 3, ProfileTable::surname => " ", ProfileTable::firstname =>" ", ProfileTable::middlename =>" ",
    ProfileTable::department_id => 1, ProfileTable::work_address =>" ", ProfileTable::home_address => " ", ProfileTable::telephone => " ",
    ProfileTable::sex => "MALE", ProfileTable::height => 3, ProfileTable::weight => 3, ProfileTable::birth_date => $date);

var_dump($profileData);
/*INSERT INTO profile (userid, surname, firstname, middlename, department_id, local_address, home_address, telephone, sex,
    height, weight, birth_date, create_date, modified_date)
                                 VALUES (1, " ", " ", " ", 1, " ", " ", " ", "MALE", 2, 2, NOW(), NOW(), NOW())*/
var_dump($test->addProfile($profileData));
var_dump($test->updateStatus($profileData[UserAuthTable::userid], ACTIVE));