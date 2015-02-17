<?php

class StaffRosterController{
    protected $user;
    protected $staffRoster;

    public function __construct(){
        $this->user = new UserModel();
        $this->staffRoster = new StaffRoster();
    }

    public function getUsers(){
        return $this->user->getAllUsers();
    }

    public function getDepartments(){
        return $this->staffRoster->getDepartments();
    }

    public function assignTask($userId, $deptId, $duty, $dutyDate, $createdBy, $modifeiedBy){
        return $this->staffRoster->assignTask(array(RosterTable::user_id => $userId, RosterTable::dept_id => $deptId,
                                                    RosterTable::duty => $duty, RosterTable::duty_date => $dutyDate,
                                                    RosterTable::created_by => $createdBy,
                                                    RosterTable::modified_by => $modifeiedBy));
    }

    public function getAllStaffsRoster(){
        return $this->staffRoster->allStaffRoster();
    }
}