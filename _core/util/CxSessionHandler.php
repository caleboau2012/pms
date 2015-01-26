<?php

session_start();

class CxSessionHandler{
    const VIEW_BAG = '__view_bag';

    public static function getItem($key){
        if (CxSessionHandler::isSetItem($key)){
            return $_SESSION[$key];
        }
        return null;
    }

    public static function clearItem($key){
        unset($_SESSION[$key]);
    }

    public static function setItem($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function isSetItem($key){
        return isset($_SESSION[$key]);
    }

    public static function destroy(){
        session_destroy();
    }

    public static function setViewBag($data){
        CxSessionHandler::setItem(CxSessionHandler::VIEW_BAG, $data);
    }

    public static function getViewBag(){
        $data = CxSessionHandler::getItem(CxSessionHandler::VIEW_BAG);
        CxSessionHandler::clearItem(CxSessionHandler::VIEW_BAG);
        return $data;
    }
}
