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

    public function assignTask($userId, $deptId, $duty, $dutyDate, $createdBy){
        return $this->staffRoster->assignTask(array(RosterTable::user_id => $userId, RosterTable::dept_id => $deptId,
                                                    RosterTable::duty => $duty, RosterTable::duty_date => $dutyDate,
                                                    RosterTable::created_by => $createdBy
                                                   ));
    }

    public function updateTask($roster_id, $dutyDate, $modifiedBy){
            return $this->staffRoster->updateTask(array(
               RosterTable::roster_id=>$roster_id,
                RosterTable::duty_date=>$dutyDate,
                RosterTable::modified_by=>$modifiedBy
            ));
    }
    public function deleteTask($roster_id,  $modifiedBy){
            return $this->staffRoster->deleteTask(array(
               RosterTable::roster_id=>$roster_id,
                RosterTable::modified_by=>$modifiedBy
            ));
    }

    public function getAllRoster(){
        return $this->staffRoster->allStaffsRoster();
    }
    public function getStaffRoster($staff_id){
        return $this->staffRoster->allStaffRoster(array(RosterTable::user_id=>$staff_id));
    }
}