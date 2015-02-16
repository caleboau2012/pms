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
}