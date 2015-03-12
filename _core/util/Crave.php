<?php
class Crave {
    public static function requireFiles($directory, $file_array){
        $root_path = Crave::getRootPath();

        foreach ($file_array as $file) {
            $file_path = $root_path . '/' . $directory . $file . '.php';
            if (file_exists($file_path)) {
                include_once $file_path;
            }
        }
    }

    public static function requireAll($directory){
        $root_path = Crave::getRootPath();
        $file_array = glob($root_path . '/' . $directory . '*.php');
        foreach ($file_array as $file_path) {
            include_once $file_path;
        }
    }

    private static function getRootPath(){
        $path_arr = explode(PROJECT_NAME, __DIR__);
        return $path_arr[0] . PROJECT_NAME;
    }
}