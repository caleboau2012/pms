<?php

class StaffController{
    public static function addStaff($data){
        StaffModel::addStaff($data);
    }

    public static function getStaff($data){
        StaffModel::getStaff($data);
    }
}