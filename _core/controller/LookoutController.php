<?php

class LookoutController {
    public function markPresence($userid) {
        $watch_path = LookoutController::watchPath();
        $watch_file = $watch_path . '/' . $userid . '.sess';

        @touch($watch_file);
        return true;
    }

    private static function deleteInactiveWatch($inactive_users) {
        $watch_path = LookoutController::watchPath();

        foreach ($inactive_users as $user) {
            $watch_file = $watch_path . '/' . $user . '.sess';
            @unlink($watch_file);
        }

        return true;
    }

    private static function watchPath() {
        $path_arr = explode(PROJECT_NAME, __DIR__);
        $project_root = $path_arr[0] . PROJECT_NAME . '/';
        $watch_file_directory = $project_root . 'watcher';

        return $watch_file_directory;
    }

    public static function sweep() {
        $watch_path = LookoutController::watchPath();

        $inactive_users = array();

        $orig_dir = getcwd();
        chdir($watch_path);

        $worked = false;

        $watch_files = glob('*.sess');

        foreach ($watch_files as $file) {
            $file_access_time = fileatime($file);
            $current_time = time();
            $inactive = ($current_time - $file_access_time) > MAX_INACTIVE_TIME;
            if ($inactive) {
                $userid = explode('.', $file);
                array_push($inactive_users, $userid[0]);
            }
//            $worked = true;
        }

        chdir($orig_dir);

        if (sizeof($inactive_users) > 0) {
            LookoutController::deleteInactiveWatch($inactive_users);
            AuthenticationController::autoLogout($inactive_users);

            $worked = true;
        }

        return $worked;
    }
}